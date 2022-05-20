<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\College;
use App\Models\StudentSopColleges;
class CollegeController extends Controller
{

    public function index()
    {
        $colleges = College::query()->where('created_by_user','no')->orderBy('id','desc')->get();
        $user = Auth::user();

        $college_data = StudentSopColleges::query()
            ->get();
        return view('admin.college',compact('user','colleges','college_data'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:colleges',
        ]);

        $status= College::query()->create([
            'name'=>$request->name,
            'created_by_user'=>'no'
        ]);

        if($status){
            return response()->json(["success" => true,"message" => "Data Added Successfully"]);
        }else{
            return response()->json(["success" => false,"message" => "Failed"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  College  $college
     * @return RedirectResponse
     */
    public function destroy(College $college)
    {
        $college->delete();

        return redirect()
            ->route('admin.college')
            ->with('success','College has been deleted successfully');
    }

    public function fetch(Request $request)
    {
        $data = College::query()->find($request->id);

        return  response()->json(["success"=>true,"data"=>$data]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' =>'required|unique:colleges,name,'.$request->id,
        ]);

        $college = College::query()->find($request->id);
        $college->name = $request->name;
        $college->sop = $request->sop;
        $status = $college->save();

        if($status){
            return response()->json(["success" => true,"message" => __("app.success")]);
        }else{
            return response()->json(["success" => false,"message" => "Failed"]);
        }
    }
    public function status(Request $request)
    {

        $college = College::query()->find($request->id);
        
        $college->status = $request->sts;
        $update = $college->save();
        if($update){
            return response()->json(["success" => true,"message" => __("app.success")]);
        }else{
            return response()->json(["success" => false,"message" => "Failed"]);
        }
    }


}



