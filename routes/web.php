<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => abort(404))->name("home");
Route::get('/login', fn () => abort(404))->name("login");
