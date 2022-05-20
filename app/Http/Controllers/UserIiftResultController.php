<?php

namespace App\Http\Controllers;
use App\Models\UserIiftResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserIiftResultController extends Controller
{
    public function index(){
        $record = UserIiftResult::query()->where('user_id',Auth::id())->get();
        if(!empty($record[0])){
            $url = $record[0]['url'];
            $result = json_decode($record[0]['data']);
        }else{
            $url=$result='';
        }
        // dd($result);

        return view('user.iiftresult',compact('result','url'));
    }
    public function iiftResult(Request $request){

        $validatedData = $request->validate([
            "files" => "required|mimes:html,htm",
        ]);
        
        if ($request->hasFile("files")) {

            $file = $request->file("files");
            

            if ($validatedData) {
                $upload = $request->file("files")->store(User::FILES_PATH);
                $filename = ltrim(
                    str_replace(User::FILES_PATH, "", $upload),
                    "/"
                );
                $url=route('user-files', $filename);
                $result = iiftgetStudentResult($url);
                if(count($result['details']) > 0){
                    $data = json_encode($result);
                    $iift_result = new UserIiftResult;
                    $iift_result->user_id = Auth::id();
                    $iift_result->url = $url;
                    $iift_result->data =$data;
                    $iift_result->save();
                }else{
                    return response()->json(['success' => false, 'error' => 'Enter a valid URL. ex: https://test.cbexams.com/.../.html']);
                }
            }
        }

        return response()->json(["success" => true, "message" => $filename,"url"=>route('user-files', $filename)]);
    }
}
