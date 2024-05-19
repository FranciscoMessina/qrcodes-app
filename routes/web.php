<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Volt::route('/dashboard', 'pages.dashboard')
    ->middleware(['auth', 'verified'])->name('dashboard');


Route::post('qrs', function () {
    $data = request()->validate([
        'name' => 'required|string',
        'type' => 'required|string',
        'data' => 'required|string',
    ]);

    $data['url_id'] = Str::random(10);

//    ddd($data);

    auth()->user()->qr_codes()->create($data);

    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('qrs.store');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
