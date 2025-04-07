<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'agencia',
        'user_id',
        'type_account',
    ];

    /**
     * Relacionamento com o usuário (cada conta pertence a um usuário).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com o tipo de conta.
     */
    public function typeAccount()
    {
        return $this->belongsTo(TypeAccount::class, 'type_account');
    }
}
