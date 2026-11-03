<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorporateProductController extends ProxyController
{
    public function index()
    {
        return view('products.index');
    }

    public function categoriesIndex()
    {
        return view('product-categories.index');
    }

    public function proxyList(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/products', $request->all());
    }

    public function proxyCheckSku(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/products/check-sku', $request->all());
    }

    public function proxyStore(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/products', $request->all());
    }

    public function proxyShow(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/products/{$id}");
    }

    public function proxyUpdate(Request $request, $id)
    {
        return $this->forward($request, 'PUT', "/api/corporate/products/{$id}", $request->all());
    }

    public function proxyDestroy(Request $request, $id)
    {
        return $this->forward($request, 'DELETE', "/api/corporate/products/{$id}");
    }

    public function proxyCategories(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/product-categories', $request->all());
    }

    public function proxyStoreCategory(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/product-categories', $request->all());
    }

    public function proxyShowCategory(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/product-categories/{$id}");
    }

    public function proxyUpdateCategory(Request $request, $id)
    {
        return $this->forward($request, 'PUT', "/api/corporate/product-categories/{$id}", $request->all());
    }

    public function proxyDestroyCategory(Request $request, $id)
    {
        return $this->forward($request, 'DELETE', "/api/corporate/product-categories/{$id}");
    }

    public function proxyUoms(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/uoms', $request->all());
    }

    public function proxyCargoTypes(Request $request)
    {
        return $this->forward($request, 'GET', '/api/cargo-types', $request->all());
    }
}
