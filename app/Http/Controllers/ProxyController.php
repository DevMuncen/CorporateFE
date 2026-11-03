<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    /**
     * Helper to forward proxy request with Sanctum token and Tenant Corporate ID headers
     */
    protected function forward(Request $request, string $method, string $path, array $data = [])
    {
        $token = session('api_token');
        $tenantId = session('tenant_corporate_id', 1);

        $http = Http::acceptJson()
            ->withHeaders([
                'X-Tenant-Corporate-ID' => $tenantId,
            ]);

        if ($token) {
            $http->withToken($token);
        }

        $url = config('services.backend.url').$path;

        $response = match (strtoupper($method)) {
            'GET' => $http->get($url, $data),
            'POST' => $http->post($url, $data),
            'PUT' => $http->put($url, $data),
            'PATCH' => $http->patch($url, $data),
            'DELETE' => $http->delete($url, $data),
            default => throw new \InvalidArgumentException("Unsupported HTTP method {$method}"),
        };

        $contentType = $response->header('Content-Type') ?? 'application/json';

        return response($response->body(), $response->status())
            ->header('Content-Type', $contentType);
    }

    /**
     * Helper to forward multipart/form-data requests with files
     */
    protected function forwardMultipart(Request $request, string $path, array $data = [])
    {
        $token = session('api_token');
        $tenantId = session('tenant_corporate_id', 1);

        $http = Http::acceptJson()
            ->withHeaders([
                'X-Tenant-Corporate-ID' => $tenantId,
            ]);

        if ($token) {
            $http->withToken($token);
        }

        // Attach all uploaded files
        foreach ($request->allFiles() as $fieldName => $file) {
            if (is_array($file)) {
                foreach ($file as $subIndex => $subFile) {
                    $http->attach("{$fieldName}[{$subIndex}]", file_get_contents($subFile->getRealPath()), $subFile->getClientOriginalName());
                }
            } else {
                $http->attach($fieldName, file_get_contents($file->getRealPath()), $file->getClientOriginalName());
            }
        }

        $url = config('services.backend.url').$path;
        $allData = array_merge($request->except(array_keys($request->allFiles())), $data);

        $response = $http->post($url, $allData);
        $contentType = $response->header('Content-Type') ?? 'application/json';

        return response($response->body(), $response->status())
            ->header('Content-Type', $contentType);
    }
}
