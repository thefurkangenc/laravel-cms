<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['articles'] = Article::orderBy('created_at', 'ASC')->get();
        return view('back.articles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::get();
        return view('back.articles.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'min:3|required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $article = new Article;
        $article->title = $request->title;
        $article->category = $request->category;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title);
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . rand(50, 999) . '.' . $request->image->getClientOriginalExtension();
            $file = $request->image->move(public_path('uploads'), $imageName);
            if ($file) {
                $article->image = '/uploads/' . $imageName;
            } else {
                return "Dosya yüklenirken bir hata oluştu. Lütfen tekrar deneyin.";
            }
        }
        $article->save();
        toastr()->success('Başarılı', 'Makale Başarıyla Oluşturuldu');
        return redirect()->route('admin.makaleler.index')->withInput();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['categories'] = Category::all();
        $data['article'] = Article::findOrFail($id);
        return view('back.articles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3|required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . rand(50, 99) . '.' . $request->image->getClientOriginalExtension();
            $file = $request->image->move(public_path('uploads'), $imageName);
            Article::where('id', $id)->update(['image' => '/uploads/' . $imageName]);
        }
        $update =  Article::where('id', $id)->update([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
        ]);
        if ($update) {
            toastr()->success('Güncellendi');
            return redirect()->route('admin.makaleler.index');
        } else {
            toastr()->error('Bir Hata Oluştu');
            return redirect()->route('admin.makaleler.index');
        }
    }

    public function switch(Request $request)
    {
        $article = Article::findOrFail($request->id);
        $article->status = $request->statu == "true" ? 1 : 0;
        $article->save();

        return $request->id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        @toastr('Makale Silindi');
        $deleteArticle = Article::where('id', $id)->delete();
        return redirect()->back();
    }

    public function hardDelete($id){
        $article = Article::onlyTrashed()->find($id);

        if(File::exists(public_path($article->image))){
            File::delete(public_path($article->image));
        }
        $article->forceDelete();

        toastr('Tamamen Silindi');
        return redirect()->back();
    }
    public function recover($id)
    {
        Article::onlyTrashed()->find($id)->restore();
        toastr()->success('Makale Geri Dönüştürüldü');
        return redirect()->back();
    }
    public function trashed()
    {
        $articles = Article::onlyTrashed()->get();
        return view('back.articles.trashedArticles', compact('articles'));
    }
}
