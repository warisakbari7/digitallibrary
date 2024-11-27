@foreach ($articles as $article)
<div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-5 mt-lg-0 mt-md-0 ">
    <div class="row w-100">
        <div class="w-100 shadow rounded border bg--eight m-lg-2 m-md-2">
            <a href="{{ route('show.article',$article->id) }}" class="nav-link p-0 related-article">
                <h4 class="text--two mt-3 text-break text-center">{{ ucwords($article->title) }}</h4>
            
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted mt-4 mb-1 ml-3 ">{{ date_format($article->created_at,'d M Y') }}</p>
            <p class="text-muted small mb-3">Author : {{ ucwords($article->author) }} </p>
                
                <div class="bg-secondary mt-4 mr-3" style="width:100px; height:19px;">
                    <div class="bg--one" style="width:{{ $article->rate * 100/5 }}px; height:19px ">
                        <img src="{{ asset('asset/images/stars.jpg') }}" alt="" style="width:100px;">
                    </div>
                </div>
            </div>
        </a>
        </div>
    </div>
</div>

@endforeach
<div class="mt-4 w-100">
    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
        {{ $articles->links() }}
    </nav>
</div>