@extends('layouts.master')
@section('content')
<div class="container-fluid">
        <!-- /.card-body -->
        <div class="row">
            <div class="col-12">
                 <div class="d-flex w-100 justify-content-center">
                    <img id="img" data-id="{{ $user->id }}" style="width:300px; height:300px" class="profile-user-img img-circle img-fluid"
                  src="{{ asset('application/users/'.$user->image) }}" alt="">
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card card-secondary">
              <div class="card-header bg-secondary">
                <h3 class="card-title">Books</h3>
      
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 350px;">
                    <input type="text" name="yes" class="form-control float-right" id="search" placeholder="Search title or author...">
      
                    <div class="input-group-append">
                      <button id="btn_search" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-head-fixed text-nowrap text-center">
                  <thead>
                    <tr>
                      <th class="text-left">Cover</th>
                      <th>Title</th>
                      <th>Author</th>
                      <th>Edition</th>
                      <th>Uploaded</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($abooks as $book)
                    <tr id="{{ $book->id }}">
                      <td class="text-left">
                        <div><img src="{{ asset('application/books/cover/'.$book->image) }}" alt="user"
                            class="rounded img-fluid" style="width:40px !important; height:45px !important;"></div>
                      </td>
                      <td>{{ ucfirst($book->title) }}</td>
                      <td>{{ ucfirst($book->author) }}</td>
                      <td>{{ $book->edition }}</td>
      
                      <td>{{ $book->created_at->diffForhumans() }}</td>
                      <td><a href="{{ route('book.show',$book->id) }}"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
                        </a></td>
                    </tr>
                    @endforeach
      
                  </tbody>
      
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer d-flex justify-content-center">
                {{ $abooks->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
@push('script')
    <script src="{{ asset('app/js/librarian/search-books.js') }}"></script>
@endpush