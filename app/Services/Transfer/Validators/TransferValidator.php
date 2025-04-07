<?php

namespace App\Services\Transfer\Validators;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class TransferValidator
{
    public function validate(array $data)
    {
        $payer = User::findOrFail($data['payer']);
        $payee = User::findOrFail($data['payee']);

        if ($payer->id === $payee->id) {
            throw new \Exception('Payer e Payee devem ser diferentes.', 422);
        }

        if ($payer->account->typeAccount['internal_name'] === 'merchant') {
            throw new \Exception('Lojistas não podem transferir.', 403);
        }

        if ($payer->account->balance < $data['value']) {
            throw new \Exception('Saldo insuficiente.', 400);
        }

        $cacheKey = "recent_transaction_{$payer->id}";
        $last = Cache::get($cacheKey);
        if ($last && $last['payee'] == $payee->id && $last['value'] == $data['value']) {
            throw new \Exception('Transação idêntica detectada.', 409);
        }
    }
}
