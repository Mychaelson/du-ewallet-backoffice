<?php

namespace App\Models\WalletUser;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawBlacklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_id',
        'bank_account',
        'status'
    ];

    protected $table = 'wallet.withdraw_blacklist';
}
