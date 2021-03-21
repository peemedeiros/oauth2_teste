<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('prepare-to-login', function () {
    $state = Str::random(40);

    session([
        'state' => $state
    ]);

    $query = http_build_query([
        'client_id' => 3,
        'redirect_url' => 'http://localhost:8001/callback',
        'response_type' => 'code',
        'scope' => '',
        'state' => $state
    ]);

    return redirect('http://localhost:8000/oauth/authorize?'.$query);
})->name('prepare.login');

//exemplo de login estilo rede social onde o backend deve autorizar a geração do acess token
Route::get('callback', function(Request $request) {
//
    $response = Http::post('http://localhost:8000/oauth/token', [
        'grant_type' => 'authorization_code',
        'client_id' => 3,
        'client_secret' => '2cnUGrJyEk9amUSD0Af27D1uUzj1whH4ZBnOnbFb',
        'redirect_url' => 'http://localhost:8001/callback',
        'code' => $request->code
    ]);

    dd($response->json());
});

//usando o grant password access token gerado a partir de um usuário cadastrado na base de dados da API
Route::get('grant-password', function() {
    $response = Http::post('http://localhost:8000/oauth/token', [
        'grant_type' => 'password',
        'client_id' => 4,
        'client_secret' => 'aCUmNr8UcY8DA36dJ0wu3RhK95cwgZVN0vMgEOy3',
        'username' => 'pedro@gmail.com',
        'password' => '123123123',
        'scope' => ''
    ]);

    dd($response->json());
});
