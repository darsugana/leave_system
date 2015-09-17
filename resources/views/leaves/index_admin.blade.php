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
            <th>Reason</th>
            <th class="text-center">Action</th>
        </thead>
        <tbody>
            @forelse($leaves as $leave)
                <tr>
                    <td>{{ $leave->user->name }}</td>
                    <td>{{ $leave->leaveType->name }}</td>
                    <td>{{ $leave->from }}</td>
                    <td>{{ $leave->to }}</td>
                    <td>
                        <a href="#" class="btn-view-leave-reason btn btn-info btn-xs"
                           data-url="{{ route('leaves.show', $leave->id) }}">
                            <i class="glyphicon glyphicon-book"></i> View reason
                        </a>
                    </td>
                    <td class="text-center">
                        @if($leave->status == LeaveStatus::PENDING)
                            <div class="btn-group btn-group-xs">
                                <a href="#" class="btn btn-success btn-approve-leave"
                                   data-url="{{ route('leaves.approve', $leave->id) }}">
                                    <i class="glyphicon glyphicon-thumbs-up"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-reject-leave"
                                   data-url="{{ route('leaves.reject', $leave->id) }}">
                                    <i class="glyphicon glyphicon-thumbs-down"></i>
                                </a>
                            </div>
                        @elseif($leave->status == LeaveStatus::APPROVED)
                            <span class="label label-success">Approved</span>
                        @else
                            <span class="label" style="background-color: black;">Rejected</span>
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

            $(".btn-approve-leave").click(function () {
                var btn = $(this);
                var url = btn.data("url");
                var token = $("html").data("token");

                // Confirm before approve
                if( ! confirm("Approve this leave?")) return;

                $.ajax({
                    url: url,
                    method: "put",
                    data: {
                        _token: token
                    }
                }).success(function (result) {
                    if (result.success) {
                        var td = btn.closest("td");
                        td.html("").append($("<span class='label label-success'>").text("Approved"));
                    }
                    else {
                        var message = result.message ? result.message : "Failed to approve the leave";
                        alert(message);
                    }
                });
            });

            $(".btn-reject-leave").click(function () {
                var btn = $(this);
                var url = btn.data("url");
                var token = $("html").data("token");

                // Confirm before approve
                if( ! confirm("Reject this leave?")) return;

                $.ajax({
                    url: url,
                    method: "put",
                    data: {
                        _token: token
                    }
                }).success(function (result) {
                    if (result.success) {
                        var td = btn.closest("td");
                        td.html("").append($("<span class='label' style='background-color: black;'>").text("Rejected"));
                    }
                    else {
                        var message = result.message ? result.message : "Failed to reject the leave";
                        alert(message);
                    }
                });
            });
        })
    </script>
@append
