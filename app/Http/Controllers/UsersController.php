<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
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
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data  = $request->only('email', 'password', 'name', 'is_admin');

        // Validate data before creating a new user
        $this->validate($request, [
            'email'     => 'required|max:255|email|unique:users',
            'password'  => 'required',
            'name'      => 'required|max:255',
        ]);

        // Hash the password before the creation
        $data['password'] = bcrypt($data['password']);

        // Create new user
        $result = User::create($data);

        // Create message from the result of the creation
        if ($result) {
            $message = (object) [
                'type' => 'primary',
                'content' => 'New user has been created',
            ];
        }
        else {
            $message = (object) [
                'type' => 'danger',
                'content' => 'Failed to create new user',
            ];
        }

        // Redirect back to users-list page
        return redirect()->route('users.index')->with(compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
        }
        catch (ModelNotFoundException $ex) {
            return app()->abort(404);
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
        }
        catch (ModelNotFoundException $ex) {
            return app()->abort(404);
        }

        $this->validate($request, [
            'email'     => "required|max:255|email|unique:users,email,{$user->id}",
            'name'      => 'required|max:255',
        ]);

        $data               = $request->only('email', 'password', 'name', 'is_admin');
        if (isset($data['password'])) {
            $data['password']   = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $result = $user->fill($data)->save();

        if ($result) {
            $message = (object) [
                'type' => 'primary',
                'content' => 'New user has been created',
            ];
        }
        else {
            $message = (object) [
                'type' => 'danger',
                'content' => 'Failed to create new user',
            ];
        }

        // Redirect back to users-list page
        return redirect()->route('users.index')->with(compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
        }
        catch (ModelNotFoundException $ex) {
            return app()->abort(404);
        }

        $result = $user->delete();

        if ($result) {
            return [
                'success' => true,
            ];
        }
        else {
            return [
                'success' => false,
            ];
        }
    }
}
