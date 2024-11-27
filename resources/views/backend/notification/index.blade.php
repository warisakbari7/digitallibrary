@extends('layouts.master')
@section('content')
<div class="container" id="no_container">
    @forelse (Auth::user()->notifications()->limit(10)->get() as $notification)
        <div class="row p-3 shadow" id="{{ $notification->inc }}">
            <div class="col-11">
                @if($notification->data['type'] == 'message')
                    <a href="{{ $notification->data['url'] }}" class="dropdown-item">
                        <div class="media">
                          <div class="media-body">
                            <h4 class="dropdown-item-title text-break text-wrap">{{ $notification->data['email'] }}</h4>
                            <p class="text-sm">A new message from <strong>{{ $notification->data['name'] }}</strong></p>
                            <p class="text-sm text-wrap text-break">{{ $notification->data['message'] }}</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                          </div>
                        </div>
                    </a>
                @else
                    <a href="{{ $notification->data['url'] }}" class="dropdown-item">
                        <div class="media">
                            <img src="{{ asset('application/users/'.$notification->data['image']) }}" alt="User Avatar" class="img-size-50 img-circle mr-3 mt-3">
                            <div class="media-body">
                                <h4 class="dropdown-item-title text-break text-wrap">{{ $notification->data['title'] }}</h4>
                                <p class="text-sm">A new {{ $notification->data['type'] }} was uploaded by <strong>{{ $notification->data['owner'] }}</strong></p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
            <div class="col-1 d-flex justify-content-center align-items-center">
                    <a id="no_delete" data-id="{{ $notification->inc }}" href="javascript:void(0)" class="bg-danger rounded  text-center" style="width:25px; ">&times;</a>
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
                <div id="btn_more" data-id="{{ $notification->inc}}" class="btn btn-secondary w-25" style="border-radius:20px;" >More</div>
            </div>
        </div>
    @endisset
</div>

@endsection
@push('script')
    <script src="{{ asset('app/js/notification/backend/index.js') }}"></script>
@endpush