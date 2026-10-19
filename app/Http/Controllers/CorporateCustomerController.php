<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorporateCustomerController extends ProxyController
{
    public function index()
    {
        return view('customers.index');
    }

    public function proxyList(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/customers', $request->all());
    }

    public function proxyStore(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/customers', $request->all());
    }

    public function proxyShow(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/customers/{$id}");
    }

    public function proxyUpdate(Request $request, $id)
    {
        return $this->forward($request, 'PUT', "/api/corporate/customers/{$id}", $request->all());
    }

    public function proxyDestroy(Request $request, $id)
    {
        return $this->forward($request, 'DELETE', "/api/corporate/customers/{$id}");
    }
}
