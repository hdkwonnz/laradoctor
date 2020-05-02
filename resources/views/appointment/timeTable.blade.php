@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <script>
            var todate = new Date();
            ////alert(todate);           
            ////var today = todate.getDay();
            ////var isWeekend = (today == 6) || (today == 0); //1 = Monday, 6 = Saturday, 0 = Sunday
            ////alert("##   " + isWeekend); //true or false

            var today = todate.getDay();
            //alert("**  " + today);
        </script>

        <div class="row">
            <div class="col-lg-1">NAME</div>
            <div class="col-lg-3">HOLIDAY</div>
            <div class="col-lg-1">MON</div>
            <div class="col-lg-1">TUE</div>
            <div class="col-lg-1">WED</div>
            <div class="col-lg-1">THU</div>
            <div class="col-lg-1">FRI</div>
        </div>
        @foreach ($doctors as $doctor)
            <div class="row">
                <div class="col-lg-1"><a href="">{{$doctor->name}}</a></div>
                <div class="col-lg-3">{{$doctor->from}} ==> {{$doctor->to}}</div>                
                <div class="col-lg-1">{{$doctor->mon}}</div>
                <div class="col-lg-1">{{$doctor->tue}}</div>
                <div class="col-lg-1">{{$doctor->wed}}</div>
                <div class="col-lg-1">{{$doctor->thu}}</div>
                <div class="col-lg-1">{{$doctor->fri}}</div>
            </div>
        @endforeach       
    </div>
</div>
@endsection