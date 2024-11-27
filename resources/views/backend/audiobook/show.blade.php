@extends('layouts.master')
@section('style')
    <style>
        #back:hover{
            color:#878f99 !important;
            transform: scale(1.5,1.5)
            }
        #back:active{
            transform: scale(1,1)
        }
    </style> 
@endsection
@section('content')
<section class="">
        <div class="container pb-4">
                <a href="{{ url()->previous() }}"><i id="back" class=" ml-5 text-xl text-secondary fa fa-arrow-circle-left mb-3 mt-4"></i></a> 

                <div class="row justify-content-center mx-0 mt-2  py-3">
                        <div id="book" class=" col-lg-9 col-md-10 col-sm-12 col-12 mt-5">
                            <div class="row"> 
                                <div class="col-lg-6 col-md-6 col-sm-6 " >
                                    <img id="lang" data-id="{{ $book->id }}" data-language="{{ $book->language }}" src="{{ asset('application/audiobooks/cover/'.$book->image) }}" style="height: 90%; width: 90%; border-radius:10px;" alt="{{ $book->title }}">
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
                                            <p class="text--two mb-0">{{ $book->downloads }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Ranking : </p>
                                        </div>
                                        <div class="col-8">
                                            <div class="bg-secondary" style="width:100px;" >
                                                    <div class="StarImg bg--one " style="width:{{ $averageRate*100/5 }}px; height:19px;">
                                                        <img src="{{ asset('asset/images/stars.jpg') }}" alt="StarsRanking" width="100" class="mb-3">
                                                    </div>
                                            </div>
                                                <small id="b_averageRate">{{ $averageRate }} </small>
                                                <small id="b_total_rate" > ({{ $total_review }})</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class=" pl-1 pt-lg-5 mt-lg-5 pt-4 ">
                                                <a href="#playerModal" data-toggle="modal" data-backdrop="static" data-keyboard="false"><button disabled id="listen_btn" style="width:120px" class=" btn  bg-warning px-4 py-1 text-white shadow mr-2 an_bold"> loading... </button></a>
                                                <a href="{{ asset('application/audiobooks/audio/'.$book->path) }}" download="download"><button style="width:120px"  class=" py-1 btn bg-success px-4 shadow an_bold">Download</button></a><br>
                                                <a href="javascript:void(0)" data-target="#bookmodal"/ data-toggle="modal"><button style="width:120px" class="mt-5 bg-primary border-primary btn px-4 py-1 shadow mr-2 an_bold">Edite</button></a>
                                                <a href="javascript:void(0)" data-target="#deleteModal" data-toggle="modal"><button style="width:120px" class="bg-danger border-danger mt-5 py-1 btn px-4 shadow an_bold">Delete</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if($book->language == 'dari')
                                @if($book->about_author != '')
                                <div id="b_aboutauthor_container" class="pl-1 text-right mt-5 py-3 w-100" style="border-top:1px solid lightgray;">
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
                                        <div id="b_aboutauthor_container" class="pl-1 mt-5 py-3 w-100" style="border-top:1px solid lightgray;">
                                            <h4 class="An_Dm_bold">About Author</h4>
                                            <small><p class="text-break">{{ $book->about_author }}</p></small>
                                        </div>
                                    @endif
                                    @if($book->about_book != '')
                                        <div id="b_aboutbook_container" class="pl-1 mt-5 py-3 w-100" style="border-top:1px solid lightgray;">
                                            <h4 class="An_Dm_bold">About Book</h4>
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
                                    <h4 class="An_Dm_bold">کتاب په اړه  </h4>
                                    <small><p class="text-break">{{ $book->about_book }}</p></small>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                </div>
             
                <div class="row justify-content-center mx-0  py-4 px-5">
                    <div class="col-12 px-5">
                        <div class="pl-1 mt-5">
                            <hr class="mb-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="An_Dm_bold">Rating Summary</h4>
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
                                            <div class="StarImg bg--one mr-3 " style="width:{{ $averageRate*100/5 }}px;height:19px;">
                                                <img src="{{ asset('asset/images/stars.jpg') }}" alt="StarsRanking" width="100" class="mb-3" >
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
                <div class="row justify-content-center mx-0  py-4 px-5">
                    <div class="col-12 reviews_container">
                        <div id="review_title" class="row bg--four px-3 py-2 rounded shadow  mt-5 mx-0 mb-4">
                                <h5 class="mb-0 An_Dm_bold">All Reveiws</h5>
                        </div>
                        @forelse ($reviews as $review)
                            <div id="r{{ $review->id }}" class="row justify-content-center mx-0  py-4">
                                <div class="col-12">
                                    <div class="row mx-1">
                                        <div class="media align-items-center">
                                            <img class="mr-3 rounded-circle shadow border" width="10%" height="80%" src="{{ asset('application/users/'.$review->user->image) }}" alt="image">
                                            <div class="media-body d-flex align-items-center">
                                                <h5 class="mt-0 mb-0 An_Dm_bold">{{ $review->user->name }} {{ $review->user->lastname }}</h5>
                                                <h6 class="mt-0 mb-0 ml-3 An_Dm_bold"><small><a href="#ConfirmDelete" data-toggle="collapse" class="text--two">Delete</a></small></h6>            
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
                                    <div id="ConfirmDelete" class="collapse mx-1 bg--four text-center rounded my-2">
                                        <h5 class="pt-2">Are you Sure to delete review?</h5>
                                        <div class="d-flex justify-content-center px-4 py-3">
                                            <button data-id="{{ $review->id }}" class="yes_delete mx-4 btn btn-danger"  style="margin-right:20px !important; width:120px;">Yes, sure</button>
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
                                            <div class="text--five ml-5 d-flex align-items-center">
                                                <h6 class="mb-0 An_light "><small>Helpful?</small></h6>
                                                <a href="javascript:void(0)" data-type="yes" id="{{ $review->id }}" class=" help_yes p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) }}</span>
                                                <a href="javascript:void(0)" data-type="no" id="{{ $review->id }}" class=" help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">{{ App\Helpers\Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        @empty
                            <div class="row justify-content-center align-items-center mx-0  py-1">
                                <div>No Reviews</div>
                             </div>
                        @endforelse
                    </div>
                    <button id="btn-more" data-review="{{ $review->id ?? 0}}" class="row w-100 bg--four px-3 py-2 rounded shadow justify-content-center   mb-5 mx-3 An_Dm_bold" style="cursor:pointer; border:none;">
                        See more reviews
                        <i class="fa fa-angle-down  mt-1 ml-2"></i>
                    </button>
                </div>
        </div>
</section>



   <!-- Book Modal -->
   <div class="modal fade  bg--opcity pr-0  " id="bookmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog  " style=" max-width: 800px !important;" role="document">
            <div class="modal-content p-0 border-0">
                <div class="modal-header text-center  bg--two align-items-center border-0 py-2 ">
                    <h4 class=" mb-0 text-white text-center w-100 an_bold pt-2" id="exampleModalLabel">Edit Book </h5>
                        <a href="javascript:void(0)" class="bg-danger rounded" style="width:25px;"><i class=" text-white" data-dismiss="modal">&times;</i></a>
                </div> 
                <div class="modal-body bookemodal bg--four rounded">
                    <form class="px-4" id="bookform" action="{{ route('book.update',$book->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b class="an_bold" id="lbl_b_name">Book Full Name </label> <span class="text-danger">*</span></b>
                            <input value="{{ $book->title }}" type="text" class="form-control  shadow rounded" placeholder="Book Full Name" id="b_name" name="b_name">
                            <span class="text-danger b_name ml-2"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_author">Author </label> <span class="text-danger">*</span></b>
                            <input value="{{ $book->author }}" type="text" class="form-control  shadow rounded" id="b_author" aria-describedby="emailHelp" name="b_author"  placeholder="Author Full Name">
                            <span class="text-danger b_author ml-2"></span>
                        </div>
                        <div class="form-group row  mx-0 ">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-lg-5 p-0">
                                <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_page">Number of Pages and Chapters </label><span class="text-danger">*</span></b>
                                <div class="row mx-0">
                                    <div class="bg-light p-2 rounded shadow d-flex w-100 ">
                                        <div class="d-flex align-items-center w-100 ">
    
                                            <input required value="{{ $book->pages }}" type="number" min="1" class="form-control form-control-sm  bg--four  " id="b_page" name="b_page" aria-describedby="emailHelp" placeholder="0 ... ">
                                            <label for="exampleInputEmail1" class="mb-0 mx-1 pr-3 " id="lbl_b_pages">Pages</label>
                                        </div>
                                        <div class="d-flex align-items-center w-100  ">
                                            <input required value="{{ $book->chapter }}" type="number" min="1" class="form-control form-control-sm  bg--four  " id="b_chapter" aria-describedby="emailHelp" name="b_chapter" placeholder="0 ...">
                                            <label for="exampleInputEmail1" class="mb-0 mx-1" id="lbl_b_chapter">Chapters</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="b_edition" name="b_edition" value="{{ $book->edition }}">

                            <div class="col-lg-4 col-md-3 col-sm-6 col-6 pl-0  pr-0 mt-3 mt-lg-0 mt-md-0 "> <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_publish">Year of publish </label><span class="text-danger">*</span></b>
    
                                <div class="bg-light p-2 rounded shadow w-100">
                                        <div class="d-flex align-items-center ">
                                            <input value="{{ $book->publish_date }}" required type="date" class="form-control form-control-sm  bg--four w-100 " name="b_publish" id="b_publish" aria-describedby="emailHelp" placeholder="0 ... ">
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_aboutauthor">About Author</b> <small>(optional)</small></label>
                            <textarea maxlength="1000" class="form-control form-control-sm rounded shadow" name="b_aboutauthor" placeholder="short biography in 1000 letter" id="b_aboutauthor" rows="6">{{ $book->about_author }}</textarea>
                            <div class="text-right pr-3 pt-2 text-muted">
                                <h6><span id="authorcounter">0</span>/1000</h6>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_aboutbook">About Book </b> <small>(optional)</small> </label>
                            <textarea maxlength="1000" class="form-control form-control-sm rounded shadow" name="b_aboutbook" placeholder="Explain book briefly in 1000 letter" id="b_aboutbook" rows="6">{{ $book->about_book }}</textarea>
                            <div class="text-right pr-3 pt-2 text-muted">
    
                                <h6><span id="bookcounter">0</span>/1000</h6>
    
                            </div>
                        </div>
    
                        <div class="alert alert-danger b_exist_error mt-2 invisible">This Book has already been registered</div>
                        <div class="row ml-auto w-100 justify-content-end mr-5 mt-3">
                            <button type="submit" class="btn btn-primary bg--two border-0 py-1 btn-sm " style="width:120px !important" id="b_lbl_finish">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->





 <!-- The Delete Modal -->
 <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header bg-danger">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="{{ route("audiobook.destroy",$book) }}" method="POST">
            @csrf
            @method('DELETE')
        <!-- Modal body -->
        <div class="modal-body">
          Are you Wanna delete this book?
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
          <input type="submit" class="btn btn-danger" value="Delete">
        </div>
        </form>
      </div>
    </div>
  </div>
  {{-- End of Modal --}}


  {{-- Start of player Modal --}}

  <div class="modal fade  bg--opcity pr-0" id="playerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog " style=" max-width: 1000px !important;" role="document">
        <div class="modal-content border-0 bg-transparent">
            <div class="row mx-0">
                <div class="col-lg-4  p-5 " style="border-top-left-radius: 15px!important; border-bottom-left-radius: 15px !important;">

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
    
                        <div class="pl-5">
                            <audio  id="player" controls="controls" controlsList="nodownload"class=" px-4" data-title="sample audio file" style="background-color:#f0f3f4;  width: 100% !important;border-radius: 25px;">
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

@endsection

@push('script')
<script src="{{ asset('app/js/audiobook/backend/review-book.js') }}"></script>
<script src="{{ asset('app/js/audiobook/backend/book-update.js') }}"></script>
<script src="{{ asset('app/js/audiobook/backend/player.js') }}"></script>
@endpush