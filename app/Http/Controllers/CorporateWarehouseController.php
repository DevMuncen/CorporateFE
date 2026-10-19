<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorporateWarehouseController extends ProxyController
{
    public function index()
    {
        return view('warehouses.index');
    }

    public function proxyList(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/warehouses', $request->all());
    }

    public function proxyStore(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/warehouses', $request->all());
    }

    public function proxyShow(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/warehouses/{$id}");
    }

    public function proxyUpdate(Request $request, $id)
    {
        return $this->forward($request, 'PUT', "/api/corporate/warehouses/{$id}", $request->all());
    }

    public function proxyDestroy(Request $request, $id)
    {
        return $this->forward($request, 'DELETE', "/api/corporate/warehouses/{$id}");
    }

    public function proxyCities(Request $request)
    {
        return $this->forward($request, 'GET', '/api/wilayah/kota', $request->all());
    }
}
