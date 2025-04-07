<?php

namespace App\Services\Transfer;

use App\Models\Transfer;
use App\Models\User;

class TransferExecutor
{
    public function execute(array $data): array
    {
        $payer = User::findOrFail($data['payer']);
        $payee = User::findOrFail($data['payee']);
        $value = $data['value'];

        $payer->account()->decrement('balance', $value);
        $payee->account()->increment('balance', $value);

        Transfer::create([
            'account_id' => $payer->account->id,
            'type' => 'output',
            'payer_id' => $payer->id,
            'payee_id' => $payee->id,
            'value' => $value,
            'idempotency_key' => $data['idempotency_key'],
        ]);

        Transfer::create([
            'account_id' => $payee->account->id,
            'type' => 'input',
            'payer_id' => $payer->id,
            'payee_id' => $payee->id,
            'value' => $value,
        ]);

        return [
            'from' => $payer->id,
            'to' => $payee->id,
            'value' => $value,
        ];
    }
}
