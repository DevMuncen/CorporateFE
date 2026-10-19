<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorporateVendorController extends ProxyController
{
    public function index()
    {
        return view('vendors.index');
    }

    public function proxyList(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/vendors', $request->all());
    }

    public function proxyStore(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/vendors', $request->all());
    }

    public function proxyShow(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/vendors/{$id}");
    }

    public function proxyUpdate(Request $request, $id)
    {
        return $this->forward($request, 'PUT', "/api/corporate/vendors/{$id}", $request->all());
    }

    public function proxyDestroy(Request $request, $id)
    {
        return $this->forward($request, 'DELETE', "/api/corporate/vendors/{$id}");
    }
}
