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
<div class="container-fluid">
        <a href="{{ url()->previous() }}"><i id="back" class=" ml-5 text-xl text-secondary fa fa-arrow-circle-left mb-3 mt-4"></i></a> 

        <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Read Message</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="mailbox-read-info">
                    <h5> Sender : {{ ucwords($contact->fullname) }}</h5>
                    <h6 class="mt-1">Email: {{ $contact->email }}
                    <h6>Phone: {{ $contact->phone }}
                      <span class="mailbox-read-time float-right">{{ date_format($contact->created_at,'d M Y  h:m a') }}</span></h6>
                  </div>
                  <div class="mailbox-controls with-border text-center">
                        <div class="btn-group">
                          <button type="submit" data-target="#confirm_delete" data-toggle="collapse" class="btn btn-default btn-sm" data-container="body" title="Delete">
                            <i class="far fa-trash-alt"></i>
                          </button>
                        </div>
                      </div>

                        <div class="collapse alert-danger with-border text-center" id="confirm_delete">
                            <div class="btn-group m-2">
                                    <form action="{{ route("contact.destroy",$contact->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                              <button type="submit" class="btn btn-default btn-sm" data-container="body" title="Delete">
                                Delete
                              </button>
                        </form>

                            </div>
                            <!-- /.btn-group -->

                        </div>
                  <div class="mailbox-read-message">
                    <p class="px-5 ">{{ ucfirst($contact->message) }}</p>
                  </div>
                  <!-- /.mailbox-read-message -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  
                </div>
                <!-- /.card-footer -->
              </div>
</div>
@endsection
