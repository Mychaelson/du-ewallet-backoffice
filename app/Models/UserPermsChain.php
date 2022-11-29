<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermsChain extends Model
{
    use HasFactory;

    protected $table = 'backoffice.user_perms_chain';
}
