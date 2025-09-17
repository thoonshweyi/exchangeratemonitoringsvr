@include("layouts.adminheader")

<div id="app">
    @include("layouts.adminleftsidebar")

    <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 col-lg-9 col-md-8 ms-auto pt-md-5 mt-mt-3">

                        <!-- Start Inner Content Area -->
                        <div class="row">
                            @yield("content")
                        </div>
                        <!-- End Inner Content Area -->
                    </div>
                </div>
            </div>
    </section>
</div>

@include("layouts.adminfooter")
