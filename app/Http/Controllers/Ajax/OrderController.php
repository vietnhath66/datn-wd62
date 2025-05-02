<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\OrderServiceInterface as OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $OrderService;

    public function __construct(
        OrderService $OrderService,
    ) {
        $this->OrderService = $OrderService;
    }

    public function chart(Request $request){
        $chart = $this->OrderService->ajaxOrderChart($request);

        return response()->json($chart);
    }
}
