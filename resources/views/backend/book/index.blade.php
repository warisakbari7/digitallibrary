@extends('layouts.master')
@section('content')
<div class="container-fluid">
  <div
    style="display:none ; transition: right 2s; z-index:3 ; color:white; font-family: monospace; border-radius: 5px; outline-offset: 2px; border:2px solid #55ACEE; outline:2px solid #55ACEE; width:300px; height:50px; background: #4285F4; position:absolute; right:-350px; top:150px"
    class=" toast-success  pt-3">
    <p class="" style="font-size: 25px; position:relative; left:23px; bottom:10px">Saved Successfully </p>
  </div>
  <!-- /.card-body -->


  <div class="row">
    <div class="col-12">
      <button class="btn btn-secondary mb-2 ml-1" data-target="#bookmodal" data-toggle="modal"> <i class="fa fa-plus" > </i> Add Book</button>
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


      <!-- Book Modal -->
      <div class="modal fade  bg--opcity pr-0  " id="bookmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog  " style=" max-width: 800px !important;" role="document">
              <div class="modal-content p-0 border-0">
                  <div class="modal-header text-center  bg-secondary align-items-center border-0 py-2 ">
                      <h4 class=" mb-0 text-white text-center w-100 an_bold pt-2" id="exampleModalLabel">Add New Book </h5>

                          <a data-dismiss="modal" href="javascript:void(0)" class="bg-danger rounded" style="width:25px;"><i class=" text-white" data-dismiss="modal">&times;</i></a>
                  </div> 
                  <div class="modal-body bookmodal bg--four rounded">
                      <form class="px-4" id="bookform" action="{{ route('book.store') }}" method="POST">
                          @csrf
                          <div class="form-group">
                              <label for="language" class="an_bold" id="lbl_language">Language</label>
                              <select required name="b_language" id="b_language" class="form-control">
                                  <option id="b_lang" value="">Select Language</option>  
                                  <option value="english">English</option>  
                                  <option value="pashto">پښتو</option>
                                  <option value="dari">دری</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1"><b class="an_bold" id="lbl_b_name">Book Full Name </label><span class="text-danger">*</span></b>
                              <input type="text" class="form-control  shadow rounded" placeholder="Book Full Name" id="b_name" name="b_name">
                              <span class="text-danger b_name ml-2"></span>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_author">Author </label><span class="text-danger">*</b></span>
                              <input type="text" class="form-control  shadow rounded" id="b_author" aria-describedby="emailHelp" name="b_author"  placeholder="Author Full Name">
                              <span class="text-danger b_author ml-2"></span>
                          </div>
                          <div class="form-group row  mx-0 ">
                              <div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-lg-5 p-0">
                                  <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_page">Number of Pages and Chapters </label><span class="text-danger">*</span></b>
                                  <div class="row mx-0">
                                      <div class="bg-light p-2 rounded shadow d-flex w-100 ">
                                          <div class="d-flex align-items-center w-100 ">

                                              <input required type="number" min="1" class="form-control form-control-sm  bg--four  " id="b_page" name="b_page" aria-describedby="emailHelp" placeholder="0 ... ">
                                              <label for="exampleInputEmail1" class="mb-0 mx-1 pr-3 " id="lbl_b_pages">Pages</label>
                                          </div>
                                          <div class="d-flex align-items-center w-100  ">
                                              <input required type="number" min="1" class="form-control form-control-sm  bg--four  " id="b_chapter" aria-describedby="emailHelp" name="b_chapter" placeholder="0 ...">
                                              <label for="exampleInputEmail1" class="mb-0 mx-1" id="lbl_b_chapter">Chapters</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-2 col-md-3 col-sm-6 col-6 pl-0 pr-lg-5 mt-3 mt-lg-0 mt-md-0">
                                  <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_edition">Edition </label><span class="text-danger">*</span></b>
                                  <div class="row mx-0">
                                      <div class="bg-light p-2 rounded shadow d-flex b">
                                          <div class="d-flex align-items-center ">
                                              <select required name="b_edition" id="b_edition" class="bg--four border-0 p-1 rounded">
                                                  <option value="1st" selected>1st</option>
                                                  <option value="2nd">2nd</option>
                                                  <option value="3rd">3rd</option>
                                                  <option value="4th">4th</option>
                                                  <option value="5th">5th</option>
                                                  <option value="6th">6th</option>
                                                  <option value="7th">7th</option>
                                                  <option value="8th">8th</option>
                                                  <option value="9th">9th</option>
                                                  <option value="10th">10th</option>
                                                  <option value="12th">12th</option>
                                                  <option value="13th">13th</option>
                                                  <option value="14th">14th</option>
                                                  <option value="15th">15th</option>
                                                  <option value="16th">16th</option>
                                                  <option value="17th">17th</option>
                                                  <option value="18th">18th</option>
                                                  <option value="19th">19th</option>
                                                  <option value="20th">20th</option>
                                              </select>
                                          </div>

                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-4 col-md-3 col-sm-6 col-6 pl-0  pr-0 mt-3 mt-lg-0 mt-md-0 "> <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_publish">Year of publish </label><span class="text-danger">*</span></b>

                                  <div class="bg-light p-2 rounded shadow w-100">
                                      <div class="d-flex align-items-center ">
                                          <input required type="date" class="form-control form-control-sm  bg--four w-100 " name="b_publish" id="b_publish" aria-describedby="emailHelp" placeholder="0 ... ">
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_aboutauthor">About Author</b> <small>(optional)</small></label>
                              <textarea maxlength="1000" class="form-control form-control-sm rounded shadow" name="b_aboutauthor" placeholder="short biography in 1000 letter" id="b_aboutauthor" rows="6"></textarea>
                              <div class="text-right pr-3 pt-2 text-muted">
                                  <h6><span id="authorcounter">0</span>/1000</h6>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_aboutbook">About Book </b> <small>(optional)</small> </label>
                              <textarea maxlength="1000" class="form-control form-control-sm rounded shadow" name="b_aboutbook" placeholder="Explain book briefly in 1000 letter" id="b_aboutbook" rows="6"></textarea>
                              <div class="text-right pr-3 pt-2 text-muted">

                                  <h6><span id="bookcounter">0</span>/1000</h6>

                              </div>
                          </div>
                          <div class="form-group w-25">
                              <label for="exampleFormControlSelect1"><b  class="an_bold" id="lbl_b_catagory">Catagories <span class="text-danger">*</span></b></label>
                              <select class="form-control" name="b_catagory" id="b_catagory">
                                  @forelse ($catagories as $cat)
                                      <option value="{{ $cat->id }}">{{ $cat->ename }}</option>                                                                                                
                                  @empty
                                      <option value="">No Data</option>                                                                                                
                                  @endforelse
                              </select>
                              <span class="text-danger b_catagory ml-2"></span>
                          </div>
                          <div class="form-group mt-3">
                              <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_tag">Tags <span class="text-danger">*</span></b> <small>(Minimum 1 and Muximum 5)</small></label>
                              <div style="height:250px; overflow:scroll" class=" p-4 bg-white shadow rounded row mx-0 b_tagcontainer" >
                                  @forelse ($tags as $tag)
                                  <span  class="book_tag bg--four px-2  rounded justify-content-center nav-link py-1  m-1  " style="height:30px !important;">{{ $tag->ename }}</span>
                                  @empty  
                                  @endforelse
                              </div>
                              <input type="hidden" id="b_tags_values" name="tags">
                              <span class="text-danger b_tag ml-2 float-left"></span>
                              <div class="text-right pr-3 pt-2 text-muted">
                                  <h6><span id="tagcounter">0</span>/5</h6>
                              </div>
                          </div>
                          <div class="row">
                              <div class="form-group w-75 col-4">
                                  <div class="row">
                                    <label for="exampleFormControlFile1"><b  class="an_bold" id="lbl_b_book">Book</b> <small>(pdf file)</small></label>
                                  </div>
                                  <div class="row">
                                        <div class="w-100 d-flex align-items-center">
                                                <label for="b_book" class="custom-file border-0 shadow rounded small bg-primary mr-3 text-white  text-center pb-0 pt-1 " style="
                                                cursor: pointer; width:120px;" id="b_bookbutton">Upload</label>
                                  </div>
                                  <div class="row p-2">
                                        <small class="b_book">*Note: PDF size should not be more then 60 MB</small>
                                        <input type="file" id="b_book" name="b_book" class="custom-file-input">                                  
                                  </div>
                                   

                                  </div>
                                  <label for="exampleFormControlFile1" class="mt-3" id="b_lblbook">Uploaded : </label>
                                  <span id="booknamelbl" class="font-italic d-block"></span>
                              </div>

                              <div class="form-group w-75 col-4">
                                  <div class="row">
                                    <label for="exampleFormControlFile1"><b class="an_bold" id="lbl_b_cover">Cover</b> <small>(jpg, png, jpeg)</small></label>
                                  </div>
                                  <div class="row">
                                        <label for="b_cover" class="custom-file border-0 shadow rounded small mt-0 bg-primary mr-3 text-white w-50 text-center pb-0 pt-1 " style="
                                        cursor: pointer;width:120px;
                                    " id="b_coverbutton">Upload </label>
                                  </div>
                                  <div class="row p-2">
                                        <small class="b_cover">*Note: Image must be between 500 KB - 2 MB</small>
                                        <input  type="file" id="b_cover" name="b_cover" class="custom-file-input">

                                  </div>
                                  <label for="exampleFormControlFile1" class="mt-3" id="b_lblcover">Uploaded : </label><span id="covernamelbl" class="font-italic d-block"></span>
                                  
                              </div>
                              <div class="col-4 d-flex justify-content-end">
                                      <img id="img_b_cover" src="{{ asset('asset/images/placeholder1.png') }}" class="w-50 rounded shadow" alt="book cover" style=" height:150px;">
                              </div>
                          </div>

                          <div class="progress mt-2 d-none">
                                  <div class="b_bar bg--two"></div>
                                  <div class="b_percent mt-2">0%</div>
                          </div>
                          <div class="alert alert-danger b_exist_error mt-2 invisible">This Book has already been registered</div>
                          <div class="row ml-auto w-100 justify-content-end mr-5 mt-3">
                              <button type="submit" class="btn btn-primary border-0  px-5 py-1 btn-sm " id="lbl_finish">Register</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
      <!-- End Modal -->

@endsection
@push('script')
<script>
      var cover = "{{ asset('asset/images/placeholder1.png') }}"
      var json_tag =  {!!  json_encode($tags) !!}
      var json_catagory =  {!!  json_encode($catagories) !!}
</script>
<script src="{{ asset('app/js/book/backend/search-books.js') }}"></script>
<script src="{{ asset('app/js/book/backend/book-form.js') }}"></script>
@endpush