<?php

namespace App\Helpers;

use App\Models\Items;
use App\Models\Sales;

class CodeGenerator
{
    public static function generateItemCode(): string
    {
        $lastItem = Items::orderBy('id', 'desc')->first();
        $nextId = $lastItem ? $lastItem->id + 1 : 1;

        return 'ITEM-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    public static function generateSalesCode(): string
    {
        $lastItem = Sales::orderBy('id', 'desc')->first();
        $nextId = $lastItem ? $lastItem->id + 1 : 1;

        return 'TRX-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
}
