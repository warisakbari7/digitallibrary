<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HelpfulController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AudioBookController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SaveableController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Contact;
use App\Models\User;
use App\Models\Tag;
use App\Models\AudioBook;
use App\Models\Book;
use App\Models\Download;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    
    $collections = Category::with(['books','articles','audiobooks'])->get();
    $catagories = Category::where('user_id','<>',null)->get();
    $popularbooks = Book::orderBy('views','desc')->where('approved','yes')->limit(15)->get();
    $quotations = DB::select('select image from quotations order by rand() limit 6');
    $tags = Tag::all();
    $recentbooks = Book::orderBy('id','desc')->where('approved','yes')->limit(15)->get();
    $downloadedBooks = Book::orderBy('downloads','desc')->where('approved','yes')->limit(15)->get();
    $recentArticles = Article::orderBy('id','desc')->where('approved','yes')->limit(6)->get();

    $downloadedaudios = AudioBook::orderby('downloads','desc')->limit(8)->get();
    return view('frontend.index',compact('collections','popularbooks','recentArticles','catagories','recentbooks','downloadedBooks','quotations','downloadedaudios'))->with('tags',$tags);
})->name('home');

Route::get('contactus',function(){
    $catagories = Category::where('user_id','<>',null)->get();
    $tags = Tag::all();
    return view('frontend.contact',compact('tags','catagories'));
})->name('contact');



//  profile page route
Route::put('profilepic',[UserController::class,'profilepic'])->name('profile.pic');

// route for star calculation
Route::get('CalculateStarsArticle',[ReviewController::class,'CalculateStarsArticle']);
Route::get('CalculateStarsBook',[ReviewController::class,'CalculateStarsBook']);
Route::get('CalculateStarsAudioBook',[ReviewController::class,'CalculateStarsAudioBook']);

// Book routes
Route::get('show_book/{book:id}',[BookController::class,'ShowBook'])->name('show.book')->middleware(['isClient']);
Route::get('show_book/download_book/{book:id}',[BookController::class,'download'])->name('download.book')->middleware(['auth','isClient']);
Route::get('show_book/{book:id}/view_book',[BookController::class,'view'])->name('view.book')->middleware(['auth','isClient']);
Route::get('allowbookreview/{book:id}',[ReviewController::class,'allowReview'])->name('allow.review')->middleware(['auth','isClient']);
Route::post('show_book/helpful',[HelpfulController::class,'index'])->middleware(['auth','isClient']);
Route::get('list-books',[BookController::class,'ListBooks'])->name('list.books');
Route::get('search-book',[BookController::class,'SearchBook'])->name('search.book');
Route::get('book-category/{id}',[BookController::class,'listBookCategory'])->name('category.book');
Route::post('show_book/save_book/{book:id}',[SaveableController::class,'book']);
Route::get('login-user-book/{book:id}',[SaveableController::class,'isLoginBook'])->name("book.IsUserLogin")->middleware(['auth','isClient']);







// AudioBook routes
Route::get('show_audiobook/{audiobook:id}',[AudioBookController::class,'ShowBook'])->name('show.audiobook')->middleware(['isClient']);
Route::get('show_audiobook/download_audiobook/{audiobook:id}',[AudioBookController::class,'download'])->name('download.audiobook')->middleware(['auth','isClient']);
Route::get('show_audiobook/{audiobook:id}/view_audiobook',[AudioBookController::class,'view'])->name('view.audiobook')->middleware(['auth','isClient']);
Route::get('allowaudiobookreview/{audiobook:id}',[ReviewController::class,'allowAudioBookReview'])->name('allow.audiobookreview')->middleware('auth','isClient');
Route::post('show_audiobook/helpful',[HelpfulController::class,'index'])->middleware('auth','isClient');
Route::get('list-audiobooks',[AudioBookController::class,'ListAudioBooks'])->name('list.audiobooks');
Route::get('search-audiobook',[AudioBookController::class,'SearchAudioBook'])->name('search.audiobook');
Route::get('audiobook-category/{id}',[AudioBookController::class,'listAudioBookCategory'])->name('category.audiobook');
Route::post('show_audiobook/save_audiobook/{audiobook:id}',[SaveableController::class,'audiobook']);
Route::get('login-user-audiobook/{audiobook:id}',[SaveableController::class,'isLoginAudioBook'])->name("audiobook.IsUserLogin")->middleware('auth');






// Article routes
Route::get('show_article/{article:id}',[ArticleController::class,'ShowArticle'])->name('show.article')->middleware(['isClient']);
Route::get('show_article/download_article/{article:id}',[ArticleController::class,'download'])->name('download.article')->middleware(['auth','isClient']);
Route::get('show_article/{article:id}/view_article',[ArticleController::class,'view'])->name('view.article')->middleware(['auth','isClient','isClient']);
Route::get('allowarticlereview/{article:id}',[ReviewController::class,'allowArticleReview'])->name('allow.articlereview')->middleware(['auth','isClient']);
Route::post('show_article/helpful',[HelpfulController::class,'index'])->middleware(['auth','isClient']);
Route::get('list-articles',[ArticleController::class,'ListArticles'])->name('list.articles');
Route::get('search-article',[ArticleController::class,'Searcharticle'])->name('search.article');
Route::get('article-category/{id}',[ArticleController::class,'listArticleCategory'])->name('category.article');
Route::post('show_article/save_article/{article:id}',[SaveableController::class,'article']);
Route::get('login-user-article/{article:id}',[SaveableController::class,'isLoginArticle'])->name("article.IsUserLogin")->middleware('auth','isClient');



// contact route
Route::post('contact-store',[ContactController::class,'store'])->name('contact.store');


Route::post("notification/markasread",[UserNotificationController::class,'MarkAsRead'])->name('notification.mark')->middleware('auth');







// Dashboard Routes 
Route::middleware(['auth','isActive'])->group(function(){
    Route::get('backend', function(){
        if(Auth::user()->type == 'librarian')
        {
            $catagories = Category::where('user_id',Auth::user()->id)->get();
            $id = $catagories->pluck('id')->toArray();
            $tags = Tag::all();
            $abooks = Book::orderBy("id",'desc')->whereIn('category_id',$id)->where("approved","yes")->paginate(30);
            $books = Book::where('approved','no')->whereIn('category_id',$id)->get();
            $articles = Article::where('approved','no')->whereIn('category_id',$id)->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view("layouts.master",compact('uvcontacts','books','catagories','tags','abooks','articles'));
        }
        else if(Auth::user()->type == 'admin')
        {
            $catagories = Category::all();
            $tags = Tag::all();
            $abooks = Book::orderBy("id",'desc')->where("approved","yes")->paginate(30);
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view("layouts.master",compact('uvcontacts','books','catagories','tags','abooks','articles'));
        }
        else
        {
            return abort(404);
        }
    });

    // category routes
    Route::resource('catagory', CategoryController::class);
    Route::post('morecatagory',[CategoryController::class,'loadmore']);
    Route::post('catagory_search',[CategoryController::class,'search']);
    

    // reviews routes
    Route::resource('review',ReviewController::class);
    Route::delete('book/review/{review:id}',[ReviewController::class,'destroy']);
    Route::delete('article/review/{review:id}',[ReviewController::class,'destroy']);
    Route::delete('audiobook/review/{review:id}',[ReviewController::class,'destroy']);
    Route::post('addArticleReview',[ReviewController::class,'storeArticleReview'])->name('add.articleReview');
    Route::post('addAudioBookReview',[ReviewController::class,'storeAudioBookReview'])->name('add.audioBookReview');
    Route::put('updateArticleReview{review}',[ReviewController::class,'updateArticleReview'])->name('update.ArticleReview');
    Route::put('updateArticleReview{review}',[ReviewController::class,'updateAudioBookReview'])->name('update.AudioBookReview');
    

    // tag routes
    Route::resource('tag',TagController::class);
    Route::post('moretag',[TagController::class,'loadmore']);
    Route::post('tag_search', [TagController::class,'search']);

    
    // quotations routes
    Route::resource('quotation', QuotationController::class);

    // librarian routes
    Route::resource('librarian', LibrarianController::class);  
    Route::post('toggleUser',[LibrarianController::class,'toggleUser']); 
    Route::post('librarian/toggleUser',[LibrarianController::class,'toggleUser']); 
    Route::post('librarian/assign',[LibrarianController::class,'assign']); 
    Route::post('librarian/remove',[LibrarianController::class,'remove']); 
    Route::post('librarian/search/',[LibrarianController::class,'search']);
    Route::get('librarian/{user:id}/books/',[LibrarianController::class,'Books'])->name('librarian.books');
    Route::get('librarian/{id}/book-search',[LibrarianController::class,'SearchBook']);
    Route::get('librarian/{user:id}/articles/',[LibrarianController::class,'Articles'])->name('librarian.articles');
    Route::get('librarian/{id}/article-search',[LibrarianController::class,'SearchArticle']);
    Route::get('librarian/{user:id}/audiobooks/',[LibrarianController::class,'AudioBooks'])->name('librarian.audiobooks');
    Route::get('librarian/{id}/audiobook-search',[LibrarianController::class,'SearchAudioBook']);

    // Book routes
    Route::resource('book',BookController::class);
    Route::post('upload-book',[BookController::class,'uploadBook'])->name('upload.book');
    Route::get('unapproved-book',[BookController::class,'listUnapproved'])->name('unapproved.book');
    Route::get('unapproved-book-show/{book:id}',[BookController::class,'showUnapproved'])->name('show.unapproved.book');
    Route::put('unapproved-book-show/{book:id}',[BookController::class,'update']);
    Route::patch('unapproved-book-show/approve-book',[BookController::class,'approve']);
    Route::get('book-search',[BookController::class,'search']);





    // AudioBook route
    Route::resource('audiobook',AudioBookController::class);
    Route::put('unapproved-audiobook-show/{audiobook:id}',[AudioBookController::class,'update']);
    Route::get('audiobook-search',[AudioBookController::class,'search']);



    // Article routes
    Route::resource('article',ArticleController::class);
    Route::post('upload-article',[ArticleController::class,'uploadarticle'])->name('upload.article');
    Route::get('unapproved-article',[ArticleController::class,'listUnapproved'])->name('unapproved.article');
    Route::get('unapproved-article-show/{article:id}',[ArticleController::class,'showUnapproved'])->name('show.unapproved.article');
    Route::put('unapproved-article-show/{article:id}',[ArticleController::class,'update']);
    Route::patch('unapproved-article-show/approve-article',[ArticleController::class,'approve']);
    Route::get('article-search',[ArticleController::class,'search']);




    // contact routes
    Route::resource('contact',ContactController::class)->except('store');

    Route::get('profile/{name}',[UserController::class,'profile'])->name('user.profile')->middleware('auth');



    Route::get('user/notification',[UserNotificationController::class,'index'])->name('user.notification');
    Route::get('user/notification/more',[UserNotificationController::class,'LoadMore']);
    Route::delete('user/notification',[UserNotificationController::class,'destroy']);


    // Admins Routes
    Route::get('admin',[UserController::class,'ListAdmin'])->name('list.admin');
    Route::post('admin',[UserController::class,'StoreAdmin'])->name('admin.store');
    Route::get('admin/{id}',[UserController::class,'AdminShow'])->name('admin.show');
    Route::post('admin/search/',[UserController::class,'AdminSearch']);
    Route::post('admin/toggleUser',[UserController::class,'toggleUser']); 
    Route::get('admin/{user:id}/books/',[UserController::class,'Books'])->name('admin.books');
    Route::get('admin/{id}/book-search',[UserController::class,'SearchBook']);
    Route::get('admin/{user:id}/articles/',[UserController::class,'Articles'])->name('admin.articles');
    Route::get('admin/{id}/article-search',[UserController::class,'SearchArticle']);
    Route::get('admin/{user:id}/audiobooks/',[UserController::class,'AudioBooks'])->name('admin.audiobooks');
    Route::get('admin/{id}/audiobook-search',[LibrarianController::class,'SearchAudioBook']);


});

Route::get('/User/profile/{name}', function () {

        $catagories = Category::where('user_id','<>',null)->get();
        $tags = Tag::all();
        $user = User::find(Auth::user()->id);
        $savedbooks = $user->SavedBooks()->get();
        $downloadedbooks = Download::with('books')->where('downloadable_type','book')->where('user_id',$user->id)->get();
        $uploadedbooks = $user->UploadedBooks()->where('approved','yes')->get();
        $savedarticles = $user->SavedArticles()->get();
        $downloadedarticles = Download::with('articles')->where('downloadable_type','article')->where('user_id',$user->id)->get();
        $uploadedarticles = $user->UploadedArticles()->where("approved","yes")->get();

        $savedaudios = $user->SavedAudioBooks()->get();
        $downloadedaudios = Download::with('audios')->where('downloadable_type','audiobook')->where('user_id',$user->id)->get();
        return view('frontend.profile',compact('downloadedaudios','savedaudios','uploadedarticles','downloadedarticles','tags','savedbooks','downloadedbooks','uploadedbooks','savedarticles'))->with('catagories',$catagories);
  
})->middleware(['auth','isClient','isActive','verified'])->name('profile');


require __DIR__.'/auth.php';
