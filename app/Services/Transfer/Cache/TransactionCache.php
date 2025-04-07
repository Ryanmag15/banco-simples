<?php

namespace App\Services\Transfer\Cache;

use Illuminate\Support\Facades\Cache;

class TransactionCache
{
    public function store(array $data): void
    {
        $cacheKey = "recent_transaction_{$data['payer']}";
        Cache::put($cacheKey, [
            'payee' => $data['payee'],
            'value' => $data['value'],
        ], now()->addSeconds(3600));
    }
}
