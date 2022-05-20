<?php

namespace App\Http\Controllers;
use App\Models\UserXatResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserXatResultController extends Controller
{
    public function index()
    {
        $record = UserXatResult::query()->where('user_id',Auth::id())->get();
        if(!empty($record[0])){
            $url = $record[0]['url'];
            $result = json_decode($record[0]['data']);
        }else{
            $url = $result = '';
        }
        
        return view('user.xatresult',compact('result','url'));
    }

    public function xatResult(Request $request)
    {
       $url = $request->input('url');
       if (empty($url) || getDomainFromUrl($url) != 'digialm.com'){
            return response()->json(['success' => false, 'error' => 'Enter a valid URL. ex: https://cdn.digialm.com/.../.html']);
        }
        $result = xatgetStudentResult($url);
        if(count(@$result['details']) > 0){
            $data = json_encode($result);
            $xat_result = new UserXatResult;
            $xat_result->user_id = Auth::id();
            $xat_result->url = $url;
            $xat_result->data =$data;
            $xat_result->save();
            return response()->json(['success' => true, 'result' => $xat_result->id]);
        }else{
            return response()->json(['success' => false, 'error' => 'Enter a valid URL. ex: https://cdn.digialm.com/.../.html']);
        }
    }
}
