<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DoctorController extends Controller
{
    public function index()
    {
        return view('doctor.index');
    }

    public function timeTable()
    {
        return view('doctor.timeTable');
    }

    public function getTimeTable()
    {
        ////아래는 vue에서 parameters를 multiple로 보낼때 예제==>매우 중요
        // $a = $_GET['id']; //for test from vue
        // $b = $_GET['name']; //for test from vue
                     
        ////$doctors = Doctor::all();//cache 사용을 위해 comment

        //redis에 cache key 'docotrs'가 존재하면 cache에서 data를 읽어 오고
        //그렇지 않으면 db에서 읽어온 data를 cache에 저장 한다.
        // $second = 60; //second
        // $doctors = Cache::store('redis')->remember('doctors', $second, function() {
        //     return Doctor::all();
        // });

        //아래는 minutes를 사용 할때 cache(redis) example
        // $doctors = Cache::store('redis')->remember('doctors', now()->addMinutes(10), function() {
        //     return Doctor::all();
        // });

        //아래는 hours를 사용 할때 cache(redis) example
        $doctors = Cache::store('redis')->remember('doctors', now()->addHours(24), function() {
            return Doctor::all();
        });

        //$doctors = Cache::store('redis')->get('doctors');//for example

        //$date = date('Y-m-d');        
        //$today = (date('N', strtotime($date)) >= 6);//?...
        //$today = date('w', strtotime($date)); //1 = Monday, 6 = Saturday, 0 = Sunday
                   
        //return view('appointment.timeTable', compact('doctors'));

        return $doctors;
    }

    public function showAppointmentByDate()
    {
        $date = \Request::get('q');
        //return $date;
        $email = auth()->user()->email;
        $appointments = Appointment::with('doctor','patient')
                        ->select('*')
                        ->where('app_date', '=', $date)
                        ->where('doctor_email', '=', $email)
                        //->where('status', '!=', "completed")
                        ->orderBy('app_date', 'asc')
                        ->orderBy('app_time', 'asc')
                        ->get();
        
        return $appointments;

        //return response()->json($appointments);
    }
}
