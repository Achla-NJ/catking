<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomPage;
use Str;
class CustomPageController extends Controller
{
    public function index()
    {
        $pages = CustomPage::all();
        $user = Auth::user();

        return view("admin.pages", compact("user", "pages"));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required|unique:custom_pages",
            "link_text" => "required",
            "description" => "required",
        ]);

        $data["slug"] = Str::slug($request->title);

        $status = CustomPage::create($data);

        if ($status) {
            return redirect()
                ->route("admin.custom-page")
                ->with("success", "Page Added successfully");
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'title' =>'required|unique:custom_pages,title,'.$request->id,
            "link_text" => "required",
            "description" => "required",
        ]);
        $page = CustomPage::query()->find($request->id);
        $page->title = $request->title;
        $page->link_text = $request->link_text;
        $page->description = $request->description;
        $page->slug = Str::slug($request->title);
        $status = $page->save();

        if ($status) {
            return redirect()
                ->route("admin.pages")
                ->with("success", "Page Updated successfully");
        }
    }

    public function fetch(Request $request)
    {
        $data = CustomPage::query()->find($request->id);
        return  view('admin.edit-custompage',compact('data'));
    }

    public function view(Request $request)
    {
        $page = CustomPage::query()->where('slug',$request->slug)->get();
        return view("admin.view-page", compact("page"));
    }

    public function newpage(Request $request)
    {
        $page = CustomPage::query()->find($request->id);
        return view("admin.new-page", compact("page"));
    }

    public function destroy(CustomPage $page){
        $status = $page->delete();
        if ($status) {
            return redirect()
                ->route("admin.pages")
                ->with("success", "Page Deleted successfully");
        }
    }
}
