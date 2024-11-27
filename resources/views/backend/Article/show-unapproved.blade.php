@extends('layouts.master')
@section('style')
    <style>
        #back:hover{
            color:#878f99 !important;
            transform: scale(1.5,1.5)
            }
        #back:active{
            transform: scale(1,1)
        }
    </style>
@endsection
@section('content')
<a href="{{ route('unapproved.article') }}"><i id="back" class="mt-2 ml-5 text-xl text-secondary fa fa-arrow-circle-left mb-3"></i></a> 

    <div class="row justify-content-center mx-0">
        <div id="article_container" class=" col-lg-8 col-md-10 col-sm-12 col-12">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6" >
                    <span id="lang" data-id="{{ $article->id }}" data-language="{{ $article->language }}"></span>
                    <embed src="{{ asset('application/articles/pdf/'.$article->path) }}" type="application/pdf" height="500" width="400">                
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-12">
                            <h3 id="title" class="An_Dm_bold">{{ $article->title }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p class="pl-1 text-muted mb-0 ">Author: </p>
                        </div>
                        <div class="col-8">
                            <p id="author" class="pl-4 text--two mb-0 ">{{ $article->author }}</p>
                        </div>
                    </div>
                    @if($article->language == 'dari')
                        <div class="row">
                            <div class="col-4">
                                <p class="pl-1 text-muted mb-0 ">Category : </p>
                            </div>
                            <div class="col-8">
                                <p class="pl-4 text--two mb-0 ">{{ $article->category->dname }}</p>
                            </div>
                        </div>
                    @elseif($article->language == 'english')
                        <div class="row">
                            <div class="col-4">
                                <p class="pl-1 text-muted mb-0 ">Category : </p>
                            </div>
                            <div class="col-8">
                                <p class="pl-4 text--two mb-0 ">{{ $article->category->ename }}</p>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-4">
                                <p class="pl-1 text-muted mb-0 ">Category : </p>
                            </div>
                            <div class="col-8">
                                <p class="pl-4 text--two mb-0 ">;{{ $article->category->pname }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-4">
                            <p class="pl-1 text-muted mb-0">Uploaded: </p>
                        </div>
                        <div class="col-8">
                            <p class="pl-4  text--two mb-0">{{ $article->created_at->format('d M Y') }}&nbsp;&nbsp; by {{ $article->owner->name }} {{ $article->owner->lastname }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p class="pl-1 text-muted mb-0">Publish Date : </p>
                        </div>
                        <div class="col-8">
                            <p id="publish" class="pl-4  text--two mb-0">{{ date_format(date_create($article->publish_date),'d M Y') }}   &nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p class="pl-1 text-muted mb-0">Pages: </p>
                        </div>
                        <div class="col-8">
                            <p id="pages" class="pl-4 text--two mb-0">{{ $article->pages }} Pages, {{ $article->chapter }} Chapters </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p class="pl-1 text-muted mb-0">Size: </p>
                        </div>
                        <div class="col-8">
                            <p  class="pl-4  text--two mb-0">{{ $article->size }} Bytes </p>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-6">
                            <a href="{{ asset('application/articles/pdf/'.$article->path) }}" target="_blank"><button class="w-100 btn  bg-warning px-4 py-1 text-white shadow mr-2 an_bold"> Read </button></a>
                        </div>
                        <div class="col-6">
                            <a href="{{ asset('application/articles/pdf/'.$article->path) }}" download><button class="w-100 py-1 btn bg-success px-4 shadow an_bold">Download</button></a><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <a href="javascript:void(0)" data-target="#articlemodal" data-toggle="modal"><button class="w-100 mt-5 bg-primary border-primary btn px-4 py-1 shadow mr-2 an_bold">Edite</button></a>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0)" data-target="#deleteModal" data-toggle="modal"><button class="w-100 bg-danger border-danger mt-5 py-1 btn px-4 shadow an_bold">Delete</button></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="javascript:void(0)" data-target="#approvemodal" data-toggle="modal"><button class="w-100 bg-secondary mt-5 py-1 btn px-4 shadow an_bold">Approve</button></a>
                        </div>
                    </div>
    
            </div>
            </div>@if($article->language == 'dari')
            @if($article->about_author != '')
            <div id="a_aboutauthor_container" class="pl-1 text-right">
                <hr>
                <h4 class="An_Dm_bold">درباره نویسنده</h4>
                <small><p class="text-break">{{ $article->about_author }}</p></small>
            </div>
            @endif
            @if($article->about_article != '')
                <div id="a_aboutarticle_container" class="pl-1 mt-5 text-right">
                    <hr>
                    <h4 class="An_Dm_bold">درباره مقاله </h4>
                    <small><p class="text-break">{{ $article->about_article }}</p></small>
                </div>
            @endif

        @elseif ($article->language == 'english')
                @if($article->about_author != '')
                    <div id="a_aboutauthor_container" class="pl-1">
                        <hr>
                        <h4 class="An_Dm_bold">About Author</h4>
                        <small><p class="text-break">{{ $article->about_author }}</p></small>
                    </div>
                @endif
                @if($article->about_article != '')
                    <div id="a_aboutarticle_container" class="pl-1 mt-5">
                        <hr>
                        <h4 class="An_Dm_bold">About Article</h4>
                        <small><p class="text-break">{{ $article->about_article }} </p></small>
                    </div>
                @endif
        @else
            @if($article->about_author != '')
                <div id="a_aboutauthor_container" class="pl-1 text-right">
                    <hr>
                    <h4 class="An_Dm_bold">دلیکوال په اړه</h4>
                    <small><p class="text-break">{{ $article->about_author }}</p></small>
                </div>
            @endif
            @if ($article->about_article != '')            
            <div id="a_aboutarticle_container" class="pl-1 mt-5 text-right">
                <hr>
                <h4 class="An_Dm_bold">دمقاله په اړه  </h4>
                <small><p class="text-break">{{ $article->about_article }}</p></small>
            </div>
            @endif
        @endif
        </div>
    </div>








   <!-- Article Modal -->
   <div class="modal fade  bg--opcity pr-0  " id="articlemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  " style=" max-width: 800px !important;" role="document">
        <div class="modal-content p-0 border-0">
            <div class="modal-header text-center  bg--two align-items-center border-0 py-2 ">
                <h4 class=" mb-0 text-white text-center w-100 an_bold pt-2" id="exampleModalLabel">Edit Article </h5>
                    <a href="javascript:void(0)" class="bg-danger rounded" style="width:25px;"><i class=" text-white" data-dismiss="modal">&times;</i></a>
            </div> 
            <div class="modal-body articlemodal bg--four rounded">
                <form class="px-4" id="articleform" action="{{ route('article.update',$article->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleInputEmail1"><b class="an_bold" id="lbl_a_name">Article Full Name </label> <span class="text-danger">*</span></b>
                        <input value="{{ $article->title }}" type="text" class="form-control  shadow rounded" placeholder="Article Full Name" id="a_name" name="a_name">
                        <span class="text-danger a_name ml-2"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_author">Author </label> <span class="text-danger">*</span></b>
                        <input value="{{ $article->author }}" type="text" class="form-control  shadow rounded" id="a_author" aria-describedby="emailHelp" name="a_author"  placeholder="Author Full Name">
                        <span class="text-danger a_author ml-2"></span>
                    </div>
                    <div class="form-group row  mx-0 ">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 pr-lg-5 p-0">
                            <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_page">Number of Pages and Chapters </label><span class="text-danger">*</span></b>
                            <div class="row mx-0">
                                <div class="bg-light p-2 rounded shadow d-flex w-100 ">
                                    <div class="d-flex align-items-center w-100 ">

                                        <input required value="{{ $article->pages }}" type="number" min="1" class="form-control form-control-sm  bg--four  " id="a_page" name="a_page" aria-describedby="emailHelp" placeholder="0 ... ">
                                        <label for="exampleInputEmail1" class="mb-0 mx-1 pr-3 " id="lbl_a_pages">Pages</label>
                                    </div>
                                    <div class="d-flex align-items-center w-100  ">
                                        <input required value="{{ $article->chapter }}" type="number" min="1" class="form-control form-control-sm  bg--four  " id="a_chapter" aria-describedby="emailHelp" name="a_chapter" placeholder="0 ...">
                                        <label for="exampleInputEmail1" class="mb-0 mx-1" id="lbl_a_chapter">Chapters</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-6 pl-0 pr-lg-5 mt-3 mt-lg-0 mt-md-0">
                            <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_edition">Edition </label><span class="text-danger">*</span></b>
                            <div class="row mx-0">
                                <div class="bg-light p-2 rounded shadow d-flex b">
                                    <div class="d-flex align-items-center ">
                                        <select required name="a_edition" id="a_edition" class="bg--four border-0 p-1 rounded">
                                            <option value="1st">1st</option>
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
                        <div class="col-lg-4 col-md-3 col-sm-6 col-6 pl-0  pr-0 mt-3 mt-lg-0 mt-md-0 "> <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_publish">Year of publish </label><span class="text-danger">*</span></b>

                            <div class="bg-light p-2 rounded shadow w-100">
                                <div class="d-flex align-items-center ">
                                    <input value="{{ $article->publish_date }}" required type="date" class="form-control form-control-sm  bg--four w-100 " name="a_publish" id="a_publish" aria-describedby="emailHelp" placeholder="0 ... ">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_aboutauthor">About Author</b> <small>(optional)</small></label>
                        <textarea value="{{ $article->about_author }}" maxlength="1000" class="form-control form-control-sm rounded shadow" name="a_aboutauthor" placeholder="short biography in 1000 letter" id="a_aboutauthor" rows="6"></textarea>
                        <div class="text-right pr-3 pt-2 text-muted">
                            <h6><span id="authorcounter">0</span>/1000</h6>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_aboutarticle">About Article </b> <small>(optional)</small> </label>
                        <textarea value="{{ $article->about_article }}" maxlength="1000" class="form-control form-control-sm rounded shadow" name="a_aboutarticle" placeholder="Explain article briefly in 1000 letter" id="a_aboutarticle" rows="6"></textarea>
                        <div class="text-right pr-3 pt-2 text-muted">

                            <h6><span id="articlecounter">0</span>/1000</h6>

                        </div>
                    </div>

                    <div class="alert alert-danger a_exist_error mt-2 invisible">This Article has already been registered</div>
                    <div class="row ml-auto w-100 justify-content-end mr-5 mt-3">
                        <button type="submit" class="btn btn-primary bg--two border-0 py-1 btn-sm " style="width:120px !important" id="a_lbl_finish">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->





 <!-- The Delete Modal -->
 <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header bg-danger">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="{{ route("article.destroy",$article->id) }}" method="POST">
            @csrf
            @method('DELETE')
        <!-- Modal body -->
        <div class="modal-body">
          Do you Want to delete this article?
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
          <input type="submit" class="btn btn-danger" value="Delete">
        </div>
        </form>
      </div>
    </div>
  </div>
  {{-- End of Modal --}}





<!-- The Approve Modal -->
<div class="modal fade" id="approvemodal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header bg-secondary">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <h5>Are you sure to  approve this article?</h3>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button id="approve" type="button" class="btn btn-primary" data-dismiss="modal">Approve</button>
        </div>
      </div>
    </div>
  </div>
  {{-- End of Modal --}}








@endsection

@push('script')
    <script src="{{ asset('app/js/article/backend/article-update.js') }}"></script>
@endpush