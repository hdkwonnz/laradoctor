@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <doctors-schedule user_email="{{ auth()->user()->email }}" user_name="{{ auth()->user()->name }}" user_patient_id="{{ auth()->user()->patient_id }}"></doctors-schedule>
        </div>
    </div>
</div>
@endsection
