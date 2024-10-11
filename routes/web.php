<?php

use Illuminate\Support\Facades\Route;

//Route::view('/', '');

Route::view('/', 'startseite')
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('create', 'createdata')
->middleware(['auth'])
->name('create');

Route::get('edit/{id}', function ($id) {
    // Hier kannst du Logik hinzufügen, z.B. die Datenbank abfragen
    return view('createdata', ['id' => $id]);
})->middleware(['auth'])->name('edit');


require __DIR__.'/auth.php';
