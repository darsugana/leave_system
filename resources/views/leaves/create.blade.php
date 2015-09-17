@extends('layout')

@section('content')
    <form action="{{ route('leaves.store') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label>Type</label>
            @include('components.error_message', ['field' => 'leave_type_id'])
            {!! Form::select('leave_type_id', $types, old('leave_type_id'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Duration</label>
            @include('components.error_message', ['field' => 'duration'])
            {!! Form::select('duration', LeaveDuration::getDurations(), old('duration'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Leaving range</label>
            @include('components.error_message', ['field' => 'from'])
            @include('components.error_message', ['field' => 'to'])
            <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="input-sm form-control" name="from" value="{{ old('from') }}">
                <span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" name="to" value="{{ old('to') }}">
            </div>
        </div>
        <div class="form-group">
            <label>Reason</label>
            @include('components.error_message', ['field' => 'reason'])
            <textarea name="reason" rows="10" class="form-control">{{ old('reason') }}</textarea>
        </div>
        <div class="form-group text-center">
            <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
        </div>
    </form>
@append

@section('css')
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@append

@section('js')
    <script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function () {
            $(".input-daterange").datepicker({
                format: "dd-mm-yyyy",
                startDate: new Date()
            });
        })
    </script>
@append
