<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::any('/{any}', function (Request $request) {
    $targetUrl = env('PROXY_TARGET') . $request->getRequestUri();

    $headers = [
        'Authorization' => $request->headers->get('Authorization'),
        'Content-Type' => $request->headers->get('Content-Type')
    ];

    switch ($request->getMethod()) {
        case 'GET':
            return Http::withHeaders($headers)->get($targetUrl, $request->all())->body();
        case 'POST':
            return Http::withHeaders($headers)->post($targetUrl, $request->all())->body();
        case 'PATCH':
        case 'PUT':
            return Http::withHeaders($headers)->put($targetUrl, $request->all())->body();
        case 'DELETE':
            return Http::withHeaders($headers)->delete($targetUrl)->body();
    }

    return '=)';
})->where('any', '.*');
