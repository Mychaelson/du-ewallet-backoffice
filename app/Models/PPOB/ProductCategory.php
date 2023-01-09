<?php

namespace App\Models\PPOB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'ppob.categories';

    public function child() {
        return $this->hasMany(ProductCategory::class,'parent_id','id');
    }
}
