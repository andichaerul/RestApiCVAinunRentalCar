<?php
http://localhost/ainun-rent/api/
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('v1/offers','ApiOffers@Index');
Route::get('v1/find_armada','FindArmada@Index');
