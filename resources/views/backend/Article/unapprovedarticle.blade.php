@extends('layouts.master')
@section('content')
<div class="container-fluid">

    <!-- /.card-body -->
  <div class="row">
    <div class="col-12">
      <div class="card card-secondary">
        <div class="card-header bg-secondary">
          <h3 class="card-title">Unapproved Articles</h3>

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 350px;">
              <input type="search" name="no" class="form-control float-right" id="search" placeholder="Search title or author">

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
                <th class="text-left">No</th>
                <th>Title</th>
                <th>Author</th>
                <th>Uploaded</th>
                <th></th>
              </tr>
            </thead>
            <tbody >
              @foreach ($articles as $article)
              <tr id="{{ $article->id }}">
                <td class="text-left">{{ $loop->iteration }}</td>
                <td>{{ ucfirst($article->title) }}</td>
                <td>{{ ucfirst($article->author) }}</td>
                <td>{{ $article->created_at->diffForhumans() }}</td>
                <td><a href="{{ route('show.unapproved.article',$article->id) }}"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
                  </a></td>
              </tr>
              @endforeach

            </tbody>

          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer d-flex justify-content-center">
          {{ $articles->links() }}
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
@push('script')

<script src="{{ asset('app/js/article/backend/search-articles.js') }}"></script>
@endpush