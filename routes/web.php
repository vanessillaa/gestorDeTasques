<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TascaController;

Route::get('/', [TascaController::class, 'mostrarWelcome'])->name('tasques.index');
Route::post('/tasques', [TascaController::class, 'store'])->name('tasques.store');
Route::put('/tasques/{titol}', [TascaController::class, 'update'])->name('tasques.update');
Route::delete('/tasques/{titol}', [TascaController::class, 'destroy'])->name('tasques.destroy');

