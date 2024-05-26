<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\CustomerController;
Route::get('/', function () {
    return view('index');
});
//p
Route::post('/modifyCustomer/{cuit}', [CustomerController::class, 'modificarCliente'])->name('modificarCliente');
Route::get('/searchCustomer', function(){
    return view('modifyCustomer/Customer');
});
//Route::post('/modificarCliente', [ClienteController::class, 'modificarCliente'])->name('modificarCliente');

Route::get('/addCustomer', function () {
    return view('addCustomer');
});
/*
Route::get('/uploadFile', function () {
    return view('uploadFile');
}); 
Route::post('/uploadFile', [CsvController::class, 'processCSV'])->name('process.csv'), function(){
    return view('index');
};*/
Route::post('/searchCustomer', [CustomerController::class, 'searchCustomer'])->name('searchCustomer');
Route::post('/addCustomer', [CustomerController::class, 'addCustomer'])->name('addCustomer');