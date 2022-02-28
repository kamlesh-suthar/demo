<?php

use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('project', '\App\Http\Controllers\ProjectController')->names('projects');

    Route::resource('employee', '\App\Http\Controllers\EmployeeController')->names('employees');
    Route::get('/employees/{format}', [App\Http\Controllers\EmployeeController::class, 'report'])->name('employee.report');
    Route::post('/employees/image-upload', [App\Http\Controllers\EmployeeController::class, 'imageUpload'])->name('employee.image-upload');

    Route::resource('customers', '\App\Http\Controllers\CustomerController')->names('customers');

    Route::resource('blog', '\App\Http\Controllers\BlogController')->names('blog');
    Route::get('blogs/export', [\App\Http\Controllers\BlogController::class, 'export'])->name('blog.export');
    Route::get('blogs/export_format/{format}', [\App\Http\Controllers\BlogController::class, 'exportFormat'])->name('blog.export_format');
    Route::get('blogs/export_sheets', [\App\Http\Controllers\BlogController::class, 'exportSheets'])->name('blog.export_sheets');
    Route::get('blogs/export_heading', [\App\Http\Controllers\BlogController::class, 'exportHeading'])->name('blog.export_heading');
    Route::get('blogs/export_mapping', [\App\Http\Controllers\BlogController::class, 'exportMapping'])->name('blog.export_mapping');
    Route::get('blogs/export_autosize', [\App\Http\Controllers\BlogController::class, 'exportAutoSize'])->name('blog.export_autosize');
    Route::post('blogs/import', [\App\Http\Controllers\BlogController::class, 'import'])->name('blog.import');

});
