<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function searchPiInterview(Request $request){
        $data = [];
        $data['user'] = User::query()
                ->where('mobile_number', 'LIKE', "%{$request->keyword}%") 
                ->orWhere('email', 'LIKE', "%{$request->keyword}%")
                ->get();
                
        if(count($data['user'])>0){
            $data['review'] = Review::query()->where('user_id',$data['user'][0]->id)->where('type',$request->type)->orderBy('id','DESC')->get();
            return response()->json(["success" => true,"data" => $data]);
        }else{
            return response()->json(["success" => false,'msg'=>'Match not found']);
        }
    }

    public function storePiReview(Request $request){
        // return $request->all();



        $review = new Review();
        $reviews=$request->review;
        
        if($reviews['id'] !=''){
            Review::query()->find($reviews['id'])->delete();
        }
            $review->user_id = $reviews['student_id'];
            $review->teacher = $reviews['teacher'];
            $review->date = $reviews['date'];

            $jsonArray = array();
            foreach (array_combine( $reviews['attribute'], $reviews['rating'] ) as $name => $value) {
                $jsonArray[] = array('name' => $name, 'value' => $value);
            }

             $json = json_encode($jsonArray);

            // $review->particulars = json_encode($reviews['attribute']);
            $review->particulars = $json;
            //$review->rating = $reviews['rating'];
            $review->selection = $reviews['selection'];
            $review->type = $reviews['type'];
            $review->remark = $reviews['remark'];

        $review->save();

        $user = User::query()->where('id', $reviews['student_id'])->first(['email']);
        $user_email = $user['email'];
        $details = [
            'email' => $user_email,
            'type' => $reviews['type']
            ];
        if($reviews['type'] == 'profile'){
            $subject = "CATKing Profile Review is Completed. Check your feedback on MyCATKing";
        }
        if($reviews['type'] == 'interview'){
            $subject = "CATKing Mock Personal Interview Feedback Updated on MyCATKing";
        }
        \Mail::to($user_email)->send(new \App\Mail\Mail($details,$subject));

        return response()->json(["success" => true,"message" =>'Data Saved Successfully']);
        // $request->session()->flash('success','Data Saved Successfully');
        // return redirect()->route($request->url);
    }


    function profile(){
        $user = Auth::user();
        return view('user.profile-review',compact('user'));
    }

    function pinterview(){
        $user = Auth::user();
        return view('user.pi',compact('user'));
    }

    function delete(Request $request){
        Review::query()->find($request->id)->delete();
        return  response()->json([
            "success" => true,
            "message" => __("app.success"),
        ]);
    }


    function emailSend(Request $request){
        $user = User::query()->where('id',$request->id)->first(['email']);
        $user_email = $user['email'];
        $title = 'Review of '.$request->rtype;

        $details = [
            'email' => $user_email,
            'type' => $request->rtype
            ];
        if($request->rtype == 'profile'){
            $subject = "CATKing Profile Review is Completed. Check your feedback on MyCATKing";
        }
        if($request->rtype == 'interview'){
            $subject = "CATKing Mock Personal Interview Feedback Updated on MyCATKing";
        }
        \Mail::to($user_email)->send(new \App\Mail\Mail($details,$subject));

        $msg ='Mail Sent to '.$user_email;
        return  response()->json([
            "success" => true,
            "message" => __("app.mail"),
        ]);
    }
}
