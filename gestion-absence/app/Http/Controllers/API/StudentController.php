<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\student;
use App\module;
use App\absence;
use Str;
use Illuminate\Support\Facades\DB;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return student::latest()->paginate(10);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(){
            $search = \Request::get('q');
            $user=DB::table('students')
            ->where('CNE','LIKE',"%" .$search. "%")
            ->orWhere('email','LIKE',"%" .$search. "%")
            ->orWhere('filliere','LIKE',"%".$search."%")
            ->join('absences','absences.student_id','students.id')
            ->join('modules','modules.id','absences.module_id')
            ->get(); 
            return $user;
    }   

    public function store(Request $request)
    {
        $exploded = explode(',',$request['image']);
        $decoded = base64_decode($exploded[1]);

        $extension = Str::contains($exploded[0],'jpeg')? 'jpeg' :'png';
        //$filename = Str::random().'.'.$extension;
        $filename = time().'.'.$extension;
        $path =  public_path().'/img/'.$filename;
        file_put_contents($path, $decoded); 

        $this->validate($request , [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students'],
            'phone' => ['required', 'string','min:6'],
            'CNE' => ['required', 'string', 'max:10','unique:students'],
            'filliere' => ['required', 'string'],
            'DOB' => ['required', 'string'],
            'annee_scolaire' => ['required', 'string'],
            'image' => ['required', 'string'],

        
        ]);
        return student::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'CNE' => $request['CNE'],
            'phone' => $request['phone'],
            'image' => $filename,
            'filliere' =>$request['filliere'],
            'annee_scolaire' =>$request['annee_scolaire'],
            'DOB' =>$request['DOB'],

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
            $student = student::findOrFail($id);
            $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students,email,'.$student->id],
            'phone' => ['required', 'string', 'min:6'],
            'image' => ['required', 'string'],
            'CNE' => ['required', 'string', 'max:8'],
            'filliere' => ['required', 'string'],
            'DOB' => ['required', 'string'],
            'annee_scolaire' => ['required', 'string'],
        
            ]);
            $student->update($request->all());
            return ['message' => 'User updated successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = student::findOrFail($id);
        $student->delete();

        return ['message' => 'Student deleted!'];
    }
}
