<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMeta;

class CatPredictorController extends Controller
{
    public function index(){
        $user = User::query()->find(Auth::id());
        
        $sc_cat_data = UserMeta::query()
            ->where("user_id", Auth::id())
            ->where("group", "sc_cat")
            ->orderBy("sort", "ASC")
            ->get();

        if (count($sc_cat_data) > 0) {
            $new_cdata = [];
            foreach ($sc_cat_data as $cur) {
                $new_cdata[$cur->relation][] = $cur;
            }
            $sc_cat_data = collect($new_cdata);
        } 
        return view('user.cat-predictor',compact('user','sc_cat_data'));
    }

    public function process(Request $request){
        $user_id = Auth::id();
        UserMeta::query()
            ->where("user_id", $user_id)
            ->where("group", "sc_cat")
            ->delete();

        $index=1;
        $user = User::query()->where('id',$user_id)->first();
        $user->name = $request->input("name");
        $user->mobile_number = $request->input("mobile_number");
        $user->whatsapp_number = $request->input("whatsapp_number");
        $user->dob = $request->input("dob");
        $user->city = $request->input("city");
        $user->update();

        foreach ($request->input("sc_cat") as $relation => $data) {
            UserMeta::query()->create([
                "user_id" => $user_id,
                "key" => $relation,
                "value" => $data,
                "relation" => "sc_cat",
                "sort" => $index,
                "group" => "sc_cat",
            ]);
            $index++;
        }
           

        $msg ='Data Submit Successfully';
        $request->session()->flash('success',$msg);
        return redirect('pp_cat_result');
    }

    public function scoreView(){
        $user = User::query()->find(Auth::id());
        
        $sc_cat_data = UserMeta::query()
            ->where("user_id", Auth::id())
            ->where("group", "sc_cat")
            ->orderBy("sort", "ASC")
            ->get();

        if (count($sc_cat_data) > 0) {
            $new_cdata = [];
            foreach ($sc_cat_data as $cur) {
                $new_cdata[$cur->relation][] = $cur;
            }
            $sc_cat_data = collect($new_cdata);
        } 
        return view('user.cat-score-predictor',compact('user','sc_cat_data'));
    }

    public function score(Request $request){
        $user_id = Auth::id();
        UserMeta::query()
            ->where("user_id", $user_id)
            ->where("group", "sc_cat")
            ->delete();

        $index=1;
        $user = User::query()->where('id',$user_id)->first();
        $user->name = $request->input("name");
        $user->mobile_number = $request->input("mobile_number");
        $user->whatsapp_number = $request->input("whatsapp_number");
        $user->dob = $request->input("dob");
        $user->city = $request->input("city");
        $user->update();

        foreach ($request->input("sc_cat") as $relation => $data) {
            UserMeta::query()->create([
                "user_id" => $user_id,
                "key" => $relation,
                "value" => $data,
                "relation" => "sc_cat",
                "sort" => $index,
                "group" => "sc_cat",
            ]);
            $index++;
        }
           

        $msg ='Data Submit Successfully';
        $request->session()->flash('success',$msg);
        return redirect('pp_cat_result');
    }
}
