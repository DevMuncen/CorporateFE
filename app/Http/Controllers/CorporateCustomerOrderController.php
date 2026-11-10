<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorporateCustomerOrderController extends ProxyController
{
    public function index()
    {
        return view('orders.index');
    }

    public function create(Request $request)
    {
        return view('orders.create', [
            'editId' => $request->query('edit_id'),
        ]);
    }

    public function show($id)
    {
        return view('orders.show', ['id' => $id]);
    }

    public function proxyList(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/orders', $request->all());
    }

    public function proxyFormDependencies(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/orders/form-dependencies', $request->all());
    }

    public function proxyStore(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/orders', $request->all());
    }

    public function proxyShow(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/orders/{$id}");
    }

    public function proxyUpdate(Request $request, $id)
    {
        return $this->forward($request, 'PUT', "/api/corporate/orders/{$id}", $request->all());
    }

    public function proxyDestroy(Request $request, $id)
    {
        return $this->forward($request, 'DELETE', "/api/corporate/orders/{$id}");
    }

    public function proxyConfirm(Request $request, $id)
    {
        return $this->forward($request, 'POST', "/api/corporate/orders/{$id}/confirm", $request->all());
    }

    public function proxyCancel(Request $request, $id)
    {
        return $this->forward($request, 'POST', "/api/corporate/orders/{$id}/cancel", $request->all());
    }

    public function proxyRoPrefill(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/orders/{$id}/ro-prefill");
    }
}
