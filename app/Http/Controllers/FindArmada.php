<?php

namespace App\Http\Controllers;

use App\ModelDaftarOrder;
use DateTime;
use DatePeriod;
use DateInterval;
use App\ModelMasterUnit;

class FindArmada extends Controller
{
    public function Index($tglStart, $tglFinish, $sort = null, $inListVarian = null, $inListLainnya = null)
    {
        $inListVarianArr = explode('_', $inListVarian);
        $data = ModelMasterUnit::all();
        switch ($sort) {
            case 'hargaTertinggi':
                $data = $data->sortByDesc('biayaSewaPerHari');
                break;
            case 'hargaTerendah':
                $data = $data->sortBy('biayaSewaPerHari');
                break;
        }
        if ($inListVarian !== "null") {
            if ($inListVarian !== null) {
                $data = $data->whereIn('idVarian', $inListVarianArr);
            }
        }

        $i = 0;
        $return = [];
        foreach ($data as $row) {
            $unitIsReady = $this->_cekKetersediaanUnit($row->id, $tglStart, $tglFinish);
            if ($unitIsReady == "unitTersedia") {
                $return[$i]['idMobil'] = $row->id;
                $return[$i]['harga'] = "Rp. " . number_format($row->biayaSewaPerHari, 0, ',', '.');
                $return[$i]['namaUnitLengkap'] = $row->brand->namaBrand . " " . $row->varian->namaVarian . " " . $row->typeOrClass . " " . $row->tahun;
                $return[$i]['namaMitra'] = $row->mitra->namaMitra;
                $return[$i]['alamatMitra'] = $row->mitra->alamatMitra;
                $return[$i]['unitBrand'] = $row->brand->namaBrand;
                $return[$i]['namaUnit'] = $row->varian->namaVarian;
                $return[$i]['idVarian'] = $row->varian->id;
                $return[$i]['typeVarian'] = $row->typeOrClass;
                $return[$i]['warna'] = $row->warna->namaWarna;
                $return[$i]['isMatic'] = $row->isMatic;
                $return[$i]['tahunKendaraan'] = $row->tahun;
                $return[$i]['isIncludeDriver'] = $row->includeDriver;
                $return[$i]['urlGambar'] = $row->gambar->first()['urlGambar'];
                $i++;
            }
        }
        return $return;
    }
    public function GroupByVarian($tglStart, $tglFinish)
    {
        $data = $this->Index($tglStart, $tglFinish);
        $arr = array();
        foreach ($data as $key => $item) {
            $namaUnit[$item['namaUnit']][$key] = null;
            $idVarian[$item['idVarian']] = null;
        }

        $namaUnitArr = array_keys($namaUnit);
        $idVarianArr = array_keys($idVarian);
        for ($i = 0; $i < count($namaUnitArr); $i++) {
            $result[$i] = array(
                'nama' => $namaUnitArr[$i],
                'id' => $idVarianArr[$i],
            );
        }
        return $result;
    }

    public function _getTanggalSewa($tglStart, $tglFinish)
    {
        $begin = new DateTime($tglStart);
        $end = new DateTime($tglFinish);
        $end = $end->modify('+1 day');
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);
        foreach ($daterange as $date) {
            $dateArr[] = $date->format("Y-m-d");
        }
        if (empty($dateArr)) {
            $data['status'] = "error";
            die(json_encode($data));
        }
        return $dateArr;
    }

    public function _cekKetersediaanUnit($idUnit, $tglStart, $tglFinish)
    {
        $tanggalSewaCustomer = $this->_getTanggalSewa($tglStart, $tglFinish);
        $order = ModelDaftarOrder::where('idUnit', '=', $idUnit);
        if ($order->count() > 0) {
            foreach ($order->get() as $row) {
                $customer = $tanggalSewaCustomer;
                $unit = $this->_getTanggalSewa($row->dariTanggal, $row->sampaiTanggal);
                for ($i = 0; $i < count($customer); $i++) {
                    if (array_search($customer[$i], $unit) !== false) {
                        return "unitTidakTersedia";
                    }
                }
                return "unitTersedia";
            }
        } else {
            return "unitTersedia";
        }
    }

    public function Detail($id)
    {
        $data = ModelMasterUnit::find($id);
        $return[0]['idMobil'] = $data->id;;
        $return[0]['harga'] = "Rp. " . number_format($data->biayaSewaPerHari, 0, ',', '.');;
        $return[0]['namaUnitLengkap'] = $data->brand->namaBrand . " " . $data->varian->namaVarian . " " . $data->typeOrClass . " " . $data->tahun;;
        $return[0]['namaMitra'] = $data->mitra->namaMitra;;
        $return[0]['alamatMitra'] = $data->mitra->alamatMitra;;
        $return[0]['unitBrand'] = $data->brand->namaBrand;;
        $return[0]['namaUnit'] = $data->varian->namaVarian;;
        $return[0]['idVarian'] = $data->varian->id;;
        $return[0]['typeVarian'] = $data->typeOrClass;;
        $return[0]['warna'] = $data->warna->namaWarna;;
        $return[0]['isMatic'] = $data->isMatic;;
        $return[0]['tahunKendaraan'] = $data->tahun;;
        $return[0]['isIncludeDriver'] = $data->includeDriver;;
        $return[0]['urlGambar'] = $data->gambar->first()['urlGambar'];;

        return $return;
    }
}
