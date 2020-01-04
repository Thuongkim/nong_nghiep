<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\User;
use App\News;
use App\Role;
use DB;
use Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('last_login','DESC')->paginate(\App\Define\Constant::PAGE_NUM_50);

        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('display_name','id')->get();
        return view('backend.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['activated' => $request->input('status', 0)]);

        $validator = \Validator::make($data = $request->all(), User::rules());
        $validator->setAttributeNames(trans('users'));
        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        foreach ($request->input('roles') as $role) {
            $user->attachRole($role);
        }

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $uRoles = $user->roles()->select('id')->get()->toArray();
        $roles = Role::select('display_name','id')->get();

        return view('backend.users.show',compact('user','roles','uRoles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = intval($id);
        $user = User::where('id', $id)->where('email', '<>', 'system@' . env('APP_NAME', 'bctech.vn'))->first();
        if (is_null($user)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return back();
        }

        $uRoles = $user->roles->pluck('id','id')->toArray();

        $roles = Role::select('display_name','id')->get();

        return view('backend.users.edit',compact('user','roles','uRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = intval($id);
        $user = User::where('id', $id)->where('email', '<>', 'system@' . env('APP_NAME', 'bctech.vn'))->first();
        if (is_null($user)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return back();
        }

        $request->merge(['activated' => $request->input('status', 0)]);

        $validator = \Validator::make($data = $request->all(), User::rules($id));
        $validator->setAttributeNames(trans('users'));
        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $user->update($data);
        DB::table('role_user')->where('user_id', $id)->delete();

        foreach ($request->input('roles') as $role) {
            $user->attachRole($role);
        }

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find(intval($id));
        if (is_null($user) || $user->id == \Auth::guard('admin')->user()->id) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return back();
        }
        if ($user->news()->count()) {
            Session::flash('message', "Quản trị đã có bài viết, bạn có thể deactive quản trị viên...");
            Session::flash('alert-class', 'danger');
            return back();
        }

        // $user->activated = 0;
        // $user->save();
        $user->delete();
        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.users.index');
    }

    public function changePassword(Request $request, $id)
    {
        $id = intval($id);
        $user = User::where('id', $id)->where('email', '<>', 'system@' . env('APP_NAME', 'bctech.vn'))->first();
        if (is_null($user)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.users.index');
        }

        return view('backend.users.change-password', compact('user'));
    }

    public function postChangePassword(Request $request, $id)
    {
        $id = intval($id);
        $validator = \Validator::make($request->all(), array(
            'new_password'      => 'required|min:6|max:30',
            're_password'       => 'same:new_password',
            ));

        $validator->setAttributeNames(trans('users'));
        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $user = User::where('id', $id)->where('email', '<>', 'system@' . env('APP_NAME', 'bctech.vn'))->first();
        if (is_null($user)) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('editError', trans('system.have_an_error'));
            return back()->withErrors($errors)->withInput();
        }

        $user->password = \Hash::make($request->input('new_password'));
        $user->save();

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');
        return redirect()->route('admin.users.index');
    }
}