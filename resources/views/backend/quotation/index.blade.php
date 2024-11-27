@extends('layouts.master')
@section('content')
<section class="bg-light py-5">
    <div class="container ">

            <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-10">
                        <div class="text-center">
                            <h4 class=" mb-0 font--family "><b>Quotations | Hadith</b></h4>
                            <span class="border-bottom  px-5"></span>
                        </div>
                    </div>
                </div>

        <div class="row">
              <div class="col-12">
                    <div class="card card-secondary">
                            <div class="card-header">
                              <h3 class="card-title">Add Quotation | Hadith</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="quotation" action="{{ route('quotation.store') }}" method="POST" enctype="multipart/form-data">
                              <div class="card-body">
                                <div class="form-group">
                                  <label for="exampleInputFile">File input</label>
                                  <div class="input-group">
                                      @csrf
                                    <div class="custom-file">
                                      <input id="pic" type="file" class="custom-file-input" name="image" id="exampleInputFile">
                                      <label id="label" class="custom-file-label" for="exampleInputFile">Choose Image</label>
                                    </div>
                                    <div class="input-group-append">
                                      <span class="input-group-text">Upload</span>
                                    </div>
                                  </div>
                                  <div class="danger text-danger ml-1"></div>
                                  <br>
                                  <div class="progress">
                                      <div class="bar bg-success"></div>
                                      <div class="percent p-2">0%</div>
                                  </div>
                                </div>
                              </div>
                              <!-- /.card-body -->
              
                              <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-left">Submit</button>
                                <div class="mt-2 success text-center text-success text-lg"></div>
                              </div>
                            </form>
                          </div>
              </div>
        </div>

        <div class="gallery-wrap my-5">
            <div class="row quotation">

                @foreach ($quotations as $q)
                    <div class="col-lg-4 mb-4 {{ $q->id }}">
                        <div class="gallery-item">
                            <a href="#{{ $q->id }}">
                                <img src="{{ asset('application/quotation/'.$q->image) }}" alt="" style="height: 200px;" class="img-fluid w-100 shadow rounded">
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-around" >
                    {{ $quotations->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="popup">
        <!-- popup for img -->
    @foreach ($quotations as $q)
    <div id="{{ $q->id }}" class="overlay">
            <div class="popup bg-light rounded p-4  position-relative" style="max-width: 500px; margin: 2em auto;">
                <a class="close mb-3" href="#">&times;</a>
                <img src="{{ asset('application/quotation/'.$q->image) }}" alt="Popup Image" class="img-fluid shadow rounded" style="max-height:300px !important" height="50%" width="100%"/>  
                <p class=" text-monospace text-muted small my-3 text-lg">Added By : 
                    @if(Auth::user()->id == $q->user_id)
                    <strong> you </strong>
                    @else
                    <strong> {{ $q->user->name }} </strong>
                    @endif
                </p>
                <button id="{{ $q->id }}" onclick="ShowModal(this)" class="btn btn-danger">Delete</button>
            </div>
        </div>
    @endforeach

    </div>
        {{-- Modal For Deleting Quotations --}}
        <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-danger mt-0">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Confirmation</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                        <form action="" id="DeleteForm" method="POST">
                            <div class="modal-body text-center">
                                <h4 id="message">Are you wanna delete this Quotation | Hadith?</h4>
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                            
                            <input type="hidden" id="DeleteId" name="id">
                            <button style="width:120px" type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button style="width:120px" id="btn_submit" class="btn btn-danger" type="submit">Delete</button>
                            </div>
                        </form>
                    </div>
            
                </div>
              </div>


               {{-- Modal For Message Quotations --}}
        <div class="modal fade" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-success mt-0">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Information</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                            <div class="modal-body text-center">
                                <h4 id="message">Deleted Successfully</h4>
                            </div>
                            <div class="modal-footer">
                            
                            <button style="width:120px" type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                            </div>
                    </div>
            
                </div>
              </div>
    
</section>

@endsection
@push('script')
    <script src="{{ asset('app/js/quotation/quotation.js') }}"></script>
@endpush