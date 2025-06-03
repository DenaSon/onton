<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Home\Index;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;


Route::get('/', Index::class)->name('home');





Route::get('/out',Logout::class )->name('logout');


Route::get('/dashboard',\App\Livewire\Dashboard\Overview::class)->name('dashboard');
