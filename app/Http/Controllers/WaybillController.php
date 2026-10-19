<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaybillController extends ProxyController
{
    public function index()
    {
        return view('waybills.index');
    }

    public function show($id)
    {
        return view('waybills.show', ['waybillId' => $id]);
    }

    public function print($id)
    {
        return view('waybills.print', ['waybillId' => $id]);
    }

    public function proxyList(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/waybills', $request->all());
    }

    public function proxyShow(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/waybills/{$id}");
    }

    public function proxyTracking(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/waybills/{$id}/tracking");
    }

    public function proxyPrint(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/waybills/{$id}/print");
    }
}
