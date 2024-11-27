@extends('layouts.frontend')
@section('content')

<section class="py-5 px-4 bg--eight ">
        <div class="container bg--map" style="background-image:url({{ asset('asset/images/Map.png') }})">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-6 p-0 mb-5 pb-5">
                    <div class=" mt-5 mb-2 ml-lg-5 pb-5 mb-5">
                        <a href="https://goo.gl/maps/W8QrcM8EbndZfaoF7" target="_blank" class="bg--opcity rounded shadow text--four nav-link py-0 pl-2">Look at google maps _____</a>
                    </div>
                </div>
                <div class="col-lg-4 mt-5  mt-lg-0 mt-md-0 ml-auto border shadow bg--opcity rounded shadow py-4 px-0">
                    <p class="p-2 pl-4 text--four An_Dm_bold">Tell us about your issue so we can <br> help you more quickly.</p>
                    <div class=" text--four">
                        <form id="ContactForm">
                            @csrf
                            <div class="form-group mx-3 px-4 ">
                                <input required name="fullname" type="text" class="form-control form-control-sm  bg-transparent text-light border-top-0 border-right-0 border-left-0  rounded-0 p-0" id="FullName" aria-describedby="Full Name" placeholder="Your full name">
                            </div>
                            <div class="form-group  mx-3 px-4">
                                <input required name="email" id="Email" type="email" class="form-control form-control-sm  bg-transparent text-light border-top-0 border-right-0 border-left-0  rounded-0 p-0" aria-describedby="emailHelp" placeholder="Your email">
                            </div>
                            <div class="form-group mx-3 px-4 ">
                                <input required type="tel" pattern="0[1-9]{9}" id="Phone" name="phone" class="form-control form-control-sm  bg-transparent text-light border-top-0 border-right-0 border-left-0  rounded-0 p-0" aria-describedby="Phone" placeholder="Your phone number">
                            </div>
                            <div class="form-group  mx-3 px-4 ">
                                <textarea required id="Message" name="message" class="form-control form-control-sm  bg-transparent text-light border-top-0 border-right-0 border-left-0  rounded-0 p-0 " placeholder="Your message" rows="8"></textarea>
                            </div>
                            <div class=" d-flex justify-content-between my-1 pb-1 align-items-center">
                                <button id="submitbtn" type="submit" class="related-article  btn btn-primary ml-auto bg-white text-muted border-0 shadow   rounded-0  mx-0 d-flex align-items-center An_light" style="width:140px; border-top-left-radius: 10px!important;
                            border-bottom-left-radius: 10px !important; ">Send message <i class="fa fa-angle-right  pl-2 "></i> </button>
                            </div>
                        </form>
                    </div>
                    <div class="text-center text--four invisible" id="sentmsg"> Message Sent</div>

                    <div class="text-center my-2 ">
                        <a href="#"><img src="{{ asset('asset/Icons/facebook icon.png') }}" class="p-2 bg--six rounded mx-1" width="40px" alt=""></a>
                        <a href="#"><img src="{{ asset('asset/Icons/instagram icon.png') }}" class="p-2 bg--six rounded mx-1" width="40px" alt=""></a>
                        <a href="#"><img src="{{ asset('asset/Icons/youtube icon.png') }}" class="px-2 bg--six rounded mx-1" style="padding-top: 11px; padding-bottom: 11px;" width="40px" alt=""></a>
                        <a href="#"><img src="{{ asset('asset/Icons/website icon.png') }}" class="p-2 bg--six rounded mx-1" width="40px" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg--opcity pb-5 ">
        <div class="container  ">
            <div class="row py-5 text--four justify-content-center">
                <div class="col-lg-6 col-md-6 col-12 col-sm-6 mb-4 mb-lg-0 mb-md-0 text-center">
                    <h6 class=" mb-0 An_Dm_bold">Our Email address
                        <hr class="bg-light w-25 p-0 mb-0 mt-1">
                    </h6>
                    <a href="#" class="nav-link p-0  text--four">SalamLibrary@salam.af</a>
                </div>

                <div class="col-lg-6 col-md-6 col-12 col-sm-6 text-center">
                    <h6 class=" mb-0 An_Dm_bold">Our Tel Number
                        <hr class="bg-light w-25 p-0 mb-0 mt-1">
                    </h6>
                    <a href="#" class="nav-link p-0 text--four">+93 73 00 24 302</a>
                </div>
            </div>
            <div class="row  text--four justify-content-center">
                <div class="col-lg-6 col-md-6 col-12 col-sm-6 mb-4 mb-lg-0 mb-md-0  text-center">
                    <h6 class="  mb-0 An_Dm_bold">Our Physical address
                        <hr class="bg-light w-25 p-0 mb-0 mt-1">
                    </h6>
                    <a href="#" class="nav-link p-0 text--four">kulola Pushta, Gul Surkh Squair</a>
                </div>

                <div class="col-lg-6 col-md-6 col-12 col-sm-6 text-center">
                    <h6 class="  mb-0 An_Dm_bold">Work Hours
                        <hr class="bg-light w-25 p-0 mb-0 mt-1">
                    </h6>
                    <p class=" p-0 m-0 text--four">8am - 8pm (KBL), Saturday - Thursday </p>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('script')
    <script src="{{ asset('app/js/contact/frontend/contact-form.js') }}"></script>
@endpush