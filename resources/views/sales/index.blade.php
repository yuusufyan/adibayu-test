<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Filter dan Tambah --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                    {{-- Filter Tanggal --}}
                    <form method="GET" action="{{ route('sales.index') }}" class="flex items-center gap-2">
                        <label for="tanggal" class="text-sm text-gray-300">Filter Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}"
                            class="border-gray-300 dark:bg-gray-700 dark:text-white rounded-md shadow-sm" />
                        <button type="submit"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm">FILTER</button>
                        <a href="{{ route('sales.index') }}" class="text-sm text-blue-400 hover:underline">Reset</a>
                    </form>

                    {{-- Tambah Penjualan --}}
                    @hasanyrole('admin|cashier')
                    <div class="text-right">
                        <a href="{{ route('sales.create') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                            + Tambah Penjualan
                        </a>
                    </div>
                    @endhasanyrole
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table id="sales-table"
                        class="table-auto w-full border border-gray-300 dark:border-gray-700 text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="border px-4 py-2">Kode</th>
                                <th class="border px-4 py-2">Tanggal</th>
                                <th class="border px-4 py-2">Total Harga</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Dibuat Oleh</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                @if (!request('tanggal') || $sale->tanggal->format('Y-m-d') === request('tanggal'))
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="border px-4 py-2">{{ $sale->kode }}</td>
                                        <td class="border px-4 py-2">{{ $sale->tanggal->format('d-m-Y') }}</td>
                                        <td class="border px-4 py-2">Rp {{ number_format($sale->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="border px-4 py-2">{{ $sale->status }}</td>
                                        <td class="border px-4 py-2">{{ $sale->user->name }}</td>
                                        <td class="border px-4 py-2 flex gap-2">
                                            <a href="{{ route('sales.show', $sale->id) }}"
                                                class="bg-blue-600 text-white px-3 py-1 rounded text-xs">Detail</a>

                                            @if ($sale->status === 'Belum Dibayar')
                                                <a href="{{ route('sales.edit', $sale->id) }}"
                                                    class="bg-yellow-500 text-white px-3 py-1 rounded text-xs">Edit</a>
                                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin hapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-600 text-white px-3 py-1 rounded text-xs">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Include DataTables jika perlu -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new DataTable('#sales-table');
        });
    </script>
</x-app-layout>