<?php

namespace App\Http\Controllers;

use Session;

class ControladorWebPostulacionGracias extends Controller
{
    public function index()
    {
            return view("web.postulacion-gracias");
    }
}