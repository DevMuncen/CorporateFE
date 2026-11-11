<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterExcelProxyController extends ProxyController
{
    public function template(Request $request, string $entity)
    {
        return $this->forwardDownload(
            $request,
            "/api/corporate/master/{$entity}/excel-template",
            $request->query()
        );
    }

    public function import(Request $request, string $entity)
    {
        $request->validate([
            'file' => 'required|file|max:5120',
        ]);

        return $this->forwardMultipart(
            $request,
            "/api/corporate/master/{$entity}/excel-import"
        );
    }
}
