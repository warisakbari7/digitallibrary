@extends('layouts.frontend')
@section('content')
<section  class="py-5" style="background-color: #e6e6e6 !important;">
        <div class="container bg-white h-100 pb-2" id="no_container">
            <div class="row p-3 mb-2  text-center text-white bg--two">
                <div class="col an_bold pt-1"><h3>Notifications</h3></div>
            </div>
                @forelse (Auth::user()->notifications()->limit(10)->get() as $notification)
                    <div class="row p-3 mb-2 shadow" style=" border-radius:90px;" id="{{ $notification->inc }}">
                        <div class="col-11">
                            @if($notification->data['type'] == 'article')
                                <a href="{{ $notification->data['url'] }}" class="dropdown-item rounded">
                                    <div class="row">
                                      <div class="col">
                                        <p class="text-sm">  <strong>{{ $notification->data['title'] }}</strong></p>
                                        <p class="text-sm text-wrap text-break"> you {{ $notification->data['type'] }} was approved successfully</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                                      </div>
                                    </div>
                                </a>
                            @else
                                <a href="{{ $notification->data['url'] }}" class="dropdown-item">
                                    <div class="row">
                                        <div class="col-2 p-3">
                                            <img src="{{ asset('application/books/cover/'.$notification->data['image']) }}" alt="User Avatar" class="w-50 h-100 rounded mr-3">
                                        </div>
                                        <div class="col-9 col-sm-6">
                                            <h4>{{ $notification->data['title'] }}</h4>
                                            <p class="text-sm text-wrap text-break">your {{ $notification->data['type'] }} was approved successfully</p>
                                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        </div>
                        <div class="col-1 d-flex justify-content-center align-items-center">
                                <a id="no_delete" data-id="{{ $notification->inc }}" href="javascript:void(0)" class="bg-danger rounded  text-center text-white text-decoration-none" style="width:25px; ">&times;</a>
                        </div>
                    </div>
                    @empty
                    <div class="row p-3 w-100 shadow pt-3">
                        <div class="col-12 text-center">No notifications</div>
                    </div>
                @endforelse
                @isset($notification)
                    <div class="row" id="btn_more_container">
                        <div class="col-12 text-center pt-4">
                            <div id="btn_more" data-id="{{ $notification->inc}}" class="btn btn-secondary bg--two w-25" style="border-radius:20px;" >More</div>
                        </div>
                    </div>
                @endisset
            </div>
</section>

@endsection
@push('script')
    <script src="{{ asset('app/js/notification/frontend/index.js') }}"></script>
@endpush