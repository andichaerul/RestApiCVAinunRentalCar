<?php

namespace App\Http\Controllers;

use App\ModelDaftarOrder;
use DateTime;
use DatePeriod;
use DateInterval;
use App\ModelMasterUnit;

class FindArmada extends Controller
{
    public function Index($tglStart, $tglFinish)
    {
        $data = ModelMasterUnit::all();

        $i = 0;
        $return = [];
        foreach ($data as $row) {
            $unitIsReady = $this->_cekKetersediaanUnit($row->id, $tglStart, $tglFinish);
            if ($unitIsReady == "unitTersedia") {
                $return[$i]['harga'] = "Rp. " . number_format($row->biayaSewaPerHari, 0, ',', '.');
                $return[$i]['namaUnitLengkap'] = $row->brand->namaBrand . " " . $row->varian->namaVarian . " " . $row->typeOrClass . " " . $row->tahun;
                $return[$i]['namaMitra'] = $row->mitra->namaMitra;
                $return[$i]['alamatMitra'] = $row->mitra->alamatMitra;
                $return[$i]['unitBrand'] = $row->brand->namaBrand;
                $return[$i]['namaUnit'] = $row->varian->namaVarian;
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

    public function OrderByVarian($tglStart, $tglFinish)
    {
        $data = $this->Index($tglStart, $tglFinish);
        $arr = array();
        foreach ($data as $key => $item) {
            $arr[$item['namaUnit']][$key] = null;
        }
        $unit = array_keys($arr);
        for ($i = 0; $i < count($unit); $i++) {
            $return['unit'][$i] = $unit[$i];
        }
        return $return;
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
}
