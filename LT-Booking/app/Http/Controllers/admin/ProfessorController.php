<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\TeacherImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;
use Maatwebsite\Excel\Facades\Excel;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role','!=',1)->orderBy('id', 'desc')->get();
        return view('admin.professors', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'email', 'max:255', 'unique:users'],
            ]
        );
        //Check the validation
        if ($validated->fails()) {
            return redirect()->back()->with('error', 'Ohh! This email is exist');
        }
        $data=$request->all();
        $user=User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['phone']),
            'contact_no'=>$data['phone']
        ]);
        if ($user) {
            return Redirect::back()->with(['success' => 'Teacher added successfully']);
        }
        return redirect()->back()->with(['worng'=>'somthing worng']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['status'=>200]);
    }
}
