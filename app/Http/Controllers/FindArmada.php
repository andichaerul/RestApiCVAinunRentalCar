<?php

namespace App\Http\Controllers;

use App\ModelDaftarArmada;

class FindArmada extends Controller
{
    public function Index()
    {
        $data = ModelDaftarArmada::all();
        foreach ($data as $row) {
            foreach ($row->gambarArmada as $urlGambar) {
                $urlGambarArr[$row->id][] = $urlGambar->url;
            }
            $return[] = array(
                'namaMitra' => (empty($row->mitra)) ? null : $row->mitra->nama_mitra,
                'unitBrand' => (empty($row->varian)) ? null : $row->varian->brand->namaBrand,
                'namaUnit' => (empty($row->varian)) ? null : $row->varian->namaVarian,
                'typeVarian' => (empty($row->varian)) ? null : $row->varian->typeUnit,
                'warna' => (empty($row->varian)) ? null : $row->varian->warna,
                'isMatic' => (empty($row->varian)) ? null : $row->isMatic,
                'tahunKendaraan' => (empty($row)) ? null : $row->tahunArmada,
                'isIncludeDriver' => (empty($row)) ? null : $row->isIncludeDriver,
                'urlGambar' => $urlGambarArr[$row->id]
            );
        }
        return $return;
    }
}
