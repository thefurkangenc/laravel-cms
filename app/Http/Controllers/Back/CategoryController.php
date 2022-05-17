<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('back.categories.index', compact('categories'));
    }
    public function getAllCategories()
    {
        $data = Category::all();
        return response()->json(['data' => $data]);
    }

    public function changeCategoryStatus(Request $request)
    {
        $category = Category::find($request->id);
        if ($category) {
            $category->status = $request->statu == "true" ? 1 : 0;
            $category->save();
            return 1;
        } else {
            return 0;
        }
    }

    public function insertCategory(Request $request)
    {
        $isExist = Category::whereSlug(STR::slug($request->categoryName))->first();
        if ($isExist) {
            return response()->json(['error' => ['Böyle bir kategori zaten var']]);
        }
        $rules = [
            'categoryName' => 'required|min:4'
        ];
        $validator = Validator::make($request->post(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        } else {
            $category = Category::insert([
                'name' => $request->categoryName,
                'slug' => STR::slug($request->categoryName)
            ]);
            return response()->json(['success' => 'Başarılı']);
        }
    }


    public function categoryUpdate(Request $request)
    {
        $isSlug = Category::whereSlug(STR::slug($request->categorySlug))->whereNotIn('id', [$request->categoryID])->first();
        $isName = Category::whereName($request->categoryName)->whereNotIn('id', [$request->categoryID])->first();
        if ($isSlug || $isName) {
            toastr()->error($request->categoryName . " Adında bir kategori veya " . $request->categorySlug . " adında bir link zaten var");
            return redirect()->back();
        }

        $category = Category::find($request->categoryID);

        $category->name = $request->categoryName;
        $category->slug = STR::slug($request->categorySlug);
        $category->save();
        return redirect()->back();
    }

    public function deleteCategory(Request $request)
    {
        $category = Category::findOrFail($request->id);
        if ($category->id == 1) {
            toastr()->error('Bu kategori silinemez');
        }
        $count = $category->articleCount();
        if ($category->articleCount() > 0) {
            $defaultCategory = Category::find(1);
            Article::where('category', $category->id)->update(['category' => 1]);
            @toastr()->success('Kategori Başarıyla Silindi. Bu kategoriye ait '. $count . " Adet Makale " . $defaultCategory->name . " kategorisine taşındı.");
        } else {
            @toastr()->success('Kategori Başarıyla Silindi.');
        }
        $category->delete();
        return redirect()->route('admin.category.index');
    }

    public function getData(Request $request)
    {
        $category = Category::find($request->id);
        return  response()->json($category, 200);
    }
}
