<?php

namespace App\Http\Controllers;
use App\Models\UserCatResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserCatResultController extends Controller
{
    public function index(){
        $record = UserCatResult::query()->where('user_id',Auth::id())->get();
        if(!empty($record[0])){
            $url = $record[0]['url'];
            $result = json_decode($record[0]['data']);
        }else{
            $url=$result='';
        }

        return view('user.catresult',compact('result','url'));
    }
    public function catResult(Request $request){
       $url = $request->url;
        if (empty($url) || !strstr(parse_url($url,PHP_URL_HOST),'cdn.digialm.com')){
            return response()->json(['success' => false, 'error' => 'Enter a valid URL. ex: https://cdn.digialm.com/.../.html']);
        }
        $result = getStudentResult($url);
        if(count(@$result['details']) > 0){
            $data = json_encode($result);
            $cat_result = new UserCatResult;
            $cat_result->user_id = Auth::id();
            $cat_result->url = $url;
            $cat_result->data =$data;
            $cat_result->save();

            $record = UserCatResult::query()->find($cat_result->id);
            $url = $record['url'];
            $result = json_decode($record['data']);

            //return view("components.cat_result", ["result" =>$result,'url'=>$url ]);
             return response()->json(['success' => true, 'result' => $cat_result->id]);
        }else{
            return response()->json(['success' => false, 'error' => 'Enter a valid URL. ex: https://cdn.digialm.com/.../.html']);
        }
    }

}
