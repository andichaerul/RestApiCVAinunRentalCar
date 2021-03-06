<?php
// http://localhost/ainun-rent/api/
use Illuminate\Support\Facades\Route;

Route::get('v1/offers', 'ApiOffers@Index');
Route::get('v1/offers/see_all', 'ApiOffers@SeeAll');
Route::get('v1/offers/detail/{id}', 'ApiOffers@Detail');


Route::get('v1/find_armada/{tglStart}/{tglFinish}/{sort}/{inListVarian}/{inListLainnya}', 'FindArmada@Index');
Route::get('v1/find_armada/group_by_varian/{tglStart}/{tglFinish}', 'FindArmada@GroupByVarian');
