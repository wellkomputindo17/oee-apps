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
                        data-id="0" data-link="{{ route('do.store') }}" data-toggle="modal" data-send="create">
                        Add DO
                    </button>
                </div>
                <div class="card-body px-0 py-1">
                    <div class="table-responsive">
                        <table class="my-table table my-tableview my-table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th width="5%">Action</th>
                                    <th width="2%">No</th>
                                    <th class="select-filter">No DO</th>
                                    <th class="select-filter">Name</th>
                                    <th class="select-filter">Type</th>
                                    <th class="select-filter">Target</th>
                                    <th class="select-filter">Actual</th>
                                    <th class="select-filter">Not Good</th>
                                    <th class="select-filter">Start Time</th>
                                    <th class="select-filter">End Time</th>
                                    <th class="select-filter">Created By</th>
                                    <th class="select-filter">Operator</th>
                                    <th class="select-filter">PIC Production</th>
                                    <th class="select-filter">Updated at</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Action</th>
                                    <th>No</th>
                                    <th>No DO</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Target</th>
                                    <th>Actual</th>
                                    <th>Not Good</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Created By</th>
                                    <th>Operator</th>
                                    <th>PIC Production</th>
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
                                            <label for="no_do" class="col-md-5">DO Number </label>
                                            <input type="text" readonly autocomplete="off" value="NEW"
                                                class="form-control col-md-7 @error('no_do') is-invalid @enderror"
                                                name="no_do" id="no_do">
                                            @error('no_do')
                                                <div class="invalid-feedback col-md-12">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-md-5">DO Name <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" required autocomplete="off"
                                                class="form-control col-md-7 @error('name') is-invalid @enderror"
                                                name="name" id="name">
                                            @error('name')
                                                <div class="invalid-feedback col-md-12">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="type" class="col-md-3">Type</label>
                                            <input type="text" autocomplete="off"
                                                class="form-control col-md-7 @error('type') is-invalid @enderror"
                                                name="type" id="type">
                                            @error('type')
                                                <div class="invalid-feedback col-md-12">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="target" class="col-md-3">Target</label>
                                            <input type="text" autocomplete="off" data-type='currency'
                                                class="form-control col-md-7 @error('target') is-invalid @enderror"
                                                name="target" id="target">
                                            @error('target')
                                                <div class="invalid-feedback col-md-12">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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

            $(".btn-exit").click(function(e) {
                e.preventDefault();
                $('.save-form input').val('');
                $('.form-modal').modal('hide');
            });

            $(document).on("click", ".btn-form", function(e) {
                e.preventDefault();
                $('.form-modal').modal('show');
                let id = $(this).data('id');
                let link = $(this).data('link');
                $(".form-modal").find(".modal-title").html("Form Add DO");
                $(".save-form").find("input[name=no_do]").val("NEW");

                if (id > 0) {
                    $(".form-modal").find(".modal-title").html("Form Edit DO");
                    let url = '{{ route('do.show', ':id') }}';
                    url = url.replace(':id', `${id}`);

                    $.ajax({
                        type: "get",
                        url: url,
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(res) {
                            $(".save-form").find("input[name=no_do]").val(res.no_do);
                            $(".save-form").find("input[name=name]").val(res.name);
                            $(".save-form").find("input[name=type]").val(res.type);
                            $(".save-form").find("input[name=target]").val(res.target);
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
                                        $('.save-form input').val('');
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
                                        // $('.form-modal').modal('hide');
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
                ajax: '{{ route('do.index') }}',
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
                        data: 'no_do',
                        name: 'no_do'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'target',
                        name: 'target'
                    },
                    {
                        data: 'actual',
                        name: 'actual'
                    },
                    {
                        data: 'ng',
                        name: 'ng'
                    },
                    {
                        data: 'time_start',
                        name: 'time_start'
                    },
                    {
                        data: 'time_stop',
                        name: 'time_stop'
                    },
                    {
                        data: 'create_by',
                        name: 'create_by'
                    },
                    {
                        data: 'operator',
                        name: 'operator'
                    },
                    {
                        data: 'pic_produksi',
                        name: 'pic_produksi'
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
