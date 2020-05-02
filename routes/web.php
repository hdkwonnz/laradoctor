<?php
use App\User;
use App\Events\AppointmentStatus;
use App\Events\WebsocketDemoEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

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
    //아래는 storage/logs 에 message를 기록하는 예제==>지우지 말 것
    // $message = "test message...";
    // Log::notice($message);

    return view('welcome');    

    //아래는 cache(redis) 사용 예제==>지우지 말 것.
    //Cache::put( 'cachekey', 'I am in the cache baby!', 120 );
    //return Cache::get( 'cachekey' );

    //Redis::set("key","testValue");
    //return Redis::get("key");

    //Cache::store('redis')->put('bar', 'baz', 600); // 10 Minutes
    // $value = Cache::get('bar');
    // return $value;

    // $user = Cache::store('redis')->remember('user', 600, function() {
    //     return User::all();
    // });
    // return response()->json($user);

    // $user = Cache::get('user');
    // return response()->json($user);
});

// Route::get('/fire', function () {
//     event(new AppointmentStatus);
//     return 'Fired';
// });

Auth::routes(['verify' => true]); //for email verification==>['verify' => true]

Route::get('profile', function () { //for email verification test =>temp
    // Only verified users may enter...
    return "This is profile";
})->middleware('verified');

Route::get('showVerificationMsg', function () { //email verification을 위하여 삽입.
    //만약 이메일 인증이 되었으면 아래 메세지가 나오고 그렇지 않으면 
    //resources/views/auth/verify.blade.php에 있는 메시가 나온다.[=>middleware('verified')]  
    return "이미 이메일 인증이 되었습니다."; //현재는 register 후에 곧바로 이 url로 오도록 RegisterController에 코딩
})->middleware('verified');                //되어 있다.

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/appointment/index', 'AppointmentController@index')->middleware('role:admin');
Route::get('/appointment/showAppointmentByDate', 'AppointmentController@showAppointmentByDate')->middleware('role:admin');
Route::get('/appointment/timeTable', 'AppointmentController@timeTable')->middleware('role:admin|doctor');//사용 중지
Route::get('/appointment/create', 'AppointmentController@create')->middleware('verified');
Route::get('/appointment/showDoctors', 'AppointmentController@showDoctors');
Route::post('/appointment/showStatus', 'AppointmentController@showStatus');
Route::post('/appointment/addAppointment', 'AppointmentController@addAppointment')->middleware('verified');
Route::post('/appointment/cancelAppointment', 'AppointmentController@cancelAppointment');
Route::post('/appointment/updateAppointment', 'AppointmentController@updateAppointment')->middleware('role:admin');
Route::post('/appointment/showPatientStatus', 'AppointmentController@showPatientStatus');

Route::get('/admin/index', 'AdminController@index')->middleware('role:admin');

Route::get('/doctor/index', 'DoctorController@index')->middleware('role:doctor');
Route::get('/doctor/showAppointmentByDate', 'DoctorController@showAppointmentByDate')->middleware('role:doctor');
Route::get('/doctor/timeTable', 'DoctorController@timeTable')->middleware('role:admin|doctor');
Route::get('/doctor/getTimeTable', 'DoctorController@getTimeTable')->middleware('role:admin|doctor');

Route::get('/patient/index', 'PatientController@index');
