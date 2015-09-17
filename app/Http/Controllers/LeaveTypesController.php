<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class LeaveTypesController extends Controller
{
    public function callAction($method, $parameters)
    {
        // Only admin can access this controller
        $user = Auth::user();
        if ( ! $user->is_admin) {
            return app()->abort(403);
        }

        return parent::callAction($method, $parameters);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $types = LeaveType::all();

        return view('leave_types.index', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->only('name');
        $name = $request->get('name');

        // Check if this name already exists
        if (LeaveType::whereName($name)->count()) {
            return [
                'message' => 'This name already exists'
            ];
        }

        $newType = LeaveType::create($data);

        return [
            'success' => true,
            'data'    => $newType,
        ];
    }
}
