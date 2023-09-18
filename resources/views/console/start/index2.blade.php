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
                    <form action="{{ route('store.console') }}" method="post" target="_blank">
                        @csrf
                        <div class="form-group row">
                            <label for="mesin_id" class="col-md-4">Machine <span style="color: red;">*</span></label>
                            <input type="hidden" name="mesin_name">
                            <div class="col-md-8">
                                <select class="mesin-select" name="mesin_id" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="line_id" class="col-md-4">Line <span style="color: red;">*</span></label>
                            <input type="hidden" name="line_name">
                            <div class="col-md-8">
                                <select class="line-select" name="line_id" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="no_do" class="col-md-4">DO <span style="color: red;">*</span></label>
                            <input type="hidden" name="do_name">
                            <div class="col-md-8">
                                <select class="do-select" name="no_do" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="target">
                        <div class="form-group row">
                            <label for="is_plan" class="col-md-4">Is Plan Downtime?</label>
                            <div class="col-md-6">
                                <input type="checkbox" class="is-plan" name="is_plan" value="yes" data-toggle="toggle"
                                    data-on="Yes" data-off="No" data-onstyle="primary" data-size="small"
                                    data-offstyle="danger">
                            </div>
                        </div>
                        <div class="form-plan" style="display: none;">
                            <div class="row dynamic-field" id="dynamic-field-1">
                                <div class="col-md-12">
                                    <div class="card shadow my-2">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group row">
                                                    <label for="plan_downtime_name" class="col-md-5">Plan Downtimes
                                                        Search</label>
                                                    <div class="col-md-7">
                                                        <div class="input-group">
                                                            <input type="hidden" name="plan_downtime_id[]"
                                                                class="plan_downtime_id" id="plan_downtime_id_1">
                                                            <input type="text" readonly
                                                                class="form-control plan_downtime_name"
                                                                name="plan_downtime_name[]" id="plan_downtime_name_1">
                                                            <div class="input-group-append">
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-sm btn-outline-primary search-plan"
                                                                    id="search-plan-1" code="1">Search</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="time_plan_start" class="col-md-5">Start & End Time</label>
                                                    <div class="col-md-7">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control time-picker time_plan_start"
                                                                autocomplete="off" id="time_plan_start_1"
                                                                name="time_plan_start[]" placeholder="Start Time">
                                                            <div class="input-group-append input-group-prepend">
                                                                <span class="input-group-text">To</span>
                                                            </div>
                                                            <input type="text"
                                                                class="form-control time-picker time_plan_stop"
                                                                autocomplete="off" id="time_plan_stop_1"
                                                                name="time_plan_stop[]" placeholder="End Time">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="row mt-4">
                                                    <div class="col-md-12">
                                                        <div class="clearfix">
                                                            <button type="button" onclick="return addNewField(this)"
                                                                id="add-button"
                                                                class="btn btn-sm btn-primary float-left text-uppercase shadow-sm"><i
                                                                    class="fa fa-plus fa-fw"></i>
                                                            </button>
                                                            <button type="button" onclick="return removeLastField(this)"
                                                                id="remove-button"
                                                                class="btn btn-sm btn-danger float-left text-uppercase ml-1"><i
                                                                    class="fa fa-minus fa-fw"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <!-- Modal -->
    <div class="modal fade list-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">List Plan Downtimes</h5>
                    <button type="button" class="close btn-exit" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="tree">
                        @foreach ($data as $key => $item)
                            @if (count((array) $item->children) > 0)
                                <li id="menu{{ $key + 1 }}">
                                    <label for="menu{{ $key + 1 }}">
                                        <a class="float-left btn-plan" id="btn-plan-1"
                                            data-name="{{ $item->jenis_downtime }}"
                                            data-id="{{ $item->id }}">{{ $item->jenis_downtime }}</a>

                                    </label>
                                    <input checked id="menu{{ $key + 1 }}" value="" type="checkbox">
                                    <ul>
                                        @foreach ($item->children as $key_sub => $item_sub)
                                            <li id="menu{{ $key_sub + 1 }}">
                                                <a>
                                                    <label for="menu{{ $key_sub + 1 }}" class="btn-plan" id="btn-plan-1"
                                                        data-name="{{ $item_sub->jenis_downtime }}"
                                                        data-id="{{ $item_sub->id }}">{{ $item_sub->jenis_downtime }}</label>
                                                    <input checked="" id="menu{{ $key_sub + 1 }}" value=""
                                                        type="checkbox">

                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li id="menu{{ $key + 1 }}">
                                    <a>
                                        <label for="menu{{ $key + 1 }}" class="btn-plan" id="btn-plan-1"
                                            data-name="{{ $item->jenis_downtime }}"
                                            data-id="{{ $item->id }}">{{ $item->jenis_downtime }}</label>
                                        <input checked="" id="menu{{ $key + 1 }}" value=""
                                            type="checkbox">


                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let buttonAdd = $("#add-button");
        let buttonRemove = $("#remove-button");
        let className = ".dynamic-field";
        let plan_downtime_id = ".plan_downtime_id";
        let plan_downtime_name = ".plan_downtime_name";
        let time_plan_start = ".time_plan_start";
        let time_plan_stop = ".time_plan_stop";
        let search_plan = ".search-plan";
        let btn_plan = ".btn-plan";
        let count = 0;
        let field = "";
        let maxFields = 999;

        function totalFields() {
            return $(className).length;
        }

        function removeLastField(obj) {
            if (totalFields() > 1) {
                $(obj).closest(className).remove();
            } else {
                alert("Minimum 1 line");
            }
        }

        function addNewField(obj) {
            if (totalFields() < maxFields) {
                count = totalFields() + Math.floor(Math.random() * 999) + 1;
                field = $("#dynamic-field-1").clone();
                field.attr("id", "dynamic-field-" + count);
                field.find("input").val("");
                field.find(plan_downtime_id).attr("id", "plan_downtime_id_" + count);
                field.find(plan_downtime_name).attr("id", "plan_downtime_name_" + count);
                field.find(time_plan_start).attr("id", "time_plan_start_" + count);
                field.find(time_plan_stop).attr("id", "time_plan_stop_" + count);
                field.find(search_plan).attr("id", "search-plan-" + count);
                field.find(search_plan).attr("code", count);
                $(className + ":last").after($(field));

                $(`#search-plan-${count}`).click(function(e) {
                    e.preventDefault();
                    let code = $(this).attr("code");
                    $(".list-modal").modal('show');
                    $(btn_plan).attr("id", "btn-plan-" + code);
                });

                $("#search-plan-1").click(function(e) {
                    e.preventDefault();
                    let code = $(this).attr("code");
                    $(".list-modal").modal('show')
                    $(btn_plan).attr("id", "btn-plan-" + 1);
                });

                $('.time-picker').datetimepicker({
                    "allowInputToggle": true,
                    "showClose": true,
                    "showClear": true,
                    "showTodayButton": true,
                    "format": "HH:mm",
                });

                // btnPlan(1);
                btnPlan(count);
            } else {
                alert(`Maximum ${maxFields} line`);
            }
        }

        function btnPlan(code) {
            $(document).on("click", `#btn-plan-${code}`, function(e) {
                e.preventDefault();
                let name = $(this).data('name');
                let id = $(this).data('id');
                $(`#plan_downtime_name_${code}`).val(name);
                $(`#plan_downtime_id_${code}`).val(id);
                $(`.list-modal`).modal('hide')
            });
        }

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            btnPlan(1);

            $("#search-plan-1").click(function(e) {
                e.preventDefault();
                let code = $(this).attr("code");
                $(".list-modal").modal('show')
            });

            $(".is-plan").change(function(e) {
                e.preventDefault();
                isChecked = $(this).is(':checked');

                if (isChecked) {
                    $(".form-plan").show();
                } else {
                    $(".form-plan").hide();
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

                $("input[name=mesin_name]").val(name);
            });

            $(`.do-select`).select2({
                placeholder: 'Search DO...',
                width: "100%",
                allowClear: true,
                ajax: {
                    url: '{{ route('get.do') }}',
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

            $(`.line-select`).select2({
                placeholder: 'Search line...',
                width: "100%",
                allowClear: true,
                ajax: {
                    url: '{{ route('get.line') }}',
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

            $(`.line-select`).change(function(e) {
                e.preventDefault();
                let name = $(this).select2('data')[0].text;

                $("input[name=line_name]").val(name);
            });
        });
    </script>
@endsection
