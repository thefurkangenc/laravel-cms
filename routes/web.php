<?php

use App\Http\Controllers\Back\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Homepage;
use App\Http\Controllers\Back\Dashboard;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\ConfigController;
use App\Http\Controllers\Back\PagesController;
use App\Models\Article;

/*
|--------------------------------------------------------------------------
| Back
|--------------------------------------------------------------------------
*/

Route::middleware('isLogin')->group(function () {
    Route::get('admin/login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('admin/login', [AuthController::class, 'loginPost'])->name('admin.login.post');
});


Route::middleware(['isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('/panel', [Dashboard::class, 'index'])->name('dashboard');
    // Makaleler
    Route::get('makaleler/silinenler', [ArticleController::class, 'trashed'])->name('trashedArticles');
    Route::resource('makaleler', ArticleController::class);
    Route::get('/switch', [ArticleController::class, 'switch'])->name('switch');
    Route::get('/deleteArticle/{id}', [ArticleController::class, 'delete'])->name('delete');
    Route::get('/hardDeleteArticle/{id}', [ArticleController::class, 'hardDelete'])->name('hardDelete');
    Route::get('/recoverArticle/{id}', [ArticleController::class, 'recover'])->name('recover');

    // Kategoriler
    Route::get('/kategoriler', [CategoryController::class, 'index'])->name('category.index');
    Route::get('getAllCategories', [CategoryController::class, 'getAllCategories'])->name('getAllCategories');
    Route::get('changeCategoryStatus', [CategoryController::class, 'changeCategoryStatus'])->name('changeCategoryStatus');
    Route::get('kategori/getData', [CategoryController::class, 'getData'])->name('getData');

    Route::post('insertCategory', [CategoryController::class, 'insertCategory'])->name('insertCategory');
    Route::post('kategori/update', [CategoryController::class, 'categoryUpdate'])->name('category.update');
    Route::post('kategori/delete', [CategoryController::class, 'deleteCategory'])->name('category.delete');


    // Sayfalar
    Route::get('/sayfalar', [PagesController::class, 'index'])->name('page.index');
    Route::get('sayfalar/olustur', [PagesController::class, 'create'])->name('page.create');
    Route::post('sayfalar/olustur', [PagesController::class, 'createPost'])->name('page.create.post');
    Route::get('sayfalar/duzenle/{id}', [PagesController::class, 'edit'])->name('page.edit');
    Route::put('sayfalar/düzenle/{id}', [PagesController::class, 'editPost'])->name('page.edit.post');
    Route::get('sayfalar/siralama',[PagesController::class,'orders'])->name('page.orders');
    Route::get('/sayfa/status', [PagesController::class, 'status'])->name('page.status');
    Route::post('sayfa/sil', [PagesController::class, 'pageDelete'])->name('page.delete');
    Route::get('sayfa/geri-donusum', [PagesController::class, 'trashedPages'])->name('page.trashed');
    Route::get('sayfa/geri-donusum/sil/{id}', [PagesController::class, 'hardDelete'])->name('page.hardDelete');
    Route::get('sayfa/geri-donusum/kurtar/{id}', [PagesController::class, 'recyclePage'])->name('page.recycle');


    // Ayarlar
    Route::get('ayarlar',[ConfigController::class,'index'])->name('ayarlar.index');
    Route::post('ayarlar/update',[ConfigController::class,'configUpdate'])->name('ayar.update');
    Route::get('/logout', [AuthController::class, 'logout'])->name('cikis');
});





/*
|--------------------------------------------------------------------------
| Front
|--------------------------------------------------------------------------
*/
Route::get('/bakim',function(){
    return view('front.offline');
});
Route::get('/', [Homepage::class, 'index'])->name('homepage');
Route::get('/kategori/{category}', [Homepage::class, 'category'])->name('category');
Route::get('/iletisim', [Homepage::class, 'contact'])->name('contact');
Route::post('/iletisim', [Homepage::class, 'contactPost'])->name('contact.post');
Route::get('/{sayfa}', [Homepage::class, 'pages'])->name('page');
Route::get('/{category}/{slug}', [Homepage::class, 'single'])->name('detailBlog');
