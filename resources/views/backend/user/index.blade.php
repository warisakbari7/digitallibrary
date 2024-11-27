@extends('layouts.master')
@section('style')
<style>
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
<div class="container-fluid">
  <div
    style="display:none ; transition: right 2s; z-index:3 ; color:white; font-family: monospace; border-radius: 5px; outline-offset: 2px; border:2px solid #55ACEE; outline:2px solid #55ACEE; width:300px; height:50px; background: #4285F4; position:absolute; right:-350px; top:150px"
    class=" toast-success  pt-3">
    <p class="" style="font-size: 25px; position:relative; left:23px; bottom:10px">Saved Successfully </p>
  </div>
  <!-- /.card-body -->


  <div class="row">
    <div class="col-12">
      <div class="card card-secondary">
        <div class="card-header bg-secondary">
          <h3 class="card-title">Users</h3>

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              
              <input type="text" name="table_search" class="form-control float-right" id="search" placeholder="Search">

              <div class="input-group-append">
                <button id="btn_search" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-hover table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr id="{{ $user->id }}">
                <td>
                  <div class=""><img src="{{ asset('application/users/'.$user->image) }}" alt="user"
                      class="rounded img-fluid" width="45" height="45" style="width:40px !important; height:45px !important;"></div>
                </td>
                <td>{{ ucfirst($user->name) }}</td>
                <td>{{ ucfirst($user->lastname) }}</td>
                <td>{{ $user->email }}</td>
                @if($user->is_active)
                <td>
                  <label id="{{ $user->id }}" class="switch">
                    <input onclick="toggle(this)" type="checkbox" checked>
                    <span class="slider round"></span>
                  </label>
                </td>
                @else
                <td>
                  <label id="{{ $user->id }}" class="switch">
                    <input onclick="toggle(this)" type="checkbox">
                    <span class="slider round"></span>
                  </label>
                </td>
                @endif
                <td><a href="{{ route('user.show',$user->id) }}"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
                  </a></td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer d-flex justify-content-center">
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
@push('script')
<script src="{{ asset('app/js/users/index-show.js') }}"></script>
@endpush