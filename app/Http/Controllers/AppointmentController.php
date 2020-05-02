<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Doctor;
use App\Status;
use App\Appointment;
use Illuminate\Http\Request;
use App\Events\AppointmentStatus;
use App\Jobs\AppointmentEmailJob;
use App\Events\PatientStatusEvent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    ///////////////////////////////////////////////////////////////////
    ///////index///////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    public function index()
    {        
        return view('appointment.index');
    }

    ///////////////////////////////////////////////////////////////////
    ///////showPatientStatus///////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    public function showPatientStatus(Request $request)
    {       
        $email = $request->doctorEmail;
        $date = date('Y-m-d'); //금일치만 보여준다
        //$appointments = Appointment::with('doctor','patient')
        $appointments = Appointment::with('patient')
                        ->select('*')
                        ->where('app_date', '=', $date)
                        ->where('doctor_email', '=', $email)
                        ->where('status', '=', 'waiting')
                        ->orderBy('app_date', 'asc')
                        ->orderBy('app_time', 'asc')
                        ->get();
        
        return $appointments;
    }

    ///////////////////////////////////////////////////////////////////
    ///////showAppointmentByDate///////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    //아래는 pagination을 사용하지 않고 한개 이상의 parameter를 json으로 
    //vue(AppointmentDate.vue)에 보낼때. pagination을 사용할때 json으로 
    //vue에 보내는 방법은 아직 찾지 못 했음.(15FEB2020)
    // public function showAppointmentByDate()
    // {
    //     $date = \Request::get('q');
    //     //return $date;
    //     $appointments = Appointment::with('doctor','patient')
    //                     ->select('*')
    //                     ->where('app_date', '=', $date)
    //                     //->where('status', '!=', "completed")
    //                     ->orderBy('app_date', 'asc')
    //                     ->orderBy('app_time', 'asc')
    //                     ->get();
    //     $count = $appointments ->count();
    //     //return $appointments;
    //     return response()->json([ //매우 중요(two objects를 vue로 보낸다)
    //         'count' => [$count],
    //         'appointments' => [$appointments]                     
    //     ]);
    // }

    //아래는 pagination을 사용 할때.
    //반드시 한개의 parameter만 보내야 한다(두개이상 보내는 방법 아직 못 찾음).    
    public function showAppointmentByDate()
    {
        //vue(AppointmentDate.vue참조)에서 parameter를 보내는 방법에 따라
        //아래처럼 받을 수도 있고
        //$date = \Request::get('q');
        
        //아래 처럼 받을 수도 있다.
        $date = $_GET['q'];

        $appointments = Appointment::with('doctor','patient')
                        ->select('*')
                        ->where('app_date', '=', $date)
                        //->where('status', '!=', "completed")
                        ->orderBy('app_date', 'asc')
                        ->orderBy('app_time', 'asc')
                        ->paginate(2);      
        return $appointments;        
    }

    ///////////////////////////////////////////////////////////////////
    ///////timeTable///////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    public function timeTable()
    {
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

        $date = date('Y-m-d');        
        //$today = (date('N', strtotime($date)) >= 6);//?...
        $today = date('w', strtotime($date)); //1 = Monday, 6 = Saturday, 0 = Sunday
                   
        return view('appointment.timeTable', compact('doctors'));
    }

    ///////////////////////////////////////////////////////////////////
    ///////create//////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    public function create()
    {
        return view('appointment.create');
    }

    ///////////////////////////////////////////////////////////////////
    ///////showDoctors/////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    public function showDoctors()
    {
        //$doctors = Doctor::all();
        
        //아래는 hours를 사용 할때 cache(redis) example
        $doctors = Cache::store('redis')->remember('doctors', now()->addHours(24), function() {
            
            return Doctor::all();
        });
        
        return $doctors;     
    }
   
    ///////////////////////////////////////////////////////////////////
    ///////showStatus//////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    public function showStatus(Request $request)
    {   
        $patientId = auth()->user()->patient_id;
        if (!$patientId){
            $status = null;
            return $status;
        }

        $this->validate($request, [
            'selectedDate' => 'required',
            'doctorId' => 'required'           
        ]);

        $selectedDate = $request->selectedDate;
        $doctorId = $request->doctorId;
             
        $whatDay = date('w', strtotime($selectedDate)); //1 = Monday, 6 = Saturday, 0 = Sunday...
        //return $whatDay;
        if(($whatDay == 0) or ($whatDay == 6))
        {
            $status = null;
            return $status;
            //return "입력하신 날짜는 휴일 입니다...";
        }
              
        $doctor = Doctor::findOrFail($doctorId);

        if($whatDay == 1){
            $workType = $doctor->mon;
        }elseif ($whatDay == 2){
            $workType = $doctor->tue;
        }elseif ($whatDay == 3){
            $workType = $doctor->wed;
        }elseif ($whatDay == 4){
            $workType = $doctor->thu;            
        }elseif ($whatDay == 5){
            $workType = $doctor->fri;
        }

        if ($workType == 'none')
        {
            $status = null;
            return $status;
        }

        if (($request->selectedDate >= $doctor->from) && ($request->selectedDate <= $doctor->to))
        {
            $status = null;
            return $status;
        }

        ////nedd to check publick holiday...

        $status = Status::select('*')
                        ->where('app_date', '=', $selectedDate)
                        ->where('doctor_id', '=', $doctorId)
                        ->first();                       
        //return response()->json($status);
       
        if ($status)
        {
            return $status;
        }
        if (!$status)
        {
            if ($workType == 'full')
            {
                $newStatus = Status::create([
                    'app_date' => $request->selectedDate,
                    'doctor_id' => $request->doctorId,
                    // 'app_0800' => false,
                    // 'app_0815' => false,
                    // 'app_0830' => false,
                    // 'app_0845' => false,
                    // 'app_0900' => false,
                    // 'app_0915' => false,
                    // 'app_0930' => false,
                    // 'app_0945' => false,
                    // 'app_1300' => false,
                    // 'app_1315' => false,
                    // 'app_1330' => false,
                    // 'app_1345' => false,
                    // 'app_1400' => false,
                    // 'app_1415' => false,
                    // 'app_1430' => false,
                    // 'app_1445' => false,
                ]);
                return $newStatus;
            }
            if ($workType == 'am')
            {
                $newStatus = Status::create([
                    'app_date' => $request->selectedDate,
                    'doctor_id' => $request->doctorId,
                    // 'app_0800' => false,
                    // 'app_0815' => false,
                    // 'app_0830' => false,
                    // 'app_0845' => false,
                    // 'app_0900' => false,
                    // 'app_0915' => false,
                    // 'app_0930' => false,
                    // 'app_0945' => false,
                    'app_1300' => 0,
                    'app_1315' => 0,
                    'app_1330' => 0,
                    'app_1345' => 0,
                    'app_1400' => 0,
                    'app_1415' => 0,
                    'app_1430' => 0,
                    'app_1445' => 0,               
                ]);
                return $newStatus;
            }
            if ($workType == 'pm')
            {
                $newStatus = Status::create([
                    'app_date' => $request->selectedDate,
                    'doctor_id' => $request->doctorId,
                    'app_0800' => 0,
                    'app_0815' => 0,
                    'app_0830' => 0,
                    'app_0845' => 0,
                    'app_0900' => 0,
                    'app_0915' => 0,
                    'app_0930' => 0,
                    'app_0945' => 0,
                    // 'app_1300' => false,
                    // 'app_1315' => false,
                    // 'app_1330' => false,
                    // 'app_1345' => false,
                    // 'app_1400' => false,
                    // 'app_1415' => false,
                    // 'app_1430' => false,
                    // 'app_1445' => false,                   
                ]);
                return $newStatus;
            }                                    
        }                           
    }

    ///////////////////////////////////////////////////////////////////
    ///////addAppointment//////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    public function addAppointment(Request $request)
    {           
        $this->validate($request, [
            'statusId' => 'required',
            'colTime' => 'required',
            'doctorId' => 'required',
            'appDate' => 'required',
            'appTime' => 'required'
        ]);
        
        //return $request->all();
        $patientId = Auth::user()->patient_id;
        if (!$patientId)
        {
            return "아직 환자번호 입력이 안되었습니다... ";
        }
        
        $status = Status::findOrFail($request->statusId);
        if ($status->{$request->colTime})////매우중요...
        {
            return "이미 다른 환자가 예약 했습니다... ";
        }
        
        $doctorEmail = $status->doctor->email;
        
        DB::beginTransaction();
        try{
            ////stackoverflow.com/questions/54034781/how-to-concatenate-variable-with-database-field-name-in-laravel-blade
            $status->{$request->colTime} = $patientId;////매우중요...
            $status->save();

            $appointment = Appointment::create([            
                'patient_id' => $patientId,
                'doctor_id' => $request->doctorId,
                'doctor_email' => $doctorEmail,
                'app_date' => $request->appDate,
                'app_time' => $request->appTime,
            ]);
            
            $appointmentId = $appointment->id; 
            $appDetails = Appointment::
                select('app_time','app_date','doctors.name AS dName','patients.name AS pName','patients.email AS pEmail')
                ->join('doctors','appointments.doctor_id','=','doctors.id')
                ->join('patients','appointments.patient_id','=','patients.id')
                ->where('appointments.id','=',$appointmentId)
                ->first();
            $patientName = $appDetails->pName;
            $doctorName = $appDetails->dName;
            $patientEmail = $appDetails->pEmail;
           
            //보낼 메일을 jobs table로 passing 한다.
            //반드시 php artisan queue:work --tries=3 --sleep=3 type 할 것.
            $job = (new AppointmentEmailJob($appointment,$patientName,$doctorName,$patientEmail))
                    ->delay(now()->addSeconds(10));
            $this->dispatch($job);
            
            DB::commit();
            return "예약이 완료 되었습니다. ==> ";
        }
        catch(Exception $e){
            DB::rollback();
            return "에러가 발생하여 처리 못했습니다...";
        }                       
    }

    ///////////////////////////////////////////////////////////////////
    ///////updateAppointment///////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    public function updateAppointment(Request $request)
    {
        $appointment = Appointment::findOrFail($request->id);
        $appointment->status = "waiting";
        $appointment->save();

        //환자 도착을 알리는 alert message를 보낸다.
        event(new AppointmentStatus($appointment));
        //위에처럼 해도 되고 아래처럼 해도 된다.
        //broadcast(new AppointmentStatus($appointment));

        //환자 도착을 알리는 내용을 화면 오른 쪽 grid(doctor/index)에 보낸다. 
        event(new PatientStatusEvent($appointment));

        //return $request->all();
    }
   
    ///////////////////////////////////////////////////////////////////
    ///////cancelAppointment///////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    public function cancelAppointment(Request $request)
    {        
        $this->validate($request, [
            'statusId' => 'required',
            'colTime' => 'required',
            'doctorId' => 'required',
            'appDate' => 'required',
            'appTime' => 'required'
        ]);
        //return $request->all();
        $patientId = Auth::user()->patient_id;          
        $status = Status::findOrFail($request->statusId);
        if ($status->{$request->colTime} != $patientId)////매우중요...
        {
            return "환자 아이디가 불일치 합니다... ";
        }
        
        //$doctorEmail = $status->doctor->email;
        
        DB::beginTransaction();
        try{
            ////stackoverflow.com/questions/54034781/how-to-concatenate-variable-with-database-field-name-in-laravel-blade
            $status->{$request->colTime} = NULL;////매우중요...
            $status->save();

            $appointment = Appointment::
                where('app_date', '=', $request->appDate)
                ->where('doctor_id', '=', $request->doctorId)
                ->where('patient_id', '=', $patientId)
                ->where('app_time', '=', $request->appTime)
                ->first();
                
            $appointment->delete(); //soft delete
            
            DB::commit();
            return "예약이 취소 되었습니다. ==> ";
        }
        catch(Exception $e){
            DB::rollback();
            return "에러가 발생하여 처리 못했습니다...";
        }                       
    }
}
