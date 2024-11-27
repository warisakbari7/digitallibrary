@extends('layouts.frontend')
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
                        <img id="profileimg" src="{{ asset('application/users/'.Auth::user()->image) }}" alt="profile picture" class=" rounded-circle img-fluid w-100  shadow" style="border-radius: 20px; height:180px !important; width:180px !important;">
                        <div class="profile-img pt-5 rounded-circle">
                            <ul class=" list-inline text-center pl-2 ">
                                <form action="{{ route("profile.pic") }}" method="POST" enctype="multipart/form-data" id="profilepicform">
                                        @csrf
                                        @method('PUT')
                                        <label id="profilelbl" for="profilepic" class="an_trial">click to change</label>
                                        <input type="file" name="image" id="profilepic" class="invisible">
                                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-6 pl-lg-5">
                    <div>
                        <h2 class="An_trial">Name : <b id="liname">{{ Auth::user()->name }}</b> <b id="lilastname">{{ Auth::user()->lastname }}</b></h2>
                        <ul class="pl-0 text--six ">
                            <li class="list-inline  " style="font-size: 14px;">Occupation : <b id="lioccupation">{{ Auth::user()->occupation }}</b></li>
                            <li class="list-inline  " style="font-size: 14px;">Live in : <b id="lilive">{{ Auth::user()->live_in }}</b></li>
                            <li class="list-inline " style="font-size: 14px;"><span class=""> Email : <b>{{ Auth::user()->email }}</b></span></li>
                            <li class="list-inline " style="font-size: 14px;"><span class=""> Phone : <b id="liphone">{{ Auth::user()->phone }}</b></span></li>
                        </ul>
                        <div class="d-flex">
                            <!-- Button trigger modal -->
                            <form action="javascript:void(0)">
                            <button id="btnmodal" class="btn btn-sm mr-4 bg-primary text-sm text-white" style="border:1px solid white; border-radius: 80px !important; width:120px;">Edit profile</button>
                            </form>
                            <form action="{{ route("logout") }}" method="POST">
                                @csrf
                                <button id="hover" type="submit" class="btn btn-sm mr-4 text-sm text-white" style="border:1px solid white; background:#FF9933; border-radius: 80px !important; width:120px;">Log Out</button>
                            </form>
                            <!-- Modal -->
                            <div class="modal fade  bg--opcity pr-0  " id="modelprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog  " style=" max-width: 300px !important;" role="document">
                                    <div class="modal-content p-0 border-0">
                                        <div class="modal-header text-center  bg--two align-items-center border-0 py-2 ">
                                            <h4 class=" mb-0 text-white text-center w-100 an_bold pt-2" id="exampleModalLabel">Edit Profile </h5>
                                            <a href=""><i class="fa fa-window-close text-white" data-dismiss="modal"></i></a>
                                        </div>
                                        <div class="modal-body rounded">
                                            <div class="px-3">
                                                <form id="updateform" action="{{ route('update.user',Auth::user()->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group mb-1">
                                                        <label for="name" class="mb-0 pb-0 An_light">First Name <small><span class="text-danger">*</span></small></label>
                                                        <input required type="text" name="name" class="form-control form-control-sm mt-0 pt-0  border-0" style="background-color: #e6e6e6 !important;" id="name" aria-describedby="emailHelp" placeholder="Ex: your name ">
                                                    </div>
                                                    <div class="form-group mb-1">
                                                        <label for="lastname" class="mb-0 pb-0 An_light">Last Name <small><span class="text-danger">*</span></small></label>
                                                        <input required type="text" name="lastname" class="form-control form-control-sm mt-0 pt-0   border-0" style="background-color: #e6e6e6 !important;" id="lastname" aria-describedby="emailHelp" placeholder="Ex: last name ">
                                                    </div>
                                                    <div class="form-group mb-1 ">
                                                        <label for="phone" class="mb-0 pb-0 An_light">Phone No. <small><span class="text-danger">*</span></small></label>
                                                        <input required type="tel" name="phone" class="form-control form-control-sm mt-0 pt-0  border-0" style="background-color: #e6e6e6 !important;" id="phone" aria-describedby="emailHelp" placeholder="Phone">
                                                    </div>
                                                    <div class="form-group mb-1 ">
                                                        <label for="occupation" class="mb-0 pb-0 An_light">Occupation <small><span class="text-danger">*</span></small></label>
                                                        <input required type="text" name="occupation" class="form-control form-control-sm mt-0 pt-0 border-0" style="background-color: #e6e6e6 !important;" id="occupation" aria-describedby="emailHelp" placeholder="occupation">
                                                    </div>
                                                    <div class="form-group mb-1">
                                                        <label for="live" class="mb-0 pb-0 An_light">Live in <small><span class="text-danger">*</span></small></label>
                                                        <input required type="text" name="live_in" class="form-control form-control-sm mt-0 pt-0  border-0" style="background-color: #e6e6e6 !important;" id="live" aria-describedby="emailHelp" placeholder="Web Developer">
                                                    </div>

                                                    <div class="d-flex justify-content-between mt-3">
                                                        <div>
                                                            <button type="submit" class="btn btn-sm ml-auto btn-primary bg--two border-0 px-3 An_light">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="d-flex justify-content-end">
                     <a class="btn btn-primary" href="#usermodal" data-toggle="modal">Change Password</a>
                    </div>

                    <nav class=" main-header navbar navbar-expand navbar-white navbar-light">
                            <ul class=" navbar-nav ml-auto">
                                    <li  class=" nav-item dropdown">
                                            <a class="nav-link" data-toggle="dropdown" href="#" id="notificationBox">

                                              @if(count(Auth::user()->unReadNotifications) > 0)
                                                <small><span class="badge badge-danger navbar-badge" id="badge">{{ count(Auth::user()->unReadNotifications) }}</span></small>
                                              @else
                                                <small><span class="badge badge-danger navbar-badge invisible" style="margin-top:20px;" id="badge">0</span></small>
                                              @endif
                                              <i class="fa fa-bell" style="position:relative; left:-7px; top:8px" ></i>                                            

                                            </a>
                                            <div id="notificationContainer" style="width:300px;" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                              
                                              @forelse (Auth::user()->unreadNotifications as $notification)
                                                @if($notification->data['type'] == 'article')
                                                <a href="{{ $notification->data['url'] }}" class="dropdown-item">
                                                    <div class="row">
                                                    <div class="col-12">
                                                        <h6 class="dropdown-item-title my-0 text-break text-wrap">{{ $notification->data['title'] }}</h6>
                                                        <p class="small text-wrap text-break">your {{ $notification->data['type'] }} was approved successfully</p>
                                                        <p class="small text-muted text-wrap my-0 text-break"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                                                    </div>
                                                    </div>
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                @else
                                                <a href="{{$notification->data['url']}}" class="dropdown-item">
                                                  <div class="row">
                                                      <div class="col-3 d-flex align-items-center justify-content-center">
                                                          <img src="{{ asset('application/books/cover/'.$notification->data['image']) }}" alt="User Avatar" style="width:55px;" class="rounded">
                                                      </div>
                                                    <div class="col-9">

                                                      <h6 class="dropdown-item-title my-0 text-break text-wrap">{{$notification->data['title']}}</h6>
                                                      <p class="small text-wrap text-break">your {{ $notification->data['type'] }} was approved successfully</p>
                                                      <p class="small text-muted text-wrap my-0 text-break"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                                                    </div>
                                                  </div>
                                                </a>
                                              <div class="dropdown-divider"></div>
                                                @endif
                                              @empty
                                              @forelse (Auth::user()->notifications as $notification)
                                                @break($loop->iteration == 5)
                                                @if($notification->data['type'] == 'article')
                                                <a href="{{ $notification->data['url'] }}" class="dropdown-item">
                                                    <div class="row">
                                                    <div class="col-12">
                                                        <h6 class="dropdown-item-title my-0 text-break text-wrap">{{ $notification->data['title'] }}</h6>
                                                        <p class="small text-wrap text-break">your {{ $notification->data['type'] }} was approved successfully</p>
                                                        <p class="small text-muted text-wrap my-0 text-break"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                                                    </div>
                                                    </div>
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                @else
                                                <a href="{{$notification->data['url']}}" class="dropdown-item">
                                                  <div class="row">
                                                      <div class="col-3 d-flex align-items-center justify-content-center">
                                                          <img src="{{ asset('application/books/cover/'.$notification->data['image']) }}" alt="User Avatar" style="width:55px;" class="rounded">
                                                      </div>
                                                    <div class="col-9">
 
                                                      <h6 class="dropdown-item-title my-0 text-break text-wrap">{{$notification->data['title']}}</h6>
                                                      <p class="small text-wrap text-break">your {{ $notification->data['type'] }} was approved successfully</p>
                                                      <p class="small text-muted text-wrap my-0 text-break"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                                                    </div>
                                                  </div>
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                @endif
                                              @empty
                                                <div id="no_notification" class="dropdown-item text-center">
                                                  No new notification
                                                </div>
                                              @endforelse
                                              @endforelse
                                    
                                              <a href="{{ route('user.notification') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
                                            </div>
                                          </li>
                            </ul>
                    </nav>
                </div>
            </div>
            <div class="row mx-3 bg-white border-top shadow">
                <div class="col-lg-3 col-md-3 col-sm-12 col-12  pt-4 " style="background-color: #e6e6e6 !important;">
                    <div class=" px-3 pt-2  ">
                        <ul class="nav nav-tabs">
                            <li class="nav-item w-100 mt-1">
                                    <a href="#SavedBooks" class="category-item bg--two text-white p-0  active" data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Saved Books </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm(Auth::user()->SavedBooks->count()) }}</small></h6>
                                            </div>
                                    </a>
                            </li>
                            <li class="nav-item w-100 mt-1">
                                    <a href="#DownloadedBooks" class=" category-item text--seven  p-0 " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Dawnloaded Books </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{  App\Helpers\Number::ToShortForm($downloadedbooks->count()) }}</small></h6>
                                            </div>
                                        </a>
                            </li>
                            <li class="nav-item w-100 mt-1">
                                    <a href="#UploadedBooks" class="category-item  p-0 text--seven " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Uploaded Books </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm($uploadedbooks->count()) }}</small></h6>
                                            </div>
                                        </a>
                            </li>

                            <hr>
                            <hr>
                            <li class="nav-item w-100 border border-secondary border-left-0 border-right-0 border-bottom-0 mt-1">
                                    <a href="#SavedArticles" class="category-item  p-0 text--seven " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Saved Articles </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm(count($savedarticles)) }}</small></h6>
                                            </div>
                                        </a>
                            </li>

                            <li class="nav-item w-100 mt-1">
                                    <a href="#DownloadedArticles" class="category-item  p-0 text--seven " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Downloaded Articles </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm(count($downloadedarticles)) }}</small></h6>
                                            </div>
                                        </a>
                            </li>
                            <li class="nav-item w-100 mt-1">
                                    <a href="#UploadedArticles" class="category-item  p-0 text--seven " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Uploaded Articles </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm(count($uploadedarticles)) }}</small></h6>
                                            </div>
                                        </a>
                            </li>
                            <hr>
                            <hr>
                            <li class="nav-item w-100 border border-secondary border-left-0 border-right-0 border-bottom-0 mt-1">
                                    <a href="#SavedAudios" class="category-item  p-0 text--seven " data-toggle="tab">
                                            <div class="text-break px-2 py-0 d-flex justify-content-between align-items-center rounded" style="background-color:inherit">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light">Saved Audios </h6>
                                                <h6 class="py-1 pb-0 mb-0"><small>{{ App\Helpers\Number::ToShortForm(Auth::user()->SavedAudioBooks->count()) }}</small></h6>
                                            </div>
                                        </a>
                            </li>

                            <li class="nav-item w-100 mt-1">
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
                <div class="col-lg-9 col-md-9 col-sm-12 col-12 mx-0  pt-4 pb-4 px-0 " style="overflow-y: scroll;  height: 100vh;">
                    <div class="tab-content px-0 mx-0">
                        <div id="SavedBooks" class="tab-pane active" >
                            <div class="row mx-0 pb-3">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex flex-wrap">
                                    @forelse($savedbooks as $book)
                                        <div  class="product-item-wrap p-2">
                                            <div class="product-item position-relative">
                                                <img src="{{ asset('application/books/cover/'.$book->image) }}" alt="" class="product-item img-fluid w-100  shadow" style="border-radius: 20px;">
                                                <div class="product-img-hover pt-5 d-flex flex-column justify-content-between" style=" border-radius:20px;">
                                                    <ul class=" list-inline text-center ">
                                                        <a href="{{ route('show.book',$book->id) }}"><button class="btn--outline--secondary px-4 py-1 an_bold" ><b>View</b></button></a>
                                                        <h5 class="mt-2 text-white text-wrap text-break text-center An_Dm_bold">{{ ucwords($book->title) }}</h6>
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
                                                    <div class="product-img-hover pt-5" style="border-radius:20px;">
                                                        <ul class=" list-inline text-center">
                                                            <a href="{{ route('show.book',$book->books->id) }}"><button class="btn--outline--secondary px-4 py-1 an_bold" ><b>View</b></button></a>
                                                            <h5 class="mt-2 text-white text-wrap text-break text-center An_Dm_bold">{{ ucwords($book->books->title) }}</h6>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center">You have not downloaded any book</div>
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
                                                        <div class="product-img-hover pt-5" style="border-radius:20px;">
                                                            <ul class=" list-inline text-center ">
                                                                <a href="{{ route('show.book',$book->id) }}"><button class="btn--outline--secondary px-4 py-1 an_bold" ><b>View</b></button></a>
                                                                <h5 class="mt-2 text-white text-center text-break text-wrap An_Dm_bold">{{ ucwords($book->title) }}</h6>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center">You have not uploaded any book</div>
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
                                            <div class="text-center">You have not saved any article</div>
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
                                            <div class="text-center">You have not downloaded any article</div>
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
                                    <div class="text-center">You have not uploaded any article</div>
                                    @endforelse                    
                                </div>
                            </div>
                        </div>
                        <div id="SavedAudios" class="tab-pane fade ">
                            <div class="row mx-0 pb-3">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex flex-wrap">
                                            @forelse ($savedaudios as $book)
                                            <div class="col-lg-6 col-md-12 col-sm-6 col-12 mt-4 mt-lg-3 d-flex flex-wrap  ">
                                                    <a href="{{ route('show.audiobook',$book->id) }}" class="w-100 related-article nav-link m-2" style="width:45%">
                                                            <div class="row shadow rounded " style="background-color:  rgb(243, 243, 243);">
                                                                <div class="col-lg-4 col-md-3 col-sm-12 col-12 px-0 shadow " >
                                                                    <img src="{{ asset('application/audiobooks/cover/'.$book->image) }}" class=" rounded  w-100" style="height: 180px !important; widthd:130px !important;" alt="">
                                                                </div>
                                                                <div class="col-lg-8 col-md-6 col-sm-12 col-12 pl-4">
                                                                    <h6 class="text--two mb-0 mt-2 an_bold text-break"><b>
                                                                        @if(strlen($book->title) > 20)
                                                                            {{ ucwords(substr($book->title,0,20)) . '...'}}
                                                                        @else
                                                                            {{ ucwords($book->title) }}
                                                                        @endif
                                                                    </b></h6>
                                                                        
                                                                    <div class="d-flex mt-1">
                                                                        <p class="text-muted mb-0 An_trial">By</p>
                                                                        <p class="pl-2 text--two mb-0 An_trial pb-0 text-break">
                                                                            @if(strlen($book->author) > 20)
                                                                                {{ ucwords(substr($book->author,0,20)) . '...'}}
                                                                            @else
                                                                                {{ ucwords($book->author) }}
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                        
                                                                    <div class="d-flex ">
                                                                        <p class=" text-muted mb-0 An_trial">Views:</p>
                                                                        <p class=" pl-2 text--two mb-0 small">{{ App\Helpers\Number::ToShortForm($book->views) }}</p>
                                                                    </div>
                                                                    <div class="d-flex ">
                                                                        <p class=" text-muted mb-0 An_trial">Dawnload:</p>
                                                                        <p class="pl-2 text--two mb-0 small">{{ App\Helpers\Number::ToShortForm($book->downloads) }}</p>
                                                                    </div>
                                                                    <div class="bg-secondary mt-4 mb-2" style="width:100px; height:19px;">
                                                                        <div class="bg--one" style="width:{{ $book->rate * 100/5 }}px; height:19px ">
                                                                            <img src="{{ asset('asset/images/stars.jpg') }}" alt="" style="width:100px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </a>
                                            </div>
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
                                                        <div class="col-lg-6 col-md-12 col-sm-6 col-12 mt-4 mt-lg-3 d-flex flex-wrap  ">
                                                                <a href="{{ route('show.audiobook',$book->audios->id) }}" class="w-100 related-article nav-link m-2" style="width:45%">
                                                                        <div class="row shadow rounded " style="background-color:  rgb(243, 243, 243);">
                                                                            <div class="col-lg-4 col-md-3 col-sm-12 col-12 px-0 shadow " >
                                                                                <img src="{{ asset('application/audiobooks/cover/'.$book->audios->image) }}" class=" rounded  w-100" style="height: 180px !important; widthd:130px !important;" alt="">
                                                                            </div>
                                                                            <div class="col-lg-8 col-md-6 col-sm-12 col-12 pl-4">
                                                                                <h6 class="text--two mb-0 mt-2 an_bold text-break"><b>
                                                                                    @if(strlen($book->audios->title) > 20)
                                                                                        {{ ucwords(substr($book->audios->title,0,20)) . '...'}}
                                                                                    @else
                                                                                        {{ ucwords($book->audios->title) }}
                                                                                    @endif
                                                                                </b></h6>
                                                                                    
                                                                                <div class="d-flex mt-1">
                                                                                    <p class="text-muted mb-0 An_trial">By</p>
                                                                                    <p class="pl-2 text--two mb-0 An_trial pb-0 text-break">
                                                                                        @if(strlen($book->audios->author) > 20)
                                                                                            {{ ucwords(substr($book->audios->author,0,20)) . '...'}}
                                                                                        @else
                                                                                            {{ ucwords($book->audios->author) }}
                                                                                        @endif
                                                                                    </p>
                                                                                </div>
                                                                    
                                                                                <div class="d-flex ">
                                                                                    <p class=" text-muted mb-0 An_trial">Views:</p>
                                                                                    <p class=" pl-2 text--two mb-0 small">{{ App\Helpers\Number::ToShortForm($book->audios->views) }}</p>
                                                                                </div>
                                                                                <div class="d-flex ">
                                                                                    <p class=" text-muted mb-0 An_trial">Dawnload:</p>
                                                                                    <p class="pl-2 text--two mb-0 small">{{ App\Helpers\Number::ToShortForm($book->audios->downloads) }}</p>
                                                                                </div>
                                                                                <div class="bg-secondary mt-4 mb-2" style="width:100px; height:19px;">
                                                                                    <div class="bg--one" style="width:{{ $book->audios->rate * 100/5 }}px; height:19px ">
                                                                                        <img src="{{ asset('asset/images/stars.jpg') }}" alt="" style="width:100px;">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </a>
                                                        </div>
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

      <!-- User Modal -->
      <div class="modal fade  bg--opcity pr-0  " id="usermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog  " style=" max-width: 800px !important;" role="document">
            <div class="modal-content p-0 border-0">
                <div class="modal-header text-center  bg--two align-items-center border-0 py-2 ">
                    <h4 class=" mb-0 text-white text-center w-100 an_bold pt-2" id="exampleModalLabel">Change Password </h5>
                        <a href="javascript:void(0)" data-dismiss="modal" class="bg-danger rounded" style="width:25px;"><i class=" text-white" >&times;</i></a>
                </div> 
                <div class="modal-body bookmodal bg--four rounded">
                    <form class="px-4" id="userform" action="{{ route('user.changepass') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b class="an_bold">Old Password</label><span class="text-danger">*</span></b>
                            <input type="password" class="form-control  shadow rounded" placeholder="old password" name="old_password">
                            <span class="text-danger b_name ml-2"></span>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><b  class="an_bold">New Password</label><span class="text-danger">*</span></b>
                            <input type="password" class="form-control  shadow rounded" aria-describedby="emailHelp" name="password"  placeholder="new password">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><b  class="an_bold">Confirm Password</label><span class="text-danger">*</span></b>
                            <input type="password" class="form-control  shadow rounded"  aria-describedby="emailHelp" name="password_confirmation"  placeholder="confirm password">
                        </div>            
                        <div class="row ml-auto w-100 justify-content-end mr-5 mt-3">
                            <button type="submit" class="btn btn-primary bg--two border-0  px-5 py-1 btn-sm" id="changebtn">Change</button>
                        </div>
                        <div class="alert alert-danger invisible mt-2" id="errormsg"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->



          <!-- User success Modal -->
          <div class="modal fade  bg--opcity pr-0  " id="msgmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog  " style=" max-width: 800px !important;" role="document">
                <div class="modal-content p-0 border-0">
                    <div class="modal-header text-center  bg-success align-items-center border-0 py-2 ">
                        <h4 class=" mb-0 text-white text-center w-100 an_bold pt-2" id="exampleModalLabel">Confirmation </h5>
                            <a href="javascript:void(0)" data-dismiss="modal" class="bg-danger rounded" style="width:25px;"><i class=" text-white" >&times;</i></a>
                    </div> 
                    <div class="modal-body bookmodal bg--four rounded text-center">
                        <h4>Your password changed successfully</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
@endsection
@push('script')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('app/js/users/profile.js') }}"></script>
    <script>
        Echo.private("approve.event.{{ Auth::user()->id }}").listen('.approve.event',e=>{
            var notification;
            if(e.type == 'book')
            {
                 notification =`
                    <a href="${e.url}" class="dropdown-item">
                        <div class="row">
                            <div class="col-3 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('application/books/cover/${e.image}') }}" alt="User Avatar" style="width:55px;" class="rounded">
                            </div>
                        <div class="col-9">
                            <div class="d-flex justify-content-end">
                                <small class="small"><i class="fa fa-sm fa-circle  text-primary"></i></small>
                            </div>
                            <h6 class="dropdown-item-title my-0 text-break text-wrap">${e.title}</h6>
                            <p class="small text-wrap text-break">your ${e.type} was approved successfully</p>
                            <p class="small text-muted text-wrap my-0 text-break"><i class="far fa-clock mr-1"></i>just now</p>
                        </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>`;
                }
                else
                {
                    
                     notification =`
                    <a href="${e.url}" class="dropdown-item">
                        <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <small class="small"><i class="fa fa-sm fa-circle  text-primary"></i></small>
                            </div>
                            <h6 class="dropdown-item-title my-0 text-break text-wrap">${e.title}</h6>
                            <p class="small text-wrap text-break">your ${e.type} was approved successfully</p>
                            <p class="small text-muted text-wrap my-0 text-break"><i class="far fa-clock mr-1"></i>just now</p>
                        </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>`;
                }
            $('#badge').removeClass('invisible');
            let x = $('#badge').text();
            x++;
            $('#badge').text(x);
            x = 0;
            $('#notificationContainer').prepend(notification);
            $('#no_notification').remove();
        });



        $('#notificationBox').click(e=>{
            let token = $("meta[name=csrf-token]").attr('content')
            let value = $('#badge').text();
            if(value > 0 )
            {
                $.post("{{ route('notification.mark') }}",{_token:token},
                    function (data) {
                    $('#badge').addClass('invisible').text('0');
                    }
                );
            }
        })

    </script>
@endpush
    