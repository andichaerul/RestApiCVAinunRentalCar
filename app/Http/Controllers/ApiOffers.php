<?php

namespace App\Http\Controllers;

use App\ModelOffersPromo;

class ApiOffers extends Controller
{
    public function Index()
    {
        $data = ModelOffersPromo::all();
        return $data;
    }

    public function SeeAll()
    {
        $data = ModelOffersPromo::all();
        foreach ($data as $row) {
            $return[] = array(
                'judulPromo' => $row->JudulPromo,
                'deskripsiPromo' => $row->DeskripsiPromo,
                'urlGambar' => $row->UrlGambar,
            );
        }
        return $return;
    }
}
