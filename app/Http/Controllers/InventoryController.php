<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends ProxyController
{
    public function stocks()
    {
        return view('inventory.stocks');
    }

    public function itemIns()
    {
        return view('inventory.item-ins');
    }

    public function itemOuts()
    {
        return view('inventory.item-outs');
    }

    public function proxyItemIns(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/item-ins', $request->all());
    }

    public function proxyStoreItemIn(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/item-ins', $request->all());
    }

    public function proxyItemOuts(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/item-outs', $request->all());
    }

    public function proxyStoreItemOut(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/item-outs', $request->all());
    }
}
