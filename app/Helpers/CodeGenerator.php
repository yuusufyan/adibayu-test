<?php

namespace App\Helpers;

use App\Models\Items;

class CodeGenerator
{
    public static function generateItemCode(): string
    {
        $lastItem = Items::orderBy('id', 'desc')->first();
        $nextId = $lastItem ? $lastItem->id + 1 : 1;

        return 'ITEM-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
}
