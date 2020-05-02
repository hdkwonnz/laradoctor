@extends('layouts.doctor')

@section('content')
<div class="container">    
    <status-alert user_email="{{ auth()->user()->email }}"></status-alert>
    <div class="row">
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            <patient-date></patient-date>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <patient-status user_email="{{ auth()->user()->email }}"></patient-status>
        </div>
    </div>
</div>
@endsection
