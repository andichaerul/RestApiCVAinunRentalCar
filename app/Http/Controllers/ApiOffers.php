<?php

namespace App\Http\Controllers;

use App\ModelOffers;

class ApiOffers extends Controller
{
    public function Index()
    {
        $data = ModelOffers::all();
        return $data;
    }
}
