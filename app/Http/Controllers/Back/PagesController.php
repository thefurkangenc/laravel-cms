<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Pages::orderBy('order', 'ASC')->get();
        return view('back.pages.index', compact('pages'));
    }
    public function status(Request $req)
    {
        $page =  Pages::find($req->id);
        $page->status = $req->statu == "true" ? 1 : 0;
        $page->save();
        if ($page) {
            return $page;
        } else {
            return "sa";
        }
    }

    public function pageDelete(Request $request)
    {
        Pages::where('id', $request->id)->delete();
        toastr()->success('Başarılı');
        return redirect()->back();
    }
    public function trashedPages()
    {
        $pages = Pages::onlyTrashed()->get();
        return view('back.pages.trashedPages', compact('pages'));
    }

    public function hardDelete($id)
    {
        $hardDelete = Pages::onlyTrashed()->where('id', $id)->forceDelete();
        if ($hardDelete) {
            return redirect()->back()->with('status', 'Başarılı');
        }
    }

    public function recyclePage($id)
    {
        $recyclePage = Pages::where('id', $id)->onlyTrashed()->update(['deleted_at' => null]);
        if ($recyclePage) {
            return redirect()->route('admin.page.trashed')->with('result', 'Tamamen silindi');
        }
        return redirect()->route('admin.page.trashed')->with('result', 'Bir sorun oluştu.');
    }

    public function create()
    {
        return view('back.pages.create');
    }


    public function edit($id)
    {
        $data['page'] = Pages::findOrFail($id);
        return view('back.pages.edit', $data);
    }
    public function editPost(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3|required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . rand(50, 99) . '.' . $request->image->getClientOriginalExtension();
            $file = $request->image->move(public_path('uploads'), $imageName);
            Pages::where('id', $id)->update(['image' => '/uploads/' . $imageName]);
        }
        $update =  Pages::where('id', $id)->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        if ($update) {
            toastr()->success('Güncellendi');
            return redirect()->route('admin.page.index');
        } else {
            toastr()->error('Bir Hata Oluştu');
            return redirect()->route('admin.page.index');
        }
    }

    public function createPost(Request $request)
    {
        $last = Pages::orderBy('order', 'DESC')->first();
        $request->validate([
            'title' => 'min:3|required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $page = new Pages;
        $page->title = $request->title;
        $page->content = $request->content;
        $page->order = $last->order + 1;
        $page->slug = Str::slug($request->title);
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . rand(50, 999) . '.' . $request->image->getClientOriginalExtension();
            $file = $request->image->move(public_path('uploads'), $imageName);
            if ($file) {
                $page->image = '/uploads/' . $imageName;
            } else {
                return "Dosya yüklenirken bir hata oluştu. Lütfen tekrar deneyin.";
            }
        }
        $page->save();
        toastr()->success('Başarılı', 'Sayfa Başarıyla Oluşturuldu');
        return redirect()->route('admin.page.index')->withInput();
    }

    public function orders(Request $request)
    {

        foreach ($request->get('page') as $newOrder => $pageID) {
            Pages::where([
                'id' => $pageID
            ])->update([
                'order' => $newOrder
            ]);
        }
    }
}
