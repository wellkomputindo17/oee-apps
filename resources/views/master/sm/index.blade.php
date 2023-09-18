@extends('app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- DataTales Example -->
            <div class="card shadow">
                <div class="card-header py-2">
                    <h6 class="m-0 font-weight-bold text-primary float-right">List {{ $title }}</h6>
                    <button type="button" class="btn btn-sm float-left btn-outline-primary btn-md mb-2 btn-form"
                        data-id="0" data-link="{{ route('sm.store') }}" data-toggle="modal" data-send="create">
                        Add Schedule
                    </button>
                </div>
                <div class="card-body px-0 py-1">
                    <div class="table-responsive">
                        <table class="my-table table my-tableview my-table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th width="5%">Action</th>
                                    <th width="2%">No</th>
                                    <th class="select-filter">Machine</th>
                                    <th class="select-filter">Schedule Start</th>
                                    <th class="select-filter">Schedule End</th>
                                    <th class="select-filter">Description</th>
                                    <th class="select-filter">Updated at</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Action</th>
                                    <th>No</th>
                                    <th>Machine</th>
                                    <th>Schedule Start</th>
                                    <th>Schedule End</th>
                                    <th>Description</th>
                                    <th>Updated at</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade form-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="close btn-exit">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="save-form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="mesin_id" class="col-md-5">Machine <span
                                                    style="color: red;">*</span></label>
                                            <div class="col-md-7">
                                                <select name="mesin_id" id="mesin_id" class="mesin-select" required>
                                                    <option value=""></option>

                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label for="desc" class="col-md-5">Description </label>
                                            <textarea name="desc" id="desc" cols="30" rows="3" class="form-control col-md-7"></textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="start" class="col-md-3">Start <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" autocomplete="off" required
                                                class="form-control col-md-7 @error('start') is-invalid @enderror date-time-picker"
                                                name="start" id="start">

                                        </div>
                                        <div class="form-group row">
                                            <label for="stop" class="col-md-3">Stop <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" autocomplete="off" required
                                                class="form-control col-md-7 @error('stop') is-invalid @enderror date-time-picker"
                                                name="stop" id="stop">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-exit">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                                    text: `${item.name}`,
                                    id: item.id,
                                }
                            })
                        };
                    },
                    cache: false
                }
            });

            $(".btn-exit").click(function(e) {
                e.preventDefault();
                $('.save-form select').html('');
                $('.save-form input').val('');
                $('.save-form textarea').val('');
                $('.form-modal').modal('hide');
            });

            $(document).on("click", ".btn-form", function(e) {
                e.preventDefault();
                $('.form-modal').modal('show');
                let id = $(this).data('id');
                let link = $(this).data('link');
                $(".form-modal").find(".modal-title").html("Form Add Maintenance Schedule");
                $(".save-form").find("input[name=no_do]").val("NEW");

                if (id > 0) {
                    $(".form-modal").find(".modal-title").html("Form Edit Maintenance Schedule");
                    let url = '{{ route('sm.show', ':id') }}';
                    url = url.replace(':id', `${id}`);

                    $.ajax({
                        type: "get",
                        url: url,
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(res) {
                            $(".save-form").find("input[name=start]").val(res.start);
                            $(".save-form").find("input[name=stop]").val(res.stop);
                            $(".save-form").find("textarea[name=desc]").val(res.desc);
                            var newOption = new Option(res.mesin.name, res.mesin_id, true,
                            true);
                            // Append it to the select
                            $('.mesin-select').append(newOption).trigger('change');


                        }
                    });
                }

                $('.save-form').safeform({
                    timeout: 2000,
                    submit: function(e) {
                        e.preventDefault();
                        // put here validation and ajax stuff..
                        let formdata = $(this).serializeArray();
                        formdata.push({
                            name: "id",
                            value: id
                        });
                        e.preventDefault();
                        $.ajax({
                            type: "post",
                            url: link,
                            data: formdata,
                            dataType: "json",
                            success: function(res) {
                                if (res.msg == 'sukses') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: res.desc,
                                    }).then(function() {
                                        $('.form-modal').modal('hide');
                                        $('.save-form select').html('');
                                        $('.save-form input').val('');
                                        $('.save-form textarea').val('');
                                        $('.my-table').DataTable().ajax
                                            .reload();
                                    });
                                    return;
                                } else if (res.msg == 'error') {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: res.desc,
                                    }).then(function() {
                                        $('.save-form select').html('');
                                        $('.save-form textarea').val('');
                                        $('.save-form input').val('');
                                        $('.my-table').DataTable().ajax
                                            .reload();
                                    });
                                    return;
                                }
                            }
                        });
                        // no need to wait for timeout, re-enable the form ASAP
                        $(this).safeform('complete');
                        return false;
                    }
                })
            });


            $.fn.DataTable.ext.pager.numbers_length = 5;
            $('.my-table').DataTable({
                processing: true,
                serverSide: true,
                pagingType: 'full_numbers',
                scrollY: "50vh",
                scrollCollapse: true,
                scrollX: true,
                ajax: '{{ route('sm.index') }}',
                oLanguage: {
                    oPaginate: {
                        sNext: '<span class="fas fa-angle-right pgn-1" style="color: #5e72e4"></span>',
                        sPrevious: '<span class="fas fa-angle-left pgn-2" style="color: #5e72e4"></span>',
                        sFirst: '<span class="fas fa-angle-double-left pgn-3" style="color: #5e72e4"></span>',
                        sLast: '<span class="fas fa-angle-double-right pgn-4" style="color: #5e72e4"></span>',
                    }
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'mesin.name',
                        name: 'mesin.name'
                    },
                    {
                        data: 'start',
                        name: 'start'
                    },
                    {
                        data: 'stop',
                        name: 'stop'
                    },
                    {
                        data: 'desc',
                        name: 'desc'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },

                ],
                columnDefs: [{
                    defaultContent: "-",
                    targets: "_all"
                }],
                fnInitComplete: function() {
                    $('.dataTables_scrollBody').css({
                        'overflow': 'hidden',
                        'border': '0'
                    });
                    $('.dataTables_scrollFoot').css('overflow', 'auto');
                    $('.dataTables_scrollFoot').on('scroll', function() {
                        $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
                    });
                },
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    this.api()
                        .columns('.select-filter')
                        .every(function() {
                            var column = this;
                            var select = $(
                                    '<select style="width: 100%;"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                    column.search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.append('<option value="' + d + '">' + d +
                                        '</option>');
                                });
                        });
                },

            });
        });
    </script>
@endsection
