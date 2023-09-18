@extends('app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header py-2">
                    <h6 class="m-0 font-weight-bold text-primary float-right">List {{ $title }}</h6>
                    <a href="javascript:void(0)" data-link="{{ route('quality_loss.store') }}" data-action="add"
                        data-type="parent" data-id_sub="0"
                        class="btn btn-sm btn-outline-primary btn-md mb-2 float-left btn-action">Add
                        Parent Quality Loss</a>

                </div>
                <div class="card-body">
                    <ul class="tree">
                        @foreach ($data as $key => $item)
                            @if (count((array) $item->children) > 0)
                                <li id="menu{{ $key + 1 }}">
                                    <label for="menu{{ $key + 1 }}">
                                        <a class="float-left">{{ $item->jenis_qualityloss }}</a>

                                        <a href="javascript:void(0)" class="float-right">
                                            <span class="badge badge-danger btn-action"
                                                data-link="{{ route('quality_loss.store') }}" data-type="child"
                                                data-action="delete" data-id_sub="{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" class="float-right">
                                            <span class="badge badge-success btn-action"
                                                data-link="{{ route('quality_loss.store') }}" data-type="child"
                                                data-action="edit" data-id_sub="{{ $item->id }}">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" class="float-right">
                                            <span class="badge badge-primary btn-action"
                                                data-link="{{ route('quality_loss.store') }}" data-type="child"
                                                data-action="add" data-id_sub="{{ $item->id }}">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                        </a>
                                    </label>
                                    <input checked id="menu{{ $key + 1 }}" value="" type="checkbox">
                                    <ul>
                                        @foreach ($item->children as $key_sub => $item_sub)
                                            <li id="menu{{ $key_sub + 1 }}">
                                                <a>
                                                    <label
                                                        for="menu{{ $key_sub + 1 }}">{{ $item_sub->jenis_qualityloss }}</label>
                                                    <input checked="" id="menu{{ $key_sub + 1 }}" value=""
                                                        type="checkbox">

                                                    <span class="badge badge-success btn-action" style="cursor: pointer;"
                                                        data-link="{{ route('quality_loss.store') }}" data-action="edit"
                                                        data-type="child_2" data-id_sub="{{ $item_sub->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </span>

                                                    <span class="badge badge-danger btn-action" style="cursor: pointer;"
                                                        data-link="{{ route('quality_loss.store') }}" data-action="delete"
                                                        data-type="child_2" data-id_sub="{{ $item_sub->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li id="menu{{ $key + 1 }}">
                                    <a>
                                        <label for="menu{{ $key + 1 }}">{{ $item->jenis_qualityloss }}</label>
                                        <input checked="" id="menu{{ $key + 1 }}" value="" type="checkbox">

                                        <span class="badge badge-primary btn-action" style="cursor: pointer;"
                                            data-link="{{ route('quality_loss.store') }}" data-action="add"
                                            data-type="child" data-id_sub="{{ $item->id }}">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="badge badge-success btn-action" style="cursor: pointer;"
                                            data-link="{{ route('quality_loss.store') }}" data-action="edit"
                                            data-type="child" data-id_sub="{{ $item->id }}">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="badge badge-danger btn-action" style="cursor: pointer;"
                                            data-link="{{ route('quality_loss.store') }}" data-action="delete"
                                            data-type="child" data-id_sub="{{ $item->id }}">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>

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
                                <input type="hidden" name="id_sub">
                                <div class="form-group row">
                                    <label for="jenis_qualityloss" class="col-md-5">Quality Loss Name<span
                                            style="color: red;font-weight: bold;">*</span></label>
                                    <input type="text" required autocomplete="off"
                                        class="form-control col-md-7 @error('jenis_qualityloss') is-invalid @enderror"
                                        name="jenis_qualityloss" id="jenis_qualityloss">
                                    @error('jenis_qualityloss')
                                        <div class="invalid-feedback col-md-12">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="desc" class="col-md-5">Description</label>
                                    <textarea name="desc" id="desc" class="form-control col-md-7" rows="3"></textarea>
                                    @error('jenis_qualityloss')
                                        <div class="invalid-feedback col-md-12">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".btn-exit").click(function(e) {
                e.preventDefault();
                $('.save-form input').val('');
                $('.save-form textarea').val('');
                $('.form-modal').modal('hide');
            });

            $(document).on("click", ".btn-action", function(e) {
                e.preventDefault();
                let link = $(this).data('link');
                let type = $(this).data('type');
                let id_sub = $(this).data('id_sub');
                let action = $(this).data('action');


                if (action == 'add') {
                    $('.form-modal').modal('show');
                    if (type == 'parent') {
                        $(".form-modal").find(".modal-title").html("Form Add Parent Quality Loss");
                    } else {
                        $(".form-modal").find(".modal-title").html("Form Add Child Quality Loss");
                    }

                    $('.save-form').safeform({
                        timeout: 2000,
                        submit: function() {
                            // put here validation and ajax stuff...
                            let jenis_qualityloss = $(this).find(
                                    "input[name=jenis_qualityloss]")
                                .val();
                            let desc = $(this).find("input[name=desc]").val();
                            // console.log(name_save);
                            e.preventDefault();
                            $.ajax({
                                type: "post",
                                url: link,
                                data: {
                                    action: action,
                                    id_sub: id_sub,
                                    type: type,
                                    jenis_qualityloss: jenis_qualityloss,
                                    desc: desc,
                                },
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
                                            $('.save-form textarea').val(
                                                '');
                                            location.reload();
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
                                            $('.save-form textarea').val(
                                                '');
                                            location.reload();
                                        });
                                        return;
                                    } else {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Oops...',
                                            text: 'Error',
                                        })
                                    }
                                }
                            });
                            // no need to wait for timeout, re-enable the form ASAP
                            $(this).safeform('complete');
                            return false;
                        }
                    })
                } else if (action == 'edit') {
                    let url = '{{ route('quality_loss.show', ':id') }}';
                    url = url.replace(':id', `${id_sub}`);

                    $('.form-modal').modal('show');

                    $(".form-modal").find(".modal-title").html("Form Edit Quality Loss");

                    $.ajax({
                        type: "get",
                        url: url,
                        data: {
                            id: id_sub
                        },
                        dataType: "json",
                        success: function(response) {
                            $(`input[name=jenis_qualityloss]`).val(response.jenis_qualityloss);
                            $(`input[name=id_sub]`).val(response.id);
                            $(`textarea[name=desc]`).val(response.desc);

                            $('.save-form').safeform({
                                timeout: 2000,
                                submit: function(e) {
                                    // put here validation and ajax stuff...
                                    let jenis_qualityloss = $(this).find(
                                            "input[name=jenis_qualityloss]")
                                        .val();
                                    let id = $(this).find(
                                            "input[name=id_sub]")
                                        .val();
                                    let desc = $(this).find("textarea[name=desc]")
                                        .val();
                                    // console.log(name_save);
                                    e.preventDefault();
                                    $.ajax({
                                        type: "post",
                                        url: link,
                                        data: {
                                            action: action,
                                            id_sub: id,
                                            type: type,
                                            jenis_qualityloss: jenis_qualityloss,
                                            desc: desc,
                                        },
                                        dataType: "json",
                                        success: function(res) {
                                            if (res.msg == 'sukses') {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Success!',
                                                    text: res
                                                        .desc,
                                                }).then(function() {
                                                    $('.form-modal')
                                                        .modal(
                                                            'hide'
                                                        );
                                                    $('.save-form input')
                                                        .val(
                                                            '');
                                                    $('.save-form textarea')
                                                        .val(
                                                            '');
                                                    location
                                                        .reload();
                                                });
                                                return;
                                            } else if (res.msg ==
                                                'error') {
                                                Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Oops...',
                                                    text: res
                                                        .desc,
                                                }).then(function() {
                                                    // $('.form-modal')
                                                    //     .modal(
                                                    //         'hide'
                                                    //     );
                                                    $('.save-form input')
                                                        .val(
                                                            '');
                                                    $('.save-form textarea')
                                                        .val(
                                                            '');
                                                    location
                                                        .reload();
                                                });
                                                return;
                                            } else {
                                                Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Oops...',
                                                    text: 'Error',
                                                })
                                            }
                                        }
                                    });
                                    // no need to wait for timeout, re-enable the form ASAP
                                    $(this).safeform('complete');
                                    return false;
                                }
                            })
                        }
                    });



                } else if (action == 'delete') {
                    $.confirm({
                        title: "Confirmation",
                        content: "Are You Sure You Will Delete Data ?",
                        theme: 'bootstrap',
                        columnClass: 'medium',
                        typeAnimated: true,
                        buttons: {
                            hapus: {
                                text: 'Submit',
                                btnClass: 'btn-red',
                                action: function() {
                                    $.ajax({
                                        type: 'POST',
                                        url: link,
                                        data: {
                                            action: action,
                                            id_sub: id_sub,
                                            type: type,
                                        },
                                        dataType: 'json',
                                        success: function(res) {
                                            if (res.msg == 'sukses') {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Success!',
                                                    text: res.desc,
                                                }).then(function() {
                                                    location.reload();
                                                });
                                                return;
                                            } else if (res.msg == 'error') {
                                                Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Oops...',
                                                    text: res.desc,
                                                }).then(function() {
                                                    location.reload();
                                                });
                                                return;
                                            } else {
                                                Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Oops...',
                                                    text: 'Error',
                                                })
                                            }
                                        },
                                        error: function(xhr, ajaxOptions, thrownError) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: thrownError,
                                            });
                                        }
                                    });
                                }
                            },
                            close: function() {}
                        }
                    });
                }

            });
        });
    </script>
@endsection
