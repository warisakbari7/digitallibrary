@extends('layouts.frontend')

@section('content')
<section class="bg--four pt-2">
        <div class="container">
             <div class="row w-100  ml-lg-5 mx-0 ">
                 <form action="{{ route('search.article') }}" id="SearchForm" class="input-group mx-auto w-75 mb-2 d-flex align-items-center bg--four  ">
                     <div class="input-group mx-auto w-75 mb-2 d-flex align-items-center bg-white rounded shadow ">
                         <input type="text" id="q" name="q" class="form-control border-0 bg-white " placeholder="Search articles here...">
                         <input type="submit" value="" id="submit_btn" class="input-group-addon bg-white  border-0  px-2"><label for="submit_btn" class="fa fa-search pr-2 pt-2" style="cursor:pointer"></label>
                     </div>
                 </form>
             </div>
         </div>
    </section>
<section class="bg--eight">
        <div class="container pb-4">
                <div class="row justify-content-center mx-0 mt-0 bg--eight py-3">
                        <div id="article_container" class=" col-lg-9 col-md-10 col-sm-12 col-12 mt-5">
                            <div class="row"> 
                                <div class="col-lg-6 col-md-6 col-sm-6 " >
                                    <embed oncontextmenu="return false" id="lang" data-id="{{ $article->id }}" data-language="{{ $article->language }}" src="{{ asset('application/articles/pdf/'.$article->path) }}#toolbar=0" class=" image-fluid shadow" style="height: 90%; width: 90%; border-radius:10px;" alt="{{ $article->title }}">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <h3 id="title" class="An_Dm_bold">{{ $article->title }}</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0 ">Author : </p>
                                        </div>
                                        <div class="col-8">
                                            <p id="author" class=" text--two mb-0 ">{{ $article->author }}</p>
                                        </div>
                                    </div>
                                        
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0 ">Category : </p>
                                        </div>
                                        <div class="col-8">
                                            @if($article->language == 'dari')
                                                <p class=" text--two mb-0 ">{{ ucwords($article->category->dname) }}</p>
                                            @elseif($article->language == 'english')
                                                <p class=" text--two mb-0 ">{{ ucwords($article->category->ename) }}</p>
                                            @else
                                                <p class=" text--two mb-0 ">{{ ucwords($article->category->pname) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0">Uploaded : </p>
                                        </div>
                                        <div class="col-8">
                                                <p class="  text--two mb-0">{{ $article->created_at->format('d M Y') }} by  
                                                        @if(Auth::check())
                                                            @if(Auth::user()->id == $article->owner_id)
                                                                you 
                                                            @endif
                                                        @else
                                                            {{ $article->owner->name }} {{ $article->owner->lastname }}</p>
                                                            
                                                        @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0">Publish Date : </p>
                                        </div>
                                        <div class="col-8">
                                            <p id="publish" class=" text--two mb-0">{{ date_format(date_create($article->publish_date),'d M Y') }}   
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Pages : </p>
                                        </div>
                                        <div class="col-8 text-left">
                                            <p id="pages" class="text--two mb-0">{{ $article->pages }} Pages, {{ $article->chapter }} Chapters </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0">Edition : </p>
                                        </div>
                                        <div class="col-8">
                                            <p id="edition" class="text--two mb-0">{{ $article->edition }} Edition, {{ $article->publish_date }} </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0">Size : </p>
                                        </div>
                                        <div class="col-8">
                                            <p class="text--two mb-0">{{ $article->size }} </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Views : </p>
                                        </div>
                                        <div class="col-8">
                                            <p class=" text--two mb-0">{{ $article->views }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Downloads : </p>
                                        </div>
                                        <div class="col-8">
                                            <p class="text--two mb-0">{{ $article->downloads ?? 0 }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Ranking : </p>
                                        </div>
                                        <div class="col-8">
                                            <div class="bg-secondary" style="width:100px" >
                                                    <div class="StarImg bg--one" style="width:{{ $averageRate*100/5 }}px;">
                                                        <img src="{{ asset('asset/images/stars.jpg') }}" alt="StarsRanking" width="100" >
                                                    </div>
                                            </div>
                                                <small id="a_averageRate">{{ $averageRate }} </small>
                                                <small id="a_total_rate" > ({{ $total_review }})</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            @if(Auth::check())
                                                <div class="pt-lg-2 pb-2">
                                                    <a id="viewbtn" href="{{ asset('application/articles/pdf/'.$article->path) }}"  target="_blank"><button  class="btn--outline--secondary btn-lg px-4 py-1 shadow mr-2 an_bold" style="width:120px"> <i class="fa fa-sm fa-book-reader"></i> Read </button></a>
                                                    <a id="downloadbtn" href="{{ asset('application/articles/pdf/'.$article->path) }}" download ><button  class="btn--outline--primary py-1 btn-lg px-4 shadow an_bold " style="width:120px"><i> </i> Download</button></a><br>
                                                </div>
                                            @else
                                                <div class="pt-lg-2 pb-2">
                                                    <a href="{{ route('view.article',$article->id) }}"><button class="btn--outline--secondary btn-lg px-4 py-1 shadow mr-2 an_bold" style="width:120px"><i class="fa fa-sm fa-book-reader"> </i> Read </button></a>
                                                    <a href="{{ route('download.article',$article->id) }}" ><button class="btn--outline--primary py-1 btn-lg px-4 shadow an_bold" style="width:120px"><i> </i> Download</button></a><br>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 p-2 ml-2">
                                            <ul class="list-inline">
                                                @foreach ($socialShare as $key=>$value )
                                                    <li class="list-inline-item"> <a href="{{ $value }}"> <img class=" img-fluid rounded" src=" {{ asset("asset/images/{$key}.png") }}" alt="" width="45"> </a> </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-12 p-2 ml-2 ">
                                                @if(Auth::check())
                                                    @if($article->SavedBy()->where('user_id',Auth::user()->id)->where('saveable_id',$article->id)->count() > 0)
                                                        <a href="javascript:void(0)" id="save_btn"><button class="w-75 bg-success text-white an_bold rounded" style="border:none">Unsave</button></a>                                        
                                                    @else
                                                        <a href="javascript:void(0)" id="save_btn"><button class="w-75 bg--two text-white an_b  old rounded" style="border:none">Save</button></a>                                        
                                                    @endif    
                                                @else
                                                    <a href="{{ route('article.IsUserLogin',$article->id) }}"><button class="w-75 bg--two text-white an_bold rounded" style="border:none">Save</button></a>
                                                @endif
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="row mt-4 p-4">
                                @if($article->language == 'dari')
                                @if($article->about_author != '')
                                <div id="a_aboutauthor_container " class="pl-1 text-right py-3 w-100" style="border-top:1px solid lightgray;">
                                    <h4 class="An_Dm_bold">درباره نویسنده</h4>
                                    <small><p class="text-break">{{ $article->about_author }}</p></small>
                                </div>
                                @endif
                                @if($article->about_article != '')
                                    <div id="a_aboutarticle_container" class="pl-1 mt-5 text-right w-100" style="border-top:1px solid lightgray;">
                                        <h4 class="An_Dm_bold">درباره مقاله </h4>
                                        <small><p class="text-break">{{ $article->about_article }}</p></small>
                                    </div>
                                @endif
                                @elseif ($article->language == 'english')
                                    @if($article->about_author != '')
                                        <div id="b_aboutauthor_container" class="pl-1 py-3 w-100" style="border-top:1px solid lightgray;">
                                            <h4 class="An_Dm_bold">About Author</h4>
                                            <small><p class="text-break">{{ $article->about_author }}</p></small>
                                        </div>
                                    @endif
                                    @if($article->about_article != '')
                                        <div id="a_aboutarticle_container" class="pl-1 py-3 w-100" style="border-top:1px solid lightgray;">
                                            <h4 class="An_Dm_bold">About ‌Article</h4>
                                            <small><p class="text-break">{{ $article->about_article }} </p></small>
                                        </div>
                                    @endif
                                @else
                                    @if($article->about_author != '')
                                    <div id="b_aboutauthor_container" class="pl-1 text-right w-100 py-3" style="border-top:1px solid lightgray;">
                                        <h4 class="An_Dm_bold">دلیکوال په اړه</h4>
                                        <small><p class="text-break">{{ $article->about_author }}</p></small>
                                </div>
                                @endif
                                @if ($article->about_article != '')            
                                <div id="a_aboutarticle_container" class="pl-1 mt-5 text-right" style="border-top:1px solid lightgray;">
                                    <h4 class="An_Dm_bold">مقاله په اړه  </h4>
                                    <small><p class="text-break">{{ $article->about_article }}</p></small>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                </div>
                <div class="row justify-content-center mx-0 bg--eight py-4" >
                           <div class="col-lg-9 col-md-10 col-sm-12 col-12 mt-2" style="border-top:1px solid lightgray;">
                                <h4 class="An_Dm_bold pl-2 py-2">You may also like</h4>
                                <div class="row">
                                    <div class="col-12">
                                        @forelse ($relatedArticles as $relatedArticle)
                                            <div class="related-article bg--four  p-1 rounded my-2  ">
                                                <a href="{{ route('show.article',$relatedArticle->id) }}" class="text--two nav-link p-0 text-center">
                                                    <h5 class="m-0 An_trial">{{ $relatedArticle->title }}</h5>
                                                </a>
                                            </div>
                                        @empty
                                            <div class=" bg--four p-1 rounded my-2  ">
                                                <a href="javascript:void(0)" class="text--two nav-link p-0 text-center">
                                                    <h5 class="m-0 An_trial">No Data</h5>
                                                </a>
                                            </div>
                                        @endforelse    
                                    </div>
                                </div>
                           </div>
                </div>
                <div class="row justify-content-center mx-0 bg--eight py-4 px-5">
                    <div class="col-12 px-5">
                        <div class="pl-1 mt-5">
                            <hr class="mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="An_Dm_bold">Rating Summary</h4>
                                @if(Auth::check())
                                    @if($article->reviews->where('user_id',Auth::user()->id)->first() == '')
                                        <!-- Button trigger modal -->
                                            <button type="button" id="addbutton" class="btn btn-primary bg--two An_light border-0  ml-4 py-0" data-toggle="modal" data-target="#reviewModal">Add a Reveiw</button>
                                        {{-- start of review modal --}}
                                            <div class="modal fade bg--opcity" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header text-white text-center bg--two align-items-center py-2 ">
                                                                <h5 class=" mb-0 w-100 text-center An_Dm_bold " id="exampleModalLabel">Add Reveiw</h5>
                                                                <i class=" text-white bg-danger rounded" style="width:25px; cursor:pointer" data-dismiss="modal">&times</i>
                                                            </div>
                
                                                            <div class="modal-body " >
                                                                <div class="row px-3 ">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <h4 class="mb-0 An_Dm_bold text-center">{{ ucwords($article->title) }}</h4>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <p class="pl-1 text-muted mb-0 An_Dm_bold">Author :</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <p class="pl-4 ml-2 text--two mb-0  small">{{ ucwords($article->author) }}</p>
                                                                            </div>
                                                                        </div>
                                                                       
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <p class="pl-1 text-muted mb-0 An_Dm_bold">Pages :</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <p class="pl-4 ml-2 text--two mb-0 small">{{ $article->pages }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <p class="pl-1 text-muted mb-0 An_Dm_bold">Views :</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <p class="pl-4 ml-2 text--two mb-0 small">{{ $article->views }}</p>
                                                                            </div>
                                                                        </div>
                
                                                                    </div>
                                                                </div> 
                                                                <form id="reviewForm" method="POST" action="{{ route('add.articleReview') }}">
                                                                    @csrf
                                                                    <div class="row mx-3 bg--four px-3 py-1 rounded shadow mt-3 mx-0 justify-content-center">
                                                                        <div class="d-flex align-items-center px-4 justify-content-center">
                                                                            <h5 class=" mb-0 An_light"><small> Rating</small> <span class="text-danger">*</span></h5>
                                                                            <div class=" d-flex  mx-3">
                                                                                <label id="1" for="oneStar" class="star fa fa-star text--six pr-1 star--red red text-dark"></label><input type="radio" name="rate" id="oneStar" value="1" class="d-none">
                                                                                <label id="2" for="twoStar" class="star fa fa-star text--six pr-1 star--orange orange text-dark"></label> <input type="radio" name="rate" id="twoStar" value="2" class="d-none">
                                                                                <label id="3" for="threeStar" class="star fa fa-star text--six pr-1 star--yellow yellow text-dark"></label> <input type="radio" name="rate" id="threeStar" value="3" class="d-none">
                                                                                <label id="4" for="fourStar" class="star fa fa-star text--six pr-1 star--yellowgreen yellowgreen text-dark"></label> <input type="radio" name="rate" value="4" id="fourStar" class="d-none">
                                                                                <label id="5" for="fiveStar" class="star fa fa-star text--six pr-1 star--green green text-dark"></label><input type="radio" name="rate" id="fiveStar" value="5" class="d-none">
                                                                            </div>
                                                                            <h6 class=" mb-0 An_Dm_bold"><small class="text--seven star-error invisible text-danger">Click to rate</small></h6>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group small mt-5  px-3">
                                                                        <label for="b_title" class="An_trial">Reveiw Title <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control form-control-sm shadow rounded" name="title" id="b_title" aria-describedby="emailHelp" placeholder="title here...">
                                                                    </div>
                                                                    <div class="form-group small  px-3">
                                                                        <label class="An_trial" for="b_body">Reveiw <span class="text-danger bolder">*</span></label>
                                                                        <textarea class="form-control form-control-sm rounded shadow" placeholder="body text ...." id="b_body" name="body" rows="4"></textarea>
                                                                    </div>
                                                                    <div class="px-3 text--five d-flex align-items-center An_trial">
                                                                        <label class="small An_trial pt-2">Would you recommend this article to others? <span class="text-danger">*</span></label>
                                                                        <label id="lblYes" for="yes" class="p-0 m-0 nav-link  small  text-white rounded shadow px-2 An_trial  ml-2 bg--two" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="yes" value="yes" class="d-none" checked>
                                                                        <label id="lblNo" for="no" class="p-0 m-0 nav-link bg--four small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="no" value="no" class="d-none">
                                                                    </div>
                                                                    <div class="row ml-auto w-100 justify-content-end mr-5 mt-3">
                                                                        <button type="submit" id="postbutton" class="btn btn-primary bg--two border-0 btn-sm  py-1 px-3 An_Dm_bold " style="width:120px;">Post Review</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        {{-- end fo review modal --}}
                                    @else
                                        <div class="toast add-review-toast font-italic" style="border-radius:30px !important;">
                                            <div class=" text-info shadow p-2" style="border-radius:30px !important;">
                                                <span > <i class="fa fa-info-circle"></i> You have already posted a review</span>
                                            </div>
                                        </div>
                                        <button type="button" id="toastaddbutton" class=" btn btn-primary bg--two An_light border-0  ml-4 py-0">Add a Reveiw</button>

                                    @endif
                                @else
                                    <a href="{{ route('allow.articlereview',$article->id) }}" class="btn btn-primary bg--two An_light border-0  ml-4 py-0">Login to Add Review</a>
                                @endif

                            </div>
                            <div class="row mt-4">
                                <div id="StarPercentageWrapper" class="col-lg-6">
                                    @for($x = 1; $x<=5; $x++ )
                                        @if(isset($stars[$x]))
                                        <div class ="row">
                                            <div class="col-1">
                                                <h6 class="text--two "><small>{{$x}}&nbsp;Star</small></h6>
                                            </div>
                                            <div class="col-10 ">
                                                <div class="progress rounded border  w-100 mx-2">
                                                    <div class="progress-bar bg--one" role="progressbar" style="width: {{ $stars[$x] }}%" aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-1 pl-2">
                                                <h6 class="text--two"><small>{{ $stars[$x] }}%</small></h6>
                                            </div>
                                        </div>
                                        @else
                                        <div class="row">
                                            <div class="col-1">
                                                <h6 class="text--two "><small>{{$x}}&nbsp;Star</small></h6>
                                            </div>
                                            <div class="col-10">
                                                <div class="progress rounded border  w-100 mx-2">
                                                    <div class="progress-bar bg--one" role="progressbar" style="width: 0%" aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <h6 class="text--two"><small>0%</small></h6>
                                            </div>
                                        </div>
                                        @endif
                                    @endfor
                                </div>
                                <div class="col-lg-6 text-center mt-4 mt-lg-0 mt-md-0 ">
                                    <h6 class="An_Dm_bold">Average Customer Rating</h6>
                                    <div class="d-flex align-items-center justify-content-center ">
                                        <div class="bg-secondary" style="width:100px;">
                                            <div class="StarImg bg--one mr-3" style="width:{{ $averageRate*100/5 }}px;">
                                                <img src="{{ asset('asset/images/stars.jpg') }}" alt="StarsRanking" width="100" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mt-3">
                                            <h6 class="text--two mb-0 An_Dm_bold mr-3">Overall</h6>
                                            <h6 class="text--two mb-0"><span id="averageRate">{{ $averageRate }}</span></h6>
                                    </div>

                                    <div class="d-flex align-items-center w-50  justify-content-between mx-auto mt-4 pt-2">
                                        <h6 class="An_Dm_bold">Total Rate</h6>
                                        <h6 class="text--two " id="total_rate">{{ $total_review }}</h6>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mx-0 bg--eight py-4 px-5">
                    <div class="col-12 reviews_container">
                        <div id="review_title" class="row bg--four px-3 py-2 rounded shadow  mt-5 mx-0 mb-4">
                                <h5 class="mb-0 An_Dm_bold">All Reveiws</h5>
                        </div>
                        @forelse ($reviews as $review)
                            <div id="r{{ $review->id }}" class="row justify-content-center mx-0 bg--eight py-4">
                                <div class="col-12">
                                    <div class="row mx-1">
                                        <div class="media align-items-center">
                                            <img class="mr-3 rounded-circle shadow border" width="10%" height="80%" src="{{ asset('application/users/'.$review->user->image) }}" alt="image">
                                            <div class="media-body d-flex align-items-center">
                                                <h5 class="mt-0 mb-0 An_Dm_bold">{{ $review->user->name }} {{ $review->user->lastname }}</h5>
                                                @auth
                                                    @if(Auth::user()->id == $review->user_id)
                                                        <h6 class="mt-0 mb-0 ml-3 An_Dm_bold"><small><a href="#editModal" data-toggle="modal" class="text--two">Edit</a></small></h6>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mt-3">
                                            <div class=" d-flex  mr-3  ">
                                                @for ($a = 1; $a <=$review->rate; $a++)
                                                        <small><i class="fa fa-star text--one pr-1 "></i></small>
                                                @endfor
                                                @for($a = $review->rate; $a <5; $a++)
                                                    <small><i class="fa fa-star text--six pr-1 "></i></small>
                                                @endfor
                                            </div>
                                            <h6 class="text-muted mb-0"><small><span class="">{{ $review->created_at->diffForhumans() }}</span></small></h6>
                                        </div>
                                    </div>
                                    <div class="mx-1 mt-2">
                                        <h6 class="An_Dm_bold text-break">{{ $review->title }}</h6>
                                        <p class="text-muted text-justify text-break">{{ $review->body }}</p>
                                        <div class="d-flex">


                                            @if($review->recommendation == 'yes')
                                                <div class="text--two d-flex align-items-center">
                                                    <i class="fa fa-check-circle mr-1"></i>
                                                    <h5 class="mb-0 An_light"> Yes, <small> I recommend this article</small></h5>
                                                </div>
                                            @else
                                                <div class="text--two d-flex align-items-center ">
                                                    <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                                                    <h5 class="mb-0 An_light"> No, <small> I don't recommend this article</small></h5>
                                                </div>
                                            @endif
                                            @if(Auth::check())
                                                <div class="text--five ml-5 d-flex align-items-center">
                                                    <h6 class="mb-0 An_light "><small>Helpful?</small></h6>
                                                        @if($review->helpfuls->where('user_id',Auth::user()->id)->where("review_id",$review->id)->where("type","article")->first() != '')
                                                            @if($review->helpfuls->where('user_id',Auth::user()->id)->where('review_id',$review->id)->where('type','article')->first()->helpful == 'yes')
                                                                <a href="javascript:void(0)" data-type="yes" id="{{ $review->id }}" class=" p-0 m-0 nav-link bg--two small  text-white   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) }}</span>
                                                                <a href="javascript:void(0)" data-type="no" id="{{ $review->id }}" class=" help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) }}</span>
                                                            @else
                                                            <a href="javascript:void(0)" data-type="yes" id="{{ $review->id }}" class=" help_yes p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) }}</span>
                                                            <a href="javascript:void(0)" data-type="no" id="{{ $review->id }}" class="p-0 m-0 nav-link bg--two small  text-white rounded-left px-2 ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) }}</span>
                                                            @endif
                                                        @else
                                                            <a href="javascript:void(0)" data-type="yes" id="{{ $review->id }}" class=" help_yes p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) }}</span>
                                                            <a href="javascript:void(0)" data-type="no" id="{{ $review->id }}" class=" help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) }}</span>
                                                        @endif
                                                </div>
                                            @else
                                                <div class="text--five ml-5 d-flex align-items-center">
                                                    <h6 class="mb-0 An_light"><small>Helpful?</small></h6>
                                                    <a href="{{ route("allow.review",$article->id) }}" class=" p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) }}</span>
                                                    <a href="{{ route("allow.review",$article->id) }}" class="p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        @empty
                            <div class="row justify-content-center align-items-center mx-0 bg--eight py-1">
                                <div>No Reviews</div>
                             </div>
                        @endforelse
                    </div>
                    <button id="btn-more" data-review="{{ $review->id ?? 0}}" class="row w-100 bg--four px-3 py-2 rounded shadow justify-content-center   mb-5 mx-3 An_Dm_bold " style="cursor:pointer; border:none">
                        See more reviews
                        <i class="fa fa-angle-down  mt-1 ml-2"></i>
                    </button>
                </div>
        </div>
</section>


        {{-- start of edit  review modal --}}
        <div class="modal fade bg--opcity" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white text-center bg--two align-items-center py-2 ">
                        <h5 class=" mb-0 w-100 text-center An_Dm_bold " id="exampleModalLabel">Edit Reveiw</h5>
                        <i class=" text-white bg-danger rounded" style="width:25px; cursor:pointer" data-dismiss="modal">&times</i>
                    </div>

                    <div class="modal-body " >
                        <div class="row px-3 ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="mb-0 An_Dm_bold text-center">{{ ucwords($article->title) }}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p class="pl-1 text-muted mb-0 An_Dm_bold">Author :</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="pl-4 ml-2 text--two mb-0  small">{{ ucwords($article->author) }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p class="pl-1 text-muted mb-0 An_Dm_bold">Pages :</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="pl-4 ml-2 text--two mb-0 small">{{ $article->pages }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p class="pl-1 text-muted mb-0 An_Dm_bold">Views :</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="pl-4 ml-2 text--two mb-0 small">{{ $article->views }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                @if(Auth::check())        
                    @if(Auth::user()->reviews->where('reviewable_id',$article->id)->where("reviewable_type","App\Models\Article")->first() != "")
                        <form id="editReviewForm" method="POST" action="{{ route('update.ArticleReview',Auth::user()->reviews->where('reviewable_id',$article->id)->where('reviewable_type','App\Models\Article')->first()->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row mx-3 bg--four px-3 py-1 rounded shadow mt-3 mx-0 justify-content-center">
                                <div class="d-flex align-items-center px-4 justify-content-center">
                                    <h5 class=" mb-0 An_light"><small> Rating</small> <span class="text-danger">*</span></h5>
                                    <div class=" d-flex  mx-3">
                                        <label id="e_1" for="e_oneStar" class="e_star fa fa-star text--six pr-1 star--red red text-dark"></label><input type="radio" name="e_rate" id="e_oneStar" value="1" class="d-none">
                                        <label id="e_2" for="e_twoStar" class="e_star fa fa-star text--six pr-1 star--orange orange text-dark"></label> <input type="radio" name="e_rate" id="e_twoStar" value="2" class="d-none">
                                        <label id="e_3" for="e_threeStar" class="e_star fa fa-star text--six pr-1 star--yellow yellow text-dark"></label> <input type="radio" name="e_rate" id="e_threeStar" value="3" class="d-none">
                                        <label id="e_4" for="e_fourStar" class="e_star fa fa-star text--six pr-1 star--yellowgreen yellowgreen text-dark"></label> <input type="radio" name="e_rate" value="4" id="e_fourStar" class="d-none">
                                        <label id="e_5" for="e_fiveStar" class="e_star fa fa-star text--six pr-1 star--green green text-dark"></label><input type="radio" name="e_rate" id="e_fiveStar" value="5" class="d-none">
                                    </div>
                                    <h6 class=" mb-0 An_Dm_bold"><small class="text--seven e_star-error invisible text-danger">Click to rate</small></h6>
                                </div>
                            </div>
                            <div class="form-group small mt-5  px-3">
                                <label for="eb_title" class="An_trial">Reveiw Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm shadow rounded" name="title" value="{{ Auth::user()->reviews->where('reviewable_id',$article->id)->where('reviewable_type','App\Models\Article')->first()->title }}" id="eb_title" aria-describedby="emailHelp" placeholder="title here...">
                            </div>
                            <div class="form-group small  px-3">
                                <label class="An_trial" for="eb_body">Reveiw <span class="text-danger bolder">*</span></label>
                                <textarea class="form-control form-control-sm rounded shadow" placeholder="body text ...." id="eb_body" name="body" rows="4">{{ Auth::user()->reviews->where('reviewable_id',$article->id)->where('reviewable_type','App\Models\Article')->first()->body }}</textarea>
                            </div>
                            <div class="px-3 text--five d-flex align-items-center An_trial">

                                <label class="small An_trial pt-2">Would you recommend this article to others? <span class="text-danger">*</span></label>
                                @if(Auth::user()->reviews->where('reviewable_id',$article->id)->where('reviewable_type','App\Models\Article')->first()->recommendation == 'yes')
                                <label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small  text-white rounded shadow px-2 An_trial  ml-2 bg--two" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none" checked>
                                <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--four small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none">
                                @else
                                    <label id="e_lblYes" for="e_yes" class="p-0 m-0 nav-link  small rounded shadow px-2 An_trial  ml-2 bg--four" style="cursor:pointer">Yes </label><input type="radio" name="recommendation" id="e_yes" value="yes" class="d-none">
                                    <label id="e_lblNo" for="e_no" class="p-0 m-0 nav-link bg--two text-white small  text--two rounded shadow px-2 An_trial  ml-2" style="cursor:pointer;">No </label><input type="radio" name="recommendation" id="e_no" value="no" class="d-none" checked>
                                @endif
                            </div>
                            <div class="row ml-auto w-100 justify-content-end mr-5 mt-3">
                                <button type="submit" class="btn btn-primary bg--two border-0 btn-sm  py-1 px-3 An_Dm_bold mt-1" id="editbutton" style="width:120px;">Update Reveiw</button>
                            </div>
                        </form>
                    @else
                        <form id="editReviewForm"></form>
                    @endif
                @endif
                
                    </div>
                </div>
            </div>
        </div>
{{-- review model --}}

@endsection
@push('script')
    <script src="{{ asset('app/js/article/frontend/download-article.js') }}"></script>
    <script src="{{ asset('app/js/article/frontend/review-article.js') }}"></script>
    <script>
        $(()=>{
            @if(Session::has("download"))
                    $('#downloadbtn').click();
                @endif

                @if(Session::has("view"))
                    $('button#viewbtn').click();
                @endif
        })  
        </script>
@endpush