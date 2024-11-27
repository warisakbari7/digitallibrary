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
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    /* Hide default HTML checkbox */
    
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    /* The slider */
    
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }
    
    input:checked+.slider {
        background-color: #2196F3;
    }
    
    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }
    
    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }
    /* Rounded sliders */
    
    .slider.round {
        border-radius: 34px;
    }
    
    .slider.round:before {
        border-radius: 50%;
    }
</style>
@endsection
@section('content')
<div class="container">
     <a href="{{ url()->previous() }}"><i id="back" class=" mt-2 text-xl text-secondary fa fa-arrow-circle-left mb-3"></i></a> 
    <div class="row">
        <div class="col-12">
            <div class="card card-secondary ">
                <div class="card-header bg-secondary"></div>
                <div class="text-center">
                    <img style="width:300px; height:300px" class="profile-user-img img-circle img-fluid"
                        src="{{ asset('application/users/'.$user->image) }}" alt="">
                </div>
                <h1 class=" profile-username text-center">{{ ucwords($user->name) }} {{ ucwords($user->lastname) }}</h1>
                <p class="text-center text-muted">{{ ucwords($user->occupation) }}</p>
                <div class="card-body border">
                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12 p-3">
                            <label for="">Email</label> : <p>{{ $user->email }}</p>
                            <hr>
                            <label for="">Live in</label> : <p>{{ $user->live_in }}</p>
                            <hr>
                            <label for="">Status </label> :
                            @if($user->is_active)
                            <label data-id="{{ $user->id }}" class="switch">
                                <input onclick="toggle(this)" type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                            @else
                            <label data-id="{{ $user->id }}" class="switch">
                                <input onclick="toggle(this)" type="checkbox">
                                <span class="slider round"></span>
                            </label>
                            @endif
                        </div>
                        <div class=" col-lg-4 col-md-12 col-sm-12 p-3" style="border-left:1px solid grey">
                            <h5>Responsible For : </h5>
                                <form id="RemoveForm">
                                    <ul id="removelist" class="border shadow-sm rounded" style="overflow: auto; height:150px">
                                            @foreach ($user->catagory as $item)
                                            <div id="{{ $item->id }}" class="border border-top-0 border-left-0 border-right-0">
                                            <li class="mt-1 mr-2">{{ $item->ename }}</li>
                                            <input  style="margin-top:-15px ; margin-right:40px" class="float-right mb-0" type="checkbox" value="{{ $item->id }}" name="{{ $item->ename }}">
                                            </div>
                                            @endforeach
                                        </ul>
                                        <button class="ml-1 btn btn-sm btn-primary">Remove</button>
                                </form>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 p-3" style="border-left:1px solid grey">
                            
                            <div class="row">
                                <div class="col-12">
                                    <h5>Catagories : </h5>
                                    <form action="" id="AssignFrom">
                                        @csrf
                                        <div class="form-group">
                                            <select multiple name="catagory[]" id="AssignList" class="form-control" style="height:150px" required>
                                                @foreach ($catagory as $item)
                                                <option value="{{ $item->id }}">{{ $item->ename }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="ml-1 btn btn-sm btn-primary mt-4">Assign</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-4 "><a href="{{ route('librarian.books',$user->id) }}" class="d-flex text-white justify-content-between py-3 btn btn-secondary"><h5>Books</h5><span>{{ $user->uploadedbooks->count() }}</span></a></div>
                        <div class="col-4 "><a href="{{ route('librarian.articles',$user->id) }}" class="d-flex text-white justify-content-between py-3 btn btn-secondary"><h5>Articles</h5><span>{{ $user->UploadedArticles->count() }}</span></a></div>
                        <div class="col-4 "><a href="{{ route('librarian.audiobooks',$user->id) }}" class="d-flex text-white justify-content-between py-3 btn btn-secondary"><h5>Audios</h5><span>{{ $user->UploadedAudioBooks->count() }}</span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('app/js/librarian/show.js') }}"></script>
@endpush