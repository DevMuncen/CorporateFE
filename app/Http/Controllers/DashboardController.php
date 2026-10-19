<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends ProxyController
{
    public function index()
    {
        return view('dashboard');
    }

    public function proxyStats(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/dashboard/mobile', $request->all());
    }
}
