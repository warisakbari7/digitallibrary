@extends('layouts.master')
@section('content')
<div class="container">


  <div class="row">
      <div class="col-12 col-sm-12">
          <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Catagory</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Tag</a>
                </li>
            
              
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                    <div class="card card-secondary">
                        <div class="card-header">
                          <h3 class="card-title">Category Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="catagory_form">
                          @csrf
                          <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" name="_method" value="PATCH">
                              <label for="name">English</label>
                              <input type="text" class="form-control" id="cat_english" name="english" placeholder="Enter Catagory">
                            </div>
                            <span id="cat_english_error" class="text-danger ml-2"></span>
                            <div class="form-group" style="direction:rtl !important;">
                              <label for="name" class="float-right">دری</label>
                              <input type="text" class="form-control" id="cat_dari" name="dari" placeholder="نام کتگوری ">
                            </div>
                            <span id="cat_dari_error" class="text-danger ml-2"></span>
                            <div class="form-group" style="direction:rtl !important;">
                              <label for="name" class="float-right">پښتو</label>
                              <input type="text" class="form-control" id="cat_pashto" name="pashto" placeholder="کتګوری نوم">
                            </div>
                            <span id="cat_pashto_error" class="text-danger ml-2"></span>
                          </div>
                          
      
                          <!-- /.card-body -->
          
                          <div class="card-footer">
                            <button id="cat_btn" type="submit" class="btn btn-primary" style="width:120px">Add</button>
                            <span id="cat_msg" class="text-success ml-5" style="display:none">Catagory inserted successfully!</span>
                          </div>
                        </form>
                      </div>

                      <div class="card">
                          <div class="card-header bg-secondary">
                            <h3 class="card-title">Catagories</h3>
            
                            <div class="card-tools">
                              <div class="input-group input-group-sm" style="width: 150px;">
                                  <div id="catagory_search_spinner">
                                    </div>
                                <input type="search" oninput="Search(this)" id="catagory_search" class=" mr-0 form-control float-right" placeholder="Search">
                              </div>
                            </div>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-head-fixed text-nowrap">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Name</th>
                                  <th>Books</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody id="cat_table">
                                @foreach ($category as $cat)
                                  <tr id="cat{{ $cat->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $cat->ename }}</td>
                                    <td>{{  count($cat->books)  }}</td>
                                    <td><a href="javascript:void(0)"><i onclick="Show(this)" data-id="{{ $cat->id }}" data-type="catagory" class="fa fa-edit text-dark"></i></a></td>                                  
                                    <td><a href="javascript:void(0)" class="text-dark"><i onclick="ShowModal(this)" data-id="{{ $cat->id }}" data-type="catagory" class="fa fa-trash"></i></a></td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                            
                          </div>
                          
                          <!-- /.card-body -->
                        </div>

                        <tfoot>
                          @if( count($category) > 0)
                            <div id="div_btn_cat" class=" text-center">
                                <button data-type="morecatagory" data-id="{{  $category[count($category)-1]->id }}" id="btn_loadmore_cat" onclick="loadmore(this)" class="btn btn-primary w-100">Load More</button>
                            </div>
                          @endif
                        </tfoot>
                </div>
                <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                    <div class="card card-secondary">
                        <div class="card-header">
                          <h3 class="card-title">Tag Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="tag_form">
                          @csrf
                          <div class="card-body">
                            <div class="form-group">
                              <label for="">Englishh</label>
                              <input type="text" class="form-control" id="tag_english" placeholder="Enter Tag" name="name">
                            </div>
                            <span id="tag_english_error" class="text-danger ml-2"></span>
                            
                            <div class="form-group" style="direction:rtl !important;">
                                <label for="" class="float-right">دری</label>
                                <input type="text" class="form-control" id="tag_dari" placeholder="نام کتگوری" name="name">
                              </div>
                              <span id="tag_dari_error" class="text-danger ml-2"></span>

                              
                            <div class="form-group" style="direction:rtl !important;">
                                <label for="" class="float-right">پښتو</label>
                                <input type="text" class="form-control" id="tag_pashto" placeholder="کتګوری نوم" name="name">
                              </div>
                              <span id="tag_pashto_error" class="text-danger ml-2"></span>
                          </div>
      
                          <!-- /.card-body -->
          
                          <div class="card-footer">
                            <button id="tag_btn" type="submit" class="btn btn-primary" style="width:120px">Add</button>
                            <span id="tag_msg" class="text-success ml-5" style="display:none">Tag inserted successfully!</span>
                          </div>
                        </form>
                      </div>
                
                
                
                
                
                
                 
                 
                 
                 
                      <div class="card">
                          <div class="card-header bg-secondary">
                            <h3 class="card-title">Tags</h3>
            
                            <div class="card-tools">
                              <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="search" oninput="Search(this)"  id="tag_search" name="table_search" class="form-control float-right" placeholder="Search">
                              </div>
                            </div>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-head-fixed text-nowrap">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>English</th>
                                  <th>Dari</th>
                                  <th>Pashto</th>
                                  <th></th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody id="tag_table" >
                                @foreach ($tags as $tag)
                                  <tr " id="tag{{ $tag->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tag->ename }}</td>
                                    <td>{{ $tag->dname }}</td>
                                    <td>{{ $tag->pname }}</td>
                                    <td><a href="javascript:void(0)" ><i onclick="Show(this)" data-id="{{ $tag->id }}" data-type="tag"  class="fa fa-edit text-dark"></i></a></td>
                                    <td><a href="javascript:void(0)"><i onclick="ShowModal(this)" data-id="{{ $tag->id }}" data-type="tag" class="fa fa-trash text-dark"></i></a></td>                             
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <tfoot>
                          @if(count($tags) > 0)
                          <div id="div_btn_tag" class=" text-center">
                              <button data-type="moretag" data-id="{{ $tags[count($tags)-1]->id }}" id="btn_loadmore_tag" onclick="loadmore(this)" class="btn btn-primary w-100">Load More</button>
                          </div>
                          @endif
                      </tfoot>
                      </div>
                    </div>
          
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
  </div>
</div>




  <!-- Modal For Updating Record -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Update Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <div class="modal-body">
                <form action="" id="modalform">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="">English</label>
                    <input id="ename" type="text" name="name" class="form-control" placeholder="">
                </div>
                <span id="modal_english_error" class="text-danger ml-2"></span>

                <div class="form-group" style="direction:rtl !important;">
                   <label for="" class="float-right">دری  </label>
                    <input id="dname" type="text" name="name" class="form-control" placeholder="">
                </div>
                <span id="modal_dari_error" class="text-danger ml-2"></span>

                <div class="form-group" style="direction:rtl !important;">
                  <label for="" class="float-right">پښتو</label>
                    <input id="pname" type="text" name="name" class="form-control" placeholder="">
                </div>
                <span id="modal_pashto_error" class="text-danger ml-2"></span>
                <input id="inid" type="hidden" name="id" value="">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" id="model_btn" style="width:120px" class="btn btn-primary">Update</button>
            </div>
          </div>
        </form>

    </div>
  </div>


  {{-- Modal For Deleting Record --}}
  <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger mt-0">
          <h5 class="modal-title" id="exampleModalCenterTitle">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <div class="modal-body">
                <form action="" id="deleteform">
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="">
                <h4>Would you like to delete this record?</h4>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
              <button type="button" id="delete_btn" style="width:120px" class="btn btn-danger">Delete</button>
            </div>
          </div>
        </form>

    </div>
  </div>


  {{-- Modal Message --}}
  <div class="modal fade" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success mt-0">
            <h5 class="modal-title" id="exampleModalCenterTitle">Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
              <div class="modal-body text-center">
                  <h4 id="message"></h4>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
              </div>
            </div>
  
      </div>
    </div>


@endsection
@push('script')
  <script>
    $(document).ready(function(){
          // Catagory scirpt
        $('#catagory_form').on('submit',function(e){
            e.preventDefault();
            $.ajax({
              url : "{{ route('catagory.store') }}",
              type : 'POST',
              data : {
                english : $('#cat_english').val(),
                dari : $('#cat_dari').val(),
                pashto : $('#cat_pashto').val(),
                _token : $('#catagory_form>input[name=_token]').val(),
              },
              beforeSend : function(){
                $('#cat_english_error').text('');
                $('#cat_dari_error').text('');
                $('#cat_pashto_error').text('');
                $('#cat_btn').html('<div class="spinner"><span class="spinner-border spinner-border-sm text-light" style="height:1rem; width:1rem" role="status" aria-hidden="true"></span><span class="ml-1">Loading...</span></div>')
              },
              success : function(result){
                if(result.status == 0){
                  $.each(result.error,function(key,value){
                    $('#cat_'+key+'_error').text(value[0]);
                  })
                  $('#cat_btn').text('Add')
                }
                else{
                  $('#catagory_form')[0].reset();
                  $('#cat_btn').text('Add');
                  $('#cat_msg').fadeIn()
                  $('#cat_msg').fadeOut(7000)
                   
                  
                $('#cat_table').prepend(`<tr id="cat`+result.cat.id+`" > ` +
                                    `<td>` + 1 +`</td>` +
                                    `<td> ` + result.cat.ename + `</td> ` +
                                    `<td>` + result.books + `</td>` +
                                    `<td><a href="javascript:void(0)"><i onclick="Show(this)" data-id="`+  result.cat.id + `" data-type="catagory" class="fa fa-edit text-dark"></i></a></td>` +                                  
                                    `<td><a href="javascript:void(0)" class="text-dark"><i onclick="ShowModal(this)" data-id="`+ result.cat.id +`" data-type="catagory" class="fa fa-trash"></i></a></td> </tr>`);
                                    Numbering('cat');
                }
              }
            })
        });

        // Tag Script

        $('#tag_form').on('submit',e =>{
          e.preventDefault();
          $.ajax({
            url : "{{ route('tag.store') }}",
            type : 'POST',
            data : {
              english : $('#tag_english').val(),
              dari : $('#tag_dari').val(),
              pashto : $('#tag_pashto').val(),
              _token : $('#tag_form>input[name=_token]').val(),
            },
            beforeSend : function(){
              $('#tag_english_error').text('');
              $('#tag_dari_error').text('');
              $('#tag_pashto_error').text('');
              $("#tag_btn").html('<div class="spinner"><span class="spinner-border spinner-border-sm text-light" style="height:1rem; width:1rem" role="status" aria-hidden="true"></span><span class="ml-1">Loading...</span></div>');
            },
            success : function(result){
              if(result.status)
              {
                $('#tag_btn').text('Add')
                $('#tag_form')[0].reset();
                $('#tag_msg').fadeIn();
                $('#tag_msg').fadeOut(7000);

                $('#tag_table').prepend(`<tr id="tag`+result.tag.id+`" > ` +
                                    `<td>` + 1 +`</td>` +
                                    `<td> ` + result.tag.ename + `</td> ` +
                                    `<td> ` + result.tag.dname + `</td> ` +
                                    `<td> ` + result.tag.pname + `</td> ` +
                                    `<td><a href="javascript:void(0)"><i onclick="Show(this)" data-id="`+  result.tag.id + `" data-type="tag" class="fa fa-edit text-dark"></i></a></td>` +                                  
                                    `<td><a href="javascript:void(0)" class="text-dark"><i onclick="ShowModal(this)" data-id="`+ result.tag.id +`" data-type="tag" class="fa fa-trash"></i></a></td> </tr>`);
                                    Numbering('tag');
              }
              else
              {
                $.each(result.error,(key,val)=>{
                  $('#tag_'+key+'_error').text(val[0]);
                });
                $('#tag_btn').text('Add');
              }
            }
          })
        });



        // script for updating record

        $('#model_btn').on('click',function(e){
          $.ajax({
            url : $('#modalform').attr('action'),
            type : 'PUT',
            data : {
              english : $('#ename').val(),
              dari : $('#dname').val(),
              pashto : $('#pname').val(),
              id : $('#inid').val(),
              _token : $('#token').val()
            },
            beforeSend : function(){
              $('#modal_error').text('');
              $("#model_btn").html('<div class="spinner"><span class="spinner-border spinner-border-sm text-light" style="height:1rem; width:1rem" role="status" aria-hidden="true"></span><span class="ml-1">Loading...</span></div>');
            },
            success : function(result){
              if(result.status)
              {
                type = this.url.split('/')
                type[0] += $('#inid').val()
                $("#model_btn").text('Update')
                $('#modalform')[0].reset();
                $('#modal').modal('toggle')
                $('#message').text('Record Updated')
                $('#MessageModal').modal('toggle')
                if(type[0].charAt(0) == 'c')
                {
                  $('#cat' + result.cat.id + ' td:nth-child(2)').text(result.cat.ename);
                  $('#cat' + result.cat.id + ' td:nth-child(3)').text(result.books);
                }
                else
                {
                  $('#tag' + result.tag.id + ' td:nth-child(2)').text(result.tag.ename);
                  $('#tag' + result.tag.id + ' td:nth-child(3)').text(result.tag.dname);
                  $('#tag' + result.tag.id + ' td:nth-child(4)').text(result.tag.pname);
                  Numbering('tag');
                }
                
              }
              else
              {
                $.each(result.errors,function(key,val){
                  $('#modal_'+key+'_error').text(val[0])
                })
                $("#model_btn").text('Update')
              }
            },
            error : function(xhr,status,error){
              alert(error);
            }
          })

        })

        $('#delete_btn').click(function(){
          $.ajax({
          url : $('#deleteform').attr('action'),
          type : 'DELETE',
          data : {
            _token : $('#token').val()
                 },
                 beforeSend : function(){
                    $("#delete_btn").html('<div class="spinner"><span class="spinner-border spinner-border-sm text-light" style="height:1rem; width:1rem" role="status" aria-hidden="true"></span><span class="ml-1">Loading...</span></div>');
                 },
          success : function(result){
            if(result.status)
            {
              type = this.url.split('/');
              $('#delete_btn').text("Delete");
              $('#deleteform')[0].reset()
              $('#DeleteModal').modal('toggle');
              $('#message').text('Record Deleted')
              $('#MessageModal').modal('toggle');
              if(type[0].charAt(0) == 'c')
              {
                $('#cat'+type[1]).remove();
                Numbering('cat');
              } 
              else
              {
                $('#tag'+type[1]).remove();
                Numbering('tag');
              } 
            }
            else
            {
              alert('error occured')
            }
            }
        });
        });
    
    });
    function ShowModal(element){
      $('#deleteform').attr('action',$(element).data('type')+"/"+ $(element).data('id'))
          $('#DeleteModal').modal('toggle');
        }

        //  script for showing record in modal
        function Show(element){
          $.ajax({
            url :  $(element).data('type')+'/'+$(element).data('id'),
            type : 'GET',
            model : $(element).data('type'),
            data : {
              id : $(element).data('id')
            },
            beforeSend: function()
            {
              $('#modalform')[0].reset();
            },
            success : function(result){
              if(result)
              {
              $('#modalform')[0].reset();
                $('#modalform').attr('action',this.model+'/'+result.id);
                $('#inid').val(result.id);
                $('#ename').val(result.ename).attr('placeholder',' ...');
                $('#dname').val(result.dname).attr('placeholder',' ... ');
                $('#pname').val(result.pname).attr('placeholder',' ... ');
                $('#modal').modal("toggle");
              }
              else{
                alert('error occured')
              }
            }
          })
        };
//      function for generating numbers for tables
        function Numbering(type)
        {
          let element = $('#'+type+'_table tr')
          let x = 0; 
          let len = element.length;
          for(; x < len; x++)
          {
            element[x].children[0].innerHTML = x+1;
          }
        }

        // function for Loading more
        function loadmore(element)
        {
          $.ajax({
            url : $(element).data('type') ,
            type : 'POST',
            data : {
               id : $(element).data("id"),
               _token : $('input[name="_token"]').val()
            },
            beforeSend : function(){
              $(element).text("Loading...")
            },
            success : function(data){
            $('#div_btn_'+data.type).empty();
            $('#'+data.type+'_table').append(data.rows);
            $('#div_btn_'+data.type).html(data.button);
            Numbering(data.type)
            }
          })
        }

        // Function for Searching Items 
        function Search(el)
        {
          if($(el).val() == '' && $(el).attr('id') == 'catagory_search')
          {
            let rows;
            @foreach ($category as $cat)
              rows +=`<tr id="cat{{ $cat->id }}" class="">
              <td>{{ $loop->iteration }}</td>
              <td>{{ $cat->ename }}</td>
              <td>{{  count($cat->books) }} </td>
              <td><a href="javascript:void(0)"><i onclick="Show(this)" data-id="{{  $cat->id }}" data-type="catagory" class="fa fa-edit text-dark"></i></a></td>                                  
              <td><a href="javascript:void(0)" class="text-dark"><i onclick="ShowModal(this)" data-id="{{ $cat->id }}" data-type="catagory" class="fa fa-trash"></i></a></td>
              </tr>`
            @endforeach
            button = @if(count($category) > 0 )
             `<button data-type="morecatagory" data-id="{{ $category[count($category)-1]->id }}" id="btn_loadmore_cat" onclick="loadmore(this)" class="btn btn-primary w-100">Load More</button>`
             @else
             ''
             @endif
            $('#cat_table').html(rows);
            $('#div_btn_cat').html(button);
          }
          else if($(el).val() == '' && $(el).attr('id') == 'tag_search')
          {
            let rows;
            @foreach ($tags as $tag)
              rows +=`<tr " id="tag{{ $tag->id }}">
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ ucfirst($tag->ename) }}</td>
                      <td>{{ ucfirst($tag->dname) }}</td>
                      <td>{{ ucfirst($tag->pname) }}</td>
                      <td><a href="javascript:void(0)" ><i onclick="Show(this)" data-id="{{ $tag->id }}" data-type="tag"  class="fa fa-edit text-dark"></i></a></td>
                      <td><a href="javascript:void(0)"><i onclick="ShowModal(this)" data-id="{{ $tag->id }}" data-type="tag" class="fa fa-trash text-dark"></i></a></td>                             
                      </tr>`
            @endforeach
            button = 
            @if(count($tags) > 0 )
            `<button data-type="moretag" data-id="{{ $tags[count($tags)-1]->id }}" id="btn_loadmore_tag" onclick="loadmore(this)" class="btn btn-primary w-100">Load More</button>`
            @else
            ''
            @endif
            $('#tag_table').html(rows);
            $('#div_btn_tag').html(button);
          }
          else
          {
            let address = $(el).attr('id')
            $.ajax({
            url : address,
            type : 'POST',
            data : {
              _token : $('input[name="_token"]').val(),
              name : $(el).val().trim()
            },
            beforeSend : function(){
              $('#'+address+'_spinner').html('<div  class="spinner"><span class=" ml-0 spinner-border spinner-border-sm text-light" style="height:1rem; width:1rem" role="status" aria-hidden="true"></span></div>')
            },
            success : data => {
              $('#div_btn_'+data.type).empty();
              $('#'+data.type+'_table').empty();
              $('#'+data.type+'_table').append(data.rows);
              Numbering(data.type)
              $('#'+address+'_spinner').empty();
            }
          })
          } 
        }
  </script>

@endpush