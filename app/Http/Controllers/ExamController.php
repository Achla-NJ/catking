<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use Str;
class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::all();
        $user = Auth::user();
        return view('admin.exam',compact('user','exams'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
        'name' => 'required|unique:exams',
        ]);
        $data['slug']= Str::slug($request->name);
        $status= Exam::create($data);

        if($status){
            return response()->json(["success"=>true,"message"=>"Data Added Successfully"]);
        }else{
            return response()->json(["success"=>false,"message"=>"Failed"]);
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Exam  $exam
    * @return \Illuminate\Http\Response
    */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exam')
        ->with('success','Exam has been deleted successfully');
    }

    public function fetch(Request $request)
    {
        $data = Exam::query()->find($request->id);
        return  response()->json(["success"=>true,"data"=>$data]);
    }

    public function update(Request $request)
    {
        $request->validate([
        'name' =>'required|unique:exams,name,'.$request->id,
        ]);
        $exam = Exam::query()->find($request->id);
        $exam->name = $request->name;
        $exam->slug = Str::slug($request->name);
        $status = $exam->save();

        if($status){
            return response()->json(["success"=>true,"message"=>__("app.success")]);
        }else{
            return response()->json(["success"=>false,"message"=>"Failed"]);
        }
    }

    public function status(Request $request)
    {

        $exam = Exam::query()->find($request->id);
        
        $exam->status = $request->sts;
        $update = $exam->save();
        if($update){
            return response()->json(["success" => true,"message" => __("app.success")]);
        }else{
            return response()->json(["success" => false,"message" => "Failed"]);
        }
    }
}
