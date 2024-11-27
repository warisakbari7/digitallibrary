@extends('layouts.frontend')
@section('content')
<section class="bg--four pt-2">
        <div class="container">
             <div class="row w-100  ml-lg-5 mx-0 ">
                 <form action="{{ route('search.audiobook') }}" id="SearchForm" class="input-group mx-auto w-75 mb-2 d-flex align-items-center bg--four  ">
                     <div class="input-group mx-auto w-75 mb-2 d-flex align-items-center bg-white rounded shadow ">
                         <input type="text" id="q" name="q" value="{{ old('q') }}" class="form-control border-0 bg-white " placeholder="Search books here...">
                         <input type="submit" value="" id="submit_btn" class="input-group-addon bg-white  border-0  px-2"><label for="submit_btn" class="fa fa-search pr-2 pt-2" style="cursor:pointer"></label>
                     </div>
                 </form>
             </div>
         </div>
     </section>
<section class="bg--eight">
        <div class="container pb-4">
                <div class="row justify-content-center mx-0 mt-0 bg--eight py-3">
                        <div id="book_container" class=" col-lg-9 col-md-10 col-sm-12 col-12 mt-5">
                            <div class="row"> 
                                <div class="col-lg-6 col-md-6 col-sm-6 " >
                                    <img id="lang" data-id="{{ $book->id }}" data-language="{{ $book->language }}" src="{{ asset('application/audiobooks/cover/'.$book->image) }}" class=" image-fluid shadow" style="height: 90%; width: 90%; border-radius:10px;" alt="{{ $book->title }}">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <h3 id="title" class="An_Dm_bold">{{ $book->title }}</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0 ">Author : </p>
                                        </div>
                                        <div class="col-8">
                                            <p id="author" class=" text--two mb-0 ">{{ $book->author }}</p>
                                        </div>
                                    </div>
                                        
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0 ">Category : </p>
                                        </div>
                                        <div class="col-8">
                                            @if($book->language == 'dari')
                                                <p class=" text--two mb-0 ">{{ ucwords($book->category->dname) }}</p>
                                            @elseif($book->language == 'english')
                                                <p class=" text--two mb-0 ">{{ ucwords($book->category->ename) }}</p>
                                            @else
                                                <p class=" text--two mb-0 ">{{ ucwords($book->category->pname) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0">Uploaded : </p>
                                        </div>
                                        <div class="col-8">
                                                <p class="  text--two mb-0">{{ $book->created_at->format('d M Y') }} by  
                                                        @if(Auth::check())
                                                            @if(Auth::user()->id == $book->owner_id)
                                                                you 
                                                            @endif
                                                        @else
                                                            {{ $book->owner->name }} {{ $book->owner->lastname }}</p>
                                                            
                                                        @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0">Publish Date : </p>
                                        </div>
                                        <div class="col-8">
                                            <p id="publish" class=" text--two mb-0">{{ date_format(date_create($book->publish_date),'d M Y') }}   
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Pages : </p>
                                        </div>
                                        <div class="col-8 text-left">
                                            <p id="pages" class="text--two mb-0">{{ $book->pages }} Pages, {{ $book->chapter }} Chapters </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0">Edition : </p>
                                        </div>
                                        <div class="col-8">
                                            <p id="edition" class="text--two mb-0">{{ $book->edition }} Edition, {{ $book->publish_date }} </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class=" text-muted mb-0">Size : </p>
                                        </div>
                                        <div class="col-8">
                                            <p class="text--two mb-0">{{ $book->size }} </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Views : </p>
                                        </div>
                                        <div class="col-8">
                                            <p class=" text--two mb-0">{{ $book->views }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Downloads : </p>
                                        </div>
                                        <div class="col-8">
                                            <p class="text--two mb-0">{{ $book->downloads ?? 0 }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Ranking : </p>
                                        </div>
                                        <div class="col-8">
                                            <div class="StarImg bg-secondary" style="width:100px" >
                                                    <div class="bg--one" style="width:{{ $averageRate*100/5 }}px;">
                                                        <img src="{{ asset('asset/images/stars.jpg') }}" alt="StarsRanking" width="100" >
                                                    </div>
                                            </div>
                                                <small id="b_averageRate">{{ $averageRate }} </small>
                                                <small id="b_total_rate" > ({{ $total_review }})</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            @if(Auth::check())
                                                <div class="pt-lg-2 pb-2">
                                                    <a href="#playerModal"  data-toggle="modal" data-backdrop="static" data-keyboard="false"><button id="viewbtn" class="btn--outline--secondary btn-lg px-4 py-1 shadow mr-2 an_bold" style="width:120px"> <i></i> Loading... </button></a>
                                                    <a id="downloadbtn" href="{{ asset('application/audiobooks/audio/'.$book->path) }}" download ><button class="btn--outline--primary py-1 btn-lg px-4 shadow an_bold " style="width:120px"><i\> </i> Download</button></a><br>
                                                </div>
                                            @else
                                                <div class="pt-lg-2 pb-2">
                                                    <a href="{{ route('view.audiobook',$book->id) }}"><button class="btn--outline--secondary btn-lg px-4 py-1 shadow mr-2 an_bold" style="width:120px"><i> </i>Listen </button></a>
                                                    <a href="{{ route('download.audiobook',$book->id) }}" ><button class="btn--outline--primary py-1 btn-lg px-4 shadow an_bold" style="width:120px"    ><i> </i> Download</button></a><br>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 p-2 ml-2">
                                            <ul class="list-inline">
                                                @foreach ($socialShare as $key=>$value )
                                                    <li class="list-inline-item" style="border-radius:20px"> <a href="{{ $value }}"> <img class=" img-fluid rounded" src=" {{ asset("asset/images/{$key}.png") }}" alt="" width="45"> </a> </li>
                                                @endforeach                                                
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 p-2 ml-2 ">
                                            @if(Auth::check())
                                                @if($book->SavedBy()->where('user_id',Auth::user()->id)->where('saveable_id',$book->id)->count() > 0)
                                                    <a href="javascrip:void(0)" id="save_btn"><button class="w-75 bg-success text-white an_bold rounded" style="border:none">Unsave</button></a>                                        
                                                @else
                                                    <a href="javascript:void(0)" id="save_btn"><button class="w-75 bg--two text-white an_b  old rounded" style="border:none">Save</button></a>                                        
                                                @endif    
                                            @else
                                                <a href="{{ route('audiobook.IsUserLogin',$book->id) }}"><button class="w-75 bg--two text-white an_bold rounded" style="border:none">Save</button></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if($book->language == 'dari')
                                @if($book->about_author != '')
                                <div id="b_aboutauthor_container" class="pl-1 text-right py-3 w-100" style="border-top:1px solid lightgray;">
                                    <h4 class="An_Dm_bold">درباره نویسنده</h4>
                                    <small><p class="text-break">{{ $book->about_author }}</p></small>
                                </div>
                                @endif
                                @if($book->about_book != '')
                                    <div id="b_aboutbook_container" class="pl-1 mt-5 text-right py-3 w-100" style="border-top:1px solid lightgray;">
                                        <h4 class="An_Dm_bold">درباره کتاب </h4>
                                        <small><p class="text-break">{{ $book->about_book }}</p></small>
                                    </div>
                                @endif
                
                                @elseif ($book->language == 'english')
                                    @if($book->about_author != '')
                                        <div id="b_aboutauthor_container" class="pl-1 py-3 mt-5 w-100" style="border-top:1px solid lightgray;">
                                            <h4 class="An_Dm_bold">About Author</h4>
                                            <small><p class="text-break">{{ $book->about_author }}</p></small>
                                        </div>
                                    @endif
                                    @if($book->about_book != '')
                                        <div id="b_aboutbook_container" class="pl-1 mt-5 py-3 w-100" style="border-top:1px solid lightgray;">
                                            <h4 class="An_Dm_bold">About ‌Book</h4>
                                            <small><p class="text-break">{{ $book->about_book }} </p></small>
                                        </div>
                                    @endif
                                @else
                                    @if($book->about_author != '')
                                    <div id="b_aboutauthor_container" class="pl-1 text-right mt-5 py-3 w-100" style="border-top:1px solid lightgray;">
                                        <h4 class="An_Dm_bold">دلیکوال په اړه</h4>
                                        <small><p class="text-break">{{ $book->about_author }}</p></small>
                                    </div>
                                @endif
                                @if ($book->about_book != '')            
                                <div id="b_aboutbook_container" class="pl-1 mt-5 text-right py-3 w-100" style="border-top:1px solid lightgray;">
                                    <h4 class="An_Dm_bold">دکتاب په اړه  </h4>
                                    <small><p class="text-break">{{ $book->about_book }}</p></small>
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
                                            <div class="w-100">
                                                    <ul id="relatedBooks" class="cs-hiddend pb-4">
                                                        @foreach ($relatedBooks as $rel)
                                                        <li class="item-a">
                                                            <div class="box">
                                                                <div class="product-item position-relative">
                                                                    <img class="model" src="{{ asset("application/audiobooks/cover/".$rel->image) }}" alt="{{ $book->title }}">
                                                                    <div class="product-img-hover pt-5">
                                                                        <ul class=" list-inline text-center">
                                                                                <a href="{{ route('show.audiobook',$rel->id) }}"><button class="btn--outline--secondary px-4 pt-1 pb-0 an_bold " style="font-size: 18px;" ><b>View</b></button></a>
                                                                                <h5 class="mt-2 text-center text-white text-left an_bold">{{ ucwords($rel->title) }}</h6>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ul>
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
                                    @if($book->reviews->where('user_id',Auth::user()->id)->first() == '')
                                        <!-- Button trigger modal -->
                                            <button type="button" id="addbutton" class="btn btn-primary bg--two An_light border-0  ml-4 py-0" data-toggle="modal" data-target="#reviewModal">Add A Reveiw</button>
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
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-3 pt-2">
                                                                        <img src="{{ asset('application/audiobooks/cover/'.$book->image) }}" class=" rounded shadow img-fluid" alt="{{ $book->tilte }}">
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <h4 class="mb-0 An_Dm_bold ">{{ ucwords($book->title) }}</h4>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <p class="pl-1 text-muted mb-0 An_Dm_bold">Author :</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <p class="pl-4 ml-2 text--two mb-0  small">{{ ucwords($book->author) }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                    <p class="pl-1 text-muted mb-0 An_Dm_bold">Edition :</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <p class="pl-4 ml-2 text--two mb-0 small">{{ $book->edition }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <p class="pl-1 text-muted mb-0 An_Dm_bold">Pages :</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <p class="pl-4 ml-2 text--two mb-0 small">{{ $book->pages }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <p class="pl-1 text-muted mb-0 An_Dm_bold">Views :</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <p class="pl-4 ml-2 text--two mb-0 small">{{ $book->views }}</p>
                                                                            </div>
                                                                        </div>
                
                                                                    </div>
                                                                </div>
                                                                <form id="reviewForm" method="POST" action="{{ route('add.audioBookReview') }}">
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
                                                                        <label class="small An_trial pt-2">Would you recommend this book to others? <span class="text-danger">*</span></label>
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
                                        <button type="button" id="toastaddbutton" class=" btn btn-primary bg--two An_light border-0  ml-4 py-0">Add A Reveiw</button>

                                    @endif
                                @else
                                    <a href="{{ route('allow.audiobookreview',$book->id) }}" class="btn btn-primary bg--two An_light border-0  ml-4 py-0">Login to Add Review</a>
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
                        <div id="review_title" class="row bg--four px-3 py-2 rounded shadow  mt-5 mx-0 mb-4" >
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
                                                    <h5 class="mb-0 An_light"> Yes, <small> I recommend this book</small></h5>
                                                </div>
                                            @else
                                                <div class="text--two d-flex align-items-center ">
                                                    <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                                                    <h5 class="mb-0 An_light"> No, <small> I don't recommend this book</small></h5>
                                                </div>
                                            @endif
                                            @if(Auth::check())
                                                <div class="text--five ml-5 d-flex align-items-center">
                                                    <h6 class="mb-0 An_light "><small>Helpful?</small></h6>
                                                        @if($review->helpfuls->where('user_id',Auth::user()->id)->where("review_id",$review->id)->where("type","book")->first() != '')
                                                            @if($review->helpfuls->where('user_id',Auth::user()->id)->where('review_id',$review->id)->where('type','book')->first()->helpful == 'yes')
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
                                                    <a href="{{ route("allow.audiobookreview",$book->id) }}" class=" p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) }}</span>
                                                    <a href="{{ route("allow.audiobookreview",$book->id) }}" class="p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) }}</span>
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
                    <button id="btn-more" data-review="{{ $review->id ?? 0}}" class="row w-100 bg--four px-3 py-2 rounded shadow justify-content-center   mb-5 mx-3 An_Dm_bold" style="cursor:pointer; border:none">
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
                            <div class="col-lg-3 col-md-3 col-sm-3 col-3 pt-2">
                                <img src="{{ asset('application/audiobooks/cover/'.$book->image) }}" class=" rounded shadow img-fluid" alt="{{ $book->title }}">
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="mb-0 An_Dm_bold ">{{ ucwords($book->title) }}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p class="pl-1 text-muted mb-0 An_Dm_bold">Author :</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="pl-4 ml-2 text--two mb-0  small">{{ ucwords($book->author) }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                            <p class="pl-1 text-muted mb-0 An_Dm_bold">Edition :</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="pl-4 ml-2 text--two mb-0 small">{{ $book->edition }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p class="pl-1 text-muted mb-0 An_Dm_bold">Pages :</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="pl-4 ml-2 text--two mb-0 small">{{ $book->pages }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p class="pl-1 text-muted mb-0 An_Dm_bold">Views :</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="pl-4 ml-2 text--two mb-0 small">{{ $book->views }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                @if(Auth::check())
                    @if(Auth::user()->reviews->where('reviewable_id',$book->id)->where("reviewable_type","App\Models\AudioBook")->first() != "")
                        <form id="editReviewForm" method="POST" action="{{ route('update.AudioBookReview',Auth::user()->reviews->where('reviewable_id',$book->id)->where('reviewable_type','App\Models\AudioBook')->first()->id) }}">
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
                                <input type="text" class="form-control form-control-sm shadow rounded" name="title" value="{{ Auth::user()->reviews->where('reviewable_id',$book->id)->where('reviewable_type','App\Models\Book')->first()->title }}" id="eb_title" aria-describedby="emailHelp" placeholder="title here...">
                            </div>
                            <div class="form-group small  px-3">
                                <label class="An_trial" for="eb_body">Reveiw <span class="text-danger bolder">*</span></label>
                                <textarea class="form-control form-control-sm rounded shadow" placeholder="body text ...." id="eb_body" name="body" rows="4">{{ Auth::user()->reviews->where('reviewable_id',$book->id)->where('reviewable_type','App\Models\Book')->first()->body }}</textarea>
                            </div>
                            <div class="px-3 text--five d-flex align-items-center An_trial">

                                <label class="small An_trial pt-2">Would you recommend this book to others? <span class="text-danger">*</span></label>
                                @if(Auth::user()->reviews->where('reviewable_id',$book->id)->where('reviewable_type','App\Models\Book')->first()->recommendation == 'yes')
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
@auth
      {{-- Start of player Modal --}}

  <div class="modal fade  bg--opcity pr-0" id="playerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog " style=" max-width: 1000px !important;" role="document">
        <div class="modal-content border-0 bg-transparent">
            <div class="row mx-0">
                <div class="col-lg-4 bg--eight p-5 " style="border-top-left-radius: 15px!important; border-bottom-left-radius: 15px !important;">

                    <img src="{{ asset('application/audiobooks/cover/'.$book->image) }}" class=" rounded shadow  w-100" style="height: 318px;" alt="">

                    <h6 class=" text--two mb-0 mt-2"><b>{{ ucwords($book->title) }}</b></h6>
                    <div class="d-flex mt-1">
                        <p class="text-muted mb-0 ">By</p>
                        <p class="pl-2 text--two mb-0  ">{{ ucwords($book->author) }}</p>
                    </div>
                    <div class="d-flex ">
                        <p class=" text-muted mb-0">views:</p>
                        <p class=" pl-2 text--two mb-0">{{ $book->views }}</p>
                    </div>
                    <div class="d-flex ">
                        <p class=" text-muted mb-0">Dawnload:</p>
                        <p class="pl-2 text--two mb-0">{{ $book->downloads }}</p>
                    </div>

                    <div class="bg-secondary" style="width:100px;">
                        <div class="StarImg bg--one mr-3 " style="width:{{ $averageRate*100/5 }}px;height:19px;">
                            <img src="{{ asset('asset/images/stars.jpg') }}" alt="StarsRanking" width="100" class="mb-3" >
                        </div>
                    </div>
                    <small id="b_averageRate1">{{ $averageRate }} </small>
                    <small id="b_total_rate1" > ({{ $total_review }})</small>
                </div>

                <div class="col-lg-8  px-0 mb-0" style=" background: url({{ asset('asset/images/playerpicture.png') }}); background-size: cover; border-top-right-radius: 15px!important;
                border-bottom-right-radius: 15px !important;">
                        <span aria-hidden="true" class=" close text-white text-right pr-3 pt-2" data-dismiss="modal" style="cursor:pointer">×</span>

                    <div class=" h-100 d-flex flex-column justify-content-between">
                        <div class="text--six pt-5 pl-5 ">
                            <h4 class="pt-3">{{ ucwords($book->title) }}</h4>
                            <p>{{ ucwords($book->author) }}</p>
                        </div>
    
                        <div class="pl-5 mb-4">
                            <audio  id="player" controls="controls" controlsList="nodownload" style="background-color:#f0f3f4;  width: 100% !important;border-radius: 25px;">
                                <source src="{{ asset('application/audiobooks/audio/'.$book->path) }}" type="audio/mpeg">
                                  Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

  {{-- End of Player Modal --}}

@endauth

@endsection 
@push('script')
    <script src="{{ asset('app/js/audiobook/frontend/download-book.js') }}"></script>
    <script src="{{ asset('app/js/audiobook/frontend/review-book.js') }}"></script>
@auth
<script src="{{ asset('app/js/audiobook/frontend/player.js') }}"></script>    
<script src="{{ asset('asset/audiplay.js') }}"></script>    
@endauth
    <script>
            $(document).ready(()=>{
                $('#relatedBooks').lightSlider({
                        loop:true,
                        item:4,
                        onSliderLoad: () => {
                            $('#relatedBooks').removeClass('cs-hidden');
                    }
                });
                @if(Session::has("download"))
                    $('#downloadbtn').click();
                @endif
            });
        </script>
@endpush