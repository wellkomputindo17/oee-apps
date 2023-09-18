<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MDA System</title>

    <!--  Fonts and icons  -->
    <link href="{{ asset('assets/css/font-google.css?v=1.0.0') }}" rel="stylesheet" />
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}">
    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css?v=1.0.0') }}">
    {{-- Datatable --}}
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css?v=1.0.1') }}"
        type="text/css">
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css?v=1.0.1') }}" type="text/css">
    {{-- Sweeat Alert --}}
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css?v=1.0.0') }}" rel="stylesheet">
    {{-- Jquery Confirm --}}
    <link rel="stylesheet" href="{{ asset('assets/jquery-confirm/jquery.confirm.min.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css?v=1.0.0') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap4-toggle.min.css?v=1.0.0') }}">
    {{-- Datepicker --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker.min.css?v=1.0.0') }}">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css?v=1.0.0') }}" rel="stylesheet">
    @if (in_array(request()->route()->getName(),
            ['andon.site', 'andon.full']))
        <link rel="stylesheet" href="{{ asset('assets/css/styles_andon.css?v=1.0.0') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css?v=1.0.0') }}">
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .axis path,
        .axis line {
            fill: none;
            stroke: white;
            shape-rendering: crispEdges;
        }

        .axis text {
            font-family: sans-serif;
            font-size: 10px;
        }

        .timeline-label {
            font-family: sans-serif;
            font-size: 12px;
        }

        #timeline2 .axis {
            transform: translate(0px, 40px);
            -ms-transform: translate(0px, 40px);
            /* IE 9 */
            -webkit-transform: translate(0px, 40px);
            /* Safari and Chrome */
            -o-transform: translate(0px, 40px);
            /* Opera */
            -moz-transform: translate(0px, 40px);
            /* Firefox */
        }

        .coloredDiv {
            height: 20px;
            width: 20px;
            float: left;
        }
    </style>
</head>

<body id="page-top">
    @if (in_array(request()->route()->getName(),
            ['andon.site', 'andon.full']))
        @yield('content')
    @else
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">



                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    @include('layouts.topbar')
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                    <!-- /.container-fluid -->


                </div>
                <!-- End of Main Content -->
                <!-- Image loader -->
                <div class="ajax-loader">
                    <img src="{{ asset('assets/img/loader_2.gif') }}" class="img-responsive" />
                </div>

                <!-- Image loader -->


                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>&copy; PT. Wellracom Industri Komputindo {{ date('Y') }}</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

                <!-- Modal -->
                <div class="modal fade my-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Notification</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="message" style="display: none;"></h5>
                                        <div class="row stop-row mt-4" style="display: none;">
                                            <div class="col-md-12 text-center">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-lg btn-outline-success btn-finish">Finish</a>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-lg btn-outline-danger btn-maintenance">Maintenance</a>
                                            </div>
                                        </div>
                                        <div class="row maintenance-row" style="display: none;">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="px-0 col-md-6 speedloss-row">

                                                    </div>
                                                    <div class="px-0 col-md-6 unplan-row">

                                                    </div>
                                                </div>

                                                <a href="javascript:void(0)"
                                                    class="btn btn-lg btn-outline-primary btn-back-maintenance mt-3">Back</a>
                                            </div>
                                        </div>
                                        <div class="row start-row mt-4" style="display: none;">
                                            <div class="col-md-12 text-center">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-lg btn-outline-success btn-start">Start</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->
    @endif


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/d3_charts.js') }}"></script>
    <script src="{{ asset('assets/js/func_timeline.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.safeform.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

    {{-- Jquery Confirm --}}
    <script src="{{ asset('assets/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap4-toggle.min.js') }}"></script>

    {{-- Datepicker --}}
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>

    {{-- Sweeat Alert --}}
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    @vite(['resources/js/app.js'])
    @yield('script')

    <script src="{{ asset('assets/echarts/dist/echarts-en.min.js') }}"></script>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let mesin_id;
            let no_do;
            let status;

            $(document).on("click", ".btn-notif", function(e) {
                e.preventDefault();
                mesin_id = $(this).data('mesin_id');
                let mesin_name = $(this).data('mesin_name');
                let do_name = $(this).data('do_name');
                status = $(this).data('status');
                no_do = $(this).data('no_do');

                if (status == 'pending') {
                    $('.my-modal').modal('show');
                    $('.my-modal').find('.message').html(`This ${mesin_name} stops at number do ${do_name}, is
                                    there a
                                    problem with
                                    this machine and has it been repaired or has the work of this machine been
                                    finished?`);
                    $('.my-modal').find('.stop-row').show();
                    $('.my-modal').find('.message').show();
                    $('.my-modal').find('.start-row').hide();
                    $('.my-modal').find('.maintenance-row').hide();
                    $('.my-modal').find('.btn-maintenance').show();
                } else {
                    $('.my-modal').modal('show');
                    $('.my-modal').find('.message').html(
                        `This ${mesin_name} is under repair, has this machine been repaired?`);
                    $('.my-modal').find('.stop-row').show();
                    $('.my-modal').find('.message').show();
                    $('.my-modal').find('.start-row').hide();
                    $('.my-modal').find('.maintenance-row').hide();
                    $('.my-modal').find('.btn-maintenance').hide();
                }

            });

            $(".btn-finish").click(function(e) {
                e.preventDefault();
                $.confirm({
                    title: "Confirmation",
                    content: "Are you sure, this machine is finished ?",
                    theme: 'bootstrap',
                    columnClass: 'medium',
                    typeAnimated: true,
                    buttons: {
                        hapus: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                $.ajax({
                                    type: "post",
                                    cache: false,
                                    async: false,
                                    url: '{{ route('finish.mesin') }}',
                                    data: {
                                        no_do: no_do,
                                        mesin_id: mesin_id,
                                        status: status,
                                    },
                                    dataType: "json",
                                    beforeSend: function() {
                                        $('.ajax-loader').css("visibility",
                                            "visible");
                                    },
                                    success: function(res) {
                                        if (res.msg == 'success') {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success!',
                                                text: res.desc,
                                            }).then(function() {
                                                $('.my-modal').modal(
                                                    'hide');
                                                location.reload();
                                            });
                                            return;
                                        } else {
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Oops...',
                                                text: res.desc,
                                            }).then(function() {
                                                $('.my-modal').modal(
                                                    'hide');
                                                location.reload();
                                            });
                                            return;
                                        }
                                    },
                                    error: function(error) {
                                        console.log(error);
                                    },
                                    complete: function(data) {
                                        $('.ajax-loader').css("visibility",
                                            "hidden");
                                    }
                                });
                            }
                        },
                        close: function() {}
                    }
                });
            });

            $(document).on("click", ".val-tree", function(e) {
                e.preventDefault();
                let type = $(this).data('type');
                let desc = $(this).data('desc');
                let reason = $(this).data('reason');
                $.confirm({
                    title: "Confirmation",
                    content: `Are you sure this machine is having this ${reason} problem?`,
                    theme: 'bootstrap',
                    columnClass: 'medium',
                    typeAnimated: true,
                    buttons: {
                        hapus: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function() {
                                $.ajax({
                                    type: "post",
                                    cache: false,
                                    async: false,
                                    url: '{{ route('maintenance.mesin') }}',
                                    data: {
                                        no_do: no_do,
                                        mesin_id: mesin_id,
                                        type: type,
                                        desc: desc,
                                        reason: reason,
                                    },
                                    dataType: "json",
                                    beforeSend: function() {
                                        $('.ajax-loader').css("visibility",
                                            "visible");
                                    },
                                    success: function(res) {
                                        if (res.msg == 'success') {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success!',
                                                text: res.desc,
                                            }).then(function() {
                                                $('.my-modal').modal(
                                                    'hide');
                                                location.reload();
                                            });
                                            return;
                                        } else {
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Oops...',
                                                text: res.desc,
                                            }).then(function() {
                                                $('.my-modal').modal(
                                                    'hide');
                                                location.reload();
                                            });
                                            return;
                                        }
                                    },
                                    error: function(error) {
                                        console.log(error);
                                    },
                                    complete: function(data) {
                                        $('.ajax-loader').css("visibility",
                                            "hidden");
                                    }
                                });
                            }
                        },
                        close: function() {}
                    }
                });
            });

            $(".btn-maintenance").click(function(e) {
                e.preventDefault();
                $('.my-modal').find('.maintenance-row').show();
                $('.my-modal').find('.stop-row').hide();
                $('.my-modal').find('.message').hide();
                $.ajax({
                    type: "post",
                    url: '{{ route('all.list.tree') }}',
                    data: {},
                    dataType: "json",
                    success: function(res) {
                        let html_unplan = '';
                        if (Object.keys(res.unplan_downtimes).length > 0) {
                            html_unplan += `
                                <h5 class="text-center font-weight-bold">Unplan Downtimes</h5>
                                <ul class="tree">`;
                            $.each(res.unplan_downtimes, function(key, val) {
                                if (Object.keys(val.children).length > 0) {
                                    html_unplan += `
                                        <li id="menu${key+1}">
                                            <label for="menu${key+1}">
                                                <a class="float-left val-tree" data-type="unplan" data-desc="${val.jenis_downtime}" data-reason="${val.jenis_downtime}">${val.jenis_downtime}</a>
                                            </label>
                                            <input id="menu${key+1}" value="" type="checkbox">
                                            <ul>
                                        `;
                                    $.each(val.children, function(key_sub, val_sub) {
                                        html_unplan += `
                                                <li id="menu${key_sub+1}">
                                                    <a>
                                                        <label
                                                            for="menu${key_sub+1}" class="val-tree" data-type="unplan" data-desc="${val.jenis_downtime}" data-reason="${val_sub.jenis_downtime}">${val_sub.jenis_downtime}</label>
                                                        <input checked="" id="menu${key_sub+1}" value=""
                                                            type="checkbox">
                                                    </a>
                                                </li>
                                                
                                            `;
                                    });
                                    html_unplan += `
                                            </ul>
                                        </li>
                                        `;
                                } else {
                                    html_unplan += `
                                            <li id="menu${key+1}">
                                                <a>
                                                    <label for="menu${key+1}" class="val-tree" data-type="unplan" data-desc="${val.jenis_downtime}" data-reason="${val.jenis_downtime}">${val.jenis_downtime}</label>
                                                    <input id="menu${key+1}" value="" type="checkbox">
                                                </a>
                                            </li>
                                        `;
                                }
                            });
                            html_unplan += `</ul>`;
                        }
                        $(".my-modal").find(".unplan-row").html(html_unplan);

                        let html_speedloss = '';
                        if (Object.keys(res.speed_loss).length > 0) {
                            html_speedloss += `
                                <h5 class="text-center font-weight-bold">Speed Loss</h5>
                                <ul class="tree">`;
                            $.each(res.speed_loss, function(key, val) {
                                if (Object.keys(val.children).length > 0) {
                                    html_speedloss += `
                                        <li id="menu${key+1}">
                                            <label for="menu${key+1}">
                                                <a class="float-left val-tree" data-type="speedloss" data-desc="${val.jenis_speedloss}" data-reason="${val.jenis_speedloss}">${val.jenis_speedloss}</a>
                                            </label>
                                            <input id="menu${key+1}" value="" type="checkbox">
                                            <ul>
                                        `;
                                    $.each(val.children, function(key_sub, val_sub) {
                                        html_speedloss += `
                                                <li id="menu${key_sub+1}">
                                                    <a>
                                                        <label
                                                            for="menu${key_sub+1}" class="val-tree" data-type="speedloss" data-desc="${val.jenis_speedloss}" data-reason="${val_sub.jenis_speedloss}">${val_sub.jenis_speedloss}</label>
                                                        <input checked="" id="menu${key_sub+1}" value=""
                                                            type="checkbox">
                                                    </a>
                                                </li>
                                                
                                            `;
                                    });
                                    html_speedloss += `
                                            </ul>
                                        </li>
                                        `;
                                } else {
                                    html_speedloss += `
                                            <li id="menu${key+1}">
                                                <a>
                                                    <label for="menu${key+1}" class="val-tree" data-type="speedloss" data-desc="${val.jenis_speedloss}" data-reason="${val.jenis_speedloss}">${val.jenis_speedloss}</label>
                                                    <input id="menu${key+1}" value="" type="checkbox">
                                                </a>
                                            </li>
                                        `;
                                }
                            });
                            html_speedloss += `</ul>`;
                        }
                        $(".my-modal").find(".speedloss-row").html(html_speedloss);
                    },
                    error: function() {
                        clearInterval(interval); // stop the interval
                    }
                });
            });

            $(".btn-back-maintenance").click(function(e) {
                e.preventDefault();
                $('.my-modal').find('.message').show();
                $('.my-modal').find('.maintenance-row').hide();
                $('.my-modal').find('.stop-row').show();
                $('.my-modal').find('.start-row').hide();
                $('.my-modal').find('.btn-maintenance').hide();
            });

            $('.select-2').select2({
                placeholder: 'Search...',
                width: "100%",
                allowClear: true,
            });

            $('.date-picker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            $('.date-time-picker').datetimepicker({
                "allowInputToggle": true,
                "showClose": true,
                "showClear": true,
                "showTodayButton": true,
                "format": "YYYY-MM-DD HH:mm",
            });

            $('.time-picker').datetimepicker({
                "allowInputToggle": true,
                "showClose": true,
                "showClear": true,
                "showTodayButton": true,
                "format": "HH:mm",
            });

            // setting dropdown di table responsive
            // hold onto the drop down menu                                             
            var dropdownMenu;

            // and when you show it, move it to the body                                     
            $(window).on('show.bs.dropdown', function(e) {

                // grab the menu        
                dropdownMenu = $(e.target).find('.cuk');

                // detach it and append it to the body
                $('body').append(dropdownMenu.detach());

                // grab the new offset position
                var eOffset = $(e.target).offset();

                // make sure to place it where it would normally go (this could be improved)
                dropdownMenu.css({
                    'display': 'block',
                    'top': eOffset.top + $(e.target).outerHeight(true),
                    'center': eOffset.center
                });
            });

            // and when you hide it, reattach the drop down, and hide it normally                                                   
            $(window).on('hide.bs.dropdown', function(e) {
                $(e.target).append(dropdownMenu.detach());
                dropdownMenu.hide();
            });

            // Format Currency
            $("input[data-type='currency']").on({
                keyup: function() {
                    // skip for arrow keys
                    if (event.which >= 37 && event.which <= 40) return;
                    // format number
                    $(this).val(function(index, value) {
                        return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    });
                },
            });
        });
    </script>

</body>

</html>
