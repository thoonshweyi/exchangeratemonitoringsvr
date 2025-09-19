@extends("layouts.adminindex")

@section("caption","user List")
@section("content")

     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">
               <a href="{{route('users.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>
               <hr/>

               <table id="mytable" class="table table-sm table-hover border">

                    <thead>
                         <th>No</th>
                         <th>Name</th>
                         <th>Employee ID</th>
                         <th>Status</th>
                         <th>Email</th>
                         <th>Role</th>
                         <th>Action</th>
                    </thead>

                    <tbody>
                         @foreach($users as $idx=>$user)
                         <tr>
                              <td>{{++$idx}}</td>
                              <td>{{$user->name}}</td>
                              <td><a href="{{route('users.show',$user->id)}}">{{$user->employee_id}}</a></td>
                              <td>{{ $user->status->name }}</td>
                              <td>{{ $user->email }}</td>
                              <td></td>
                              <td>
                                   <a href="{{ route('users.edit',$user->id) }}" class="text-info"><i class="fas fa-pen"></i></a>
                                   <!-- <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$user->id}}"><i class="fas fa-trash-alt"></i></a> -->
                                   <!-- <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a> -->
                                   <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$user->employee_id}}"><i class="fas fa-trash-alt"></i></a>

                              </td>
                              <!-- <form id="formdelete-{{ $user->id }}" class="" action="{{route('users.destroy',$user->id)}}" method="POST"> -->
                              <!-- <form id="formdelete-{{ $idx }}" class="" action="{{route('users.destroy',$user->id)}}" method="POST"> -->
                              <form id="formdelete-{{ $user->employee_id }}" class="" action="{{route('users.destroy',$user->id)}}" method="POST">
                                   @csrf
                                   @method("DELETE")
                              </form>
                         </tr>
                         @endforeach
                    </tbody>

               </table>


          </div>
     </div>
     <!-- End Page Content Area -->
@endsection

@section("css")
     <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

@section("scripts")
     <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script>

     <script type="text/javascript">
          // for mytable
          $("#mytable").DataTable();

          $(document).ready(function(){
               $(".delete-btns").click(function(){
                    // console.log('hay');

                    var getidx = $(this).data("idx");
                    // console.log(getidx);

                    if(confirm(`Are you sure !!! you want to Delete ${getidx} ?`)){
                         $('#formdelete-'+getidx).submit();
                         return true;
                    }else{
                         false;
                    }
               });
          });


     </script>
@endsection
