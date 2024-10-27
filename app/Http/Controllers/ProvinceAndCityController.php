<?php

namespace App\Http\Controllers;

use App\Models\ProvinceAndCity;
use Illuminate\Http\Request;

class ProvinceAndCityController extends Controller
{
    /**
     * Get all unique provinces with their IDs.
     */
    public function getAllProvinces()
    {
        $provinces = ProvinceAndCity::select('id', 'province_name')->distinct('province_name')->get();
        // filter duplicate provinces
        $provinces = $provinces->unique('province_name');
        // make it an array
        $provinces = $provinces->values()->all();
        return response()->json($provinces);
    }

    /**
     * Get all cities for a given province with their IDs.
     */
    public function getAllCities($provinceName)
    {
        $cities = ProvinceAndCity::where('province_name', $provinceName)->select('id', 'city_name')->get();
        return response()->json($cities);
    }
}