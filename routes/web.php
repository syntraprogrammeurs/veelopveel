<?php

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

use App\Role;
use App\User;

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/user/create', function(){
    DB::insert('insert into users(name, email,password) 
values (?,?,?)', ['Tom', 'vanhoutte.tom@gmail.com', bcrypt(123456)]);
});*/

Route::get('user/role/create', function(){
   $user = User::findOrFail(1);
   $role = new Role(['name'=>'Administrator']);
   $user->roles()->save($role);
});

Route::get('role/user/create', function(){
    $role = Role::findOrFail(1);
    $user = new User(['name'=>'Tim', 'email'=>'vanhoutte.tim@gmail.com',
        'password' => bcrypt(123456)]);
    $role->users()->save($user);
});

/** role/create***/
/*** Subscriber, Shopmanager, Editor**/
Route::get('role/create', function(){
    $myroles = ['Administrator','Subscriber','Shopmanager', 'Editor','SEO','Abonnee'];
    $testRol= Role::all(); ///* hier zitten alle rollen in van de database uit de tabel rol**/
    $teller=0;
    foreach($myroles as $myrole){
        foreach($testRol as $rol){
            if($myrole == $rol->name){
                $teller++;
            }
        }
        if($teller == 0){
            $role = new Role();
            $role->name =$myrole;
            $role->save();
        }
        $teller = 0;
    }
});

/**DATA WIJZIGEN*/
Route::get('role/update', function(){
    $user = User::findOrFail(2);
    if($user->has('roles')){
        foreach($user->roles as $role){
            if($role->name == 'Shopmanager'){
                $role->name = 'Administrator';
                $role->save();
            }

        }
    }
});

/**meerdere rollen aan 1 user toekennen**/
Route::get('/multipleroles', function(){
    $user = User::findOrFail(2);
    $user->roles()->sync([1,2,3,4]);
});


