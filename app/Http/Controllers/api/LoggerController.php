<?php

namespace App\Http\Controllers;

use App\Models\Logger;
use Illuminate\Http\Request;

class LoggerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Logger::getAllObject($request);
    }

}
