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
        return $this->forward($request, 'GET', '/api/corporate/distributors', $request->all());
    }

    public function proxyStore(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/distributors', $request->all());
    }

    public function proxyShow(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/distributors/{$id}");
    }

    public function proxyUpdate(Request $request, $id)
    {
        return $this->forward($request, 'PUT', "/api/corporate/distributors/{$id}", $request->all());
    }

    public function proxyDestroy(Request $request, $id)
    {
        return $this->forward($request, 'DELETE', "/api/corporate/distributors/{$id}");
    }

    public function store(Request $request)
    {
        return $this->proxyStore($request);
    }

    public function show(Request $request, $id)
    {
        return $this->proxyShow($request, $id);
    }

    public function update(Request $request, $id)
    {
        return $this->proxyUpdate($request, $id);
    }

    public function destroy(Request $request, $id)
    {
        return $this->proxyDestroy($request, $id);
    }
}
