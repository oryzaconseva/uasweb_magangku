<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // <-- PASTIKAN BARIS INI ADA
use Illuminate\Foundation\Validation\ValidatesRequests; // <-- Biasanya ini juga ada
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests; // <-- PASTIKAN TRAIT INI DIGUNAKAN
}
