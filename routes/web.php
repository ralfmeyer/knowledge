<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CreateDataComponent;
use App\Livewire\TestComponent;
use App\Livewire\HtmlEditorComponent;
use App\Livewire\ResizeableBox;

//Route::view('/', '');

Route::view('/', 'startseite')
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::get('scrollbox', ResizeableBox::class)
    ->middleware(['auth'])
    ->name('scrollbox');

Route::get('create', CreateDataComponent::class)
    ->middleware(['auth'])
    ->name('create');

Route::get('xxx', TestComponent::class)
->middleware(['auth'])
->name('xxx');

Route::get('edit/{pid}', CreateDataComponent::class)
    ->middleware(['auth'])
    ->name('edit');

Route::get('ckedit/{pid}', HtmlEditorComponent::class)
->middleware(['auth'])
->name('ckedit');

require __DIR__.'/auth.php';
