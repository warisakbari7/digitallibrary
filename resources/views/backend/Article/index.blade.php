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
      <button class="btn btn-secondary mb-2 ml-1" data-target="#articlemodal" data-toggle="modal"> <i class="fa fa-plus" > </i> Add Article</button>
      <div class="card card-secondary">
        <div class="card-header bg-secondary">
          <h3 class="card-title">Articles</h3>

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
                <th class="text-left">No</th>
                <th>Title</th>
                <th>Author</th>
                <th>Uploaded</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($aarticles as $article)
              <tr id="{{ $article->id }}">
                <td class="text-left">
                    {{ $loop->iteration }}
                </td>
                <td>{{ ucwords($article->title) }}</td>
                <td>{{ ucwords($article->author) }}</td>

                <td>{{ $article->created_at->diffForhumans() }}</td>
                <td><a href="{{ route('article.show',$article->id) }}"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
                  </a></td>
              </tr>
              @endforeach

            </tbody>

          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer d-flex justify-content-center">
          {{ $aarticles->links() }}
        </div>
      </div>
    </div>
  </div>
</div>


      <!-- Article Modal -->
      <div class="modal fade  bg--opcity pr-0  " id="articlemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog  " style=" max-width: 800px !important;" role="document">
              <div class="modal-content p-0 border-0">
                  <div class="modal-header text-center  bg-secondary align-items-center border-0 py-2 ">
                      <h4 class=" mb-0 text-white text-center w-100 an_bold pt-2" id="exampleModalLabel">Add New Article </h5>

                          <a data-dismiss="modal" href="javascript:void(0)" class="bg-danger rounded" style="width:25px;"><i class=" text-white" data-dismiss="modal">&times;</i></a>
                  </div> 
                  <div class="modal-body articlemodal bg--four rounded">
                      <form class="px-4" id="articleform" action="{{ route('article.store') }}" method="POST">
                          @csrf
                          <div class="form-group">
                              <label for="language" class="an_bold" id="a_lbl_language">Language</label>
                              <select required name="a_language" id="a_language" class="form-control">
                                  <option id="a_lang" value="">Select Language</option>  
                                  <option value="english">English</option>  
                                  <option value="pashto">پښتو</option>
                                  <option value="dari">دری</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1"><b class="an_bold" id="lbl_a_name">Article Full Name </label><span class="text-danger"> *</span></b>
                              <input type="text" class="form-control  shadow rounded" placeholder="Article Full Name" id="a_name" name="a_name">
                              <span class="text-danger a_name ml-2"></span>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_author">Author </label><span class="text-danger"> *</b></span>
                              <input type="text" class="form-control  shadow rounded" id="a_author" aria-describedby="emailHelp" name="a_author"  placeholder="Author Full Name">
                              <span class="text-danger a_author ml-2"></span>
                          </div>
                          <div class="form-group row  mx-0 ">
                              <div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-lg-5 p-0">
                                  <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_page">Number of Pages and Chapters </label><span class="text-danger"> *</span></b>
                                  <div class="row mx-0">
                                      <div class="bg-light p-2 rounded shadow d-flex w-100 ">
                                          <div class="d-flex align-items-center w-100 ">

                                              <input required type="number" min="1" class="form-control form-control-sm  bg--four  " id="a_page" name="a_page" aria-describedby="emailHelp" placeholder="0 ... ">
                                              <label for="exampleInputEmail1" class="mb-0 mx-1 pr-3 " id="lbl_a_pages">Pages</label>
                                          </div>
                                          <div class="d-flex align-items-center w-100  ">
                                              <input required type="number" min="1" class="form-control form-control-sm  bg--four  " id="a_chapter" aria-describedby="emailHelp" name="a_chapter" placeholder="0 ...">
                                              <label for="exampleInputEmail1" class="mb-0 mx-1" id="lbl_a_chapter">Chapters</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              
                              <div class="col-lg-4 col-md-3 col-sm-6 col-6 pl-0  pr-0 mt-3 mt-lg-0 mt-md-0 "> <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_publish">Year of publish </label><span class="text-danger"> *</span></b>

                                  <div class="bg-light p-2 rounded shadow w-100">
                                      <div class="d-flex align-items-center ">
                                          <input required type="date" class="form-control form-control-sm  bg--four w-100 " name="a_publish" id="a_publish" aria-describedby="emailHelp" placeholder="0 ... ">
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_aboutauthor">About Author</b> <small>(optional)</small></label>
                              <textarea maxlength="1000" class="form-control form-control-sm rounded shadow" name="a_aboutauthor" placeholder="short biography in 1000 letter" id="a_aboutauthor" rows="6"></textarea>
                              <div class="text-right pr-3 pt-2 text-muted">
                                  <h6><span id="authorcounter">0</span>/1000</h6>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_aboutarticle">About Article </b> <small>(optional)</small> </label>
                              <textarea maxlength="1000" class="form-control form-control-sm rounded shadow" name="a_aboutarticle" placeholder="Explain article briefly in 1000 letter" id="a_aboutarticle" rows="6"></textarea>
                              <div class="text-right pr-3 pt-2 text-muted">
                                  <h6><span id="articlecounter">0</span>/1000</h6>
                              </div>
                          </div>
                          <div class="form-group w-25">
                              <label for="exampleFormControlSelect1"><b  class="an_bold" id="lbl_a_catagory">Catagories <span class="text-danger"> *</span></b></label>
                              <select class="form-control" name="a_catagory" id="a_catagory">
                                  @forelse ($catagories as $cat)
                                      <option value="{{ $cat->id }}">{{ $cat->ename }}</option>                                                                                                
                                  @empty
                                      <option value="">No Data</option>                                                                                                
                                  @endforelse
                              </select>
                              <span class="text-danger a_catagory ml-2"></span>
                          </div>
                          <div class="form-group mt-3">
                              <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_tag">Tags <span class="text-danger"> *</span></b> <small>(Minimum 1 and Muximum 5)</small></label>
                              <div style="height:250px; overflow:scroll" class=" p-4 bg-white shadow rounded row mx-0 a_tagcontainer" >
                                  @forelse ($tags as $tag)
                                  <span  class="article_tag bg--four px-2  rounded justify-content-center nav-link py-1  m-1  " style="height:30px !important;">{{ $tag->ename }}</span>
                                  @empty  
                                  @endforelse
                              </div>
                              <input type="hidden" id="a_tags_values" name="tags">
                              <span class="text-danger a_tag ml-2 float-left"></span>
                              <div class="text-right pr-3 pt-2 text-muted">
                                  <h6><span id="tagcounter">0</span>/5</h6>
                              </div>
                          </div>
                          <div class="row">
                              <div class="form-group w-75 col-4">
                                  <div class="row">
                                    <label for="exampleFormControlFile1"><b  class="an_bold" id="lbl_a_article">Article</b> <small>(pdf file)</small></label>
                                  </div>
                                  <div class="row">
                                        <label for="a_article" class="custom-file border-0 shadow rounded small bg-primary mr-3 text-white  text-center pb-0 pt-1 " style="
                                        cursor: pointer; width:120px;" id="a_articlebutton">Upload</label>
                                  </div>
                                  <div class="row p-2">
                                        <input type="file" id="a_article" name="a_article" class="custom-file-input">
                                        <small class="a_article"> *Note: PDF size should not be more then 60 MB</small>
                                  </div>

                                  <label for="exampleFormControlFile1" class="mt-3" id="a_lblarticle">Uploaded : </label>
                                  <span id="articlenamelbl" class="font-italic d-block"></span>
                              
                              </div>

                              
                          </div>

                          <div class="progress mt-2 d-none">
                                  <div class="a_bar bg--two"></div>
                                  <div class="a_percent mt-2">0%</div>
                          </div>
                          <div class="alert alert-danger a_exist_error mt-2 invisible">This Article has already been registered</div>
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
      var json_tag =  {!!  json_encode($tags) !!}
      var json_catagory =  {!!  json_encode($catagories) !!}
</script>
<script src="{{ asset('app/js/article/backend/search-articles.js') }}"></script>
<script src="{{ asset('app/js/article/backend/article-form.js') }}"></script>
@endpush