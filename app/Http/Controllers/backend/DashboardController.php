<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;


class DashboardController extends Controller
{   

    public function index()
    {
        $template = 'admin.dashboard.home.index';

        return view('admin.dashboard.layout', compact(
            'template',
        ));
    }

}
