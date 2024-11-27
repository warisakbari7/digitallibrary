@extends('layouts.frontend')
  @section('content')
    <section class="pt-5 bg--eight">
        <div class="container ">
            <div class=" ml-lg-4 " style="background: url( {{ asset('asset/images/library.jpg') }} );  background-image: linear-gradient( to right, #cccccc 40%, transparent 70%), url({{ asset("asset/images/library.jpg") }}); background-size: cover; position: center center; border-radius: 25px; background-repeat: no-repeat;">
                <div class="row pl-5 ">
                    <div class="col-lg-7 col-md-8 col-sm-10 col-12 p-5 ">
                        <h2 class="an_bold" style="font-size: 48px;"><b>    SALAM UNIVERSITY DIGITAL  LIBRARY</b></h2>
                        <p class="An_light" style="font-size: 20px !important;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque aliquid corporis, et deleniti, laborum nam animi officia, molestiae vero ipsam iure corrupti.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class=" py-5 bg--eight ">
        <div class="container  ">
            <div class="row mx-2">
                <div class="col-lg-3 col-md-3 col-sm-12 col-12  ">
                        <div class=" shadow bg--four" style="border-radius: 15px; height:100vh">
                            <h4 class="text-center border-bottom pb-2 pt-2 An_bold">Books</h4>
                            @forelse ($collections as $cat)
                                @if($cat->books->where("approved","yes")->count() > 0)
                                <a href="{{ route('category.book',$cat->id) }}" class="text--seven nav-link py-1 ">
                                    <div class=" category-item bg--four px-2 py-0 d-flex justify-content-between align-items-center rounded">
                                        <h6 class=" pt-1 pb-0 mb-0 An_light font-weight-bolder">{{ ucwords($cat->ename) }}</h6>
                                        <small class="py-1 pb-0 mb-0 ">{{ App\Helpers\Number::ToShortForm(count($cat->books->where('approved','yes'))) }}</small>
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
                    <div class="py-2 shadow bg--four my-3" style="border-radius: 15px; height:100vh">
                        <h4 class="text-center border-bottom pb-2 An_bold">Articles</h4>
                        @forelse ($collections as $cat)
                            @if($cat->articles->where('approved','yes')->count() > 0)
                                <a href="{{ route('category.article',$cat->id) }}" class="text--seven nav-link py-1 ">
                                    <div class=" category-item bg--four px-2 py-0 d-flex justify-content-between align-items-center rounded">
                                        <h6 class=" pt-1 pb-0 mb-0 An_light font-weight-bolder">{{ ucwords($cat->ename) }}</h6>
                                        <small class="py-1 pb-0 mb-0 ">{{ App\Helpers\Number::ToShortForm(count($cat->articles->where('approved','yes'))) }}</small>
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



                    <div class="py-2 shadow bg--four my-3" style="border-radius: 15px; height:100vh">
                            <h4 class="text-center border-bottom pb-2 an_bold">Audio Books</h4>
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
                    <div>
                        <h4 class="an_bold">Most Popular Books</h4>
                    </div>
                    <div class="row ">
                            <div class="w-100" >
                                    <ul id="popularbooks" class="cs-hidden" >
                                        @foreach ($popularbooks as $book)
                                        <li class="item-a">
                                                <div class="box">
                                                    <div class="product-item position-relative">
                                                        <img class="model" src="{{ asset("application/books/cover/".$book->image) }}" alt="{{ $book->title }}">
                                                            <div class="product-img-hover pt-5">
                                                                <ul class=" list-inline text-center ">
                                                                    <a href="{{ route('show.book',$book->id) }}"><button class="btn--outline--secondary px-4 pt-1 pb-0 an_bold " style="font-size: 18px;" ><b>View</b></button></a>
                                                                    <h5 class="mt-2 text-center text-white text-center text-break an_bold">{{ ucwords($book->title) }}</h6>
                                                                </ul>
                                                            </div>
                                                    </div>
                                                </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                    </div>
                    <div>
                        <hr class="mt-4">
                        <h4 class="an_bold mt-4">Recently Uploaded Books</h4>
                    </div>
                    <div class="row">
                        <div class="w-100" >
                            <ul id="recentBooks" class="cs-hidden" >
                                @foreach ($recentbooks as $book)
                                <li class="item-a">
                                        <div class="box">
                                            <div class="product-item position-relative">
                                                <img class="model" src="{{ asset("application/books/cover/".$book->image) }}" alt="{{ $book->title }}">
                                                    <div class="product-img-hover pt-5">
                                                        <ul class=" list-inline text-center ">
                                                            <a href="{{ route('show.book',$book->id) }}"><button class="btn--outline--secondary px-4 pt-1 pb-0 an_bold " style="font-size: 18px;" ><b>View</b></button></a>
                                                            <h5 class="mt-2 text-center text-white text-break an_bold">{{ ucwords($book->title) }}</h6>
                                                        </ul>
                                                    </div>
                                            </div>
                                        </div>
                                </li>
                                @endforeach
                        
                            </ul>
                        </div>
                    </div>
                    <div>
                        <hr class="mt-4">
                        <h4 class="an_bold">Most Downloaded Books </h4>
                    </div>
                    <div class="row">
                        <div class="w-100" >
                            <ul id="downloadedBooks" class="cs-hidden" >
                                @foreach ($downloadedBooks as $book)
                                <li class="item-a">
                                        <div class="box">
                                            <div class="product-item position-relative">
                                                <img class="model" src="{{ asset("application/books/cover/".$book->image) }}" alt="{{ $book->title }}">
                                                    <div class="product-img-hover pt-5">
                                                        <ul class=" list-inline text-center ">
                                                            <a href="{{ route('show.book',$book->id) }}"><button class="btn--outline--secondary px-4 pt-1 pb-0 an_bold " style="font-size: 18px;" ><b>View</b></button></a>
                                                            <h5 class="mt-2 text-center text-white text-break an_bold">{{ ucwords($book->title) }}</h6>
                                                        </ul>
                                                    </div>
                                            </div>
                                        </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div>
                        <hr class=" mt-5 ">
                        <h4 class="an_bold mb-0 pb-0">Most Downloaded Audioes </h4>
                    </div>
                    <div class="row">
                            @forelse ($downloadedaudios as $book)
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
                                <div class="text-center">No Audio Book Found</div>
                            @endforelse
                    </div>

                    <div>
                        <hr class=" mt-4 ">
                        <h4 class="an_bold">Recently Uploaded Article </h4>
                    </div>
                    <div>
                        @forelse ($recentArticles as $article)
                            <div class="related-article bg--four p-1 rounded my-2  ">
                                <a href="{{ route('show.article',$article->id) }}" class="text--two nav-link p-0 text-center">
                                    <h5 class="m-0 An_trial">{{ $article->title }}</h5>
                                </a>
                            </div>
                        @empty
                            <div class=" bg--four p-1 rounded my-2  ">
                                <a href="javascript:void(0)" class="text--two nav-link p-0 ">
                                    <h5 class="m-0 An_trial">No Data</h5>
                                </a>
                            </div>
                        @endforelse
                        <hr class="p-0 mt-4 mb-0">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg--four py-4">
        <div class="container">
            <div class="text-center">
                <h4 class="an_bold">Popular Quotes</h4>
            </div>
            <hr class=" rounded shadow">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                <div class="carousel-inner   w-100 ">

                    @for($q = 0; $q < count($quotations); $q++ )
                    <div class="carousel-item  w-100 {{ $q == 0 ? 'active':'' }}">
                            <div class="row ">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6 my-3 ">
                                    <img src="{{ asset("application/quotation/".$quotations[$q]->image) }}"  class="img-fluid shadow rounded" style="height:300px !important;" alt="Image">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6 my-3">
                                    <img src="{{ asset("application/quotation/".$quotations[++$q]->image) }}" class="img-fluid shadow rounded" style="height:300px !important; " alt="Image">
                                </div>
                            </div>
                        </div> 
                    @endfor

                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>
@endsection

@push('script')
<script>
    $(document).ready(()=>{
        $('#recentBooks').lightSlider({
                loop:true,
                item:4,
                onSliderLoad: () => {
                    $('#recentBooks').removeClass('cs-hidden');
            }
        });

        $('#downloadedBooks').lightSlider({
                loop:true,
                item:4,
                onSliderLoad: () => {
                    $('#downloadedBooks').removeClass('cs-hidden');
            }
        });

        $('#popularbooks').lightSlider({
                loop:true,
                item:4,
                onSliderLoad: () => {
                    $('#popularbooks').removeClass('cs-hidden');
            }
        });
    })
</script>
@endpush
