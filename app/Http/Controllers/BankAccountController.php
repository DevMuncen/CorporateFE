<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BankAccountController extends ProxyController
{
    /**
     * Display Corporate Bank Accounts and VA Partnership page.
     */
    public function index()
    {
        return view('finance.bank-accounts.index');
    }

    /**
     * Proxy GET: List bank accounts belonging to this corporate merchant.
     */
    public function proxyList(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/finance/bank-accounts', $request->all());
    }

    /**
     * Proxy POST: Store a newly created bank account.
     */
    public function proxyStore(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/finance/bank-accounts', $request->all());
    }

    /**
     * Proxy GET: Retrieve single bank account details.
     */
    public function proxyShow(Request $request, $id)
    {
        return $this->forward($request, 'GET', '/api/corporate/finance/bank-accounts/'.$id);
    }

    /**
     * Proxy PUT: Update bank account information.
     */
    public function proxyUpdate(Request $request, $id)
    {
        return $this->forward($request, 'PUT', '/api/corporate/finance/bank-accounts/'.$id, $request->all());
    }

    /**
     * Proxy DELETE: Soft delete bank account.
     */
    public function proxyDestroy(Request $request, $id)
    {
        return $this->forward($request, 'DELETE', '/api/corporate/finance/bank-accounts/'.$id);
    }

    /**
     * Proxy POST: Set a bank account as default.
     */
    public function proxySetDefault(Request $request, $id)
    {
        return $this->forward($request, 'POST', '/api/corporate/finance/bank-accounts/'.$id.'/set-default', $request->all());
    }

    /**
     * Proxy GET: List available COA Kas & Bank accounts.
     */
    public function proxyCoaOptions(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/finance/bank-accounts/coa-options', $request->all());
    }
}
