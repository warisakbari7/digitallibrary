@extends('layouts.frontend')
@section('content')
<section class="bg--four pt-2 ">
   <div class="container">
        <div class="row w-100  ml-lg-5 mx-0 ">
            <form action="{{ route('search.book') }}" id="SearchForm" class="input-group mx-auto w-75 mb-2 d-flex align-items-center bg--four  ">
                <div class="input-group mx-auto w-75 mb-2 d-flex align-items-center bg-white rounded shadow ">
                    <input type="text" id="q" name="q" class="form-control border-0 bg-white " placeholder="Search books here...">
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
                                <h4 class="text-center border-bottom pb-2 pt-2 An_bold">Books</h4>
                                @forelse ($collections as $cat)
                                    @if($cat->books->where("approved","yes")->count() > 0)
                                    <a href="{{ route('category.book',$cat->id) }}" class="text--seven nav-link py-1 ">
                                            @if($cat->id == $id)
                                            <div class=" category-item bg--two text-white px-2 py-0 d-flex justify-content-between align-items-center rounded">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light font-weight-bolder">{{ ucwords($cat->ename) }}</h6>
                                                <small class="py-1 pb-0 mb-0 ">{{ App\Helpers\Number::ToShortForm(count($cat->books->where('approved','yes'))) }}</small>
                                            </div>
                                        @else
                                            <div class=" category-item bg--four px-2 py-0 d-flex justify-content-between align-items-center rounded">
                                                <h6 class=" pt-1 pb-0 mb-0 An_light font-weight-bolder">{{ ucwords($cat->ename) }}</h6>
                                                <small class="py-1 pb-0 mb-0 ">{{ App\Helpers\Number::ToShortForm(count($cat->books->where('approved','yes'))) }}</small>
                                            </div>
                                        @endif
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
                    <div class="row" id="BookContainer">
                            @foreach ($books as $book)
                            <div class="product-item-wrap p-3">
                                <div class="product-item position-relative " style="width:150px !important; height:270px !important;">
                                    <img src="{{ asset('application/books/cover/'.$book->image) }}" alt="{{ $book->title }}" class="img-fluid rounded shadow" style="width:150px !important; height:270px !important;" >
                                    <div class="product-img-hover pt-5" style="width:150px !important; height:270px !important;">
                                        <ul class=" list-inline text-center pl-2 ">
                                            <a href="{{ route('show.book',$book->id) }}"><button class="btn--outline--secondary px-4 py-1"><b><small>View</small></b></button></a>
                                            <h6 class="mt-2 text-white text-center An_Dm_bold text-break">{{ ucwords($book->title) }}</h6>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
     <script src="{{ asset('app/js/book/frontend/search-book.js') }}"></script>
 @endpush