<?php

use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\MessageModel;

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

// --- laravel monolith way ---

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    $messageList = MessageModel::all();
    return view('about', ['messageList' => $messageList]);
});

// --- laravel-vue inertia way ---

Route::get('/hello', function () {
    $messageList = MessageModel::all();
    return Inertia::render('Hello', ['messageList' => $messageList]);
});

Route::post('/add-message', function (Request $request) {
    $validatedText = $request->validate([
        'text' => ['required','min:5']
    ]);

    MessageModel::create($validatedText);

    return redirect('/hello');
});

Route::get('/contact', function () {
    return Inertia::render('Contact');
});
