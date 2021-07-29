<?php
use Illuminate\Support\Facades\Route;

// Route::get('greeting', function () {
//     return 'Hi, this is your awesome package! Mcqanpt';
// });

// Route::get('picmatch/test', 'EdgeWizz\Picmatch\Controllers\PicmatchController@test')->name('test');

Route::post('fmt/gridtnf/store', 'EdgeWizz\Gridtnf\Controllers\GridtnfController@store')->name('fmt.gridtnf.store');
Route::post('fmt/gridtnf/update/{id}', 'EdgeWizz\Gridtnf\Controllers\GridtnfController@update')->name('fmt.gridtnf.update');
Route::post('fmt/gridtnf/csv_upload', 'EdgeWizz\Gridtnf\Controllers\GridtnfController@csv_upload')->name('fmt.gridtnf.csv');

/* 
Route::any('fmt/gridtnf/delete/{id}', 'EdgeWizz\Gridtnf\Controllers\GridtnfController@delete')->name('fmt.gridtnf.delete');
Route::any('fmt/gridtnf/inactive/{id}',  'EdgeWizz\Gridtnf\Controllers\GridtnfController@inactive')->name('fmt.gridtnf.inactive');
Route::any('fmt/gridtnf/active/{id}',  'EdgeWizz\Gridtnf\Controllers\GridtnfController@active')->name('fmt.gridtnf.active'); 
*/
