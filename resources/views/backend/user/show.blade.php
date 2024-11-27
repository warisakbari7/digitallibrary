@extends('layouts.master')
@section('style')
<style>
    label#profilelbl:hover
    {
        color: lightblue;
        cursor:pointer;
    }
    label#profilelbl
    {
         color:white
    }
    button#hover{
        
    }
    button#hover:hover
    {
        background :#ff8000 !important;
        cursor:pointer;
    }
</style>
@endsection
@section('content')
<section class="py-5" style="background-color: #e6e6e6 !important;">
        <div class="container">
            <div class="row mx-3 bg-white rounded-top border-bottom py-4 shadow">
                <div class="col-3 text-center border-right">
                    <div class="profile-item position-relative">
                        <img id="profileimg" src="{{ asset('application/users/'.$user->image) }}" alt="profile picture" class=" rounded-circle img-fluid w-100  shadow" style="border-radius: 20px; height:180px !important; width:180px !important;">
                    </div>
                </div>
                <div class="col-9 pl-lg-5">
                    <div class=" ">
                        <h2 class="An_trial">Name : <b id="liname">{{ $user->name }}</b> <b id="lilastname">{{ $user->lastname }}</b></h2>
                        <ul class="pl-0 text--six ">
                            <li class="list-inline  " style="font-size: 14px;">Occupation : <b id="lioccupation">{{ $user->occupation }}</b></li>
                            <li class="list-inline  " style="font-size: 14px;">Live in : <b id="lilive">{{ $user->live_in }}</b></li>
                            <li class="list-inline " style="font-size: 14px;"><span class=""> Email : <b>{{ $user->email }}</b></span></li>
                            <li class="list-inline " style="font-size: 14px;"><span class=""> Phone : <b id="liphone">{{ $user->phone }}</b></span></li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="row mx-3 bg-white border-top shadow">
                <div class="col-lg-3 col-md-3 col-sm-12 col-12  pt-4 " style="background-color: #e6e6e6 !important;">
                    <div class=" px-3 pt-2  ">
                        <ul class="nav nav-tabs">
                            <li class="nav-item w-100">
                                    <a href="#SavedBooks" class="category-item bg--two text-white p-0  active" data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Saved Books </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm(Auth::user()->SavedBooks->count()) }}</small></h6>
                                            </div>
                                    </a>
                            </li>
                            <li class="nav-item w-100">
                                    <a href="#DownloadedBooks" class=" category-item text--seven  p-0 " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Dawnloaded Books </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{  App\Helpers\Number::ToShortForm($downloadedbooks->count()) }}</small></h6>
                                            </div>
                                        </a>
                            </li>
                            <li class="nav-item w-100">
                                    <a href="#UploadedBooks" class="category-item  p-0 text--seven " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Uploaded Books </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm($uploadedbooks->count()) }}</small></h6>
                                            </div>
                                        </a>
                            </li>

                            <hr>
                            <hr>
                            <li class="nav-item w-100 border border-secondary border-left-0 border-right-0 border-bottom-0">
                                    <a href="#SavedArticles" class="category-item  p-0 text--seven " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Saved Articles </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm(count($savedarticles)) }}</small></h6>
                                            </div>
                                        </a>
                            </li>

                            <li class="nav-item w-100">
                                    <a href="#DownloadedArticles" class="category-item  p-0 text--seven " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Downloaded Articles </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm(count($downloadedarticles)) }}</small></h6>
                                            </div>
                                        </a>
                            </li>
                            <li class="nav-item w-100">
                                    <a href="#UploadedArticles" class="category-item  p-0 text--seven " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Uploaded Articles </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm(count($uploadedarticles)) }}</small></h6>
                                            </div>
                                        </a>
                            </li>
                            <hr>
                            <hr>
                            <li class="nav-item w-100 border border-secondary border-left-0 border-right-0 border-bottom-0">
                                    <a href="#SavedAudios" class="category-item  p-0 text--seven " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Saved Audios </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm(Auth::user()->SavedAudioBooks->count()) }}</small></h6>
                                            </div>
                                        </a>
                            </li>

                            <li class="nav-item w-100">
                                    <a href="#DownloadedAudios" class="category-item  p-0 text--seven " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Downloaded Audios </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{  App\Helpers\Number::ToShortForm($downloadedaudios->count()) }}</small></h6>
                                            </div>
                                    </a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-12  pt-4 pb-4 px-1 " style="overflow-y: scroll;  height: 100vh;">
                    <div class="tab-content mx-0">
                        <div id="SavedBooks" class="tab-pane active " >
                            <div class="row mx-0 pb-3">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex flex-wrap">
                                    @forelse($savedbooks as $book)
                                        <div class="product-item-wrap p-2">
                                            <div class="product-item position-relative">
                                                <img src="{{ asset('application/books/cover/'.$book->image) }}" alt="" class="product-item img-fluid w-100  shadow" style="border-radius: 20px;">
                                                <div class="product-img-hover pt-5 ml-2 w-100" style=" border-radius:20px;">
                                                    <ul class=" list-inline text-center pl-2 ">
                                                        <a href="{{ route('book.show',$book->id) }}"><button class="btn--outline--secondary px-4 py-1 an_bold" ><b>View</b></button></a>
                                                        <h5 class="mt-2 text-white text-left An_Dm_bold">{{ ucwords($book->title) }}</h6>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    <div class="text-center">No Saved Book</div>
                                    @endforelse              
                                </div>
                            </div>
                        </div>
                        <div id="DownloadedBooks" class="tab-pane fade" >
                            <div class="row mx-0 pb-3">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex flex-wrap">
                                        @forelse($downloadedbooks as $book)
                                            <div class="product-item-wrap p-2">
                                                <div class="product-item position-relative">
                                                    <img src="{{ asset('application/books/cover/'.$book->books->image) }}" alt="{{ $book->books->title }}" class="product-item img-fluid w-100  shadow" style="border-radius: 20px;">
                                                    <div class="product-img-hover pt-5 ml-2 w-100" style="border-radius:20px;">
                                                        <ul class=" list-inline text-center pl-2 ">
                                                            <a href="{{ route('book.show',$book->books->id) }}"><button class="btn--outline--secondary px-4 py-1 an_bold" ><b>View</b></button></a>
                                                            <h5 class="mt-2 text-white text-left An_Dm_bold">{{ ucwords($book->books->title) }}</h6>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center">No downloaded  books</div>
                                        @endforelse
                                </div>
                            </div>
                        </div>
                        <div id="UploadedBooks" class="tab-pane fade">
                            <div class="row mx-0 pb-3">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex flex-wrap">
                                            @forelse($uploadedbooks as $book)
                                                <div class="product-item-wrap p-2">
                                                    <div class="product-item position-relative">
                                                        <img src="{{ asset('application/books/cover/'.$book->image) }}" alt="{{ $book->title }}" class="product-item img-fluid w-100  shadow" style="border-radius: 20px;">
                                                        <div class="product-img-hover pt-5 ml-2 w-100" style="border-radius:20px;">
                                                            <ul class=" list-inline text-center pl-2 ">
                                                                <a href="{{ route('book.show',$book->id) }}"><button class="btn--outline--secondary px-4 py-1 an_bold" ><b>View</b></button></a>
                                                                <h5 class="mt-2 text-white text-left An_Dm_bold">{{ ucwords($book->title) }}</h6>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center">No uploaded books</div>
                                            @endforelse
                                </div>
                            </div>
                        </div>
                        <div id="SavedArticles" class="tab-pane fade">
                            <div class="row mx-0 pb-3">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            @forelse($savedarticles as $article)
                                                <div class="related-article bg--four p-1 rounded my-2  ">
                                                    <a href="{{ route('show.article',$article->id) }}" class="text--two nav-link p-0 text-center">
                                                        <h5 class="m-0 An_trial">{{ $article->title }}</h5>
                                                    </a>
                                                </div>
                                            @empty
                                            <div class="text-center">No Seved articles</div>
                                            @endforelse                    
                                        </div>
                            </div>
                        </div>

                        <div id="DownloadedArticles" class="tab-pane fade">
                            <div class="row mx-0 pb-3">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            @forelse($downloadedarticles as $article)
                                                <div class="related-article bg--four p-1 rounded my-2  ">
                                                    <a href="{{ route('show.article',$article->articles->id) }}" class="text--two nav-link p-0 text-center">
                                                        <h5 class="m-0 An_trial">{{ $article->articles->title }}</h5>
                                                    </a>
                                                </div>
                                            @empty
                                            <div class="text-center">No Downloaded articles</div>
                                            @endforelse                    
                                        </div>
                            </div>
                        </div>
                        <div id="UploadedArticles" class="tab-pane fade">
                            <div class="row mx-0 pb-3">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    @forelse($uploadedarticles as $article)
                                        <div class="related-article bg--four p-1 rounded my-2  ">
                                            <a href="{{ route('show.article',$article->id) }}" class="text--two nav-link p-0 text-center">
                                                <h5 class="m-0 An_trial">{{ $article->title }}</h5>
                                            </a>
                                        </div>
                                    @empty
                                    <div class="text-center">No uploaded articles</div>
                                    @endforelse                    
                                </div>
                            </div>
                        </div>
                        <div id="SavedAudios" class="tab-pane fade">
                            <div class="row mx-0 pb-3">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex flex-wrap">
                                            @forelse ($savedaudios as $book)
                                            <a href="{{ route('show.audiobook',$book->id) }}" class=" nav-link w-50 mx-0">
                                                    <div class="row shadow rounded bg--eight">
                                                        <div class="col-lg-4 col-md-6 col-sm-6 px-0 shadow " >
                                                            <img src="{{ asset('application/audiobooks/cover/'.$book->image) }}" class=" rounded  w-100" style="height: 180px !important; width:120px !important;" alt="">
                                                        </div>
                                                        <div class="col-lg-8 col-md-6 col-sm-6">
                                                            <h6 class="text--two mb-0 mt-2 an_bold text-break"><b>
                                                             
                                                                {{  (strlen($book->title) < 15) ?  ucwords($book->title)    :  substr(ucwords($book->title),0,15) .'...' }} 
                                                             
                                                            </b></h6>
                                                                
                                                            <div class="d-flex mt-1">
                                                                <p class="text-muted mb-0 An_trial">By</p>
                                                                <p class="pl-2 text--two mb-0 An_trial pb-0 text-break">{{ ucwords($book->author) }}</p>
                                                            </div>
                                                
                                                            <div class="d-flex ">
                                                                <p class=" text-muted mb-0 An_trial">Views:</p>
                                                                <p class=" pl-2 text--two mb-0 small">{{ App\Helpers\Number::ToShortForm($book->views) }}</p>
                                                            </div>
                                                            <div class="d-flex ">
                                                                <p class=" text-muted mb-0 An_trial">Dawnload:</p>
                                                                <p class="pl-2 text--two mb-0 small">{{ App\Helpers\Number::ToShortForm($book->downloads) }}</p>
                                                            </div>
                                                            <div class="bg-secondary mt-4" style="width:100px; height:19px;">
                                                                <div class="bg--one" style="width:{{ $book->rate * 100/5 }}px; height:19px ">
                                                                    <img src="{{ asset('asset/images/stars.jpg') }}" alt="" class="mb-2" style="width:100px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </a>
                                            @empty
                                                <div class="text-center">No Saved Audio Book</div>
                                            @endforelse
                                        </div>                    
                            </div>
                        </div>
                        <div id="DownloadedAudios" class="tab-pane fade">
                                                <div class="row mx-0 pb-3">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex flex-wrap">
                                                        @forelse ($downloadedaudios as $book)
                                                        <a href="{{ route('show.audiobook',$book->audios->id) }}" class="nav-link mx-2 ">
                                                                <div class="row shadow rounded bg--eight">
                                                                    <div class="col-lg-4 col-md-6 col-sm-6 px-0 shadow " >
                                                                        <img src="{{ asset('application/audiobooks/cover/'.$book->audios->image) }}" class=" rounded  w-100" style="height: 180px !important; width:100px !important;" alt="">
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-6 col-sm-6 pl-4">
                                                                        <h6 class="text--two mb-0 mt-2 an_bold text-break"><b>
                                                                         
                                                                            {{  (strlen($book->audios->title) < 15) ?  ucwords($book->audios->title)    :  substr(ucwords($book->audios->title),0,15) .'...' }} 
                                                                         
                                                                        </b></h6>
                                                                            
                                                                        <div class="d-flex mt-1">
                                                                            <p class="text-muted mb-0 An_trial">By</p>
                                                                            <p class="pl-2 text--two mb-0 An_trial pb-0 text-break">{{ ucwords($book->audios->author) }}</p>
                                                                        </div>
                                                            
                                                                        <div class="d-flex ">
                                                                            <p class=" text-muted mb-0 An_trial">Views:</p>
                                                                            <p class=" pl-2 text--two mb-0 small">{{ App\Helpers\Number::ToShortForm($book->audios->views) }}</p>
                                                                        </div>
                                                                        <div class="d-flex ">
                                                                            <p class=" text-muted mb-0 An_trial">Dawnload:</p>
                                                                            <p class="pl-2 text--two mb-0 small">{{ App\Helpers\Number::ToShortForm($book->audios->downloads) }}</p>
                                                                        </div>
                                                                        <div class="bg-secondary mt-4" style="width:100px; height:19px;">
                                                                            <div class="bg--one" style="width:{{ $book->audios->rate * 100/5 }}px; height:19px ">
                                                                                <img src="{{ asset('asset/images/stars.jpg') }}" alt="" style="width:100px;" class="mb-2">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </a>
                                                        @empty
                                                            <div class="text-center">No Downloaded Audio Book</div>
                                                        @endforelse
                                                    </div>
                                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection




