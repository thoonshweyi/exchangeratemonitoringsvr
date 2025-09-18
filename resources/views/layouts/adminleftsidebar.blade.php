<!-- START NAVBAR -->
<nav class="navbar navbar-expand-md navbar-light">

    <button type="button" class="navbar-toggler bg-light ms-auto mb-2" data-bs-toggle="collapse" data-bs-target="#mynavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div id="mynavbar" class="navbar-collapse collapse">
        <div class="container-fluid">
            <div class="row">
                <!-- Start Left Sidebar -->
                <div class="col-xl-2 col-lg-3 col-md-4 fixed-top sidebars">

                    <a href="#" class="navbar-brand d-block text-white text-center py-3 mx-auto mb-4 borderbottoms">Exchange Rate Monitoring</a>

                    <div class="pb-3 borderbottoms">
                        <img src="{{ asset("/assets/img/users/user1.jpg")}}" class="rounded-circle me-3" width="50px" alt="{{ $userdata->name }}"/>
                        <a href="#" class="text-white">{{ $userdata->name }}</a>
                    </div>
                    <!--'flex-column' change flex to original column -->
                    <ul class="navbar-nav flex-column mt-4">
                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 currents"><i class="fas fa-home fa-lg me-3"></i>Dashboard</a></li>
                        <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks" data-bs-toggle="collapse" data-bs-target="#pagelayout"><i class="fas fa-user-cog"></i> Analytics<i class="fas fa-angle-right mores"></i></a>
                            <ul id="pagelayout" class="collapse ps-4">
                                <li><a href="{{ route("currencies.index") }}" class="nav-link text-white sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>  Currencies</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-user fa-lg me-3"></i>Profile</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-envelope fa-lg me-3"></i>Inbox</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-shopping-cart fa-lg me-3"></i>Sales</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-chart-line fa-lg me-3"></i>Analytics</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-chart-bar fa-lg me-3"></i>Charts</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-table fa-lg me-3"></i>Return</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-truck fa-lg me-3"></i>Delivery</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebarlinks"><i class="fas fa-wrench fa-lg me-3"></i>Setting</a></li>

                        {{-- @can('view',App\Models\Resource::class)
                        <li class="nav-item"><a href="javascript:void(0);" class="nav-link text-white p-3 mb-2 sidebarlinks" data-bs-toggle="collapse" data-bs-target="#pagelayout"><i class="fas fa-user-cog"></i> System Admin <i class="fas fa-angle-right mores"></i></a>
                            <ul id="pagelayout" class="collapse ps-4">
                                <li><a href="{{route('users.index')}}" class="nav-link text-white sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i>  Users</a></li>
                                <li><a href="{{ route("branches.index") }}" class="nav-link text-white sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Branches </a></li>
                                <li><a href="{{ route('roles.index') }}" class="nav-link text-white sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Roles </a></li>
                                <li><a href="{{ route('permissions.index') }}" class="nav-link text-white sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Permissions </a></li>
                                <li><a href="{{ route('permissionroles.index') }}" class="nav-link text-white sidebarlinks"><i class="fas fa-long-arrow-alt-right me-4"></i> Permission Roles </a></li>
                            </ul>
                        </li>
                        @endcan --}}



                    </ul>

                </div>

                <!-- End Left Sidebar -->

                <!-- Start Top Sidebar -->
                 @include("layouts.adminnavbar")
                <!-- End Top Sidebar -->
            </div>
        </div>
    </div>

</nav>
<!-- END NAVBAR  -->
