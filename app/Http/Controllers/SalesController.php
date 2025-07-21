<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Sales;
use App\Models\SalesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\CodeGenerator;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $items = Items::all();
        $sales = Sales::with('user')->latest()->get();
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $items = Items::all();
        return view('sales.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $kode = CodeGenerator::generateSalesCode();

            $total = collect($request->items)->sum(function ($item) {
                return $item['qty'] * $item['harga_satuan'];
            });

            $sale = Sales::create([
                'kode' => $kode,
                'user_id' => auth()->id(),
                'tanggal' => now(),
                'total_harga' => $total,
                'status' => 'Belum Dibayar',
            ]);

            foreach ($request->items as $detail) {
                SalesItem::create([
                    'sale_id' => $sale->id,
                    'item_id' => $detail['item_id'],
                    'qty' => $detail['qty'],
                    'harga_satuan' => $detail['harga_satuan'],
                    'total' => $detail['qty'] * $detail['harga_satuan'],
                ]);
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Penjualan berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales $sales)
    {
        //
        $sales->load(['items.item', 'user']);
        return view('sales.show', compact('sales'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
        if ($sales->status === 'Sudah Dibayar') {
            return redirect()->route('sales.index')->with('error', 'Penjualan tidak bisa diedit karena sudah dibayar.');
        }

        $sales->load('items');
        $items = Items::all();
        return view('sales.edit', compact('sales', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales $sales)
    {
        if ($sales->status === 'Sudah Dibayar') {
            return redirect()->route('sales.index')->with('error', 'Penjualan tidak bisa diedit karena sudah dibayar.');
        }

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $total = collect($request->items)->sum(function ($item) {
                return $item['qty'] * $item['harga_satuan'];
            });

            $sales->update([
                'total_harga' => $total,
            ]);

            // Hapus semua item lama
            $sales->items()->delete();

            // Insert ulang
            foreach ($request->items as $detail) {
                SalesItem::create([
                    'sale_id' => $sales->id,
                    'item_id' => $detail['item_id'],
                    'qty' => $detail['qty'],
                    'harga_satuan' => $detail['harga_satuan'],
                    'total' => $detail['qty'] * $detail['harga_satuan'],
                ]);
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Penjualan berhasil diupdate');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        if ($sales->status === 'Sudah Dibayar') {
            return redirect()->route('sales.index')->with('error', 'Penjualan tidak bisa dihapus karena sudah dibayar.');
        }

        DB::transaction(function () use ($sales) {
            $sales->items()->delete();
            $sales->delete();
        });

        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil dihapus');
    }
}
