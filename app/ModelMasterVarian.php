<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelMasterVarian extends Model
{
    protected $table = "masterVarian";
    protected $primaryKey = "id";

    public function brand()
    {
        return $this->hasOne(ModelMasterBrand::class, 'id', 'idBrand');
    }
}
