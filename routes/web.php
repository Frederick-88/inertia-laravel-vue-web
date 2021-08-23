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

// -------------------------------
// --- laravel monolith way ---
// -------------------------------

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    $messageList = MessageModel::all();
    return view('about', ['messageList' => $messageList]);
});

// -------------------------------
// --- laravel-vue inertia way ---
// -------------------------------

Route::get('/hello', function () {
    $messageList = MessageModel::all();
    return Inertia::render('Hello', ['messageList' => $messageList]);
});

Route::post('/add-message', function (Request $request) {
    $validatedText = $request->validate([
        'text' => ['required', 'min:5']
    ]);

    MessageModel::create($validatedText);

    // redirect back & redirect with the specific route in this component is the same
    return redirect()->back();
});

Route::put('/update-message', function (Request $request) {
    $request->validate([
        'text'   => ['required', 'min:5'],
    ]);

    $selectedMessage = MessageModel::where('id', $request->id)->first();
    if(!$selectedMessage){
        return redirect('/hello')->withErrors(['message' => "Message ID Not Found: [{$request->id}]"]);
    }

    try {
        $selectedMessage->update([
            'text' => $request->text
        ]);
        return redirect('/hello')->withErrors(['successMessage' => "Succesfully Updated '$selectedMessage->text' Message!"]);
    } catch (\Exception $e) {
        Log::error($e);
        return redirect('/hello')->withErrors(['message' => $e->getMessage()]);
    }
});

 // for delete, to receive the id need to use POST.
// except if we are going to use controller with 'Route::resources' rather than 'Route::post'
Route::post('/delete-message', function (Request $request) {
    $selectedMessage = MessageModel::where('id', $request->id)->first();
    if(!$selectedMessage){
        return redirect('/hello')->withErrors(['message' => "Message ID Not Found: [{$request->id}]"]);
    }

    try {
        $selectedMessage->delete();
        return redirect('/hello')->withErrors(['successMessage' => "Succesfully Deleted '$selectedMessage->text' Message!"]);
    } catch (\Exception $e) {
        Log::error($e);
        return redirect('/hello')->withErrors(['message' => $e->getMessage()]);
    }
});

Route::get('/contact', function () {
    return Inertia::render('Contact');
});
