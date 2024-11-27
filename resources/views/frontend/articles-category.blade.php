@extends('layouts.frontend')
@section('content')
<section class="bg--four pt-2">
    <div class="container">
         <div class="row w-100  ml-lg-5 mx-0 ">
             <form action="{{ route('search.article') }}" id="SearchForm" class="input-group mx-auto w-75 mb-2 d-flex align-items-center bg--four  ">
                 <div class="input-group mx-auto w-75 mb-2 d-flex align-items-center bg-white rounded shadow ">
                     <input type="text" id="q" name="q" class="form-control border-0 bg-white " placeholder="Search articles here...">
                     <input type="submit" value="" id="submit_btn" class="input-group-addon bg-white  border-0  px-2"><label for="submit_btn" class="fa fa-search pr-2 pt-2" style="cursor:pointer"></label>
                 </div>
             </form>
         </div>
     </div>
</section>
    <section class=" my-5">
        <div class="container  ">
            <div class="row mx-2 justify-content-center">
                <div class="col-lg-3 col-md-3 col-12 col-12  ">
                    <div class=" px-3 py-5 shadow bg--four rounded" style="height:100vh;">
                        <h5 class="text--two">Categories</h5>
                        @forelse ($collections as $cat)
                            @if($cat->articles->where('approved','yes')->count() > 0)
                                <a href="{{ route('category.article',$cat->id) }}" class="text--seven nav-link py-1 ">
                                    @if($cat->id == $id)
                                    <div class=" category-item bg--two text-white px-2 py-0 d-flex justify-content-between align-items-center rounded">
                                        <h6 class=" pt-1 pb-0 mb-0 An_light font-weight-bolder">{{ ucwords($cat->ename) }}</h6>
                                        <small class="py-1 pb-0 mb-0 ">{{ App\Helpers\Number::ToShortForm(count($cat->articles->where('approved','yes'))) }}</small>
                                    </div>
                                    @else
                                        <div class=" category-item bg--four px-2 py-0 d-flex justify-content-between align-items-center rounded">
                                            <h6 class=" pt-1 pb-0 mb-0 An_light font-weight-bolder">{{ ucwords($cat->ename) }}</h6>
                                            <small class="py-1 pb-0 mb-0 ">{{ App\Helpers\Number::ToShortForm(count($cat->articles->where('approved','yes'))) }}</small>
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
                <div class="col-9">
                    <div id="ArticleContainer" class="row w-100">
                        @include('ajax-pages.article.list-article')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
  <script src="{{ asset('app/js/article/frontend/list-article.js') }}"></script>
@endpush