@extends('layouts.frontend')
@section('content')
<section class="bg--four pt-2 ">
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
    <section class=" shadow bg--eight  py-5">
        <div class="container">
            <div class="row mx-2">
                <div class="col-lg-3 col-md-3 col-12 col-12 ">
                        <div class=" shadow bg--four" style="border-radius: 15px; height:100vh">
                                <h4 class="text-center border-bottom pb-2 pt-2 An_bold">Audio Books</h4>
                                @forelse ($collections as $cat)
                                    @if($cat->audiobooks->count() > 0)
                                    <a href="{{ route('category.audiobook',$cat->id) }}" class="text--seven nav-link py-1 ">
                                            <div class=" category-item bg--four px-2 py-0 d-flex justify-content-between align-items-center rounded">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light font-weight-bolder">{{ ucwords($cat->ename) }}</h6>
                                                <small class="py-1 pb-0 mb-0 ">{{ App\Helpers\Number::ToShortForm(count($cat->audiobooks)) }}</small>
                                            </div>
                                    </a>
                                    @endif
                                @empty
                                    <a href="javascript:void(0)" class="text--seven nav-link p-0">
                                        <div class="bg--two text-white px-2 py-0 d-flex justify-content-between align-items-center rounded">
                                            <h6 class=" pt-1 pb-0 mb-0 An_light">No Data</h6>
                                        </div>
                                    </a>
                                @endforelse
                                
                        </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-12 mt-5 mt-lg-0 mt-md-0 ">
                    <div class="row" id="BookContainer d-flex justify-content-center align-items-center">
                            @forelse ($books as $book)
                            <a href="{{ route('show.audiobook',$book->id) }}" class="nav-link mx-2 ">
                                    <div class="row shadow rounded " style="background-color:  rgb(243, 243, 243);">
                                        <div class="col-lg-4 col-md-6 col-sm-6 px-0 shadow " >
                                            <img src="{{ asset('application/audiobooks/cover/'.$book->image) }}" class="rounded-left  w-100" style="height: 180px !important; width:100px !important;" alt="">
                                        </div>
                                        <div class="col-lg-8 col-md-6 col-sm-6 pl-4">
                                            <h6 class="text--two mb-0 mt-2 an_bold text-break"><b>
                                                    {{  (strlen($book->title) < 10) ?  ucwords($book->title)    :  substr(ucwords($book->title),0,10) .'...' }}
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
                                                    <img src="{{ asset('asset/images/stars.jpg') }}" alt="" style="width:100px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </a>
                            @empty
                                <div class="text-center an_bold w-100 p-5 shadow">
                                    Not Found
                                </div>
                        @endforelse
                        <div class="my-5 pl-5 w-100">
                                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                                    {{ $books->links() }}
                                </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
 @endsection
 @push('script')
     <script src="{{ asset('app/js/audiobook/frontend/list-book.js') }}"></script>
 @endpush