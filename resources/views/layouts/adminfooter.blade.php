        <!-- START FOOTER SECTION -->
        <section class="footers">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 col-lg-9 col-md-8 ms-auto">
                        <div class="row border-top pt-3">
                            <div class="col-lg-6 text-center">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        {{-- <a href="#" class="text-dark">Data Land Technoloay Co.,Ltd</a> --}}
                                        <a href="#" class="text-dark">Exchange Rate Monitorint Co.,Ltd</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" class="text-dark">About</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" class="text-dark">Contact</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-lg-6 text-center">
                                <p>&copy; <span id="getyear"></span> Copyright, All Rights Reversed.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END FOOTER SECTION -->



        <!-- START MODAL AREA -->

        <!-- Start Signout Modal -->
        <div id="signout" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Want to leave?</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <span>Press logout to leave</span>
                    </div>

                    <div class="modal-footer">
                        <button type="butto" class="btn btn-success" data-bs-dismiss="modal">Stay Here</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">Logout</button>

                        {{-- <a href="javascript:void(0);" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i class="fas fa-sign-out fa-sm text-muted me-2"></i>Logout</a> --}}
                        <form id="logoutform" action="{{ route('logout') }}" method="POST" >@csrf</form>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Signout Modal -->

        <!-- END MODAL AREA -->

        <!-- bootstrap css1 js2 -->
        {{-- <script src="{{ asset('./assets/libs/bootstrap5/bootstrap.bundle.min.js') }}" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> --}}
        <script src="{{ asset('./assets/libs/bootstrap5/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('./assets/libs/bootstrap5/bootstrap.min.js') }}"   type="text/javascript"></script>

        <!-- jquery js1 -->
        <script src="{{asset('./assets/libs/jquery-3.6.0/jquery-3.6.0.min.js')}}" type="text/javascript"></script>

        {{-- sweetalert2 css1 js1 --}}
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}" type="text/javascript"></script>


        <!-- custome js -->
        <script src="{{ asset('./assets/dist/js/app.js') }}" type="text/javascript"></script>

        <!-- Extra js -->
        @yield('scripts')
    </body>
</html>
