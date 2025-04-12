<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    public function listOrderShipper()
    {
        return view('shipper.list-order');
    }

    public function accountShipper()
    {
        return view('shipper.shipper-account');
    }

    public function deliveredShipper()
    {
        return view('shipper.shipper-order');
    }
}
