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
}
