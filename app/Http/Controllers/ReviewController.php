<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Helpers\Number;
use App\Models\Article;
use App\Models\Book;
use App\Models\AudioBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
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
            'body'=>'required',
            'title'=>'required',
            'rate'=>'required',
            'recommendation'=>'required',
            'id'=>'required'
        ]);
        $book = Book::find($request->id);
         $review = $book->reviews()->create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'rate' => $request->rate,
            'recommendation' => $request->recommendation
        ]);
        $book->rate = Helper::calculateStars($book->reviews->groupBy('rate'),$book->reviews->count());
        $book->save();
        $recommendation = '';
        $stars = '';
        $_recommendation ='';
        $helpful = '';
        if($review->recommendation == 'yes')
        {
            $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small  text-white rounded shadow px-2 An_trial  ml-2 bg--two" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none" checked>
            <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--four small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none">';
        }
        else
        {
            $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small rounded shadow px-2 An_trial  ml-2 bg--four" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none">
            <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--two text-white small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none" checked>';
        }

        for ($a = 1; $a <=$review->rate; $a++)
            $stars .= '<small><i class="fa fa-star text--one pr-1 "></i></small>';
        
        for($a = $review->rate; $a <5; $a++)
            $stars .= '<small><i class="fa fa-star text--six pr-1 "></i></small>';


        
        if($review->recommendation == 'yes')
        {
            $_recommendation = '<div class="text--two d-flex align-items-center">
                <i class="fa fa-check-circle mr-1"></i>
                <h5 class="mb-0 An_light"> Yes, <small> I recommend this book</small></h5>
            </div>';
        }
        else
        {
            $_recommendation = '<div class="text--two d-flex align-items-center ">
                <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this book</small></h5>
            </div>';
        }

        $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class=" help_yes p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
            <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class=" help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
        $row ='
        <div id="r'. $review->id .'" class="row justify-content-center mx-0 bg--eight py-4">
            <div class="col-12">
                <div class="row mx-1">
                    <div class="media align-items-center">
                        <img class="mr-3 rounded-circle shadow border" width="10%" height="80%" src="'. asset('application/users/'.$review->user->image).'" alt="image">
                        <div class="media-body d-flex align-items-center">
                            <h5 class="mt-0 mb-0 An_Dm_bold">'. $review->user->name .' '.  $review->user->lastname .'</h5>
                            <h6 class="mt-0 mb-0 ml-3 An_Dm_bold"><small><a href="#editModal" data-toggle="modal" class="text--two">Edit</a></small></h6> 
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <div class=" d-flex  mr-3  ">'.$stars.'</div>
                        <h6 class="text-muted mb-0"><small><span>'. $review->created_at->diffForhumans() .'</span></small></h6>
                    </div>
                </div>
                <div class="mx-1 mt-2">
                    <h6 class="An_Dm_bold">'. $review->title .'</h6>
                    <p class="text-muted text-justify An_">'. $review->body .'</p>
                    <div class="d-flex">
                        '.$_recommendation.'
                        <div class="text--five ml-5 d-flex align-items-center">
                            <h6 class="mb-0 An_light"><small>Helpful?</small></h6>
                            '.$helpful.'
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>';


        $form = 
        '<form id="editReviewForm" method="POST" action="'. route('review.update',$review->id) .'">
        <input type="hidden" name="_token" value="'. csrf_token() .'">'.
        '<input type="hidden" name="_method" value="PUT" >'.
        '<div class="row mx-3 bg--four px-3 py-1 rounded shadow mt-3 mx-0 justify-content-center">'.
            '<div class="d-flex align-items-center px-4 justify-content-center">'.
                '<h5 class=" mb-0 An_light"><small> Rating</small> <span class="text-danger">*</span></h5>'.
                '<div class=" d-flex  mx-3">'.
                    '<label id="e_1" for="e_oneStar" class="e_star fa fa-star text--six pr-1 star--red red text-dark"></label><input type="radio" name="e_rate" id="e_oneStar" value="1" class="d-none">'.
                    '<label id="e_2" for="e_twoStar" class="e_star fa fa-star text--six pr-1 star--orange orange text-dark"></label> <input type="radio" name="e_rate" id="e_twoStar" value="2" class="d-none">'.
                    '<label id="e_3" for="e_threeStar" class="e_star fa fa-star text--six pr-1 star--yellow yellow text-dark"></label> <input type="radio" name="e_rate" id="e_threeStar" value="3" class="d-none">'.
                    '<label id="e_4" for="e_fourStar" class="e_star fa fa-star text--six pr-1 star--yellowgreen yellowgreen text-dark"></label> <input type="radio" name="e_rate" value="4" id="e_fourStart" class="d-none">'.
                    '<label id="e_5" for="e_fiveStar" class="e_star fa fa-star text--six pr-1 star--green green text-dark"></label><input type="radio" name="e_rate" id="e_fiveStar" value="5" class="d-none">'.
                '</div>'.
                '<h6 class=" mb-0 An_Dm_bold"><small class="text--seven e_star-error invisible text-danger">Click to rate</small></h6>'.
            '</div>'.
        '</div>'.
        '<div class="form-group small mt-5  px-3">'.
            '<label for="eb_title" class="An_trial">Reveiw Title <span class="text-danger">*</span></label>'.
            '<input type="text" class="form-control form-control-sm shadow rounded" name="title" value="'. $review->title .'" id="eb_title" aria-describedby="emailHelp" placeholder="title here...">'.
        '</div>'.
        '<div class="form-group small  px-3">'.
            '<label class="An_trial" for="eb_body">Reveiw <span class="text-danger bolder">*</span></label>'.
            '<textarea class="form-control form-control-sm rounded shadow" placeholder="body text ...." id="eb_body" name="body" rows="4">'. $review->body .'</textarea>'.
        '</div>'.
        '<div class="px-3 text--five d-flex align-items-center An_trial">'.
            '<label class="small An_trial pt-2">Would you recommend this book to others? <span class="text-danger">*</span></label>'.
            ''. $recommendation .''.
        '</div>'.
        '<div class="row ml-auto w-100 justify-content-end mr-5 mt-3">'.
            '<button type="submit" id="editbutton" class="btn btn-primary bg--two border-0 btn-sm  py-1 px-3 An_Dm_bold mt-1" style="width:120px">Update Reveiw</button>'.
        '</div>
        </form>';
        return response()->json(['Review'=>$row,'form'=>$form ]);
    }

    public function storeArticleReview(Request $request)
    {
        $request->validate([
            'body'=>'required',
            'title'=>'required',
            'rate'=>'required',
            'recommendation'=>'required',
            'id'=>'required'
        ]);
        $article = Article::find($request->id);
         $review = $article->reviews()->create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'rate' => $request->rate,
            'recommendation' => $request->recommendation
        ]);
        
        $article->rate = Helper::calculateStars($article->reviews->groupBy('rate'),$article->reviews->count());
        $article->save();
        $recommendation = '';
        $stars = '';
        $_recommendation ='';
        $helpful = '';
        if($review->recommendation == 'yes')
        {
            $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small  text-white rounded shadow px-2 An_trial  ml-2 bg--two" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none" checked>
            <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--four small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none">';
        }
        else
        {
            $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small rounded shadow px-2 An_trial  ml-2 bg--four" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none">
            <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--two text-white small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none" checked>';
        }

        for ($a = 1; $a <=$review->rate; $a++)
            $stars .= '<small><i class="fa fa-star text--one pr-1 "></i></small>';
        
        for($a = $review->rate; $a <5; $a++)
            $stars .= '<small><i class="fa fa-star text--six pr-1 "></i></small>';


        
        if($review->recommendation == 'yes')
        {
            $_recommendation = '<div class="text--two d-flex align-items-center">
                <i class="fa fa-check-circle mr-1"></i>
                <h5 class="mb-0 An_light"> Yes, <small> I recommend this article</small></h5>
            </div>';
        }
        else
        {
            $_recommendation = '<div class="text--two d-flex align-items-center ">
                <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this article</small></h5>
            </div>';
        }

        $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class=" help_yes p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
            <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class=" help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
        $row ='
        <div id="r'. $review->id .'" class="row justify-content-center mx-0 bg--eight py-4">
            <div class="col-12">
                <div class="row mx-1">
                    <div class="media align-items-center">
                        <img class="mr-3 rounded-circle shadow border" width="10%" height="80%" src="'. asset('application/users/'.$review->user->image).'" alt="image">
                        <div class="media-body d-flex align-items-center">
                            <h5 class="mt-0 mb-0 An_Dm_bold">'. $review->user->name .' '.  $review->user->lastname .'</h5>
                                    <h6 class="mt-0 mb-0 ml-3 An_Dm_bold"><small><a href="#editModal" data-toggle="modal" class="text--two">Edit</a></small></h6> 
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <div class=" d-flex  mr-3  ">'.$stars.'</div>
                        <h6 class="text-muted mb-0"><small><span>'. $review->created_at->diffForhumans() .'</span></small></h6>
                    </div>
                </div>
                <div class="mx-1 mt-2">
                    <h6 class="An_Dm_bold">'. $review->title .'</h6>
                    <p class="text-muted text-justify An_">'. $review->body .'</p>
                    <div class="d-flex">
                        '.$_recommendation.'
                        <div class="text--five ml-5 d-flex align-items-center">
                            <h6 class="mb-0 An_light"><small>Helpful?</small></h6>
                            '.$helpful.'
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>';


        $form = 
        '<form id="editReviewForm" method="POST" action="'. route('update.ArticleReview',$review->id) .'">
        <input type="hidden" name="_token" value="'. csrf_token() .'">'.
        '<input type="hidden" name="_method" value="PUT" >'.
        '<div class="row mx-3 bg--four px-3 py-1 rounded shadow mt-3 mx-0 justify-content-center">'.
            '<div class="d-flex align-items-center px-4 justify-content-center">'.
                '<h5 class=" mb-0 An_light"><small> Rating</small> <span class="text-danger">*</span></h5>'.
                '<div class=" d-flex  mx-3">'.
                    '<label id="e_1" for="e_oneStar" class="e_star fa fa-star text--six pr-1 star--red red text-dark"></label><input type="radio" name="e_rate" id="e_oneStar" value="1" class="d-none">'.
                    '<label id="e_2" for="e_twoStar" class="e_star fa fa-star text--six pr-1 star--orange orange text-dark"></label> <input type="radio" name="e_rate" id="e_twoStar" value="2" class="d-none">'.
                    '<label id="e_3" for="e_threeStar" class="e_star fa fa-star text--six pr-1 star--yellow yellow text-dark"></label> <input type="radio" name="e_rate" id="e_threeStar" value="3" class="d-none">'.
                    '<label id="e_4" for="e_fourStar" class="e_star fa fa-star text--six pr-1 star--yellowgreen yellowgreen text-dark"></label> <input type="radio" name="e_rate" value="4" id="e_fourStart" class="d-none">'.
                    '<label id="e_5" for="e_fiveStar" class="e_star fa fa-star text--six pr-1 star--green green text-dark"></label><input type="radio" name="e_rate" id="e_fiveStar" value="5" class="d-none">'.
                '</div>'.
                '<h6 class=" mb-0 An_Dm_bold"><small class="text--seven e_star-error invisible text-danger">Click to rate</small></h6>'.
            '</div>'.
        '</div>'.
        '<div class="form-group small mt-5  px-3">'.
            '<label for="eb_title" class="An_trial">Reveiw Title <span class="text-danger">*</span></label>'.
            '<input type="text" class="form-control form-control-sm shadow rounded" name="title" value="'. $review->title .'" id="eb_title" aria-describedby="emailHelp" placeholder="title here...">'.
        '</div>'.
        '<div class="form-group small  px-3">'.
            '<label class="An_trial" for="eb_body">Reveiw <span class="text-danger bolder">*</span></label>'.
            '<textarea class="form-control form-control-sm rounded shadow" placeholder="body text ...." id="eb_body" name="body" rows="4">'. $review->body .'</textarea>'.
        '</div>'.
        '<div class="px-3 text--five d-flex align-items-center An_trial">'.
            '<label class="small An_trial pt-2">Would you recommend this article to others? <span class="text-danger">*</span></label>'.
            ''. $recommendation .''.
        '</div>'.
        '<div class="row ml-auto w-100 justify-content-end mr-5 mt-3">'.
            '<button type="submit" id="editbutton" class="btn btn-primary bg--two border-0 btn-sm  py-1 px-3 An_Dm_bold mt-1" style="width:120px">Update Reveiw</button>'.
        '</div>
        </form>';
        return response()->json(['Review'=>$row,'form'=>$form ]);
    }


    public function storeAudioBookReview(Request $request)
    {
        $request->validate([
            'body'=>'required',
            'title'=>'required',
            'rate'=>'required',
            'recommendation'=>'required',
            'id'=>'required'
        ]);
        $book = AudioBook::find($request->id);
         $review = $book->reviews()->create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'rate' => $request->rate,
            'recommendation' => $request->recommendation
        ]);
        
        $book->rate = Helper::calculateStars($book->reviews->groupBy('rate'),$book->reviews->count());
        $book->save();
        $recommendation = '';
        $stars = '';
        $_recommendation ='';
        $helpful = '';
        if($review->recommendation == 'yes')
        {
            $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small  text-white rounded shadow px-2 An_trial  ml-2 bg--two" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none" checked>
            <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--four small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none">';
        }
        else
        {
            $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small rounded shadow px-2 An_trial  ml-2 bg--four" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none">
            <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--two text-white small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none" checked>';
        }

        for ($a = 1; $a <=$review->rate; $a++)
            $stars .= '<small><i class="fa fa-star text--one pr-1 "></i></small>';
        
        for($a = $review->rate; $a <5; $a++)
            $stars .= '<small><i class="fa fa-star text--six pr-1 "></i></small>';


        
        if($review->recommendation == 'yes')
        {
            $_recommendation = '<div class="text--two d-flex align-items-center">
                <i class="fa fa-check-circle mr-1"></i>
                <h5 class="mb-0 An_light"> Yes, <small> I recommend this audio book</small></h5>
            </div>';
        }
        else
        {
            $_recommendation = '<div class="text--two d-flex align-items-center ">
                <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this audio book</small></h5>
            </div>';
        }

        $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class=" help_yes p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
            <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class=" help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
        $row ='
        <div id="r'. $review->id .'" class="row justify-content-center mx-0 bg--eight py-4">
            <div class="col-12">
                <div class="row mx-1">
                    <div class="media align-items-center">
                        <img class="mr-3 rounded-circle shadow border" width="10%" height="80%" src="'. asset('application/users/'.$review->user->image).'" alt="image">
                        <div class="media-body d-flex align-items-center">
                            <h5 class="mt-0 mb-0 An_Dm_bold">'. $review->user->name .' '.  $review->user->lastname .'</h5>
                                    <h6 class="mt-0 mb-0 ml-3 An_Dm_bold"><small><a href="#editModal" data-toggle="modal" class="text--two">Edit</a></small></h6> 
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <div class=" d-flex  mr-3  ">'.$stars.'</div>
                        <h6 class="text-muted mb-0"><small><span>'. $review->created_at->diffForhumans() .'</span></small></h6>
                    </div>
                </div>
                <div class="mx-1 mt-2">
                    <h6 class="An_Dm_bold">'. $review->title .'</h6>
                    <p class="text-muted text-justify An_">'. $review->body .'</p>
                    <div class="d-flex">
                        '.$_recommendation.'
                        <div class="text--five ml-5 d-flex align-items-center">
                            <h6 class="mb-0 An_light"><small>Helpful?</small></h6>
                            '.$helpful.'
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>';


        $form = 
        '<form id="editReviewForm" method="POST" action="'. route('update.AudioBookReview',$review->id) .'">
        <input type="hidden" name="_token" value="'. csrf_token() .'">'.
        '<input type="hidden" name="_method" value="PUT" >'.
        '<div class="row mx-3 bg--four px-3 py-1 rounded shadow mt-3 mx-0 justify-content-center">'.
            '<div class="d-flex align-items-center px-4 justify-content-center">'.
                '<h5 class=" mb-0 An_light"><small> Rating</small> <span class="text-danger">*</span></h5>'.
                '<div class=" d-flex  mx-3">'.
                    '<label id="e_1" for="e_oneStar" class="e_star fa fa-star text--six pr-1 star--red red text-dark"></label><input type="radio" name="e_rate" id="e_oneStar" value="1" class="d-none">'.
                    '<label id="e_2" for="e_twoStar" class="e_star fa fa-star text--six pr-1 star--orange orange text-dark"></label> <input type="radio" name="e_rate" id="e_twoStar" value="2" class="d-none">'.
                    '<label id="e_3" for="e_threeStar" class="e_star fa fa-star text--six pr-1 star--yellow yellow text-dark"></label> <input type="radio" name="e_rate" id="e_threeStar" value="3" class="d-none">'.
                    '<label id="e_4" for="e_fourStar" class="e_star fa fa-star text--six pr-1 star--yellowgreen yellowgreen text-dark"></label> <input type="radio" name="e_rate" value="4" id="e_fourStart" class="d-none">'.
                    '<label id="e_5" for="e_fiveStar" class="e_star fa fa-star text--six pr-1 star--green green text-dark"></label><input type="radio" name="e_rate" id="e_fiveStar" value="5" class="d-none">'.
                '</div>'.
                '<h6 class=" mb-0 An_Dm_bold"><small class="text--seven e_star-error invisible text-danger">Click to rate</small></h6>'.
            '</div>'.
        '</div>'.
        '<div class="form-group small mt-5  px-3">'.
            '<label for="eb_title" class="An_trial">Reveiw Title <span class="text-danger">*</span></label>'.
            '<input type="text" class="form-control form-control-sm shadow rounded" name="title" value="'. $review->title .'" id="eb_title" aria-describedby="emailHelp" placeholder="title here...">'.
        '</div>'.
        '<div class="form-group small  px-3">'.
            '<label class="An_trial" for="eb_body">Reveiw <span class="text-danger bolder">*</span></label>'.
            '<textarea class="form-control form-control-sm rounded shadow" placeholder="body text ...." id="eb_body" name="body" rows="4">'. $review->body .'</textarea>'.
        '</div>'.
        '<div class="px-3 text--five d-flex align-items-center An_trial">'.
            '<label class="small An_trial pt-2">Would you recommend this article to others? <span class="text-danger">*</span></label>'.
            ''. $recommendation .''.
        '</div>'.
        '<div class="row ml-auto w-100 justify-content-end mr-5 mt-3">'.
            '<button type="submit" id="editbutton" class="btn btn-primary bg--two border-0 btn-sm  py-1 px-3 An_Dm_bold mt-1" style="width:120px">Update Reveiw</button>'.
        '</div>
        </form>';
        return response()->json(['Review'=>$row,'form'=>$form ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        if(Auth::user()->id == $review->user_id)
        {
            $review->body = $request->body;
            $review->title = $request->title;
            $review->rate = $request->e_rate;
            $review->recommendation = $request->recommendation;
            $review->save();
            $book = Book::find($review->reviewable_id);
            $book->rate = Helper::calculateStars($book->reviews->groupBy('rate'),$book->reviews->count());
            $book->save();
            $id = $review->id;
            $recommendation = '';
            $stars = '';
            $_recommendation ='';
            $helpful = '';
            if($review->recommendation == 'yes')
            {
                $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small  text-white rounded shadow px-2 An_trial  ml-2 bg--two" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none" checked>
                <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--four small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none">';
            }
            else
            {
                $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small rounded shadow px-2 An_trial  ml-2 bg--four" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none">
                <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--two text-white small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none" checked>';
            }

            for ($a = 1; $a <=$review->rate; $a++)
                $stars .= '<small><i class="fa fa-star text--one pr-1 "></i></small>';
            
            for($a = $review->rate; $a <5; $a++)
                $stars .= '<small><i class="fa fa-star text--six pr-1 "></i></small>';


            
            if($review->recommendation == 'yes')
            {
                $_recommendation = '<div class="text--two d-flex align-items-center">
                    <i class="fa fa-check-circle mr-1"></i>
                    <h5 class="mb-0 An_light"> Yes, <small> I recommend this article</small></h5>
                </div>';
            }
            else
            {
                $_recommendation = '<div class="text--two d-flex align-items-center ">
                    <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                    <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this article</small></h5>
                </div>';
            }
            if($review->helpfuls->where('user_id',Auth::user()->id)->where("review_id",$review->id)->where("type","book")->first() != "")
            {
                if($review->helpfuls->where('user_id',Auth::user()->id)->where('review_id',$review->id)->where('type','book')->first()->helpful == 'yes')
                {
                    $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class="p-0 m-0 nav-link bg--two small  text-white rounded-left  px-2   ml-2">Yes &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                    <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class="help_no p-0 m-0 nav-link bg--four small  text--two rounded-left  px-2   ml-2">No &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                }
                else
                {
                    $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class="help_yes p-0 m-0 nav-link bg--four small  text--two rounded-left  px-2   ml-2">Yes &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. count($review->helpfuls->where('helpful','yes')) .'</span>
                    <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class="p-0 m-0 nav-link bg--two small  text-white rounded-left  px-2   ml-2">No &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                }
            }
            else
            {
                $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class="help_yes p-0 m-0 nav-link bg--four small  text--two rounded-left px-2 ml-2">Yes &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                <a href="javascript:void(0)" data-type"no" id="'. $review->id .'" class="help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
            }
            $row ='
                <div class=" col-12">'.
                    '<div class="row mx-1">'.
                        '<div class="media align-items-center">'.
                            '<img class="mr-3 rounded-circle shadow border" width="10%" height="80%" src="'. asset('application/users/'.$review->user->image).'" alt="image">'.
                            '<div class="media-body d-flex align-items-center">'.
                                '<h5 class="mt-0 mb-0 An_Dm_bold">'. $review->user->name .' '.  $review->user->lastname .'</h5>'.
                                '<h6 class="mt-0 mb-0 ml-3 An_Dm_bold"><small><a href="#editModal" data-toggle="modal" class="text--two">Edit</a></small></h6>'.
                            '</div>'.
                        '</div>'.
                        '<div class="d-flex align-items-center justify-content-center mt-3">'.
                            '<div class=" d-flex  mr-3  ">'.$stars.'</div>'.
                            '<h6 class="text-muted mb-0"><small><span>'. $review->created_at->diffForhumans() .'</span></small></h6>'.
                        '</div>'.
                    '</div>'.
                    '<div class="mx-1 mt-2">'.
                        '<h6 class="An_Dm_bold">'. $review->title .'</h6>'.
                        '<p class="text-muted text-justify An_">'. $review->body .'</p>'.
                        '<div class="d-flex">'.
                            ''.$_recommendation.''.
                            '<div class="text--five ml-5 d-flex align-items-center">'.
                                '<h6 class="mb-0 An_light"><small>Helpful?</small></h6>'.
                                ''.$helpful.''.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                    '<hr>'.
                '</div>'.'';

                $form = 
                    '<form id="editReviewForm" method="POST" action="'. route('update',$review->id) .'">
                    <input type="hidden" name="_token" value="'. csrf_token() .'">'.
                    '<input type="hidden" name="_method" value="PUT" >'.
                    '<div class="row mx-3 bg--four px-3 py-1 rounded shadow mt-3 mx-0 justify-content-center">'.
                        '<div class="d-flex align-items-center px-4 justify-content-center">'.
                            '<h5 class=" mb-0 An_light"><small> Rating</small> <span class="text-danger">*</span></h5>'.
                            '<div class=" d-flex  mx-3">'.
                                '<label id="e_1" for="e_oneStar" class="e_star fa fa-star text--six pr-1 star--red red text-dark"></label><input type="radio" name="e_rate" id="e_oneStar" value="1" class="d-none">'.
                                '<label id="e_2" for="e_twoStar" class="e_star fa fa-star text--six pr-1 star--orange orange text-dark"></label> <input type="radio" name="e_rate" id="e_twoStar" value="2" class="d-none">'.
                                '<label id="e_3" for="e_threeStar" class="e_star fa fa-star text--six pr-1 star--yellow yellow text-dark"></label> <input type="radio" name="e_rate" id="e_threeStar" value="3" class="d-none">'.
                                '<label id="e_4" for="e_fourStar" class="e_star fa fa-star text--six pr-1 star--yellowgreen yellowgreen text-dark"></label> <input type="radio" name="e_rate" value="4" id="e_fourStart" class="d-none">'.
                                '<label id="e_5" for="e_fiveStar" class="e_star fa fa-star text--six pr-1 star--green green text-dark"></label><input type="radio" name="e_rate" id="e_fiveStar" value="5" class="d-none">'.
                            '</div>'.
                            '<h6 class=" mb-0 An_Dm_bold"><small class="text--seven e_star-error invisible text-danger">Click to rate</small></h6>'.
                        '</div>'.
                    '</div>'.
                    '<div class="form-group small mt-5  px-3">'.
                        '<label for="eb_title" class="An_trial">Reveiw Title <span class="text-danger">*</span></label>'.
                        '<input type="text" class="form-control form-control-sm shadow rounded" name="title" value="'. $review->title .'" id="eb_title" aria-describedby="emailHelp" placeholder="title here...">'.
                    '</div>'.
                    '<div class="form-group small  px-3">'.
                        '<label class="An_trial" for="eb_body">Reveiw <span class="text-danger bolder">*</span></label>'.
                        '<textarea class="form-control form-control-sm rounded shadow" placeholder="body text ...." id="eb_body" name="body" rows="4">'. $review->body .'</textarea>'.
                    '</div>'.
                    '<div class="px-3 text--five d-flex align-items-center An_trial">'.
                        '<label class="small An_trial pt-2">Would you recommend this article to others? <span class="text-danger">*</span></label>'.
                        ''. $recommendation .''.
                    '</div>'.
                    '<div class="row ml-auto w-100 justify-content-end mr-5 mt-3">'.
                        '<button type="submit" id="editbutton" class="btn btn-primary bg--two border-0 btn-sm  py-1 px-3 An_Dm_bold mt-1" style="width:120px">Update Reveiw</button>'.
                    '</div>
                    </form>';
            return response()->json(['Review'=>$row,'id'=>$id,'form'=>$form ]);
        }
    }
    public function updateArticleReview(Request $request, Review $review)
    {
        
        if(Auth::user()->id == $review->user_id)
        {

            $review->body = $request->body;
            $review->title = $request->title;
            $review->rate = $request->e_rate;
            $review->recommendation = $request->recommendation;
            $review->save();
            $article = article::find($review->reviewable_id);
            $article->rate = Helper::calculateStars($article->reviews->groupBy('rate'),$article->reviews->count());
            $article->save();
            $id = $review->id;
            $recommendation = '';
            $stars = '';
            $_recommendation ='';
            $helpful = '';
            if($review->recommendation == 'yes')
            {
                $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small  text-white rounded shadow px-2 An_trial  ml-2 bg--two" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none" checked>
                <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--four small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none">';
            }
            else
            {
                $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small rounded shadow px-2 An_trial  ml-2 bg--four" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none">
                <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--two text-white small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none" checked>';
            }

            for ($a = 1; $a <=$review->rate; $a++)
                $stars .= '<small><i class="fa fa-star text--one pr-1 "></i></small>';
            
            for($a = $review->rate; $a <5; $a++)
                $stars .= '<small><i class="fa fa-star text--six pr-1 "></i></small>';


            
            if($review->recommendation == 'yes')
            {
                $_recommendation = '<div class="text--two d-flex align-items-center">
                    <i class="fa fa-check-circle mr-1"></i>
                    <h5 class="mb-0 An_light"> Yes, <small> I recommend this article</small></h5>
                </div>';
            }
            else
            {
                $_recommendation = '<div class="text--two d-flex align-items-center ">
                    <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                    <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this article</small></h5>
                </div>';
            }
            if($review->helpfuls->where('user_id',Auth::user()->id)->where("review_id",$review->id)->where("type","article")->first() != "")
            {
                if($review->helpfuls->where('user_id',Auth::user()->id)->where('review_id',$review->id)->where('type','article')->first()->helpful == 'yes')
                {
                    $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class="p-0 m-0 nav-link bg--two small  text-white rounded-left  px-2   ml-2">Yes &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                    <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class="help_no p-0 m-0 nav-link bg--four small  text--two rounded-left  px-2   ml-2">No &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                }
                else
                {
                    $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class="help_yes p-0 m-0 nav-link bg--four small  text--two rounded-left  px-2   ml-2">Yes &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. count($review->helpfuls->where('helpful','yes')) .'</span>
                    <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class="p-0 m-0 nav-link bg--two small  text-white rounded-left  px-2   ml-2">No &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                }
            }
            else
            {
                $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class="help_yes p-0 m-0 nav-link bg--four small  text--two rounded-left px-2 ml-2">Yes &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                <a href="javascript:void(0)" data-type"no" id="'. $review->id .'" class="help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
            }

            $row ='
                <div class=" col-12">'.
                    '<div class="row mx-1">'.
                        '<div class="media align-items-center">'.
                            '<img class="mr-3 rounded-circle shadow border" width="10%" height="80%" src="'. asset('application/users/'.$review->user->image).'" alt="image">'.
                            '<div class="media-body d-flex align-items-center">'.
                                '<h5 class="mt-0 mb-0 An_Dm_bold">'. $review->user->name .' '.  $review->user->lastname .'</h5>'.
                                '<h6 class="mt-0 mb-0 ml-3 An_Dm_bold"><small><a href="#editModal" data-toggle="modal" class="text--two">Edit</a></small></h6>'.
                            '</div>'.
                        '</div>'.
                        '<div class="d-flex align-items-center justify-content-center mt-3">'.
                            '<div class=" d-flex  mr-3  ">'.$stars.'</div>'.
                            '<h6 class="text-muted mb-0"><small><span>'. $review->created_at->diffForhumans() .'</span></small></h6>'.
                        '</div>'.
                    '</div>'.
                    '<div class="mx-1 mt-2">'.
                        '<h6 class="An_Dm_bold">'. $review->title .'</h6>'.
                        '<p class="text-muted text-justify An_">'. $review->body .'</p>'.
                        '<div class="d-flex">'.
                            ''.$_recommendation.''.
                            '<div class="text--five ml-5 d-flex align-items-center">'.
                                '<h6 class="mb-0 An_light"><small>Helpful?</small></h6>'.
                                ''.$helpful.''.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                    '<hr>'.
                '</div>'.'';
                $form = 
                    '<form id="editReviewForm" method="POST" action="'. route('update.ArticleReview',$review->id) .'">
                    <input type="hidden" name="_token" value="'. csrf_token() .'">'.
                    '<input type="hidden" name="_method" value="PUT" >'.
                    '<div class="row mx-3 bg--four px-3 py-1 rounded shadow mt-3 mx-0 justify-content-center">'.
                        '<div class="d-flex align-items-center px-4 justify-content-center">'.
                            '<h5 class=" mb-0 An_light"><small> Rating</small> <span class="text-danger">*</span></h5>'.
                            '<div class=" d-flex  mx-3">'.
                                '<label id="e_1" for="e_oneStar" class="e_star fa fa-star text--six pr-1 star--red red text-dark"></label><input type="radio" name="e_rate" id="e_oneStar" value="1" class="d-none">'.
                                '<label id="e_2" for="e_twoStar" class="e_star fa fa-star text--six pr-1 star--orange orange text-dark"></label> <input type="radio" name="e_rate" id="e_twoStar" value="2" class="d-none">'.
                                '<label id="e_3" for="e_threeStar" class="e_star fa fa-star text--six pr-1 star--yellow yellow text-dark"></label> <input type="radio" name="e_rate" id="e_threeStar" value="3" class="d-none">'.
                                '<label id="e_4" for="e_fourStar" class="e_star fa fa-star text--six pr-1 star--yellowgreen yellowgreen text-dark"></label> <input type="radio" name="e_rate" value="4" id="e_fourStart" class="d-none">'.
                                '<label id="e_5" for="e_fiveStar" class="e_star fa fa-star text--six pr-1 star--green green text-dark"></label><input type="radio" name="e_rate" id="e_fiveStar" value="5" class="d-none">'.
                            '</div>'.
                            '<h6 class=" mb-0 An_Dm_bold"><small class="text--seven e_star-error invisible text-danger">Click to rate</small></h6>'.
                        '</div>'.
                    '</div>'.
                    '<div class="form-group small mt-5  px-3">'.
                        '<label for="eb_title" class="An_trial">Reveiw Title <span class="text-danger">*</span></label>'.
                        '<input type="text" class="form-control form-control-sm shadow rounded" name="title" value="'. $review->title .'" id="eb_title" aria-describedby="emailHelp" placeholder="title here...">'.
                    '</div>'.
                    '<div class="form-group small  px-3">'.
                        '<label class="An_trial" for="eb_body">Reveiw <span class="text-danger bolder">*</span></label>'.
                        '<textarea class="form-control form-control-sm rounded shadow" placeholder="body text ...." id="eb_body" name="body" rows="4">'. $review->body .'</textarea>'.
                    '</div>'.
                    '<div class="px-3 text--five d-flex align-items-center An_trial">'.
                        '<label class="small An_trial pt-2">Would you recommend this article to others? <span class="text-danger">*</span></label>'.
                        ''. $recommendation .''.
                    '</div>'.
                    '<div class="row ml-auto w-100 justify-content-end mr-5 mt-3">'.
                        '<button type="submit" id="editbutton" class="btn btn-primary bg--two border-0 btn-sm  py-1 px-3 An_Dm_bold mt-1" style="width:120px">Update Reveiw</button>'.
                    '</div>
                    </form>';
            return response()->json(['Review'=>$row,'id'=>$id,'form'=>$form ]);
        }
    }



    public function updateAudioBookReview(Request $request, Review $review)
    {
        
        if(Auth::user()->id == $review->user_id)
        {

            $review->body = $request->body;
            $review->title = $request->title;
            $review->rate = $request->e_rate;
            $review->recommendation = $request->recommendation;
            $review->save();
            $book = AudioBook::find($review->reviewable_id);
            $book->rate = Helper::calculateStars($book->reviews->groupBy('rate'),$book->reviews->count());
            $book->save();
            $id = $review->id;
            $recommendation = '';
            $stars = '';
            $_recommendation ='';
            $helpful = '';
            if($review->recommendation == 'yes')
            {
                $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small  text-white rounded shadow px-2 An_trial  ml-2 bg--two" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none" checked>
                <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--four small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none">';
            }
            else
            {
                $recommendation = '<label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small rounded shadow px-2 An_trial  ml-2 bg--four" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none">
                <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--two text-white small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none" checked>';
            }

            for ($a = 1; $a <=$review->rate; $a++)
                $stars .= '<small><i class="fa fa-star text--one pr-1 "></i></small>';
            
            for($a = $review->rate; $a <5; $a++)
                $stars .= '<small><i class="fa fa-star text--six pr-1 "></i></small>';


            
            if($review->recommendation == 'yes')
            {
                $_recommendation = '<div class="text--two d-flex align-items-center">
                    <i class="fa fa-check-circle mr-1"></i>
                    <h5 class="mb-0 An_light"> Yes, <small> I recommend this audio book</small></h5>
                </div>';
            }
            else
            {
                $_recommendation = '<div class="text--two d-flex align-items-center ">
                    <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                    <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this audio book</small></h5>
                </div>';
            }
            if($review->helpfuls->where('user_id',Auth::user()->id)->where("review_id",$review->id)->where("type","audiobook")->first() != "")
            {
                if($review->helpfuls->where('user_id',Auth::user()->id)->where('review_id',$review->id)->where('type','audiobook')->first()->helpful == 'yes')
                {
                    $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class="p-0 m-0 nav-link bg--two small  text-white rounded-left  px-2   ml-2">Yes &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                    <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class="help_no p-0 m-0 nav-link bg--four small  text--two rounded-left  px-2   ml-2">No &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                }
                else
                {
                    $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class="help_yes p-0 m-0 nav-link bg--four small  text--two rounded-left  px-2   ml-2">Yes &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. count($review->helpfuls->where('helpful','yes')) .'</span>
                    <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class="p-0 m-0 nav-link bg--two small  text-white rounded-left  px-2   ml-2">No &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                }
            }
            else
            {
                $helpful = '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class="help_yes p-0 m-0 nav-link bg--four small  text--two rounded-left px-2 ml-2">Yes &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                <a href="javascript:void(0)" data-type"no" id="'. $review->id .'" class="help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
            }

            $row ='
                <div class=" col-12">'.
                    '<div class="row mx-1">'.
                        '<div class="media align-items-center">'.
                            '<img class="mr-3 rounded-circle shadow border" width="10%" height="80%" src="'. asset('application/users/'.$review->user->image).'" alt="image">'.
                            '<div class="media-body d-flex align-items-center">'.
                                '<h5 class="mt-0 mb-0 An_Dm_bold">'. $review->user->name .' '.  $review->user->lastname .'</h5>'.
                                '<h6 class="mt-0 mb-0 ml-3 An_Dm_bold"><small><a href="#editModal" data-toggle="modal" class="text--two">Edit</a></small></h6>'.
                            '</div>'.
                        '</div>'.
                        '<div class="d-flex align-items-center justify-content-center mt-3">'.
                            '<div class=" d-flex  mr-3  ">'.$stars.'</div>'.
                            '<h6 class="text-muted mb-0"><small><span>'. $review->created_at->diffForhumans() .'</span></small></h6>'.
                        '</div>'.
                    '</div>'.
                    '<div class="mx-1 mt-2">'.
                        '<h6 class="An_Dm_bold">'. $review->title .'</h6>'.
                        '<p class="text-muted text-justify An_">'. $review->body .'</p>'.
                        '<div class="d-flex">'.
                            ''.$_recommendation.''.
                            '<div class="text--five ml-5 d-flex align-items-center">'.
                                '<h6 class="mb-0 An_light"><small>Helpful?</small></h6>'.
                                ''.$helpful.''.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                    '<hr>'.
                '</div>'.'';
                $form = 
                    '<form id="editReviewForm" method="POST" action="'. route('update.AudioBookReview',$review->id) .'">
                    <input type="hidden" name="_token" value="'. csrf_token() .'">'.
                    '<input type="hidden" name="_method" value="PUT" >'.
                    '<div class="row mx-3 bg--four px-3 py-1 rounded shadow mt-3 mx-0 justify-content-center">'.
                        '<div class="d-flex align-items-center px-4 justify-content-center">'.
                            '<h5 class=" mb-0 An_light"><small> Rating</small> <span class="text-danger">*</span></h5>'.
                            '<div class=" d-flex  mx-3">'.
                                '<label id="e_1" for="e_oneStar" class="e_star fa fa-star text--six pr-1 star--red red text-dark"></label><input type="radio" name="e_rate" id="e_oneStar" value="1" class="d-none">'.
                                '<label id="e_2" for="e_twoStar" class="e_star fa fa-star text--six pr-1 star--orange orange text-dark"></label> <input type="radio" name="e_rate" id="e_twoStar" value="2" class="d-none">'.
                                '<label id="e_3" for="e_threeStar" class="e_star fa fa-star text--six pr-1 star--yellow yellow text-dark"></label> <input type="radio" name="e_rate" id="e_threeStar" value="3" class="d-none">'.
                                '<label id="e_4" for="e_fourStar" class="e_star fa fa-star text--six pr-1 star--yellowgreen yellowgreen text-dark"></label> <input type="radio" name="e_rate" value="4" id="e_fourStart" class="d-none">'.
                                '<label id="e_5" for="e_fiveStar" class="e_star fa fa-star text--six pr-1 star--green green text-dark"></label><input type="radio" name="e_rate" id="e_fiveStar" value="5" class="d-none">'.
                            '</div>'.
                            '<h6 class=" mb-0 An_Dm_bold"><small class="text--seven e_star-error invisible text-danger">Click to rate</small></h6>'.
                        '</div>'.
                    '</div>'.
                    '<div class="form-group small mt-5  px-3">'.
                        '<label for="eb_title" class="An_trial">Reveiw Title <span class="text-danger">*</span></label>'.
                        '<input type="text" class="form-control form-control-sm shadow rounded" name="title" value="'. $review->title .'" id="eb_title" aria-describedby="emailHelp" placeholder="title here...">'.
                    '</div>'.
                    '<div class="form-group small  px-3">'.
                        '<label class="An_trial" for="eb_body">Reveiw <span class="text-danger bolder">*</span></label>'.
                        '<textarea class="form-control form-control-sm rounded shadow" placeholder="body text ...." id="eb_body" name="body" rows="4">'. $review->body .'</textarea>'.
                    '</div>'.
                    '<div class="px-3 text--five d-flex align-items-center An_trial">'.
                        '<label class="small An_trial pt-2">Would you recommend this article to others? <span class="text-danger">*</span></label>'.
                        ''. $recommendation .''.
                    '</div>'.
                    '<div class="row ml-auto w-100 justify-content-end mr-5 mt-3">'.
                        '<button type="submit" id="editbutton" class="btn btn-primary bg--two border-0 btn-sm  py-1 px-3 An_Dm_bold mt-1" style="width:120px">Update Reveiw</button>'.
                    '</div>
                    </form>';
            return response()->json(['Review'=>$row,'id'=>$id,'form'=>$form ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {   
        if($review->reviewable_type == 'App\Models\Article')
        {
            $article = Article::find($review->reviewable_id);
            $article->rate = Helper::calculateStars($article->reviews->groupBy('rate'),$article->reviews->count());
            $article->save();
            $review->delete();
            return \response()->json(['msg'=>'success','id'=>$review->id]);
        }
        else if($review->reviewable_type == 'App\Models\AudioBook')
        {
            $book = AudioBook::find($review->reviewable_id);
            $book->rate = Helper::calculateStars($book->reviews->groupBy('rate'),$book->reviews->count());
            $book->save();
            $review->delete();
            return \response()->json(['msg'=>'success','id'=>$review->id]);
        }
        else
        {
            $review->delete();
            return \response()->json(['msg'=>'success','id'=>$review->id]);
        }

    }

    public function allowReview(Book $book)
    {
        return Redirect::to(route('show.book',$book->id));
    }

    public function allowAudioBookReview(AudioBook $audiobook)
    {
        $book = $audiobook;
        return Redirect::to(route('show.audiobook',$book->id));
    }

    public function allowArticleReview(Article $article)
    {

        return Redirect::to(route('show.article',$article->id));
    }

    public function CalculateStarsArticle(Request $request)
    {
        $article = Article::find($request->id);
        $total_review = count($article->reviews->toArray());
        $stars = $article->reviews->groupBy('rate'); 
        $averageRate = Helper::calculateStars($stars,$total_review);
        return response()->json(['stars'=>$stars,'total_review'=>$total_review,'average_rate'=>$averageRate]);
    }

    public function CalculateStarsBook(Request $request)
    {
        $book = Book::find($request->id);
        $total_review = count($book->reviews->toArray());
        $stars = $book->reviews->groupBy('rate'); 
        $averageRate = Helper::calculateStars($stars,$total_review);
        return response()->json(['stars'=>$stars,'total_review'=>$total_review,'average_rate'=>$averageRate]);
    }

    public function CalculateStarsAudioBook(Request $request)
    {
        $book = AudioBook::find($request->id);
        $total_review = count($book->reviews->toArray());
        $stars = $book->reviews->groupBy('rate'); 
        $averageRate = Helper::calculateStars($stars,$total_review);
        return response()->json(['stars'=>$stars,'total_review'=>$total_review,'average_rate'=>$averageRate]);
    }
}

