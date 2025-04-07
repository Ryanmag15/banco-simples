<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'internal_name',
    ];

    /**
     * Relacionamento: um tipo de conta pode ter muitas contas associadas.
     */
    public function accounts()
    {
        return $this->hasMany(Account::class, 'type_account');
    }
}
