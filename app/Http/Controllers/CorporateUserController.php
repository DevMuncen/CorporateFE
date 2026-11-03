<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorporateUserController extends ProxyController
{
    public function index()
    {
        if (session('user_role') !== 'corporate_admin' && session()->has('user_role')) {
            abort(403, 'Akses ditolak. Hanya PIC Admin yang memiliki hak akses ke Manajemen Pengguna.');
        }

        return view('users.index');
    }

    public function proxyList(Request $request)
    {
        if (session('user_role') !== 'corporate_admin' && session()->has('user_role')) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak. Hanya PIC Admin yang memiliki hak akses ke Manajemen Pengguna.'], 403);
        }

        return $this->forward($request, 'GET', '/api/corporate/users', $request->all());
    }

    public function proxyStore(Request $request)
    {
        if (session('user_role') !== 'corporate_admin' && session()->has('user_role')) {
            return response()->json(['status' => 'error', 'message' => 'Hanya PIC Admin Corporate yang dapat menambah pengguna baru.'], 403);
        }

        return $this->forward($request, 'POST', '/api/corporate/users', $request->all());
    }

    public function proxyShow(Request $request, $id)
    {
        if (session('user_role') !== 'corporate_admin' && session()->has('user_role')) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak. Hanya PIC Admin yang memiliki hak akses.'], 403);
        }

        return $this->forward($request, 'GET', "/api/corporate/users/{$id}");
    }

    public function proxyUpdate(Request $request, $id)
    {
        if (session('user_role') !== 'corporate_admin' && session()->has('user_role')) {
            return response()->json(['status' => 'error', 'message' => 'Hanya PIC Admin Corporate yang dapat mengubah data pengguna.'], 403);
        }

        return $this->forward($request, 'PUT', "/api/corporate/users/{$id}", $request->all());
    }

    public function proxyDestroy(Request $request, $id)
    {
        if (session('user_role') !== 'corporate_admin' && session()->has('user_role')) {
            return response()->json(['status' => 'error', 'message' => 'Hanya PIC Admin Corporate yang dapat menghapus pengguna.'], 403);
        }

        return $this->forward($request, 'DELETE', "/api/corporate/users/{$id}");
    }
}
