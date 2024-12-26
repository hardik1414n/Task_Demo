<?php

use App\Http\Controllers\Productcontroller;
use Illuminate\Support\Facades\Route;

Route::get('/', [Productcontroller::class,'index']);
Route::get('get_session', [Productcontroller::class,'getsession']);
Route::get('show_session', [Productcontroller::class,'show_session']);

Route::get('remove_value', [Productcontroller::class,'remove']);


Route::get('delete_session', function(){
    session()->forget('values');
    echo "<h1>Session Destroyed</h1>";
});


Route::post('select_product',[Productcontroller::class,'select_product'])->name('select_product');

Route::post('add_product',[Productcontroller::class, 'add_product'])->name('add.product');

Route::post('store_invoice',[Productcontroller::class,'store_invoice'])->name('store.invoice');

Route::post('remove_product',[Productcontroller::class, 'remove_product'])->name('remove.product');

Route::post('edit_product',[Productcontroller::class,'edit_product'])->name('edit.product');

Route::post('qty_units',[Productcontroller::class, 'qty_units'])->name('qty.units');