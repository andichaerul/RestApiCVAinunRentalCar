<?php
// http://localhost/ainun-rent/api/
use Illuminate\Support\Facades\Route;

Route::get('v1/offers', 'ApiOffers@Index');
Route::get('v1/find_armada/{tglStart}/{tglFinish}', 'FindArmada@Index');
