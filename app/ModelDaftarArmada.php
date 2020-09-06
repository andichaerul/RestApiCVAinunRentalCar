<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelDaftarArmada extends Model
{
    protected $table = "daftarArmada";
    protected $primaryKey = "id";

    public function mitra()
    {
        return $this->hasOne(ModelMasterMitra::class, 'id_mitra', 'idMitra');
    }

    public function varian()
    {
        return $this->hasOne(ModelMasterVarian::class, 'id', 'idVarian');
    }

    public function gambarArmada(){
        return $this->hasMany(ModelMasterGambarArmada::class, 'idGroup', 'idGambar');
    }
}
