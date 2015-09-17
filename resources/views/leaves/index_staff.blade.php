@extends('layout')

@section('content')
    <a href="{{ route('leaves.create') }}" class="btn btn-default btn-sm">
        <i class="glyphicon glyphicon-plus-sign"></i> Create new leave
    </a>
    <table class="table table-striped">
        <thead>
            <th>User</th>
            <th>Type</th>
            <th>From</th>
            <th>To</th>
            <th class="text-center">Reason</th>
            <th class="text-center">Status</th>
        </thead>
        <tbody>
            @forelse($leaves as $leave)
                <tr>
                    <td>{{ $leave->user->name }}</td>
                    <td>{{ $leave->leaveType->name }}</td>
                    <td>{{ $leave->from }}</td>
                    <td>{{ $leave->to }}</td>
                    <td class="text-center">
                        <a href="#" class="btn-view-leave-reason btn btn-info btn-xs"
                           data-url="{{ route('leaves.show', $leave->id) }}">
                            <i class="glyphicon glyphicon-book"></i> View reason
                        </a>
                    </td>
                    <td class="text-center">
                        @if($leave->status == 'pending')
                            <span class="label label-default">Pending</span>
                        @elseif($leave->status == 'approved')
                            <span class="label label-success">Approved</span>
                        @else
                            <span class="label" style="background-color: black">Rejected</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr class="bg-info text-center">
                    <td colspan="6">There's currently no leaves</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@append

@section('js')
    <script>
        $(function () {
            $(".btn-view-leave-reason").click(function () {
                var url = $(this).data("url");

                $.get(url).success(function (result) {
                    var reason = result.data.reason;
                    alert(reason);
                });
            });
        });
    </script>
@append
