@foreach ($books as $book)
    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
        <div class="product-item-wrap p-3">
            <div class="product-item position-relative " style="width:170px !important; height:250px !important;">
                <img src="{{ asset('application/books/cover/'.$book->image) }}" alt="{{ $book->title }}" class="img-fluid rounded shadow" style="width:170px !important; height:250px !important;" >
                <div class="product-img-hover pt-5" style="width:170px !important; height:250px !important;">
                    <ul class=" list-inline text-center pl-2 ">
                        <a href="{{ route('show.book',$book->id) }}"><button class="btn--outline--secondary px-4 py-1"><b><small>View</small></b></button></a>
                        <h6 class="mt-2 text-white text-center An_Dm_bold text-break">{{ ucwords($book->title) }}</h6>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endforeach
<div class="my-5 pl-5 w-100">
        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
            {{ $books->links() }}
        </nav>
</div>