@extends('layouts.master')
@section('style')
<style>
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  /* Hide default HTML checkbox */

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  /* The slider */

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */

  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
</style>
@endsection
@section('content')
<div class="container-fluid">
  <div
    style="display:none ; transition: right 2s; z-index:3 ; color:white; font-family: monospace; border-radius: 5px; outline-offset: 2px; border:2px solid #55ACEE; outline:2px solid #55ACEE; width:300px; height:50px; background: #4285F4; position:absolute; right:-350px; top:150px"
    class=" toast-success  pt-3">
    <p class="" style="font-size: 25px; position:relative; left:23px; bottom:10px">Saved Successfully </p>
  </div>
  <div class="card card-secondary mt-2">
    <div class="card-header">
      <h3 class="card-title"> Admin Registration Form</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body mb-0">
      <form action="{{ route('admin.store') }}" method="POST" id="admin_form">
        <div class="form-group">
          @csrf
          <label for="exampleInputFile">Photo</label>
          <div class="input-group">
            <input id="pic" type="file" class="custom-file-input" name="image">
            <label id="label" class="custom-file-label" for="exampleInputFile">Choose Image</label>
          </div>

        </div>
        <span class="ml-2 text-danger image_error"></span>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="name">Name</label>
              <input id="name" type="text" class="form-control" name="name" placeholder="name">
              <span class="ml-2 text-danger name_error"></span>
            </div>

            <div class="form-group">
              <label for="lastname">Last Name</label>
              <input id="lastname" type="text" class="form-control" name="lastname" placeholder="last name">
              <span class="ml-2 text-danger lastname_error"></span>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input id="email" type="email" class="form-control" name="email" placeholder="email">
              <span class="ml-2 text-danger email_error"></span>
            </div>


            <div class="form-group">
              <label for="occupation">Occupation</label>
              <input id="occupation" type="text" class="form-control" name="occupation" placeholder="occupation">
              <span class="ml-2 text-danger occupation_error"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="live">Live in</label>
              <select  class="custom-select" name="live" id="live" value="{{ old('live') }}" style="border:none;">
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
              <span class="ml-2 text-danger live_error"></span>
            </div>
             <br>
            <div class="form-group">
              <label> Phone</label>
              <input id="phone" type="tel" class="form-control" name="phone" placeholder="phone">
              <span class="ml-2 text-danger phone_error"></span>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input id="password" type="password" class="form-control" name="password" placeholder="pasword">
              <span class="ml-2 text-danger password_error"></span>
            </div>
            <div class="form-group">
              <label for="password_confirmation">Confirm Password</label>
              <input id="password_confirmation" type="password" class="form-control" placeholder="repeat password" name="password_confirmation">
              <span class="ml-2 text-danger password_confirmation_error"></span>
            </div>
          </div>

        </div>


    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Register</button>
    </div>
    </form>

  </div>
  <!-- /.card-body -->


  <div class="row">
    <div class="col-12">
      <div class="card card-secondary">
        <div class="card-header bg-secondary">
          <h3 class="card-title">Admins</h3>

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control float-right" id="search" placeholder="Search">

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
          <table class="table table-hover table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>phone</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr id="{{ $user->id }}">
                <td>
                  <div class=""><img src="{{ asset('application/users/'.$user->image) }}" alt="user"
                      class="rounded img-fluid" width="45"></div>
                </td>
                <td>{{ ucfirst($user->name) }}</td>
                <td>{{ ucfirst($user->lastname) }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                @if($user->is_active)
                <td>
                  <label id="{{ $user->id }}" class="switch">
                    <input onclick="toggle(this)" type="checkbox" checked>
                    <span class="slider round"></span>
                  </label>
                </td>
                @else
                <td>
                  <label id="{{ $user->id }}" class="switch">
                    <input onclick="toggle(this)" type="checkbox">
                    <span class="slider round"></span>
                  </label>
                </td>
                @endif
                <td><a href="{{ route('admin.show',$user->id) }}"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
                  </a></td>
              </tr>
              @endforeach

            </tbody>

          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer d-flex justify-content-center">
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@push('script')
<script src="{{ asset('app/js/admin/index.js') }}"></script>
@endpush