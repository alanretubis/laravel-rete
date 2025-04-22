<?php
use Illuminate\Support\Facades\Route;
use AlanRetubis\LaravelRete\Http\Controllers\RuleController;

Route::middleware(['web'])->prefix('laravel-rete')->group(function () {
    Route::get('rules', [RuleController::class, 'index'])->name('rete.rules.index');
    Route::post('rules', [RuleController::class, 'store'])->name('rete.rules.store');
});
