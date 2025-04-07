<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StocksController extends Controller
{
    public function index()
    {
        return view('stocks.list'); // Ensure this matches your view path
    }
}
