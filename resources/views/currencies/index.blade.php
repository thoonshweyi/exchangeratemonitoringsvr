@extends("layouts.adminindex")

@section("caption","City List")
@section("content")

     <!-- Start Page Content Area -->
     <div class="container-fluid">

          <div class="col-md-12">
               <form id="createform">
                    {{ csrf_field() }}
                    <div class="row align-items-end">

                        <div class="col-md-2 form-group mb-3">
                              <label for="name">Name <span class="text-danger">*</span></label>
                              {{-- @error("name")
                                   <span class="text-danger">{{ $message }}<span>
                              @enderror --}}
                              <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Enter Currency Name" value="{{ old('name') }}"/>
                        </div>

                        <div class="col-md-2 form-group mb-3">
                              <label for="code">Code <span class="text-danger">*</span></label>
                              {{-- @error("name")
                                   <span class="text-danger">{{ $message }}<span>
                              @enderror --}}
                              <input type="text" name="code" id="code" class="form-control form-control-sm rounded-0" placeholder="Enter Currency Code" value="{{ old('code') }}"/>
                        </div>



                         <div class="col-md-2 form-group mb-3">
                              <label for="status_id">Status</label>
                              <select name="status_id" id="status_id" class="form-control form-control-sm rounded-0">
                                   @foreach($statuses as $status)
                                        <option value="{{$status['id']}}">{{$status['name']}}</option>
                                   @endforeach
                              </select>
                         </div>

                         <input type="hidden" name="user_id" id="user_id" value="{{ $userdata['id'] }}">

                         <div class="col-md-2 mb-3 text-sm-end text-md-start">
                              <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                              <button type="submit" id="create-btn" class="btn btn-primary btn-sm rounded-0 ms-3">Submit</button>
                         </div>
                    </div>
               </form>
          </div>

          <hr/>

          <div class="col-md-12">
               <div>
                    {{-- <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0">Bulk Delete</a> --}}
                    <a href="javascript:void(0);" id="generateotp-btn" class="btn btn-danger btn-sm rounded-0">Bulk Delete</a>

               </div>
               <div>
                    <form action="" method="">
                         <div class="row justify-content-end">
                              <div class="col-md-2 col-sm-6 mb-2">
                                   <div class="input-group">
                                        <input type="text" name="filtername" id="filtername" class="form-control form-control-sm rounded-0" placeholder="Search...." value="{{ request('filtername') }}"/>
                                        <button type="button" id="btn-search" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                                   </div>
                              </div>
                         </div>
                    </form>
               </div>

          </div>
          <div class="col-md-12 loader-container">

               <div class="table-container">
                    <table id="mytable"  class="table table-sm table-hover border">

                         <thead>
                              <th>
                                   <input type="checkbox" name="selectalls" id="selectalls" class="form-check-input selectalls" />
                              </th>
                              <th>Id</th>
                              <th>Name</th>
                              <th>Code</th>
                              <th>Status</th>
                              <th>By</th>
                              <th>Created At</th>
                              <th>Updated At</th>
                              <th>Action</th>
                         </thead>

                         <tbody>

                         </tbody>

                    </table>
                    {{-- $cities->links("pagination::bootstrap-4") --}}

               </div>


               <div class="loader">
                    <div class="loader-item"></div>
                    <div class="loader-item"></div>
                    <div class="loader-item"></div>
               </div>


          </div>
     </div>
     <!-- End Page Content Area -->

     <!-- START MODAL AREA -->
          <!-- start edit modal -->
               <div id="editmodal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                              <div class="modal-header">
                                   <h6 class="modal-title">Edit Form</h6>
                                   <button type="" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>

                              <div class="modal-body">
                                   <form id="editform">

                                        <div class="row align-items-end">

                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="editname">Name <span class="text-danger">*</span></label>
                                                  <input type="text" name="editname" id="editname" class="form-control form-control-sm rounded-0" placeholder="Enter currency name" value="{{ old('name') }}"/>
                                             </div>

                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="editcode">Code <span class="text-danger">*</span></label>
                                                  <input type="text" name="editcode" id="editcode" class="form-control form-control-sm rounded-0" placeholder="Enter currency code" value="{{ old('name') }}"/>
                                             </div>


                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="status_id">Status</label>
                                                  <select name="editstatus_id" id="editstatus_id" class="form-control form-control-sm rounded-0">
                                                       @foreach($statuses as $status)
                                                            <option value="{{$status['id']}}">{{$status['name']}}</option>
                                                       @endforeach
                                                  </select>
                                             </div>
                                             <input type="hidden" name="id" id="id"/>
                                             <input type="hidden" name="user_id" id="user_id" value="{{ $userdata['id'] }}"/>


                                             <div class="col-md-12 text-end mb-3">
                                                  <button type="submit" id="edit-btn" class="btn btn-primary btn-sm rounded-0">Update</button>
                                             </div>
                                        </div>
                                   </form>
                              </div>

                              <div class="modal-footer">

                              </div>
                         </div>
                    </div>
               </div>
          <!-- end edit modal -->

          <!-- start otp modal -->
          {{-- <div id="otpmodal" class="modal fade">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                         <div class="modal-content">

                              <div class="modal-body">
                                   <form id="verifyform" action="" method="">

                                        <div class="row">
                                             <div class="col-md-12 form-group mb-3">
                                                  <label for="otpcode">OTP Code <span class="text-danger">*</span></label>
                                                  <input type="text" name="otpcode" id="otpcode" class="form-control form-control-sm rounded-0" placeholder="Enter your otp" />
                                             </div>

                                             <input type="hidden" name="otpuser_id" id="otpuser_id" value="{{ $userdata['id'] }}"/>


                                             <div class="col-md-12 text-end mb-3">
                                                  <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                                             </div>
                                        </div>
                                        <p id="otpmessage"></p>
                                        <p id="">Expire in <span id="otptimer"></span> seconds</p>
                                   </form>
                              </div>

                         </div>
                    </div>
            </div> --}}
          <!-- end otp modal -->
     <!-- END MODAL AREA -->
@endsection

@section("css")
    {{-- <link href="{{ asset('assets/dist/css/loader.css') }}" rel="stylesheet" /> --}}
@endsection

@section("scripts")
     <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
     {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

     <script type="text/javascript">




          $(document).ready(function(){
               // Start Passing Header Token
               const token = "Bearer {{-- config('app.passport_token')--}}";
               // console.log(token);
               // Start Passing Header Token
               $.ajaxSetup({
                    headers:{
                         "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                         "Authorization": token,
                         "Accept": "application/json"
                    }
               });

               // End Passing Header Token



               // Start Create Form

               $("#createform").validate({
                    rules:{
                        name:"required"
                    },
                    messages:{
                        name:"Please enter the currency name"
                    },

                    submitHandler:function(form){

                         $("#create-btn").text("Sending....");
                         let formdata = $(form).serialize();

                         $.ajax({
                              url: "{{ url('api/currencies')}}",
                              type:"POST",
                              data: formdata,
                              dataType:"json",
                              success:function(response){
                                   // console.log(response);

                                   // console.log(response.status);

                                   if(response){

                                        const data = response.data;
                                        let html = `
                                        <tr id="row_${data.id}">
                                             <td><input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" /></td>
                                             <td>${data.id}</td>
                                             <td>${data.name}</td>
                                             <td>${data.code}</td>
                                             <td>
                                                  <div class="form-checkbox form-switch">
                                                       <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? "checked" : "" }  data-id="${data.id}" />
                                                  </div>
                                             </td>
                                             <td>${data.user.name}</td>
                                             <td>${data.created_at}</td>
                                             <td>${data.updated_at}</td>
                                             <td>
                                                  <a href="javascript:void(0);" class="text-info edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                                  <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${data.id}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                             </td>
                                        </tr>
                                        `;
                                        $("#mytable tbody").append(html);

                                         // clear form
                                        // $("#createform")[0].reset();
                                        $("#createform").trigger("reset");

                                        $("#create-btn").html("Sutmit");

                                        Swal.fire({
                                             title: "Added!",
                                             text: "Added Successfully",
                                             icon: "success"
                                        });
                                   }
                              },
                              error:function(response){
                                   console.log("Error:",response);
                                   $("#create-btn").html("Try Again");
                              }
                         })
                    }
               });
               // End Create Form

               // Start Fetch All Datas
               function fetchalldatas(){
                    $.ajax({
                         url:"{{url('api/currencies')}}",
                         // url:"{{--'api/warehouses'--}}",
                         // url:"{{-- route('api.warehouses.index') --}}",


                         method:"GET",
                         dataType:"json",
                         success:function(response){
                              console.log(response); // {status: 'scuccess', data: Array(2)}
                              const datas = response.data;
                              console.log(datas);

                              let html;
                              datas.forEach(function(data,idx){
                                   // console.log(data);
                                   html += `
                                   <tr id="row_${data.id}">
                                        <td><input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" /></td>
                                        <td>${++idx}</td>
                                        <td>${data.name}</td>
                                        <td>${data.code}</td>
                                        <td>
                                             <div class="form-checkbox form-switch">
                                                  <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? "checked" : "" }  data-id="${data.id}" />
                                             </div>
                                        </td>
                                        {{-- <td>${data.user["name"]}</td> --}}
                                        <td>${data.user.name}</td>
                                        <td>${data.created_at}</td>
                                        <td>${data.updated_at}</td>
                                        <td>
                                             <a href="javascript:void(0);" class="text-info edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                             <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${idx}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                   </tr>
                                   `;

                              });
                              $("#mytable tbody").prepend(html);

                         }
                    });
               }
               fetchalldatas();
               // End Fetch All Datas


               // Start Edit Form
               $(document).on("click",".edit-btns",async function(){



                    const getid = $(this).data("id");
                    // console.log(getid);

                    await $.get(`api/currencies/${getid}`,async function(response){
                         console.log(response); // {id: 9, name: 'myanmar', slug: 'myanmar', status_id: 3, user_id: 1, …}

                         $("#editmodal").modal("show"); // toggle() can also used.

                         $("#id").val(response.id);
                         $("#editname").val(response.name);
                         $("#editcode").val(response.code);
                         $("#editstatus_id").val(response.status_id);

                    });
               });
               // End Edit Form

               // Start Edit Modal
               $("#editform").validate({
                    rules:{
                         editname:"required",
                         editcode:"required"
                    },
                    messages:{
                         editname:"Please enter the currency name",
                         editcode:"Please enter the currency code"
                    },

                    submitHandler:function(form){

                         const getid = $("#id").val();

                         $("#edit-btn").text("Sending....");
                         let formdata = $(form).serialize();

                         $.ajax({
                              url: `api/currencies/${getid}`,
                              type:"PUT",
                              data: formdata,
                              dataType:"json",
                              success:function(response){
                                   console.log(response);

                                   // console.log(response.status);

                                   if(response){

                                        const data = response.data;
                                        let html = `
                                        <tr id="row_${data.id}">
                                             <td><input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" /></td>
                                             <td>${data.id}</td>
                                             <td>${data.name}</td>
                                             <td>${data.code}</td>
                                             <td>
                                                  <div class="form-checkbox form-switch">
                                                       <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? "checked" : "" }  data-id="${data.id}" />
                                                  </div>
                                             </td>
                                             <td>${data.user.name}</td>
                                             <td>${data.created_at}</td>
                                             <td>${data.updated_at}</td>
                                             <td>
                                                  <a href="javascript:void(0);" class="text-info edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                                  <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${data.id}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                             </td>
                                        </tr>
                                        `;
                                        $("#row_"+data.id).replaceWith(html);

                                        $("#edit-btn").text("Update");
                                        $("#editmodal").modal("hide"); // toggle()

                                        Swal.fire({
                                             title: "Updated!",
                                             text: "Updated Successfully",
                                             icon: "success"
                                        });

                                   }
                              },
                              error:function(response){
                                   console.log("Error:",response);
                                   $("#edit-btn").html("Try Again");
                              }
                         })
                    }
               });
               // End Edit Modal


               // Start Delete Item
               // Using api route
               $(document).on("click",".delete-btns",function(){
                    const getidx = $(this).attr("data-idx");
                    const getid = $(this).data("id");
                    // console.log(getid);

                    Swal.fire({
                         title: "Are you sure?",
                         text: `You won't be able to revert this id ${getidx}`,
                         icon: "warning",
                         showCancelButton: true,
                         confirmButtonColor: "#3085d6",
                         cancelButtonColor: "#d33",
                         confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                         if (result.isConfirmed) {
                              // data remove
                              $.ajax({
                                   url:`api/currencies/${getid}`,
                                   type:"DELETE",
                                   dataType:"json",
                                   // data:{_token:"{{csrf_token()}}"},
                                   success:function(response){
                                        console.log(response);   // 1

                                        if(response){
                                             // ui remove
                                             $(`#row_${getid}`).remove();

                                             Swal.fire({
                                                  title: "Deleted!",
                                                  text: "Your file has been deleted.",
                                                  icon: "success"
                                             });
                                        }
                                   },
                                   error:function(response){
                                        console.log("Error: ",response)
                                   }
                              });

                         }
                    });
               });
               // End Delete Item

               //Start change-btn
               $(document).on("change",".change-btn",function(){

                    var getid = $(this).data("id");
                    // console.log(getid); // 1 2

                    var setstatus = $(this).prop("checked") === true ? 3 : 4;
                    // console.log(setstatus); // 3 4

                    $.ajax({
                         url:"api/currenciesstatus",
                         type:"PUT",
                         dataType:"json",
                         data:{"id":getid,"status_id":setstatus},
                         success:function(response){
                              console.log(response); // {success: 'Status Change Successfully'}
                              console.log(response.success); // Status Change Successfully

                              Swal.fire({
                                   title: "Updated!",
                                   text: "Updated Successfully",
                                   icon: "success"
                              });
                         }
                    });
               });
               // End change btn

          });


     </script>
@endsection
