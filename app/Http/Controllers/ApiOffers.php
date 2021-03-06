<?php

namespace App\Http\Controllers;

use App\ModelOffersPromo;

class ApiOffers extends Controller
{
    public function Index()
    {
        $data = ModelOffersPromo::all()->sortByDesc('w_insert')->take(5);
        foreach ($data as $row) {
            $return[] = array(
                'no' => $row->id,
                'judulPromo' => $row->JudulPromo,
                'deskripsiPromo' => $row->DeskripsiPromo,
                'urlGambar' => $row->UrlGambar,
            );
        }
        return $return;
    }

    public function SeeAll()
    {
        $data = ModelOffersPromo::all();
        foreach ($data as $row) {
            $return[] = array(
                'no' => $row->id,
                'judulPromo' => $row->JudulPromo,
                'deskripsiPromo' => $row->DeskripsiPromo,
                'urlGambar' => $row->UrlGambar,
            );
        }
        return $return;
    }



    public function Detail($id)
    {
        $data = ModelOffersPromo::find($id);
        $return[] = array(
            'judulPromo' => $data->JudulPromo,
            'deskripsiPromo' => $data->DeskripsiPromo,
            'urlGambar' => $data->UrlGambar,
        );
        return $return;
    }
}
