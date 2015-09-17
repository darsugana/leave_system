<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Support\LeaveDuration;
use App\Models\Support\LeaveStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            $view = 'leaves.index_admin';
            $leaves = Leave::all();
        }
        else {
            $view = 'leaves.index_staff';
            $leaves = $user->leaves;
        }

        return view($view, compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $types = LeaveType::all()->lists('name', 'id');

        return view('leaves.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'leave_type_id',
            'duration',
            'from',
            'to',
            'reason'
        ]);

        $availableDurations = LeaveDuration::getDurations();
        $this->validate($request, [
            'leave_type_id' => 'required|exists:leave_types,id',
            'duration'      => 'required|in:' . implode(',', array_keys($availableDurations)),
            'from'          => 'required|date_format:Y-m-d',
            'to'            => 'required|date_format:Y-m-d|min:from',
            'reason'        => 'required'
        ]);

        $data['status'] = LeaveStatus::PENDING; // Set default status by "pending" when create
        $result = $this->getCurrentUser()->leaves()->create($data);

        return redirect()->route('leaves.index');
    }

    public function show($id)
    {
        try {
            $leave = Leave::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            return app()->abort(404);
        }

        return [
            'data' => $leave
        ];
    }

    public function approve($id)
    {
        try {
            $leave = Leave::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            return app()->abort(404);
        }

        // Only admin can approve
        if ( ! $this->isCurrentUserAdmin()) {
            return app()->abort(403);
        }

        // Only approvable if currently is pending
        if ($leave->status != LeaveStatus::PENDING) {
            return [
                'message' => 'This leave is not approvable'
            ];
        }

        $leave->status = LeaveStatus::APPROVED;
        $result = $leave->save();

        return [
            'success' => $result
        ];
    }

    public function reject($id)
    {
        try {
            $leave = Leave::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            return app()->abort(404);
        }

        // Only admin can reject
        if ( ! $this->isCurrentUserAdmin()) {
            return app()->abort(403);
        }

        // Only rejectable if currently is pending
        if ($leave->status != LeaveStatus::PENDING) {
            return [
                'message' => 'This leave is not rejectable'
            ];
        }

        $leave->status = LeaveStatus::REJECTED;
        $result = $leave->save();

        return [
            'success' => $result
        ];
    }

    /**
     * @return User
     */
    protected function getCurrentUser()
    {
        return Auth::user();
    }

    protected function isCurrentUserAdmin()
    {
        return $this->getCurrentUser()->is_admin;
    }
}
