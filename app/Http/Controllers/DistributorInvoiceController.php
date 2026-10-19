<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistributorInvoiceController extends ProxyController
{
    public function index()
    {
        return view('finance.distributor-invoices.index');
    }

    public function corporateInvoices()
    {
        return view('finance.corporate-invoices.index');
    }

    public function proxyList(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/finance/distributor-invoices', $request->all());
    }

    public function proxyStore(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/finance/distributor-invoices', $request->all());
    }

    public function proxyShow(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/finance/distributor-invoices/{$id}");
    }

    public function proxyFormDependencies(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/finance/distributor-invoices/form-dependencies', $request->all());
    }

    public function proxyCorporateInvoices(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/invoices', $request->all());
    }
}
