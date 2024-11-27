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
  @yield('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="" alt="Salam Digital Library" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <!-- Messages Dropdown Menu -->
      <li  class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" id="notificationBox">
          <i class="fa fa-bell mr-2" ></i>
          @if(count(Auth::user()->unReadNotifications) > 0)
            <small><span class="badge badge-danger navbar-badge" id="badge">{{ count(Auth::user()->unReadNotifications) }}</span></small>
          @else
            <small><span class="badge badge-danger navbar-badge invisible" id="badge">0</span></small>
          @endif
        </a>
        <div id="notificationContainer" style="width:500px;" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          
          @forelse (Auth::user()->unreadNotifications as $notification)
          <div class="dropdown-divider"></div>
            @if($notification->data['type'] == 'message')
            <a href="{{ $notification->data['url'] }}" class="dropdown-item">
                <div class="media">
                  <div class="media-body">
                    <h4 class="dropdown-item-title text-break text-wrap">{{ $notification->data['email'] }}</h4>
                    <p class="text-sm">A new message from <strong>{{ $notification->data['name'] }}</strong></p>
                    <p class="text-sm text-wrap text-break">{{ $notification->data['message'] }}</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                  </div>
                  <small class="small"><i class="fa fa-sm fa-circle  text-success"></i></small>
                </div>
              </a>`
            @else
            <a href="{{ $notification->data['url'] }}" class="dropdown-item">
                <div class="media">
                  <img src="{{ asset('application/users/'.$notification->data['image']) }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h4 class="dropdown-item-title text-break text-wrap">{{ $notification->data['title'] }}</h4>
                  <p class="text-sm">A new {{ $notification->data['type'] }} was uploaded by <strong>{{ $notification->data['owner'] }}</strong></p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                </div>
              </div>
            </a>
            @endif
          @empty
          @forelse (Auth::user()->notifications as $notification)
            @break($loop->iteration == 5)
            <div class="dropdown-divider"></div>
            @if($notification->data['type'] == 'message')
            <a href="{{ $notification->data['url'] }}" class="dropdown-item">
                <div class="media">
                  <div class="media-body">
                    <h4 class="dropdown-item-title text-break text-wrap">{{ $notification->data['email'] }}</h4>
                    <p class="text-sm">A new message from <strong>{{ $notification->data['name'] }}</strong></p>
                    <p class="text-sm text-wrap text-break">{{ $notification->data['message'] }}</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                  </div>
                </div>
              </a>
            @else
            <a href="{{ $notification->data['url'] }}" class="dropdown-item">
                <div class="media">
                  <img src="{{ asset('application/users/'.$notification->data['image']) }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h4 class="dropdown-item-title text-break text-wrap">{{ $notification->data['title'] }}</h4>
                  <p class="text-sm">A new {{ $notification->data['type'] }} was uploaded by <strong>{{ $notification->data['owner'] }}</strong></p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForhumans() }}</p>
                </div>
              </div>
              </a>
            @endif
          @empty
            <div id="no_notification" class="dropdown-item text-center">
              No new notification
            </div>
          @endforelse
          @endforelse

          <div class="dropdown-divider"></div>
          <a href="{{ route('user.notification') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img id="userimg" src="{{ asset('application/users/'.Auth::user()->image) }}" class="img-circle elevation-2" alt="User Image" style="width:45px !important; height:40px !important;">
        </div>
        <div class="info">
          <span class="d-block text-white">{{ ucwords(Auth::user()->name) }} {{ ucwords(Auth::user()->lastname) }}</span>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item hover">
                <a href="{{ route('user.profile',Auth::user()->name.'.'.Auth::user()->lastname) }}" class="nav-link active text-center text-gray">
                  <i class="fa fa-home nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
              @if(Auth::user()->type == 'admin')
              <li class="nav-item hover">
                <a href="{{ route('list.admin') }}" class="nav-link active text-center text-gray">
                  <i class="fa fa-user nav-icon"></i>
                  <p>Admins</p>
                </a>
              </li>
              @endif
              <li class="nav-item hover">
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                <button type="submit" class="nav-link text-gray">
                  <i class="fa fa-sign-out-alt nav-icon"></i>
                  <p>Log out</p>
                </button>
              </form>
              </li>

            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('catagory.index') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                 Categories & Tags
              </p>
            </a>
          </li>
          @if(Auth::user()->type=='admin')
          <li class="nav-item">
            <a href="{{ route('librarian.index') }}" class="nav-link">
              <i class="nav-icon fa fa-book-reader"></i>
              <p>
                 Librarians
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item"> 
              <a href="{{ route('user.index') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                   Users
                </p>
              </a>
            </li>
          <li class="nav-item">
              <a href="{{ route('quotation.index') }}" class="nav-link">
                <i class="nav-icon fa fa-quote-left fa-quote-right"></i>
                <p>
                   Quotation | Hadith
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>
                  Article
                  <i class="right fas fa-angle-left"></i>
                  @if(count(($articles ?? []))>0)
                    <span class="badge badge-danger right">
                      {{ count($articles) }}
                    </span>
                  @endif
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route("article.index") }}" class="nav-link">
                    <i class="far nav-icon"></i>
                    <p>List Articles</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('unapproved.article') }}" class="nav-link">
                    <i class="far nav-icon"></i>
                    <p>New Uploaded</p>
                    <span class="badge badge-danger right">@if(count(($articles??[]))>0){{ count($articles) }}@endif</span>
                  </a>
                </li>
              </ul>
            </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Book
                <i class="right fas fa-angle-left"></i>
                  @if(count(($books??[]))>0)
                   <span class="badge badge-info right">
                    {{ count($books) }}
                  </span>                  
                  @endif
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route("book.index") }}" class="nav-link">
                  <i class="far nav-icon"></i>
                  <p>List Books</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('unapproved.book') }}" class="nav-link">
                  <i class="far nav-icon"></i>
                  <p>New Uploaded</p>
                  <span class="badge badge-info right">@if(count(($books??[]))>0){{ count($books) }}@endif</span>
                </a>
              </li>
            </ul>
          </li>

          

          <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-audio"></i>
                <p>
                  Audio
                  <i class="right fas fa-angle-left"></i>
                    
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route("audiobook.index") }}" class="nav-link">
                    <i class="far nav-icon"></i>
                    <p>List Audios</p>
                  </a>
                </li>
              </ul>
          </li>



          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Contact
                <i class="right fas fa-angle-left"></i>
                  @if(count(($uvcontacts??[]))>0)
                <span class="badge badge-warning right">
                  {{ count($uvcontacts) }}
                </span>
                  @endif
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route("contact.index") }}" class="nav-link">
                  <i class="far nav-icon"></i>
                  <p>Messages</p>
                </a>
              </li>
            </ul>
        </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper pt-2">


    <!-- Main content -->
  @yield("content")
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href=""><span style="color:#ff851b
        ">A</span>SOFT</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('asset/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('asset/dist/js/pages/dashboard.js') }}"></script> --}}
<script src="{{ asset('asset/plugins/jsgrid/jsgrid.min.js') }}"></script>
<script src="{{ asset('asset/plugins/jsgrid/demos/db.js') }}"></script>
<script src="{{ asset('asset/select2.min.js') }}"></script>
<script src="{{ asset('css-2/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('css-2/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/asset/form.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
  Echo.private('book.{{ auth()->id() }}').listen('.book.upload',(e)=>{
      let element = `<div class="dropdown-divider"></div>
          <a href="${e.url}" class="dropdown-item">
            <div class="media">
              <img src="{{ asset('application/users/${e.image}') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h4 class="dropdown-item-title text-break text-wrap">${e.title}</h4>
                <p class="text-sm">A new book was uploaded by <strong>${e.owner}</strong></p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>${e.created_at}</p>
              </div>
              <small class="small"><i class="fa fa-sm fa-circle  text-success"></i></small>
            </div>
          </a>`;
          $('#badge').removeClass('invisible');
          let x = $('#badge').text();
          x++;
          $('#badge').text(x);
          x = 0;
          $('#notificationContainer').prepend(element);
          $('#no_notification').remove();
  })


  Echo.private('article.{{ auth()->id() }}').listen('.article.upload',(e)=>{
      let element = `<div class="dropdown-divider"></div>
          <a href="${e.url}" class="dropdown-item">
            <div class="media">
              <img src="{{ asset('application/users/${e.image}') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h4 class="dropdown-item-title text-break text-wrap">${e.title}</h4>
                <p class="text-sm">A new article was uploaded by <strong>${e.owner}</strong></p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>${e.created_at}</p>
              </div>
              <small class="small"><i class="fa fa-sm fa-circle  text-success"></i></small>
            </div>
          </a>`;
          $('#badge').removeClass('invisible');
          let x = $('#badge').text();
          x++;
          $('#badge').text(x);
          x = 0;
          $('#notificationContainer').prepend(element);
          $('#no_notification').remove();

  })

  Echo.channel('new-message').listen('.new.message',e=>{
    let element = `<div class="dropdown-divider"></div>
          <a href="${e.url}" class="dropdown-item">
            <div class="media">
              <div class="media-body">
                <h4 class="dropdown-item-title text-break text-wrap">${e.email}</h4>
                <p class="text-sm">A new message from <strong>${e.name}</strong></p>
                <p class="text-sm text-wrap text-break">${e.message}</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>just now</p>
              </div>
              <small class="small"> <i class="fa fa-sm fa-circle  text-success"></i></small>
            </div>
          </a>`;
          $('#badge').removeClass('invisible');
          let x = $('#badge').text();
          x++;
          $('#badge').text(x);
          x = 0;
          $('#notificationContainer').prepend(element);
          $('#no_notification').remove();
  })



  $('#notificationBox').click(e=>{
    let token = $("meta[name=csrf-token]").attr('content')
    let value = $('#badge').text();
    if(value > 0 )
    {
          $.post("{{ route('notification.mark') }}",{_token:token},
          function (data) {
            $('#badge').addClass('invisible').text('0');
          }
        );
    }
  })
</script>
@stack('script')
</body>
</html>
