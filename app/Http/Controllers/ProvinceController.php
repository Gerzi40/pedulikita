<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function cities(string $id)
    {
        $cities = Province::find($id)->cities;
        return $cities;
    }
}
