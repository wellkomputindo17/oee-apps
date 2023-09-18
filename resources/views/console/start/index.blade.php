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
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! session('error') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Start Console</h6>
                </div>
                <div class="card-body">
                    <form class="save-form">
                        <input type="hidden" name="link" value="{{ route('store.console') }}">
                        <div class="form-group row">
                            <label for="mesin_id" class="col-md-4">Machine <span style="color: red;">*</span></label>
                            <input type="hidden" name="mesin_name">
                            <div class="col-md-8">
                                <select class="mesin-select" name="mesin_id" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row plan-row" style="display: none;">
                            <label for="is_plan" class="col-md-4">Is Plan Downtime?</label>
                            <div class="col-md-6">
                                <input type="checkbox" class="is-plan" name="is_plan" value="yes" data-toggle="toggle"
                                    data-on="Yes" data-off="No" data-onstyle="primary" data-size="small"
                                    data-offstyle="danger">
                            </div>
                        </div>
                        <div class="form-group row do-row" style="display: none;">
                            <label for="no_do" class="col-md-4">DO </label>
                            <input type="hidden" name="do_name">
                            <div class="col-md-8">
                                <select class="do-select" name="no_do">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="target">


                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-outline-primary mt-2" type="submit">Start</button>
                                {{-- <button class="btn btn-outline-danger" type="submit">Stop</button> --}}
                            </div>
                        </div>

                    </form>
                </div>
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

            $(".is-plan").change(function(e) {
                e.preventDefault();
                isChecked = $(this).is(':checked');

                if (isChecked) {
                    $(".do-row").hide();
                } else {
                    $(".do-row").show();
                }
            });

            $('.save-form').safeform({
                timeout: 2000,
                submit: function(e) {
                    e.preventDefault();
                    // put here validation and ajax stuff..
                    let formdata = $(this).serializeArray();
                    let link = $(this).find("input[name=link]").val();
                    e.preventDefault();
                    $.ajax({
                        type: "post",
                        url: link,
                        data: formdata,
                        dataType: "json",
                        beforeSend: function() {
                            // Show image container
                            $('.ajax-loader').css("visibility", "visible");
                        },
                        success: function(res) {
                            if (res.msg == 'sukses') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: res.desc,
                                }).then(function() {
                                    let next_href =
                                        '{{ route('list.console', ':id') }}';
                                    next_href = next_href.replace(':id',
                                        `mesin_id=${res.data.mesin_id}&no_do=${res.data.no_do}&mesin_name=${res.data.mesin_name}&do_name=${res.data.do_name}`
                                    );
                                    document.location.href = next_href;
                                });
                                return;
                            } else if (res.msg == 'error') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: res.desc,
                                });
                                return;
                            }
                        },
                        complete: function(data) {
                            // Hide image container
                            $('.ajax-loader').css("visibility", "hidden");
                        }
                    });
                    // no need to wait for timeout, re-enable the form ASAP
                    $(this).safeform('complete');
                    return false;
                }
            })

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
                                    text: `${item.no_mesin} | ${item.name}`,
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
                let id = $(this).val();
                $("input[name=mesin_name]").val(name);

                $.ajax({
                    type: "post",
                    url: '{{ route('change.mesin') }}',
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res == true) {
                            $(".plan-row").show();
                            $(".is-plan").prop("checked", true).change();
                        } else {
                            $(".plan-row").hide();
                            $(".is-plan").prop("checked", false).change();
                            $(".do-row").show();
                        }
                    }
                });
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
                            action: 'not_run'
                        };
                    },

                    dataType: 'json',
                    type: 'POST',
                    delay: 0,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: `${item.no_do} | ${item.name}`,
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
