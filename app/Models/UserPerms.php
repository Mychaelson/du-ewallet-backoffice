<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPerms extends Model
{
    use HasFactory;

    protected $table = 'backoffice.user_perms';
}
