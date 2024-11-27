@foreach ($books as $book)
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
@endforeach
<div class="my-5 pl-5 w-100">
        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
            {{ $books->links() }}
        </nav>
</div>