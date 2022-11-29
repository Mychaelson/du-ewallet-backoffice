<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

   protected $table ='backoffice.module';

   public function child() {
    return $this->hasMany(Module::class,'parent_id','modid');
}
}
