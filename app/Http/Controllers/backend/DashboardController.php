<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\OrderServiceInterface as OrderService;

class DashboardController extends Controller
{   


    protected $OrderService;

    public function __construct(
        OrderService $OrderService,

    ) {
        $this->OrderService = $OrderService;
    }

    public function index()
    {
        $orderStatistic = $this->OrderService->orderStatistic();
        // dd($orderStatistic);
        // $customerStatistic = $this->CustomerService->customerStatistic();
        $template = 'admin.dashboard.home.index';

        return view('admin.dashboard.layout', compact(
            'template',
            'orderStatistic'
        ));
    }

}
