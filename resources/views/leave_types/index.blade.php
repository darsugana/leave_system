@extends('layout')

@section('content')
    <button class="btn-add-leave-type btn btn-default btn-sm"
            data-url="{{ route('leave-types.store') }}">
        <i class="glyphicon glyphicon-plus-sign"></i> Add Leave-type
    </button>
    <table id="tbl-leave-types" class="table table-condensed">
        <thead>
            <th>Name</th>
        </thead>
        <tbody>
            @forelse($types as $type)
                <tr>
                    <td>{{ $type->name }}</td>
                </tr>
            @empty
                <tr class="bg-info" id="tr-empty">
                    <td colspan="1">There's currently no leave-types</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@append

@section('js')
    <script src="{{ asset('js/leave_types/index.js') }}"></script>
@append
