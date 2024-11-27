@extends('layouts.frontend')
@section('content')
<section class="bg--four pt-2 ">
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
                    <div class=" px-3 py-5 shadow bg--four " style="height:100vh;">
                        <h5 class="text--two">You may also read</h5>
                        <div class="ml-2">
                            @forelse ($extraArticles as $article)
                                <a href="{{ route('show.article',$article->id) }}" class="related-article text--seven  nav-link p-0 "><i class="fa fa-angle-right text--two"></i>
                                @if(strlen($article->title) > 21)    
                                    {{ ucwords(substr($article->title,0,21).'...') }} 
                                @else
                                    {{ ucwords($article->title) }} 
                                @endif
                                </a> 
                            @empty
                                <a href="javascript:void(0)" class="text--seven  nav-link p-0 "><i class="fa fa-angle-right text--two"></i> No Data </a>                
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div id="ArticleContainer" class="row w-100">
                        @forelse ($articles as $article)
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-5 mt-lg-0 mt-md-0 ">
                                <div class="row w-100">
                                    <div class="w-100">
                                        <a href="{{ route('show.article',$article->id) }}" class="nav-link p-0">
                                            <h4 class="text--two mt-3 text-break text-center">{{ ucwords($article->title) }}</h4>
                                        </a>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted mt-4 mb-1 ">{{ date_format($article->created_at,'d M Y') }}</p>
                                            <p class="text-muted small mb-3">Author : {{ ucwords($article->author) }} </p>
                                        
                                            <div class="bg-secondary mt-4" style="width:100px; height:19px;">
                                                <div class="bg--one" style="width:{{ $article->rate * 100/5 }}px; height:19px ">
                                                    <img src="{{ asset('asset/images/stars.jpg') }}" alt="" style="width:100px;">
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mt-0">
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="p-2 pt-4 shadow  row w-100 an_bold ml-2">
                                <div class="col-lg-12 col-md-12 text-center col-sm-12 col-12 mt-5 mt-lg-0 mt-md-0 text-">
                                    <p>Not Found</p>
                                </div>
                            </div>
                        @endforelse
                        <div class="mt-4 w-100">
                            <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                                {{ $articles->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
  <script src="{{ asset('app/js/article/frontend/list-article.js') }}"></script>
@endpush