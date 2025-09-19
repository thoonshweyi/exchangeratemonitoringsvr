@extends("layouts.adminindex")

@section("caption","Edit user")
@section("content")

     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">
               <form action="/users/{{$user->id}}" method="POST">
                    @csrf
                    @method("PUT")

                    <div class="row">
                       <div class="col-md-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="Name">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Employee:</strong>
                                <input type="text" name="employee_id" value="{{ old('employee_id', $user->employee_id) }}" class="form-control" placeholder="Employee ID">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Branch:</strong>
                                <select class="form-control" id="branch_id" name="branch_id[]" multiple>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->branch_id }}" {{ in_array($branch->branch_id, $userBranches) ? 'selected' : '' }}>
                                            {{ $branch->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Phone Number:</strong>
                                <input type="text" name="ph_no" value="{{ old('ph_no', $user->ph_no) }}" class="form-control" placeholder="Phone No">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Email:</strong>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Password:</strong>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Confirm Password:</strong>
                                <input type="password" name="confirm-password" class="form-control" placeholder="Confirm Password">
                            </div>
                        </div>

                        {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{ __('user.role') }}:</strong>
                                <select id="roles" name="roles[]" class="form-control">
                                    <option value="" selected disabled>-- Select Role --</option>
                                    @foreach ($roles as $key => $role)
                                        <option value="{{ $key }}" {{ in_array($key, $userRole) ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                         <div class="col-md-12 mt-3">
                              <div class="d-flex justify-content-end">
                                   <a href="{{route('users.index')}}" class="btn btn-secondary btn-sm rounded-0 me-3">Cancel</a>
                                   <button type="submit" class="btn btn-secondary btn-sm rounded-0">Update</button>
                              </div>
                         </div>
                    </div>
               </form>

          </div>
     </div>
     <!-- End Page Content Area -->
@endsection

@section("css")
    {{-- select css1 js1 --}}
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

@section("scripts")
    {{-- select2 css1 js1 --}}
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}" type="text/javascript"></script>

     <script type="text/javascript">
          $(document).ready(function(){

            $('#branch_id').select2({
                width: '100%',
                allowClear: true,
            });

            $('#roles').select2({
                width: '100%',
                allowClear: true,
            });
          });
     </script>
@endsection
