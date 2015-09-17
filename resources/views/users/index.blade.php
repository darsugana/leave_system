@extends('layout')

@section('content')
    <a href="{{ route('users.create') }}" class="btn btn-default btn-sm">
        <i class="glyphicon glyphicon-plus-sign"></i> Create new user
    </a>

    <table class="table table-striped">
        <thead>
            <th>Email</th>
            <th>Name</th>
            <th class="text-center">Is Admin</th>
            <th>&nbsp;</th>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td class="text-center">
                        @if($user->is_admin)
                            <span class="label label-primary">Yes</span>
                        @else
                            <span class="label label-default">No</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('users.edit', $user->id) }}"><i class="glyphicon glyphicon-edit"></i></a>
                        <a href="#" class="btn-delete-user" data-url="{{ route('users.destroy', $user->id) }}"><i class="glyphicon glyphicon-trash"></i></a>
                    </td>
                </tr>
            @empty
                <tr class="bg-info">
                    <td colspan="4">There's currently no user</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@append

@section('js')
    <script>
        $(function () {
            $(".btn-delete-user").click(function () {
                var btn   = $(this);
                var url   = btn.data("url");
                var token = $("html").data("token");

                // Confirm before delete
                if ( ! confirm("Delete this user?")) return;

                // Send AJAX request to delete the user
                $.ajax({
                    url: url,
                    method: "delete",
                    data: {
                        _token: token
                    }
                }).success(function (result) {
                    if (result.success) {
                        btn.closest("tr").remove();
                    } else {
                        alert("Failed to delete the user");
                    }
                });
            });
        });
    </script>
@append
