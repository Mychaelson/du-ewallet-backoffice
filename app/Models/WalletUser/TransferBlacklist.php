<?php

namespace App\Models\WalletUser;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferBlacklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_id',
        'status'
    ];

    protected $table = 'wallet.transfer_blacklist';
}
