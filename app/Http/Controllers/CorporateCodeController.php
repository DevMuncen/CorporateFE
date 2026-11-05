<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorporateCodeController extends ProxyController
{
    /**
     * Proxy uniqueness check request to Backend.
     */
    public function proxyCheck(Request $request)
    {
        $method = $request->isMethod('post') ? 'POST' : 'GET';
        $params = $request->all();
        return $this->forward($request, $method, '/api/corporate/code/check', $params);
    }

    /**
     * Proxy code suggestion request to Backend.
     */
    public function proxySuggest(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/code/suggest', $request->all());
    }
}
