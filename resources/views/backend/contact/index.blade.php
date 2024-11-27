@extends('layouts.master');
@section('content')
<div class="container-fluid mt-3">
    <h2>Contact Messages</h2>
    <br>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
      <li class="nav-item bg-primary">
        <a class="btn btn-primary active" data-toggle="tab" href="#unread">Unread
           @if(count(($uvcontacts??[]))>0)
            <span class="badge badge-warning right">
              {{ count($uvcontacts) }}
            </span>
              @endif</a>
      </li>
      <li class="nav-item bg-info ">
        <a class="btn btn-info" data-toggle="tab" href="#read">Read</a>
      </li>
    </ul>
  
    <!-- Tab panes -->
    <div class="tab-content">
      <div id="unread" class="container-fluid tab-pane active"><br>


        <div class="card card-secondary card-outline">
            <div class="card-header">
              <h3 class="card-title">Messages</h3>
            </div>


            <!-- /.card-header -->
            <div class="card-body p-0">

              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Message</th>
                                    <th></th>
                                    <th></th>
                            </tr>
                        </thead>
                  <tbody>
                    @forelse ($uvcontacts  as $contact)
                        <tr>
                            <td>
                              <div class="icheck-primary">{{ $loop->iteration }}</div>
                            </td>
                            <td class="mailbox-name text-lg">{{ ucwords($contact->fullname) }}</td>
                            <td class="mailbox-subject"><b>
                               @if(strlen($contact->message) > 80)
                                 {{ substr(ucfirst($contact->message),0,80).'...'}}
                               @else
                                 {{ ucfirst($contact->message) }}
                               @endif
                                </b></td>
                            <td class="mailbox-date">{{ $contact->created_at->diffForhumans() }}</td>
                            <td class="mailbox-attachment"><a href="{{ route('contact.show',$contact->id) }}"><i class="fa fa-eye text-dark"></i></a></td>

                        </tr>
                    @empty
                        
                    @endforelse
                  {{-- <tr>
                    <td>
                      <div class="icheck-primary">
                        2
                      </div>
                    </td>
                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                    </td>
                    <td class="mailbox-date">28 mins ago</td>
                  </tr> --}}
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0 text-center d-flex justify-content-center ">
                <div class="pt-3">
                    {{ $uvcontacts->links() }}
                </div>
            </div>
          </div>
      </div>




      
      <div id="read" class="container-fluid tab-pane"><br>


        <div class="card card-secondary card-outline">
            <div class="card-header">
              <h3 class="card-title">Messages</h3>
            </div>


            <!-- /.card-header -->
            <div class="card-body p-0">

              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Message</th>
                                    <th></th>
                                    <th></th>
                            </tr>
                        </thead>
                  <tbody>
                    @forelse ($contacts  as $contact)
                        <tr>
                            <td>
                              <div class="icheck-primary">{{ $loop->iteration }}</div>
                            </td>
                            <td class="mailbox-name text-lg">{{ ucwords($contact->fullname) }}</td>
                            <td class="mailbox-subject"><b>
                               @if(strlen($contact->message) > 80)
                                 {{ substr(ucfirst($contact->message),0,80).'...'}}
                               @else
                                 {{ ucfirst($contact->message) }}
                               @endif
                                </b></td>
                            <td class="mailbox-date">{{ $contact->created_at->diffForhumans() }}</td>
                            <td class="mailbox-attachment"><a href="{{ route('contact.show',$contact->id) }}"><i class="fa fa-eye text-dark"></i></a></td>

                        </tr>
                    @empty
                        
                    @endforelse
                  {{-- <tr>
                    <td>
                      <div class="icheck-primary">
                        2
                      </div>
                    </td>
                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                    </td>
                    <td class="mailbox-date">28 mins ago</td>
                  </tr> --}}
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0 text-center d-flex justify-content-center ">
                <div class="pt-3">
                    {{ $contacts->links() }}
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  
@endsection