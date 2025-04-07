<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'payer_id',
        'payee_id',
        'value',
        'type',
        'idempotency_key',
    ];

    /**
     * Conta associada à transferência (relacionamento opcional se necessário).
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Pagador da transferência.
     */
    public function payer()
    {
        return $this->belongsTo(Account::class, 'payer_id');
    }

    /**
     * Recebedor da transferência.
     */
    public function payee()
    {
        return $this->belongsTo(Account::class, 'payee_id');
    }


    public function findTransferByIdempotencyKey(string $key)
    {
        return Transfer::where('idempotency_key', $key)->first();
    }
}
