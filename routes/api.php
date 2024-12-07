<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', static function (Request $request) {
    echo 'hello';
    return $request->user();
});


Route::post('/auth/login', [AuthController::class,'login'])->name('auth.login');


Route::group(['middleware' => [ApiAuthMiddleware::class]],static function () {

    Route::group(['prefix' => 'auth','as' => 'auth.'],static function (){
        Route::get('/me', [AuthController::class,'me']);
        Route::post('/logout', [AuthController::class,'logout']);
    });

    Route::group(['prefix' => 'users', 'as' => 'users.','controller' =>  UserController::class],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'show')->name('show');
        Route::post('/','store')->name('store');
        Route::match(['put','patch'],'/{user}','update')->name('update');
        Route::match(['put','patch'],'/{id}/restore','restore')->name('restore');
        Route::delete('/{user}','destroy')->name('destroy');
        Route::delete('/{user}/force-delete','forceDelete')->name('forceDelete');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.','controller' => RoleController::class],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{role}', 'show')->name('show');
        Route::post('/','store')->name('store');
        Route::match(['put','patch'],'/{role}','update')->name('update');
        Route::delete('/{role}','destroy')->name('destroy');
    });


});


Route::post('/test',function (){
   $role = Role::find(1);

   dd($role->permissions->toArray());
});



//Route::group([],static function (){
//    Route::get('/', [UserController::class,'index']);
//});
