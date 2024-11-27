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
<section class="py-5" >
        <div class="container">
            <div class="row mx-3 bg-white rounded-top border-bottom py-4 shadow">
                <div class="col-3 text-center border-right">
                    <div class="profile-item position-relative">
                        <img id="profileimg" src="{{ asset('application/users/'.Auth::user()->image) }}" alt="profile picture" class=" rounded-circle img-fluid w-100  shadow" style="border-radius: 20px; height:180px !important; width:180px !important;">
                        <div class="profile-img pt-5 rounded-circle">
                            <ul class=" list-inline text-center pl-2 ">
                                <form action="{{ route('profile.pic') }}" method="POST" enctype="multipart/form-data" id="profilepicform">
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
                            @if(Auth::user()->phone != '')
                            <li class="list-inline " style="font-size: 14px;"><span class=""> Phone : <b id="liphone">{{ Auth::user()->phone }}</b></span></li>
                            @endif
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
                </div>
            </div>
            <div class="row mx-3 text-center bg-white border-top shadow">
                <div class="col-4 bg--two pt-2 hover">
                    <a href="{{ route('librarian.books',Auth::user()->id) }}" class="text-white">
                        <h4 class="an_bold">Books</h4>
                        <hr>
                        <p >{{ Auth::user()->uploadedbooks->where('approved','yes')->count() }}</p>
                    </a>
                </div>
                <div class="col-4 pt-2 bg--one hover">
                    <a href="{{ route('librarian.articles',Auth::user()->id) }}" class="text-white">
                        <h4 class="an_bold">Articles</h4>
                        <hr>
                        <p>{{ Auth::user()->UploadedArticles->where('approved','yes')->count() }}</p>
                    </a>
                </div>
                <div class="col-4 pt-2 bg-secondary hover">
                    <a href="{{ route('librarian.audiobooks',Auth::user()->id) }}" class="text-white ">
                        <h4 class="an_bold">Audios</h4>
                        <hr>
                        <p>{{ Auth::user()->UploadedAudioBooks->where('approved','yes')->count() }}</p>
                    </a>
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
    <script src="{{ asset('app/js/users/profile-backend.js') }}"></script>
@endpush
    