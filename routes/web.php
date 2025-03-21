<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => abort(404))->name("home");
