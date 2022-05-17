<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Pages;


class Dashboard extends Controller
{
    public function index(){
        $article = Article::all()->count();
        $hit = Article::sum('hit');
        $category =  Category::all()->count();
        $pages = Pages::all()->count();
        return view('back.dashboard',compact(['article','hit','category','pages']));
    }
}
