<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Cuisines\Create as CuisinesCreate;
use App\Http\Livewire\Cuisines\Edit as CuisinesEdit;
use App\Http\Livewire\Cuisines\Index as CuisinesIndex;


Route::group(['middleware' => ['auth', 'is-active'] ], function () {
    Route::get('cuisines',CuisinesIndex::class)->name('cuisine-management');
    Route::get('cuisines/edit/{id}/{ref_lang?}',CuisinesEdit::class)->name('edit-cuisine');
    Route::get('cuisines/create',CuisinesCreate::class)->name('add-cuisine');
});