<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelMasterUnit extends Model
{
    protected $table = 'masterUnit';
    protected $primaryKey = 'id';

    public function mitra()
    {
        return $this->hasOne(ModelMasterMitra::class, 'id', 'idMitra');
    }

    public function brand()
    {
        return $this->hasOne(ModelMasterBrand::class, 'id', 'idBrand');
    }

    public function warna()
    {
        return $this->hasOne(ModelMasterWarna::class, 'id', 'idWarna');
    }

    public function gambar()
    {
        return $this->hasMany(ModelGaleriUnit::class, 'idUnit', 'id');
    }

    public function varian()
    {
        return $this->hasOne(ModelMasterVarian::class, 'id', 'idVarian');
    }
}
