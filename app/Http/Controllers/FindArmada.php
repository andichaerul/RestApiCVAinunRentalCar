<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use App\ModelOrders;
use App\ModelDaftarArmada;

class FindArmada extends Controller
{
    public function Index($tglStart, $tglFinish)
    {
        $idArmadaReady = $this->_findArmadaReady($tglStart, $tglFinish);
        $return = [];
        for ($i = 0; $i < count($idArmadaReady); $i++) {
            $detailArmada = ModelDaftarArmada::find($idArmadaReady[$i]);
            foreach ($detailArmada->gambarArmada as $urlGambar) {
                $urlGambarArr[$detailArmada->id][] = $urlGambar->url;
            }
            $return[] = array(
                'namaMitra' => (empty($detailArmada->mitra)) ? null : $detailArmada->mitra->nama_mitra,
                'unitBrand' => (empty($detailArmada->varian)) ? null : $detailArmada->varian->brand->namaBrand,
                'namaUnit' => (empty($detailArmada->varian)) ? null : $detailArmada->varian->namaVarian,
                'typeVarian' => (empty($detailArmada->varian)) ? null : $detailArmada->varian->typeUnit,
                'warna' => (empty($detailArmada->varian)) ? null : $detailArmada->varian->warna,
                'isMatic' => (empty($detailArmada->varian)) ? null : $detailArmada->varian->isMatic,
                'tahunKendaraan' => (empty($row)) ? null : $detailArmada->tahunArmada,
                'isIncludeDriver' => (empty($row)) ? null : $detailArmada->isIncludeDriver,
                'urlGambar' => $urlGambarArr[$detailArmada->id]
            );
        }
        return $return;
    }

    public function _tglPemakaian($tglStart, $tglFinish)
    {
        $begin = new DateTime($tglStart);
        $end = new DateTime($tglFinish);
        $end = $end->modify('+1 day');
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);
        foreach ($daterange as $date) {
            $test[] = $date->format("Y-m-d");
        }
        if (empty($test)) {
            $error = array(
                'status' => 'error',
            );
            die(json_encode($error));
        } else {
            return $test;
        }
    }

    public function _findArmadaReady($tglStart, $tglFinish)
    {
        $idArmadaReady = [];
        $data = ModelOrders::all();
        $tglPemakaian = $this->_tglPemakaian($tglStart, $tglFinish);
        foreach ($data as $row) {
            $id = $row->id;
            $begin = new DateTime($row->dariTanggal);
            $end = new DateTime($row->sampaiTanggal);
            $end = $end->modify('+1 day');

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval, $end);
            foreach ($daterange as $date) {
                $test[$id][] = $date->format("Y-m-d");
            }
            for ($i = 0; $i < count($tglPemakaian); $i++) {
                $dede[$i] = array_search($tglPemakaian[$i], $test[$id]);
                if (array_search($tglPemakaian[$i], $test[$id]) === false) {
                    null;
                } else {
                    $tidakTersedia[$id] = $id;
                }
            }
            if (empty($tidakTersedia[$id])) {
                $idArmadaReady[] = $id;
            }
        }
        return $idArmadaReady;
    }
}
