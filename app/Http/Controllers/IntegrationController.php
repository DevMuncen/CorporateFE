<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntegrationController extends ProxyController
{
    public function index()
    {
        $backendUrl = rtrim(config('services.backend.url') ?: config('app.backend_url') ?: env('BACKEND_URL', 'http://127.0.0.1:8001'), '/');
        return view('integrations.index', compact('backendUrl'));
    }

    public function proxyAppsList(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/integrations/apps', $request->all());
    }

    public function proxyAppsCheckCode(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/integrations/apps/check-code', $request->all());
    }

    public function proxyAppsStore(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/integrations/apps', $request->all());
    }

    public function proxyAppsShow(Request $request, $id)
    {
        return $this->forward($request, 'GET', "/api/corporate/integrations/apps/{$id}");
    }

    public function proxyAppsUpdate(Request $request, $id)
    {
        return $this->forward($request, 'PUT', "/api/corporate/integrations/apps/{$id}", $request->all());
    }

    public function proxyAppsRotateSecret(Request $request, $id)
    {
        return $this->forward($request, 'POST', "/api/corporate/integrations/apps/{$id}/rotate-secret", $request->all());
    }

    public function proxyAppsSetStatus(Request $request, $id)
    {
        return $this->forward($request, 'POST', "/api/corporate/integrations/apps/{$id}/status", $request->all());
    }

    public function proxyAppsDestroy(Request $request, $id)
    {
        return $this->forward($request, 'DELETE', "/api/corporate/integrations/apps/{$id}");
    }

    public function proxyWebhooksList(Request $request, $appId)
    {
        return $this->forward($request, 'GET', "/api/corporate/integrations/apps/{$appId}/webhooks");
    }

    public function proxyWebhooksStore(Request $request, $appId)
    {
        return $this->forward($request, 'POST', "/api/corporate/integrations/apps/{$appId}/webhooks", $request->all());
    }

    public function proxyWebhooksPing(Request $request, $appId, $webhookId)
    {
        return $this->forward($request, 'POST', "/api/corporate/integrations/apps/{$appId}/webhooks/{$webhookId}/ping");
    }

    public function proxyWebhooksResetCircuit(Request $request, $appId, $webhookId)
    {
        return $this->forward($request, 'POST', "/api/corporate/integrations/apps/{$appId}/webhooks/{$webhookId}/reset-circuit");
    }

    public function proxyLogsInbound(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/integrations/logs/inbound', $request->all());
    }

    public function proxyLogsOutbound(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/integrations/logs/outbound', $request->all());
    }

    public function proxyOutboundRetry(Request $request, $logId)
    {
        return $this->forward($request, 'POST', "/api/corporate/integrations/logs/outbound/{$logId}/retry");
    }

    public function proxyOutboundRetryBulk(Request $request)
    {
        return $this->forward($request, 'POST', '/api/corporate/integrations/logs/outbound/retry-bulk');
    }

    public function proxyMappingsList(Request $request)
    {
        return $this->forward($request, 'GET', '/api/corporate/integrations/mappings', $request->all());
    }
}
