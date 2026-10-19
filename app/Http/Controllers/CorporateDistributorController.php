<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorporateDistributorController extends ProxyController
{
    public function index()
    {
        return view('distributors.index');
    }

    public function proxyList(Request $request)
    {
        // Queries customers or distributors
        return $this->forward($request, 'GET', '/api/corporate/customers', $request->all());
    }

    public function proxyStore(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/customers', $request->all());
    }
}
