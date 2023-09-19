@extends('app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List Console</h6>
                </div>
                <div class="card-body px-0">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('list.console') }}" method="get">
                                @csrf
                                <div class="row px-4">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mesin_id">Machine </label>
                                            <input type="hidden" name="mesin_name" value="{{ $mesin_name }}">
                                            <select class="mesin-select" name="mesin_id">
                                                <option value="{{ $mesin_id }}">{{ $mesin_name }}</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_do">DO </label>
                                            <input type="hidden" name="do_name" value="{{ $do_name }}">
                                            <select class="do-select" name="no_do">
                                                @if ($no_do != '0')
                                                    <option value="{{ $no_do }}">{{ $do_name }}</option>
                                                @else
                                                    <option value=""></option>
                                                @endif

                                            </select>

                                        </div>
                                        <input type="hidden" name="target">
                                    </div>
                                    <div class="col-md-3 ">
                                        <button type="submit" class="btn btn-outline-primary mt-4">Search</button>

                                    </div>
                                    {{-- <div class="col-md-3">
                                        <a href="javascript:void(0)"
                                            class="btn btn-outline-success mt-4 btn-finishmtn float-right">Finish
                                            Maintenance</a>
                                    </div> --}}
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="my-table table my-tableview my-table-striped table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th>DO</th>
                                            <th>Lost Category</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Reason Grp Desc</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Duration</th>
                                            <th>Last Edit By</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let no_do = '{{ $no_do }}';
            let mesin_id = '{{ $mesin_id }}';
            let interval = null;

            if (no_do != '' && mesin_id != '') {
                start();
            }

            // $('.my-modal').modal('show');
            $(document).on("click", ".btn-repair", function(e) {
                e.preventDefault();
                $.confirm({
                    title: "Confirmation",
                    content: "Are you sure, this machine has been repaired ?",
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
                                    url: '{{ route('done.mesin') }}',
                                    data: {
                                        no_do: no_do,
                                        mesin_id: mesin_id,
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
                                                $('.my-table').DataTable()
                                                    .ajax
                                                    .reload();
                                                $('.my-modal').modal(
                                                    'hide');
                                                start();
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Oops...',
                                                text: res.desc,
                                            }).then(function() {
                                                clearInterval(interval);
                                                return;
                                            });
                                            return;
                                        }
                                    },
                                    error: function() {
                                        clearInterval(
                                            interval); // stop the interval
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

            function start() {
                const Http = window.axios;
                const Echo = window.Echo;
                let channel = Echo.channel('services-oee');
                channel.listen('OeeEvent', function(data) {
                    let res = data.message;
                    for (let i = 0; i < res.length; i++) {
                        if (res[i].msg == 'success') {
                            if (res[i].code == 'mesin_perbaikan') {
                                $('.my-table').DataTable().ajax
                                    .reload();
                            } else if (res[i].code == 'stop_produksi') {
                                $('.my-modal').modal('show');
                                $('.my-modal').find('.message').html(res[i].desc);
                                $('.my-modal').find('.stop-row').hide();
                                $('.my-modal').find('.start-row').show();
                                $('.my-modal').find('.message').show();
                                $('.my-modal').find('.maintenance-row').hide();
                                return;
                            } else if (res[i].code == 'running') {
                                $('.my-table').DataTable().ajax
                                    .reload();
                            } else if (res[i].code == 'perbaikan') {
                                $('.my-table').DataTable().ajax
                                    .reload();
                            } else if (res[i].code == 'stop_perbaikan') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: res[i].desc,
                                }).then(function() {
                                    location.reload();
                                    // console.log("stop");
                                    // return;
                                });
                                return;
                            } else if (res[i].code == 'downtime') {
                                $('.my-table').DataTable().ajax
                                    .reload();
                            } else if (res[i].code == 'stop_finish') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: res[i].desc,
                                }).then(function() {
                                    $('.my-table').DataTable().ajax
                                        .reload();
                                    $('.my-modal').modal(
                                        'hide');
                                    return;
                                });
                                return;
                            } else if (res[i].code == 'error') {
                                console.log(res[i].desc);
                                return;
                            } else {
                                console.log(res[i].desc);
                                return;
                            }

                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: res[i].desc,
                            }).then(function() {
                                $('.my-modal').modal(
                                    'hide');
                                return;
                            });
                            return;
                        }
                    }

                });
            }

            $(".btn-start").click(function(e) {
                e.preventDefault();
                $('.my-modal').modal('hide');
                start();
            });

            $.fn.DataTable.ext.pager.numbers_length = 5;
            $('.my-table').DataTable({
                processing: false,
                serverSide: true,
                pagingType: 'full_numbers',
                scrollY: "50vh",
                scrollCollapse: true,
                async: false,
                cache: false,
                scrollX: true,
                ajax: {
                    type: "post",
                    url: '{{ route('ajax.list.console') }}',
                    data: {
                        no_do: '{{ $no_do }}',
                        mesin_id: '{{ $mesin_id }}',
                    },
                    dataType: "json",
                },
                oLanguage: {
                    oPaginate: {
                        sNext: '<span class="fas fa-angle-right pgn-1" style="color: #5e72e4"></span>',
                        sPrevious: '<span class="fas fa-angle-left pgn-2" style="color: #5e72e4"></span>',
                        sFirst: '<span class="fas fa-angle-double-left pgn-3" style="color: #5e72e4"></span>',
                        sLast: '<span class="fas fa-angle-double-right pgn-4" style="color: #5e72e4"></span>',
                    }
                },
                columns: [{
                        data: 'no_do',
                        name: 'no_do'
                    },
                    {
                        data: 'loss',
                        name: null
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'desc_type',
                        name: 'desc_type'
                    },
                    {
                        data: 'reason_desc',
                        name: 'reason_desc'
                    },
                    {
                        data: 'log_start',
                        name: 'log_start'
                    },
                    {
                        data: 'log_stop',
                        name: 'log_stop'
                    },
                    {
                        data: null,
                        name: null,
                        render: (data, type, row) => {
                            if (data['log_stop'] == null) {
                                let from = new Date(dmyToDate(data['log_time_start']));
                                let diffSecs = Math.abs((new Date().getTime() - from.getTime()) /
                                    1000);
                                return secondsToDhms(diffSecs);
                            } else {
                                return data['duration'];
                            }
                        }
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },

                ],
                columnDefs: [{
                    defaultContent: "-",
                    targets: "_all"
                }, {
                    className: 'dt-center',
                    targets: [1]
                }, ],


            });

            // Amended from: https://stackoverflow.com/a/64454486/519413
            function dmyToDate(dateStr) {
                let arr = dateStr.split(' ');

                let dateArr = arr[0].split('-');
                let dd = (dateArr[2] || '').padStart(2, '0');
                let mm = (dateArr[1] || '').padStart(2, '0');
                let yyyy = (dateArr[0] || '').padStart(2, '0');

                let timeArr = arr[1].split(':');
                let hh = (timeArr[0] || '').padStart(2, '0');
                let mi = (timeArr[1] || '').padStart(2, '0');
                let secs = (timeArr[2] || '').padStart(2, '0');
                mm = (parseInt(mm) - 1).toString(); // January is 0    
                return new Date(yyyy, mm, dd, hh, mi, secs);
            }

            // https://stackoverflow.com/a/52387803/519413
            function secondsToDhms(seconds) {
                seconds = Number(seconds);
                let d = Math.floor(seconds / (3600 * 24));
                let h = Math.floor(seconds % (3600 * 24) / 3600);
                let m = Math.floor(seconds % 3600 / 60);
                let s = Math.floor(seconds % 60);

                let dDisplay = d > 0 ? d : "";
                let hDisplay = h > 0 ? addZero(h) : "00";
                let mDisplay = m > 0 ? addZero(m) : "00";
                let sDisplay = s > 0 ? addZero(s) : "00";
                return hDisplay + ":" + mDisplay + ":" + sDisplay;
            }

            function addZero(i) {
                if (i < 10) {
                    i = "0" + i
                }
                return i;
            }


            $(`.mesin-select`).select2({
                placeholder: 'Search machine...',
                width: "100%",
                allowClear: true,
                ajax: {
                    url: '{{ route('get.mesin') }}',
                    dataType: 'json',
                    type: 'POST',
                    delay: 0,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: `${item.no_mesin} - ${item.name}`,
                                    id: item.id,
                                }
                            })
                        };
                    },
                    cache: false
                }
            });

            $(`.mesin-select`).change(function(e) {
                e.preventDefault();
                let name = $(this).select2('data')[0].text;
                $("input[name=mesin_name]").val(name);
            });

            $(`.do-select`).select2({
                placeholder: 'Search DO...',
                width: "100%",
                allowClear: true,
                ajax: {
                    url: '{{ route('get.do') }}',
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            action: 'run'
                        };
                    },
                    dataType: 'json',
                    type: 'POST',
                    delay: 0,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: `${item.no_do} - ${item.name}`,
                                    id: item.no_do,
                                    target: item.target
                                }
                            })
                        };
                    },
                    cache: false
                }
            });

            $(`.do-select`).change(function(e) {
                e.preventDefault();
                let target = $(this).select2('data')[0].target;
                let name = $(this).select2('data')[0].text;

                $("input[name=do_name]").val(name);
                $("input[name=target]").val(target);
            });

        });
    </script>
@endsection
