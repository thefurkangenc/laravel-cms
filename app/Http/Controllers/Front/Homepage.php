<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Pages;
use App\Models\Contact;
use App\Models\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


// Models
use App\Models\Article;

class Homepage extends Controller
{
    public function __construct()
    {
        if(Config::find(1)->active == 2){
            return redirect()->to('/bakim')->send();
        }
        view()->share([
            'pages' => Pages::whereStatus(1)->orderBy('order', 'ASC')->get(),
            'categories' => Category::where('status',1)->inRandomOrder()->get()
        ]);
    }
    public function index()
    {
        $data['articles'] = Article::with('getCategory')->whereHas('getCategory',function($query){
            $query->where('status',1);
        })->whereStatus(1)->orderBy('created_at', 'DESC')->paginate(10);

        return view('front.homepage', $data);
    }
    public function single($category, $slug)
    {
        $category = Category::whereStatus(1)->whereSlug($category)->first() ?? abort(403, 'Böyle Bir Kategori Bulunamadı');
        $article = Article::whereStatus(1)->whereSlug($slug)->first() ?? abort(403, 'Böyle Bir Yazı Bulunamadı');
        if ($category->slug != $article->getCategory->slug) {
            abort(403, 'Bu Kategoriye Ait Böyle Bir Yazı Yok');
        }
        $article->increment('hit');
        $data['article'] = $article;
        return view('front.single', $data);
    }

    public function category($slug)
    {
        $category = Category::whereStatus(1)->whereSlug($slug)->first() ?? abort(403, 'Böyle Bir Katego Bulunamadı');
        $articles = Article::whereStatus(1)->whereCategory($category->id)->orderBy('created_at', 'DESC')->paginate(1);
        $data['articles'] = $articles;
        $data['category'] = $category;
        return view('front.category', $data);
    }

    public function pages($slug)
    {
        $data['page'] = Pages::whereStatus(1)->where('slug', $slug)->first() ?? abort(403, 'Böyle Bir Sayfa Bulunamadı');
        return view('front.page', $data);
    }

    public function contact()
    {
        return view('front.contact');
    }
    public function contactPost(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'topic' => 'required',
            'message' => 'required|min:10'
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }


        Mail::send([],[],
            function ($message) use($request) {
                $message->from('iletisim@blogsitesi.com', ' Furkan The Blog');
                $message->to('27furkangenc@gmail.com');
                $message->setBody('Mesajı Gönderen : ' . $request->name . ' <br/>
                Mesajı Gönderen Mail :'.$request->email.'<br/>
                Mesaj Konusu :  '.$request->topic.'
                Mesaj : '.$request->message.' <br/><br/>
                Mesaj Gönderilme Tarihi : '.now().'
                ','text/html');
                $message->subject($request->name . ' kişisi iletişim ile mesaj gönderdi');
            }
        );
        // $contact = new Contact;
        // $contact->name = $request->name;
        // $contact->email = $request->email;
        // $contact->topic = $request->topic;
        // $contact->message = $request->message;
        // $contact->save();
        return redirect()->route('contact')->with('success', 'Mesajınız Alındı.');
    }
}
