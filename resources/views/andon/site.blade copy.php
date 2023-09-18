@extends('app')
@section('content')
    <div class="row page-header min-vh-100 relative"
        style="background-image: url('{{ asset('assets/img/curved-images/curved.jpg') }}')">
        <div class="col-md-12 p-0 m-0">
            <!-- Image and text -->
            <nav class="navbar navbar-dark navbar-expand-md bg-faded justify-content-center bg-dark">
                <a class="navbar-brand d-flex w-50 mr-auto text-white" href="javascript:void(0)">
                    <img src="{{ asset('assets/img/logo.png') }}" width="40" alt="">
                </a>
                <button class="navbar-toggler text-white" type="button" data-toggle="collapse"
                    data-target="#collapsingNavbar3">
                    <span class="navbar-toggler-icon text-white"></span>
                </button>
                <div class="navbar-collapse collapse w-50 text-white" id="collapsingNavbar3">
                    <h6 class="w-100 justify-content-center">PT Wellracom Industri Komputindo</h6>
                    <ul class="navbar-nav  justify-content-center">
                    </ul>


                    <ul class="nav navbar-nav ml-auto  justify-content-end">
                        <p>TEST</p>
                    </ul>
                </div>
            </nav>

        </div>
        <div class="col-md-6 my-3">
            <div id="line-1" class="card h-100 bg-dark text-white">
                <div id="header-card" class="card-header bg-dark text-white">
                    <span class="float-left status-mesin">-</span>
                    <span style="font-size: 11px;" class="float-right time-line mt-1 mx-1">&nbsp;00:00:00</span>
                </div>
                <div class="card-body d-flex flex-column mb-0">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <h5 class="card-title nama-mesin">-</h5>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">DO Number</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="do-number" class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Operator</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="operator" class="text-control bg-dark text-white">
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Target</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="target" class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Actual</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="actual" class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Cycle Time</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="cycle-time" class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">NG <span class="small-text">(pcs)</span></label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="ng" class="text-control bg-dark text-white">
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-12">

                            <div class="chart">
                                <div id="chartSimple_1"
                                    style="height: 370px; width: 100%;margin-top: -70px;margin-bottom: -80px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 my-3">
            <div id="line-2" class="card h-100 bg-dark text-white">
                <div id="header-card" class="card-header bg-dark text-white">
                    <span class="float-left status-mesin">-</span>
                    <span style="font-size: 11px;" class="float-right time-line mt-1 mx-1">&nbsp;00:00:00</span>

                </div>
                <div class="card-body d-flex flex-column mb-0">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <h5 class="card-title nama-mesin">-</h5>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">DO Number</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="do-number" class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Operator</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="operator" class="text-control bg-dark text-white">
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Target</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="target" class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Actual</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="actual"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Cycle Time</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="cycle-time"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">NG <span class="small-text">(pcs)</span></label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="ng"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-12">

                            <div class="chart">
                                <div id="chartSimple_2"
                                    style="height: 370px; width: 100%;margin-top: -70px;margin-bottom: -80px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 my-3">
            <div id="line-3" class="card h-100 bg-dark text-white">
                <div id="header-card" class="card-header bg-dark text-white">
                    <span class="float-left status-mesin">-</span>
                    <span style="font-size: 11px;" class="float-right time-line mt-1 mx-1">&nbsp;00:00:00</span>

                </div>
                <div class="card-body d-flex flex-column mb-0">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <h5 class="card-title nama-mesin">-</h5>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">DO Number</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="do-number"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Operator</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="operator"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Target</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="target"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Actual</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="actual"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Cycle Time</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="cycle-time"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">NG <span class="small-text">(pcs)</span></label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="ng"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-12">

                            <div class="chart">
                                <div id="chartSimple_3"
                                    style="height: 370px; width: 100%;margin-top: -70px;margin-bottom: -80px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 my-3">
            <div id="line-4" class="card h-100 bg-dark text-white">
                <div id="header-card" class="card-header bg-dark text-white">
                    <span class="float-left status-mesin">-</span>
                    <span style="font-size: 11px;" class="float-right time-line mt-1 mx-1">&nbsp;00:00:00</span>

                </div>
                <div class="card-body d-flex flex-column mb-0">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <h5 class="card-title nama-mesin">-</h5>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">DO Number</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="do-number"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Operator</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="operator"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Target</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="target"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Actual</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="actual"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">Cycle Time</label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="cycle-time"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label class="col-md-5 text-form-label">NG <span class="small-text">(pcs)</span></label>
                                <div class="col-md-7">
                                    <input type="text" disabled id="ng"
                                        class="text-control bg-dark text-white">
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-12">

                            <div class="chart">
                                <div id="chartSimple_4"
                                    style="height: 370px; width: 100%;margin-top: -70px;margin-bottom: -80px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function chartSimple(id, value) {
            let chartSimple_1 = document.getElementById(`chartSimple_${id}`);
            let myChartSimple_1 = echarts.init(chartSimple_1);
            let optionSimple;
            optionSimple = {
                series: [{
                    name: 'Pressure',
                    type: 'gauge',
                    progress: {
                        show: true,
                    },
                    itemStyle: {
                        color: '#22428D',
                    },
                    detail: {
                        valueAnimation: true,
                        color: '#fff',
                        fontSize: '15px',
                        formatter: '{value}%'
                    },
                    splitLine: {
                        lineStyle: {
                            color: '#fff'
                        }
                    },
                    axisTick: {
                        lineStyle: {
                            color: '#fff'
                        }
                    },
                    axisPointer: {
                        label: {
                            color: '#fff'
                        }
                    },
                    axisLabel: {
                        color: '#fff'
                    },
                    data: value
                }]
            };

            $(window).on('resize', function() {
                if (myChartSimple_1 != null && myChartSimple_1 != undefined) {
                    myChartSimple_1.resize();
                }
            });

            return optionSimple && myChartSimple_1.setOption(optionSimple);
        }

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

        $(function() {
            // START CHART SIMPLE
            const gaugeDataSimple = [{
                value: 0,
                title: {
                    color: '#fff'
                },
            }]
            chartSimple(1, gaugeDataSimple);
            chartSimple(2, gaugeDataSimple);
            chartSimple(3, gaugeDataSimple);
            chartSimple(4, gaugeDataSimple);

            const Http = window.axios;
            const Echo = window.Echo;
            let channel = Echo.channel('services-oee');
            channel.listen('OeeEvent', function(data) {
                let res = data.message;
                for (let i = 0; i < res.length; i++) {
                    if (res[i].msg == 'success') {
                        let from = new Date(dmyToDate(res[i].time));
                        let diffSecs = Math.abs((new Date().getTime() - from.getTime()) /
                            1000);
                        let live_time = secondsToDhms(diffSecs);
                        // }
                        $(`#line-${res[i].mesin_id} .nama-mesin`).html(`${res[i].nama_mesin}`);
                        $(`#line-${res[i].mesin_id} .status-mesin`).html(`${res[i].status}`);
                        $(`#line-${res[i].mesin_id} .time-line`).html(`${live_time}`);
                        $(`#line-${res[i].mesin_id} #do-number`).val(`${res[i].oee.nomorDo}`);
                        $(`#line-${res[i].mesin_id} #cycle-time`).val(`${res[i].oee.cycleTime}`);
                        $(`#line-${res[i].mesin_id} #ng`).val(`${res[i].oee.notGood}`);
                        $(`#line-${res[i].mesin_id} #operator`).val(`${res[i].operator}`);
                        $(`#line-${res[i].mesin_id} #target`).val(`${res[i].target}`);
                        $(`#line-${res[i].mesin_id} #actual`).val(`${res[i].oee.actual}`);

                        gaugeDataSimple[0].value = (100 - (res[i].target - res[i].oee.actual) / res[i]
                                .target * 100)
                            .toFixed(
                                2);
                        // let chartSimple = ;
                        chartSimple(res[i].mesin_id, gaugeDataSimple);

                        if (res[i].status == 'produksi') {
                            $(`#line-${res[i].mesin_id} .status-mesin`).html("Running");
                            $(`#line-${res[i].mesin_id}`).removeClass();
                            $(`#line-${res[i].mesin_id}`).addClass('card h-100 bg-success text-white');
                            $(`#line-${res[i].mesin_id} #do-number`).removeClass();
                            $(`#line-${res[i].mesin_id} #do-number`).addClass(
                                'text-control bg-success text-white');
                            $(`#line-${res[i].mesin_id} #header-card`).removeClass();
                            $(`#line-${res[i].mesin_id} #header-card`).addClass(
                                'card-header bg-success text-white');
                            $(`#line-${res[i].mesin_id} #cycle-time`).removeClass();
                            $(`#line-${res[i].mesin_id} #cycle-time`).addClass(
                                'text-control bg-success text-white');
                            $(`#line-${res[i].mesin_id} #ng`).removeClass();
                            $(`#line-${res[i].mesin_id} #ng`).addClass(
                                'text-control bg-success text-white');
                            $(`#line-${res[i].mesin_id} #operator`).removeClass();
                            $(`#line-${res[i].mesin_id} #operator`).addClass(
                                'text-control bg-success text-white');
                            $(`#line-${res[i].mesin_id} #target`).removeClass();
                            $(`#line-${res[i].mesin_id} #target`).addClass(
                                'text-control bg-success text-white');
                            $(`#line-${res[i].mesin_id} #actual`).removeClass();
                            $(`#line-${res[i].mesin_id} #actual`).addClass(
                                'text-control bg-success text-white');
                        } else if (res[i].status == 'downtime') {
                            $(`#line-${res[i].mesin_id} .status-mesin`).html("Downtime");
                            $(`#line-${res[i].mesin_id}`).removeClass();
                            $(`#line-${res[i].mesin_id}`).addClass('card h-100 bg-danger text-white');
                            $(`#line-${res[i].mesin_id} #do-number`).removeClass();
                            $(`#line-${res[i].mesin_id} #do-number`).addClass(
                                'text-control bg-danger text-white');
                            $(`#line-${res[i].mesin_id} #header-card`).removeClass();
                            $(`#line-${res[i].mesin_id} #header-card`).addClass(
                                'card-header bg-danger text-white');
                            $(`#line-${res[i].mesin_id} #cycle-time`).removeClass();
                            $(`#line-${res[i].mesin_id} #cycle-time`).addClass(
                                'text-control bg-danger text-white');
                            $(`#line-${res[i].mesin_id} #ng`).removeClass();
                            $(`#line-${res[i].mesin_id} #ng`).addClass(
                                'text-control bg-danger text-white');
                            $(`#line-${res[i].mesin_id} #operator`).removeClass();
                            $(`#line-${res[i].mesin_id} #operator`).addClass(
                                'text-control bg-danger text-white');
                            $(`#line-${res[i].mesin_id} #target`).removeClass();
                            $(`#line-${res[i].mesin_id} #target`).addClass(
                                'text-control bg-danger text-white');
                            $(`#line-${res[i].mesin_id} #actual`).removeClass();
                            $(`#line-${res[i].mesin_id} #actual`).addClass(
                                'text-control bg-danger text-white');
                        } else if (res[i].status == 'Finish') {
                            $(`#line-${res[i].mesin_id} .status-mesin`).html("Finish");
                            $(`#line-${res[i].mesin_id}`).removeClass();
                            $(`#line-${res[i].mesin_id}`).addClass('card h-100 bg-primary text-white');
                            $(`#line-${res[i].mesin_id} #do-number`).removeClass();
                            $(`#line-${res[i].mesin_id} #do-number`).addClass(
                                'text-control bg-primary text-white');
                            $(`#line-${res[i].mesin_id} #header-card`).removeClass();
                            $(`#line-${res[i].mesin_id} #header-card`).addClass(
                                'card-header bg-primary text-white');
                            $(`#line-${res[i].mesin_id} #cycle-time`).removeClass();
                            $(`#line-${res[i].mesin_id} #cycle-time`).addClass(
                                'text-control bg-primary text-white');
                            $(`#line-${res[i].mesin_id} #ng`).removeClass();
                            $(`#line-${res[i].mesin_id} #ng`).addClass(
                                'text-control bg-primary text-white');
                            $(`#line-${res[i].mesin_id} #operator`).removeClass();
                            $(`#line-${res[i].mesin_id} #operator`).addClass(
                                'text-control bg-primary text-white');
                            $(`#line-${res[i].mesin_id} #target`).removeClass();
                            $(`#line-${res[i].mesin_id} #target`).addClass(
                                'text-control bg-primary text-white');
                            $(`#line-${res[i].mesin_id} #actual`).removeClass();
                            $(`#line-${res[i].mesin_id} #actual`).addClass(
                                'text-control bg-primary text-white');
                        } else {
                            $(`#line-${res[i].mesin_id} .status-mesin`).html("-");
                            $(`#line-${res[i].mesin_id}`).removeClass();
                            $(`#line-${res[i].mesin_id}`).addClass('card h-100 bg-dark text-white');
                            $(`#line-${res[i].mesin_id} #do-number`).removeClass();
                            $(`#line-${res[i].mesin_id} #do-number`).addClass(
                                'text-control bg-dark text-white');
                            $(`#line-${res[i].mesin_id} #header-card`).removeClass();
                            $(`#line-${res[i].mesin_id} #header-card`).addClass(
                                'card-header bg-dark text-white');
                            $(`#line-${res[i].mesin_id} #cycle-time`).removeClass();
                            $(`#line-${res[i].mesin_id} #cycle-time`).addClass(
                                'text-control bg-dark text-white');
                            $(`#line-${res[i].mesin_id} #ng`).removeClass();
                            $(`#line-${res[i].mesin_id} #ng`).addClass(
                                'text-control bg-dark text-white');
                            $(`#line-${res[i].mesin_id} #operator`).removeClass();
                            $(`#line-${res[i].mesin_id} #operator`).addClass(
                                'text-control bg-dark text-white');
                            $(`#line-${res[i].mesin_id} #target`).removeClass();
                            $(`#line-${res[i].mesin_id} #target`).addClass(
                                'text-control bg-dark text-white');
                            $(`#line-${res[i].mesin_id} #actual`).removeClass();
                            $(`#line-${res[i].mesin_id} #actual`).addClass(
                                'text-control bg-dark text-white');
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



        });
    </script>
@endsection
