<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Salam Digital Library </title>
        <link rel="icon" href="{{ asset('asset/images/icon.png') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/fontawesome-free-5.11.2-web/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/slider.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/lightslider.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/rating.css') }}">
        <script src="{{ asset('asset/plugins/jquery/jquery.js') }}"></script>
        <script src="{{ asset('js/lightsliders.js') }}"></script>
        @section('style')
        @show
        <style>
            span.tag{
                cursor: pointer;
            }
            span.tag:hover
            {
            opacity : 0.8   
            }
            span.tag:active
            {
                opacity ; 1
            }
        </style> 
    </head>
    <body>
            <header>
                    <div class="container-fluid  mt-5 ">
                        <div class="row align-items-center justify-content-center w-100 mt-3  mt-lg-0 mt-md-0 mb-3 ml-lg-5">
                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 mt-3">
                                <span class="navbar-brand d-flex justify-content-lg-center align-items-center  text--five ml-2 mr-0 d-none d-lg-block " href="/index.html">
                                    <h2 class="an_trial font-weight-normal">Salam<span class="an_bold">Library</span></h2>
                                </span>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-6 col-6 w-100 mt-3">
                                <nav class="navbar navbar-expand-lg navbar-light justify-content-end mt-0 ">
                                    
                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                    </button>

                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <ul class="navbar-nav">
                                            <li class="home nav-menu nav-item  text-center ">
                                                <a class="nav-link pb-0 An_trial  text-reset border border-top-0 border-left-0 border-bottom-0" href="{{ route('home') }}" style="font-size: 29px; ">Home</a>
                                            </li>
                                            <li class="books nav-menu nav-item text-center ">
                                                <a class=" nav-link  An_trial pb-0 text-reset border border-top-0 border-left-0 border-bottom-0" style="font-size: 29px; " href="{{ route('list.books') }}">Books </a>
                                            </li>
                                            <li class="audiobooks nav-menu nav-item text-center ">
                                                <a class=" nav-link text-reset  An_trial pb-0 border border-top-0 border-left-0 border-bottom-0" style="font-size: 29px;" href="{{ route('list.audiobooks') }}">AudioBook </a>
                                            </li>
                                            <li class="articles nav-menu nav-item text-center ">
                                                <a class=" nav-link text-reset An_trial pb-0 border border-top-0 border-left-0 border-bottom-0" style="font-size: 29px; " href="{{ route('list.articles') }}">Articles</a>
                                            </li>

                                            <li class="contact nav-menu nav-item text-center ">
                                                <a class=" nav-link An_trial text-reset pb-0 " style="font-size: 29px;" href="{{ route('contact') }}">Contact Us</a>
                                            </li>
                    
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-12 mt-2">
                                <div class="d-flex  w-100 mt-3 mt-lg-0  justify-content-between justify-content-lg-start  ">
                                    <!-- Sign up button
                                -->
                                @if(Auth::check())
                                    <a href="{{ route('profile',ucwords(Auth::user()->name).'.'.ucwords(Auth::user()->lastname)) }}" class="nav-link m-0 p-0"><button class="bg-light text--two rounded  py-2 px-4  ml-lg-1 ml-md-2 An_Dm_bold" style="font-size: 18px; border: 1.5px solid #006699 !important;"> Profile</button></a>
                                    <div class="dropdown bg--two rounded ml-2 An_Dm_bold">
                                            <button type="button" class=" pt-2 btn bg--two text-white dropdown-toggle" data-toggle="dropdown">
                                              Upload Book / Article
                                            </button>
                                            <div class="dropdown-menu ">
                                              <a class="dropdown-item" href="#articlemodal" data-toggle="modal">Upload Article</a>
                                              <a class="dropdown-item" href="#bookmodal" data-toggle="modal">Upload Book</a>
                                            </div>
                                          </div>
                                                                    <!-- Book Modal -->
                                                                    <div class="modal fade  bg--opcity pr-0  " id="bookmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                                        <div class="modal-dialog  " style=" max-width: 800px !important;" role="document">
                                                                            <div class="modal-content p-0 border-0">
                                                                                <div class="modal-header text-center  bg--two align-items-center border-0 py-2 ">
                                                                                    <h4 class=" mb-0 text-white text-center w-100 an_bold pt-2" id="exampleModalLabel">Add New Book </h5>
                                                                                        <a href="javascript:void(0)" data-dismiss="modal" class="text-decoration-none bg-danger rounded" style="width:25px;"><i class=" text-white" >&times;</i></a>
                                                                                </div> 
                                                                                <div class="modal-body bookmodal bg--four rounded">
                                                                                    <form class="px-4" id="bookform" action="{{ route('upload.book') }}" method="POST">
                                                                                        @csrf
                                                                                        <div class="form-group">
                                                                                            <label for="language" class="an_bold" id="b_lbl_language">Language</label>
                                                                                            <select required name="b_language" id="b_language" class="form-control">
                                                                                                <option id="b_lang" value="">Select Language</option>
                                                                                                <option value="pashto">پښتو</option>
                                                                                                <option value="english">English</option>
                                                                                                <option value="dari">دری</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="exampleInputEmail1"><b class="an_bold" id="lbl_b_name">Book Full Name</label><span class="text-danger">*</span></b>
                                                                                            <input type="text" class="form-control  shadow rounded" placeholder="Book Full Name" id="b_name" name="b_name">
                                                                                            <span class="text-danger b_name ml-2"></span>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_author">Author</label><span class="text-danger">*</span></b>
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
                                                                                                    <div class="bg-light p-2 rounded shadow d-flex ">
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
                                                                                            <div class="col-lg-4 col-md-3 col-sm-6 col-6 pl-0  pr-0 mt-3 mt-lg-0 mt-md-0 "> <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_publish">Year of publish </label><span class="text-danger"> *</span></b>
                                            
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
                                                                                                <h6><span id="b_authorcounter">0</span>/1000</h6>
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
                                                                                            <label for="exampleFormControlSelect1"><b  class="an_bold" id="lbl_b_catagory">Catagories </label><span class="text-danger">*</span></b>
                                                                                            <select required class="form-control" name="b_catagory" id="b_catagory">
                                                                                                @forelse ($catagories as $cat)
                                                                                                    <option value="{{ $cat->id }}">{{ $cat->ename }}</option>                                                                                                
                                                                                                @empty
                                                                                                    <option value="">No Data</option>                                                                                                
                                                                                                @endforelse
                                                                                            </select>
                                                                                            <span class="text-danger b_catagory ml-2"></span>
                                                                                        </div>
                                                                                        <div class="form-group mt-3">
                                                                                            <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_b_tag">Tags </label><span class="text-danger">*</span></b><small>(Minimum 1 and Muximum 5)</small>
                                                                                            <div style="height:250px; overflow:scroll" class=" p-4 bg-white shadow rounded row mx-0 b_tagcontainer" >
                                                                                                @forelse ($tags as $tag)
                                                                                                <span  class="book_tag bg--four px-2  rounded justify-content-center nav-link py-1  m-1  " style="height:30px !important;">{{ $tag->ename }}</span>
                                                                                                @empty  
                                                                                                @endforelse
                                                                                            </div>
                                                                                            <input type="hidden" id="b_tags_values" name="tags">
                                                                                            <span class="text-danger b_tag ml-2 float-left "></span>
                                                                                            <div class="text-right pr-3 pt-2 text-muted">
                                                                                                <h6><span id="b_tagcounter">0</span>/5</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="form-group w-75 col-4">
                                                                                                <div class="row">
                                                                                                <label for="exampleFormControlFile1"><b  class="an_bold" id="lbl_b_book">Book</b> <small>(pdf file)</small></label>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                        <label for="b_book" class="custom-file border-0 shadow rounded small bg--two mr-3 text-white  text-center pb-0 pt-1 " style="
                                                                                                        cursor: pointer;
                                                                                                        width:120px;" id="b_bookbutton">Upload 
                                                                                                            </label>
                                                                                                </div>
                                                                                                <div class="row p-2">
                                                                                                    <small class="b_book">*Note: PDF size should not be more then 60 MB</small>
                                                                                                    <input type="file" id="b_book" name="b_book" class="custom-file-input">
                                                                                                </div>
                                
                                                                                                <label for="exampleFormControlFile1" class="mt-3" id="b_lblbook">Uploaded :</label>
                                                                                                <span id="booknamelbl" class="font-italic d-block"></span>
                                                                                            
                                                                                            </div>
                                                
                                                                                            <div class="form-group w-75 col-4">
                                                                                                <div class="row">
                                                                                                        <label for="exampleFormControlFile1"><b class="an_bold" id="lbl_b_cover">Cover</b> <small>(jpg, png, jpeg)</small></label>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                        <label for="b_cover" class="custom-file border-0 shadow rounded small mt-0 bg--two mr-3 text-white text-center pb-0 pt-1 " style="
                                                                                                        cursor: pointer;
                                                                                                        width:120px !important;" id="b_coverbutton">Upload
                                                                                                        </label>
                                                                                                </div>
                                                                                                <div class="row p-2">
                                                                                                        <span class="custom-file-control"></span>
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
                                                                                                <div class="b_percent">0%</div>
                                                                                        </div>
                                                                                        <div class="alert alert-danger b_exist_error mt-2 invisible">This Book has already been registered</div>
                                                                                        <div class="row ml-auto w-100 justify-content-end mr-5 mt-3">
                                                                                            <button type="submit" class="btn btn-primary bg--two border-0  px-5 py-1 btn-sm " id="b_lbl_finish">Register</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- End Modal -->

                                                                    {{-- start of article modal --}}
                                                                    <!-- Article Modal -->
                                                                    <div class="modal fade  bg--opcity pr-0  " id="articlemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                                            <div class="modal-dialog  " style=" max-width: 800px !important;" role="document">
                                                                                <div class="modal-content p-0 border-0">
                                                                                    <div class="modal-header text-center  bg--two align-items-center border-0 py-2 ">
                                                                                        <h4 class=" mb-0 text-white text-center w-100 an_bold pt-2" id="exampleModalLabel">Add Article </h5>
                                                                                            <a href="javascript:void(0)" data-dismiss="modal" class="text-decoration-none bg-danger rounded" style="width:25px;"><i class=" text-white" >&times;</i></a>
                                                                                    </div> 
                                                                                    <div class="modal-body articlemodal bg--four rounded">
                                                                                        <form class="px-4" id="articleform" action="{{ route('upload.article') }}" method="POST">
                                                                                            @csrf
                                                                                            <div class="form-group">
                                                                                                <label for="language" class="an_bold" id="a_lbl_language">Language</label><b><span class="text-danger"> *</span></b>
                                                                                                <select required name="a_language" id="a_language" class="form-control">
                                                                                                    <option id="b_lang" value="">Select Language</option>
                                                                                                    <option value="pashto">پښتو</option>
                                                                                                    <option value="english">English</option>
                                                                                                    <option value="dari">دری</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="exampleInputEmail1"><b class="an_bold" id="lbl_a_name">Article Full Name </label><span class="text-danger"> *</span></b>
                                                                                                <input type="text" class="form-control  shadow rounded" placeholder="Article Full Title" id="a_name" name="a_name">
                                                                                                <span class="text-danger a_name ml-2"></span>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_author">Author </label><span class="text-danger"> *</span></b>
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

                                                                                                <div class="col-lg-4 col-md-3 col-sm-6 col-6 pl-0  pr-0 mt-3 mt-lg-0 mt-md-0 "> <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_publish">Year of publish <span class="text-danger">*</span></b></label>
                                                
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
                                                                                                    <h6><span id="a_authorcounter">0</span>/1000</h6>
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
                                                                                                <label for="exampleFormControlSelect1"><b  class="an_bold" id="lbl_a_catagory">Catagories <span class="text-danger">*</span></b></label>
                                                                                                <select required class="form-control" name="a_catagory" id="a_catagory">
                                                                                                    @forelse ($catagories as $cat)
                                                                                                        <option value="{{ $cat->id }}">{{ $cat->ename }}</option>                                                                                                
                                                                                                    @empty
                                                                                                        <option value="">No Data</option>                                                                                                
                                                                                                    @endforelse
                                                                                                </select>
                                                                                                <span class="text-danger a_catagory ml-2"></span>
                                                                                            </div>
                                                                                            <div class="form-group mt-3">
                                                                                                <label for="exampleInputEmail1"><b  class="an_bold" id="lbl_a_tag">Tags </b><span class="text-danger">*</span> <small>(Minimum 1 and Muximum 5)</small></label>
                                                                                                <div style="height:250px; overflow:scroll" class=" p-4 bg-white shadow rounded row mx-0 a_tagcontainer" >
                                                                                                    @forelse ($tags as $tag)
                                                                                                    <span  class="article_tag bg--four px-2  rounded justify-content-center nav-link py-1  m-1  " style="height:30px !important;">{{ $tag->ename }}</span>
                                                                                                    @empty  
                                                                                                    @endforelse
                                                                                                </div>
                                                                                                <input type="hidden" id="a_tags_values" name="tags">
                                                                                                <span class="text-danger a_tag ml-2 float-left "></span>
                                                                                                <div class="text-right pr-3 pt-2 text-muted">
                                                                                                    <h6><span id="a_tagcounter">0</span>/5</h6>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="form-group w-75 col-4">
                                                                                                    <div class="row">
                                                                                                    <label for="exampleFormControlFile1"><b  class="an_bold" id="lbl_a_article">Article</b> <small>(pdf file)</small></label>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                            <label for="a_article" class="custom-file border-0 shadow rounded small bg--two mr-3 text-white  text-center pb-0 pt-1 " style="
                                                                                                            cursor: pointer; width:120px;" id="a_articlebutton">Upload 
                                                                                                                </label>
                                                                                                    </div>
                                                                                                    <div class="row p-2">
                                                                                                        <small class="a_article">*Note: PDF size should not be more then 60 MB</small>
                                                                                                        <input type="file" id="a_article" name="a_article" class="custom-file-input">
                                                                                                    
                                                                                                    </div>

                                                                                                        <label  for="exampleFormControlFile1" class="mt-3" id="a_lblarticle">Uploaded :</label>
                                                                                                        <span id="articlenamelbl" class="font-italic d-block"></span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="progress mt-2 d-none">
                                                                                                    <div class="a_bar bg--two"></div>
                                                                                                    <div class="a_percent">0%</div>
                                                                                            </div>
                                                                                            <div class="alert alert-danger a_exist_error mt-2 invisible">This Book has already been registered</div>
                                                                                            <div class="row ml-auto w-100 justify-content-end mr-5 mt-3">
                                                                                                <button type="submit" class="btn btn-primary bg--two border-0  px-5 py-1 btn-sm " id="a_lbl_finish">Register</button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <!-- End Modal -->
                                @else
                                <a href="{{ route('register') }}"><button class="btn btn-primary bg--one border-0 py-2 px-3  ml-lg-2 ml-md-2 An_Dm_bold" style="font-size: 20px;">Sign up</button></a>
                                <a href="{{ route('login') }}"><button class="btn btn-primary bg--two border-0 py-2 px-3  ml-lg-2 ml-md-2 An_Dm_bold" style="font-size: 20px;">Log in</button></a>
                                @endif

                                </div>
                            </div>
                        </div>
                    </div>
            </header>
        @yield('content')
        @if(!Auth::check())
            <section class="bg--six ">
                <div class="container p-5">
                    <div class="row  w-100   justify-content-center">
                       <div class="col-lg-5  d-flex justify-content-between col-md-12 col-sm-12 col-12  ">
                        <a href="{{ route("register") }}"><button class="hover btn btn-danger bg--one border-0 text--five   px-5 An_Dm_bold " style="border-radius: 30px; font-size: 20px;">Sign Up</button></a>
                        <a href="{{ route("login") }}"> <button class="hover btn btn-danger bg--one border-0 text--five px-5  mt-lg-0  An_Dm_bold" style="border-radius: 30px; font-size: 20px;"><span class="px-1">Log in</span></button></a>
                    
                       </div>
                    </div>
                </div>
            </section>
        @endif
        <footer>
                <div class="bg--seven py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 pr-lg-4">
                                <h5 class="text--one An_Dm_bold">About Us</h5>
                                <span class="border--orange "></span>
                                <p class="text-white text-justify An_light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus maiores quam facere tempore adipisci reiciendis, quasi odio rerum necessitatibus quia error non. Quis, pariatur ducimus vitae consequuntur nostrum cum officiis.</p>
                            </div>
                            <div class="col-lg-4 pl-lg-5 pr-4">
                                <h5 class="text--one  An_Dm_bold">Terms and policy</h5>
                                <span class="border--orange "></span>
                                <ul class="text-light An_light pl-4 ">
                                    <li>Lorem ipsum dolor sit amet and we ...</li>
                                    <li>Lorem ipsum dolor sit amet and we to kanoe more it is ...</li>
                                    <li>Lorem ipsum dolor sit amet and we should know ...</li>
        
                                </ul>
                            </div>
                            <div class="col-lg-4 pl-lg-4">
                                <h5 class="text--one An_Dm_bold">Contact Us</h5>
                                <span class="border--orange "></span>
                                <p class="text-white text-justify An_light">Lorem ipsum dolor sit amet consectetur adip</p>
                                <div>
                                    <a href="#"><img src="{{ asset('asset/Icons/facebook icon.png') }}" class="p-2 bg--six rounded mx-1" width="40px" alt=""></a>
                                    <a href="#"><img src="{{ asset('asset/Icons/instagram icon.png') }}" class="p-2 bg--six rounded mx-1" width="40px" alt=""></a>
                                    <a href="#"><img src="{{ asset('asset/Icons/youtube icon.png') }}" class="px-2 bg--six rounded mx-1" style="padding-top: 11px; padding-bottom: 11px;" width="40px" alt=""></a>
                                    <a href="#"><img src="{{ asset('asset/Icons/website icon.png') }}" class="p-2 bg--six rounded mx-1" width="40px" alt=""></a>
                                </div>
                            </div>
        
                        </div>
                    </div>
                </div>
                <div class="bg--five p-3">
                    <div class="container">
                        <div class="row justify-content-center">
                            <p class="mb-0 text-white ">Copyright &copy Reserved by <a href="#"><b class="an_bold">ASOFT</b></a> | 2021</p>
                        </div> 
                    </div>
                </div>
        </footer>
        <script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
        <script src="{{ asset('asset/select2.min.js') }}"></script>
        <script src="{{ asset('css-2/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('css-2/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js') }}"></script>
        <script>
            var cover = "{{ asset('asset/images/placeholder1.png') }}"
            var json_tag =  {!!  json_encode($tags) !!}
            var json_catagory =  {!!  json_encode($catagories) !!}
    
        </script>
        <script src="{{ asset('asset/select2.min.js') }}"></script>
        <script src="{{ asset('/asset/form.js') }}"></script>
        <script src="{{ asset("app/js/book/frontend/book-form.js") }}"></script>
        <script src="{{ asset("app/js/article/frontend/article-form.js") }}"></script>
        <script src="{{ asset('asset/rating.js') }}"></script>
        <script>
            $(()=>{
                var menu = "{{ Route::currentRouteName() }}";
                menu = menu.split('.').pop();
                $(`.${menu}`).removeClass('nav-item').addClass('text--five')
                .append('<small><small><span class="fa fa-circle"></span></small></small>');
               
            })
        </script>
        @stack('script')
    </body>
</html>