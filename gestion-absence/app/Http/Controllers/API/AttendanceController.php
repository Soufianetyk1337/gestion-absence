<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\absence;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return absence::latest()->paginate(10);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'hours' => ['required', 'string', 'max:255'],
            'justification' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'string', 'max:255'],
            'date' => ['required', 'string', 'min:6'],
            'module_id' => ['required', 'integer', 'max:8'],
            'student_id' => ['required', 'integer'],
        
        ]);
        return absence::create([
            'hours' => $request['hours'],
            'justification' => $request['justification'],
            'student_id' => $request['student_id'],
            'date' => $request['date'],
            'module_id' => $request['module_id'],
            'type' =>$request['type']
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $abs = absence::findOrFail($id);
       $request->validate([
            'hours' => ['required', 'string', 'max:255'],
            'justification' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'string', 'max:255'],
            'date' => ['required', 'string', 'min:6'],
            'module_id' => ['required', 'integer', 'max:8'],
            'student_id' => ['required', 'integer'],
        
        ]);
        $abs->update($request->all());
        return ['message' => 'Module updated successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $abs = absence::findOrFail($id);
        $abs->delete();

        return ['message' => 'User deleted!'];
    }
}
