<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Salam Digital Library</title>
        <script src="{{ asset('js/jquery.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.min.css') }}">
        {{-- Select2 style --}}
        <link rel="stylesheet" href="{{ asset('asset/select2.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('asset/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
        
        <link rel="stylesheet" href="{{ asset('asset/plugins/jsgrid/jsgrid-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/plugins/jsgrid/jsgrid.min.css') }}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset('asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- JQVMap -->
        <link rel="stylesheet" href="{{ asset('asset/plugins/jqvmap/jqvmap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.min.css') }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset('asset/plugins/daterangepicker/daterangepicker.css') }}">
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('asset/plugins/summernote/summernote-bs4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css-2/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css-2/fontawesome-free-5.11.2-web/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css-2/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">
</head>

<body style=" background: url( {{ asset('asset/images/bg-login.jpg') }} )  fixed 50% 50%  ; background-size: cover;">

    <section>

        <div class="container">
            <div class=" row justify-content-center text-center text-light">
                <div class="mt-lg-1 pt-lg-1 pt-2">
                    <a class="navbar-brand  text--five ml-2 mr-0 d-none d-lg-block " href="/index.html">
                        <h1 class="mb-0 pb-0 An_Dm_bold text--four">Salam Digital <span class="an_bold">Library</span></h1>
                    </a>
                    <p class="mb-0 An_trial text--four">Registering to this Library, you accept our <a href="#"
                            class="text--four "><b>Terms of use</b> <br> </a> and our <a href="#"
                            class="text--four"><b>Privacy policy</b></a></p>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-9">
                    <div class="bg-light" style=" border-radius: 10px;">
                        <form action="/register" method="POST" enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <div class="d-flex justify-content-center align-items-center d-block pt-4 pb-0 px-2"
                                style="flex-direction:column">
                                <label for="image" c style="cursor:pointer">
                                    <input type="file" class="d-none" name="image" id="image">
                                    <img id="user_img" src="{{ asset('asset/images/placeholder.jpg') }}"
                                        placeholder="add photo" style="border:3px solid #00A1F1; padding:3px;"
                                        class=" rounded-circle  image-fluid" alt="" width="140" height="140">
                                </label>
                                <span class="text-danger small">
                                    @error('image')
                                    {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class=" px-4 ">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <div style="margin-bottom:0%;"
                                                    class="mt-3  form-group d-flex border align-items-center rounded shadow ">
                                                    <input max="100" value="{{ old('name') }}" min="1" type="text" name="name"
                                                        class="form-control form-control  border-0 px-2" id="name"
                                                         placeholder="First Name">
                                                </div>
                                                <span class="ml-2 text-danger small">
                                                    @error('name')
                                                    {{ $message }}
                                                    @enderror
                                                </span>

                                            </div>
                                            <div class="col-6">
                                                <div style="margin-bottom:0%;"
                                                    class="mt-3 form-group d-flex border align-items-center rounded shadow ">
                                                    <input max="100" min="1" type="text" name="last_name" value="{{ old('last_name') }}"
                                                        class="form-control   border-0 px-2" id="lastname"
                                                        aria-describedby="emailHelp" placeholder="Last Name">
                                                </div>
                                                <span class="ml-2 text-danger small">
                                                    @error('last_name')
                                                    {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div style="margin-bottom:0%;"
                                                    class="mt-3 form-group d-flex border align-items-center rounded shadow ">
                                                    <input type="text" max="100" min="1" name="occupation" value="{{ old('occupation') }}"
                                                        class="form-control   border-0" id="occupation"
                                                        placeholder="Occupation">
                                                </div>
                                                <span class="ml-2 text-danger small">
                                                    @error('occupation')
                                                    {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="col-6">
                                                <div style="margin-bottom:0%;"
                                                    class="mt-3 form-group d-flex border align-items-center rounded shadow ">
                                                    <small><i class="fa fa-location-arrow px-2 text--three"></i></small>
                                                                <select required class="form-control" name="live_in" id="live" value="{{ old('live_in') }}" style="border:none;">
                                                                        <option value="">Live in</option>
                                                                            <option value="Afghanistan
                                                                            ">Afghanistan
                                                                            </option><option value="Albania
                                                                            ">Albania
                                                                            </option><option value="Algeria
                                                                            ">Algeria
                                                                            </option><option value="Andorra
                                                                            ">Andorra
                                                                            </option><option value="Angola
                                                                            ">Angola
                                                                            </option><option value="Antigua
                                                                            ">Antigua
                                                                            </option><option value="Argentina
                                                                            ">Argentina
                                                                            </option><option value="Armenia
                                                                            ">Armenia
                                                                            </option><option value="Australia
                                                                            ">Australia
                                                                            </option><option value="Austria
                                                                            ">Austria
                                                                            </option><option value="Azerbaijan
                                                                            ">Azerbaijan
                                                                            </option><option value="Bahamas
                                                                            ">Bahamas
                                                                            </option><option value="Bahrain
                                                                            ">Bahrain
                                                                            </option><option value="Bangladesh
                                                                            ">Bangladesh
                                                                            </option><option value="Barbados
                                                                            ">Barbados
                                                                            </option><option value="Belarus
                                                                            ">Belarus
                                                                            </option><option value="Belgium
                                                                            ">Belgium
                                                                            </option><option value="Belize
                                                                            ">Belize
                                                                            </option><option value="Benin
                                                                            ">Benin
                                                                            </option><option value="Bhutan
                                                                            ">Bhutan
                                                                            </option><option value="Bolivia
                                                                            ">Bolivia
                                                                            </option><option value="Bosnia
                                                                            ">Bosnia
                                                                            </option><option value="Botswana
                                                                            ">Botswana
                                                                            </option><option value="Brazil
                                                                            ">Brazil
                                                                            </option><option value="Brunei
                                                                            ">Brunei
                                                                            </option><option value="Bulgaria
                                                                            ">Bulgaria
                                                                            </option><option value="Burkina Faso
                                                                            ">Burkina Faso
                                                                            </option><option value="Burundi
                                                                            ">Burundi
                                                                            </option><option value="Côte d'Ivoire
                                                                            ">Côte d'Ivoire
                                                                            </option><option value="Cabo Verde
                                                                            ">Cabo Verde
                                                                            </option><option value="Cambodia
                                                                            ">Cambodia
                                                                            </option><option value="Cameroon
                                                                            ">Cameroon
                                                                            </option><option value="Canada
                                                                            ">Canada
                                                                            </option><option value="Central African Republic
                                                                            ">Central African Republic
                                                                            </option><option value="Chad
                                                                            ">Chad
                                                                            </option><option value="Chile
                                                                            ">Chile
                                                                            </option><option value="China
                                                                            ">China
                                                                            </option><option value="Colombia
                                                                            ">Colombia
                                                                            </option><option value="Comoros
                                                                            ">Comoros
                                                                            </option><option value="Congo
                                                                            ">Congo
                                                                            </option><option value="Costa Rica
                                                                            ">Costa Rica
                                                                            </option><option value="Croatia
                                                                            ">Croatia
                                                                            </option><option value="Cuba
                                                                            ">Cuba
                                                                            </option><option value="Cyprus
                                                                            ">Cyprus
                                                                            </option><option value="Czechia
                                                                            ">Czechia
                                                                            </option><option value="Democratic Republic of the Congo
                                                                            ">Democratic Republic of the Congo
                                                                            </option><option value="Denmark
                                                                            ">Denmark
                                                                            </option><option value="Djibouti
                                                                            ">Djibouti
                                                                            </option><option value="Dominica
                                                                            ">Dominica
                                                                            </option><option value="Dominican Republic
                                                                            ">Dominican Republic
                                                                            </option><option value="Ecuador
                                                                            ">Ecuador
                                                                            </option><option value="Egypt
                                                                            ">Egypt
                                                                            </option><option value="El Salvador
                                                                            ">El Salvador
                                                                            </option><option value="Equatorial Guinea
                                                                            ">Equatorial Guinea
                                                                            </option><option value="Eritrea
                                                                            ">Eritrea
                                                                            </option><option value="Estonia
                                                                            ">Estonia
                                                                            </option><option value="Eswatini
                                                                            ">Eswatini
                                                                            </option><option value="Ethiopia
                                                                            ">Ethiopia
                                                                            </option><option value="Fiji
                                                                            ">Fiji
                                                                            </option><option value="Finland
                                                                            ">Finland
                                                                            </option><option value="France
                                                                            ">France
                                                                            </option><option value="Gabon
                                                                            ">Gabon
                                                                            </option><option value="Gambia
                                                                            ">Gambia
                                                                            </option><option value="Georgia
                                                                            ">Georgia
                                                                            </option><option value="Germany
                                                                            ">Germany
                                                                            </option><option value="Ghana
                                                                            ">Ghana
                                                                            </option><option value="Greece
                                                                            ">Greece
                                                                            </option><option value="Grenada
                                                                            ">Grenada
                                                                            </option><option value="Guatemala
                                                                            ">Guatemala
                                                                            </option><option value="Guinea
                                                                            ">Guinea
                                                                            </option><option value="Guinea-Bissau
                                                                            ">Guinea-Bissau
                                                                            </option><option value="Guyana
                                                                            ">Guyana
                                                                            </option><option value="Haiti
                                                                            ">Haiti
                                                                            </option><option value="Holy See
                                                                            ">Holy See
                                                                            </option><option value="Honduras
                                                                            ">Honduras
                                                                            </option><option value="Hungary
                                                                            ">Hungary
                                                                            </option><option value="Iceland
                                                                            ">Iceland
                                                                            </option><option value="India
                                                                            ">India
                                                                            </option><option value="Indonesia
                                                                            ">Indonesia
                                                                            </option><option value="Iran
                                                                            ">Iran
                                                                            </option><option value="Iraq
                                                                            ">Iraq
                                                                            </option><option value="Ireland
                                                                            ">Ireland
                                                                            </option><option value="Israel
                                                                            ">Israel
                                                                            </option><option value="Italy
                                                                            ">Italy
                                                                            </option><option value="Jamaica
                                                                            ">Jamaica
                                                                            </option><option value="Japan
                                                                            ">Japan
                                                                            </option><option value="Jordan
                                                                            ">Jordan
                                                                            </option><option value="Kazakhstan
                                                                            ">Kazakhstan
                                                                            </option><option value="Kenya
                                                                            ">Kenya
                                                                            </option><option value="Kiribati
                                                                            ">Kiribati
                                                                            </option><option value="Kuwait
                                                                            ">Kuwait
                                                                            </option><option value="Kyrgyzstan
                                                                            ">Kyrgyzstan
                                                                            </option><option value="Laos
                                                                            ">Laos
                                                                            </option><option value="Latvia
                                                                            ">Latvia
                                                                            </option><option value="Lebanon
                                                                            ">Lebanon
                                                                            </option><option value="Lesotho
                                                                            ">Lesotho
                                                                            </option><option value="Liberia
                                                                            ">Liberia
                                                                            </option><option value="Libya
                                                                            ">Libya
                                                                            </option><option value="Liechtenstein
                                                                            ">Liechtenstein
                                                                            </option><option value="Lithuania
                                                                            ">Lithuania
                                                                            </option><option value="Luxembourg
                                                                            ">Luxembourg
                                                                            </option><option value="Madagascar
                                                                            ">Madagascar
                                                                            </option><option value="Malawi
                                                                            ">Malawi
                                                                            </option><option value="Malaysia
                                                                            ">Malaysia
                                                                            </option><option value="Maldives
                                                                            ">Maldives
                                                                            </option><option value="Mali
                                                                            ">Mali
                                                                            </option><option value="Malta
                                                                            ">Malta
                                                                            </option><option value="Marshall Islands
                                                                            ">Marshall Islands
                                                                            </option><option value="Mauritania
                                                                            ">Mauritania
                                                                            </option><option value="Mauritius
                                                                            ">Mauritius
                                                                            </option><option value="Mexico
                                                                            ">Mexico
                                                                            </option><option value="Micronesia
                                                                            ">Micronesia
                                                                            </option><option value="Moldova
                                                                            ">Moldova
                                                                            </option><option value="Monaco
                                                                            ">Monaco
                                                                            </option><option value="Mongolia
                                                                            ">Mongolia
                                                                            </option><option value="Montenegro
                                                                            ">Montenegro
                                                                            </option><option value="Morocco
                                                                            ">Morocco
                                                                            </option><option value="Mozambique
                                                                            ">Mozambique
                                                                            </option><option value="Myanmar
                                                                            ">Myanmar
                                                                            </option><option value="Namibia
                                                                            ">Namibia
                                                                            </option><option value="Nauru
                                                                            ">Nauru
                                                                            </option><option value="Nepal
                                                                            ">Nepal
                                                                            </option><option value="Netherlands
                                                                            ">Netherlands
                                                                            </option><option value="New Zealand
                                                                            ">New Zealand
                                                                            </option><option value="Nicaragua
                                                                            ">Nicaragua
                                                                            </option><option value="Niger
                                                                            ">Niger
                                                                            </option><option value="Nigeria
                                                                            ">Nigeria
                                                                            </option><option value="North Korea
                                                                            ">North Korea
                                                                            </option><option value="North Macedonia
                                                                            ">North Macedonia
                                                                            </option><option value="Norway
                                                                            ">Norway
                                                                            </option><option value="Oman
                                                                            ">Oman
                                                                            </option><option value="Pakistan
                                                                            ">Pakistan
                                                                            </option><option value="Palau
                                                                            ">Palau
                                                                            </option><option value="Palestine State
                                                                            ">Palestine State
                                                                            </option><option value="Panama
                                                                            ">Panama
                                                                            </option><option value="Papua New Guinea
                                                                            ">Papua New Guinea
                                                                            </option><option value="Paraguay
                                                                            ">Paraguay
                                                                            </option><option value="Peru
                                                                            ">Peru
                                                                            </option><option value="Philippines
                                                                            ">Philippines
                                                                            </option><option value="Poland
                                                                            ">Poland
                                                                            </option><option value="Portugal
                                                                            ">Portugal
                                                                            </option><option value="Qatar
                                                                            ">Qatar
                                                                            </option><option value="Romania
                                                                            ">Romania
                                                                            </option><option value="Russia
                                                                            ">Russia
                                                                            </option><option value="Rwanda
                                                                            ">Rwanda
                                                                            </option><option value="Saint Kitts
                                                                            ">Saint Kitts
                                                                            </option><option value="Saint Lucia
                                                                            ">Saint Lucia
                                                                            </option><option value="Saint Vincent
                                                                            ">Saint Vincent
                                                                            </option><option value="Samoa
                                                                            ">Samoa
                                                                            </option><option value="San Marino
                                                                            ">San Marino
                                                                            </option><option value="Sao Tome
                                                                            ">Sao Tome
                                                                            </option><option value="Saudi Arabia
                                                                            ">Saudi Arabia
                                                                            </option><option value="Senegal
                                                                            ">Senegal
                                                                            </option><option value="Serbia
                                                                            ">Serbia
                                                                            </option><option value="Seychelles
                                                                            ">Seychelles
                                                                            </option><option value="Sierra Leone
                                                                            ">Sierra Leone
                                                                            </option><option value="Singapore
                                                                            ">Singapore
                                                                            </option><option value="Slovakia
                                                                            ">Slovakia
                                                                            </option><option value="Slovenia
                                                                            ">Slovenia
                                                                            </option><option value="Solomon Islands
                                                                            ">Solomon Islands
                                                                            </option><option value="Somalia
                                                                            ">Somalia
                                                                            </option><option value="South Africa
                                                                            ">South Africa
                                                                            </option><option value="South Korea
                                                                            ">South Korea
                                                                            </option><option value="South Sudan
                                                                            ">South Sudan
                                                                            </option><option value="Spain
                                                                            ">Spain
                                                                            </option><option value="Sri Lanka
                                                                            ">Sri Lanka
                                                                            </option><option value="Sudan
                                                                            ">Sudan
                                                                            </option><option value="Suriname
                                                                            ">Suriname
                                                                            </option><option value="Sweden
                                                                            ">Sweden
                                                                            </option><option value="Switzerland
                                                                            ">Switzerland
                                                                            </option><option value="Syria
                                                                            ">Syria
                                                                            </option><option value="Tajikistan
                                                                            ">Tajikistan
                                                                            </option><option value="Tanzania
                                                                            ">Tanzania
                                                                            </option><option value="Thailand
                                                                            ">Thailand
                                                                            </option><option value="Timor-Leste
                                                                            ">Timor-Leste
                                                                            </option><option value="Togo
                                                                            ">Togo
                                                                            </option><option value="Tonga
                                                                            ">Tonga
                                                                            </option><option value="Trinidad
                                                                            ">Trinidad
                                                                            </option><option value="Tunisia
                                                                            ">Tunisia
                                                                            </option><option value="Turkey
                                                                            ">Turkey
                                                                            </option><option value="Turkmenistan
                                                                            ">Turkmenistan
                                                                            </option><option value="Tuvalu
                                                                            ">Tuvalu
                                                                            </option><option value="Uganda
                                                                            ">Uganda
                                                                            </option><option value="Ukraine
                                                                            ">Ukraine
                                                                            </option><option value="United Arab Emirates
                                                                            ">United Arab Emirates</option>
                                                                            <option value="United Kingdom">United Kingdom</option>
                                                                            <option value="United States of America">United States of America</option>
                                                                            <option value="Uruguay">Uruguay</option>
                                                                            <option value="Uzbekistan">Uzbekistan</option>
                                                                            <option value="Vanuatu">Vanuatu</option>
                                                                            <option value="Venezuela">Venezuela</option>
                                                                            <option value="Vietnam">Vietnam
                                                                            </option><option value="Yemen">Yemen</option>
                                                                            <option value="Zambia">Zambia</option>
                                                                            <option value="Zimbabwe">Zimbabwe</option>
                                                                    </select>
                                                </div>
                                                
                                                <span class="ml-2 text-danger small">
                                                    @error('live_in')
                                                    {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div style="margin-bottom:0%;"
                                                    class="mt-3 form-group d-flex border align-items-center rounded shadow ">
                                                    <small><i class="fa fa-envelope px-2 text--three"></i></small>
                                                    <input max="100" min="1" type="email" name="email" value="{{ old('email') }}"
                                                        class="form-control   border-0 px-0" id="email"
                                                        aria-describedby="emailHelp" placeholder="Email">
                                                </div>
                                                <span class="ml-2 text-danger small">
                                                    @error('email')
                                                    {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="col-6">
                                                <div style="margin-bottom:0%;"
                                                    class="mt-3 form-group d-flex border align-items-center rounded shadow ">
                                                    <small><i class="fa fa-phone-alt px-2 text--three"></i></small>
                                                    <input  max="15" min="10" pattern="^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$" type="tel" name="phone" value="{{ old('phone') }}"
                                                        class="form-control   border-0 px-0" id="phone"
                                                        placeholder="Phone">
                                                </div>
                                                <span class="ml-2 text-danger small">
                                                    @error('phone')
                                                    {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div style="margin-bottom:0%;"
                                                    class="mt-3 form-group d-flex border align-items-center rounded shadow ">
                                                    <small><i class="fa fa-lock px-2 text--three"></i></small>
                                                    <input max="100" min="1" name="password" type="password"
                                                        class="form-control   border-0 px-0" id="password"
                                                        placeholder="Password">
                                                </div>
                                                <span class="ml-2 text-danger small">
                                                    @error('password')
                                                    {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="col-6">
                                                <div style="margin-bottom:0%;"
                                                    class="mt-3 form-group d-flex border align-items-center rounded shadow "
                                                    style="margin-bottom:0%;">
                                                    <small><i class="fa fa-lock px-2 text--three"></i></small>
                                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                                        class="form-control   border-0 px-0" 
                                                        placeholder="Confirm Password">
                                                </div>
                                                <span class="ml-2 text-danger small">
                                                    @error('passwor_confirmation')
                                                    {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <button class="btn btn-primary bg--two w-100 border-0 shadow mt-3 an_bold "><strong>Sign
                                        Up</strong></button>
                                <div class="text-center  mt-2 mb-4 pb-3">
                                    <p class="m-0 p-0 d-flex align-items-center justify-content-center An_Dm_bold ">
                                        <small>Already have an account?</small>
                                        <a href="{{ route('login') }}" class="text--two nav-link  p-0 mx-1  an_bold"><b>Log
                                                in</b></a>
                                    </p>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>


    </section>
<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('asset/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('asset/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('asset/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('asset/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('asset/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('asset/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('asset/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('asset/dist/js/adminlte.js') }}"></script>

<script src="{{ asset('asset/plugins/jsgrid/jsgrid.min.js') }}"></script>
<script src="{{ asset('asset/plugins/jsgrid/demos/db.js') }}"></script>
<script src="{{ asset('asset/select2.min.js') }}"></script>
<script src="{{ asset('css-2/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('css-2/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js') }}"></script>
        <script>
            var img = "{{ asset('asset/images/placeholder.jpg') }}"
        </script> 
    <script src="{{ asset('app/js/users/register.js') }}"></script>
    <script>
   $('#live').select2({
        placeholder: 'Live in',
        tags: true
    });
    </script>
</body>

</html>