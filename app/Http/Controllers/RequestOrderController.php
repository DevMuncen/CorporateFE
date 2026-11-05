<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestOrderController extends ProxyController
{
    public function index()
    {
        return view('request-orders.index');
    }

    public function create()
    {
        return view('request-orders.create');
    }

    public function show($id)
    {
        return view('request-orders.show', ['id' => $id]);
    }

    public function distributorOrdersIndex()
    {
        return view('distributor-orders.index');
    }

    public function proxyList(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/request-orders', $request->all());
    }

    public function proxyStore(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/request-orders', $request->all());
    }

    public function proxyShow(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/request-orders/{$id}");
    }

    public function proxyUpdate(Request $request, $id)
    {
        return $this->forward($request, 'PUT', "/api/corporate/request-orders/{$id}", $request->all());
    }

    public function proxySubmit(Request $request, $id)
    {
        return $this->forward($request, 'POST', "/api/corporate/request-orders/{$id}/submit", $request->all());
    }

    public function proxyWithdraw(Request $request, $id)
    {
        return $this->forward($request, 'POST', "/api/corporate/request-orders/{$id}/withdraw", $request->all());
    }

    public function proxyDestroy(Request $request, $id)
    {
        return $this->forward($request, 'DELETE', "/api/corporate/request-orders/{$id}");
    }

    public function proxyInquireRoutes(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/request-orders/inquire-routes', $request->all());
    }

    public function proxyCalculatePricing(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/request-orders/calculate-pricing', $request->all());
    }

    public function proxyFormDependencies(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/form-dependencies/request-order', $request->all());
    }

    public function proxyDistributorOrders(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/distributor-orders', $request->all());
    }

    public function proxyLogisticVendors(Request $request)
    {
        return $this->forward($request, 'GET', '/api/master/logistic-vendors/options', $request->all());
    }
}
