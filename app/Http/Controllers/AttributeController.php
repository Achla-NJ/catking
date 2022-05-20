<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributeController extends Controller
{
    public function index()
    {
        $interview = Attribute::query()->where('type','interview')->get();
        $profile = Attribute::query()->where('type','profile')->get();

        $interviews = count($interview) > 0 ? $interview : [''];
        $profiles = count($profile) > 0 ? $profile : [''];

        return view('admin.attribute',compact('interviews','profiles'));
    }

    public function store(Request $request)
    {
        $type = $request->input('type');

        Attribute::query()->where('type',$type)->delete();

        $attribute = $request->attribute;

        foreach($attribute as $item){
            $particular = new Attribute();
            $particular->attribute = $item;
            $particular->type = $type;
            $particular->save();
        }

        $request->session()->flash('success','Data Saved Successfully');

        return redirect()->route('admin.attributes');
    }

}
