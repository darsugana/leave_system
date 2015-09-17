<?php

Route::get('/', function () { return redirect('home'); });
Route::get('home', function () { return redirect()->route('leaves.index'); });

Route::controller('auth', 'Auth\AuthController');

Route::get('auth/logout', [
    'uses' => function () {
        Auth::logout();
        return redirect('auth/login');
    },
    'as' => 'auth.logout'
]);

Route::group(['middleware' => 'auth'], function () {

    Route::resource('users', 'UsersController');

    Route::resource('leave-types', 'LeaveTypesController');

    Route::put('leaves/{id}/approve', [
        'uses' => 'LeavesController@approve',
        'as'   => 'leaves.approve'
    ]);
    Route::put('leaves/{id}/reject', [
        'uses' => 'LeavesController@reject',
        'as'   => 'leaves.reject'
    ]);
    Route::resource('leaves', 'LeavesController');

});
