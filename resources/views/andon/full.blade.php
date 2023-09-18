@extends('app')
@section('content')
    <div class="row page-header min-vh-100 relative"
        style="background-image: url('{{ asset('assets/img/curved-images/curved.jpg') }}')">
        <div class="col-md-12 p-0 m-0">
            <div class="col-md-12 p-0 m-0">
                <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="javascript:void(0)">
                                    <img src="{{ asset('assets/img/logo.png') }}" width="40" alt="LOGO"
                                        class="img img-fluid"> PT Wellracom Industri Komputindo
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="mx-auto order-0">
                        <a class="navbar-brand mx-auto" href="#">Machine Data Acquisition</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                        <!--digital clock start-->
                        <div class="datetime ml-auto text-white">
                            <div class="date">
                                <span id="dayname">Day</span>,
                                <span id="month">Month</span>
                                <span id="daynum">00</span>,
                                <span id="year">Year</span>
                            </div>
                            <div class="time text-center">
                                <span id="hour">00</span>:
                                <span id="minutes">00</span>:
                                <span id="seconds">00</span>
                                <span id="period" class="d-none">AM</span>
                            </div>
                        </div>
                        <!--digital clock end-->
                    </div>
                </nav>
            </div>
        </div>
        <div class="col-md-12 my-2">
            {{-- <div class="row">
                <div class="col-md-4 mb-2">
                    <select class="form-select bg-dark text-white" id="inputGroupSelect01">
                        <option value="1">Machine 1</option>
                        <option value="2">Machine 2</option>
                        <option value="3">Machine 3</option>
                    </select>
                </div>
            </div> --}}
            <div class="card h-100 bg-dark text-white">
                <div class="card-header bg-dark text-white">
                    OEE Monitoring System
                </div>
                <div class="card-body d-flex flex-column mb-0 bg-dark text-white">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    {{-- <div class="row mb-1">
                                        <label class="col-sm-12 col-md-5 text-form-label">Production No</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" value="PRD-2107001" disabled
                                                class="text-control bg-dark text-white">
                                        </div>
                                    </div> --}}
                                    <div class="row mb-1">
                                        <label class="col-sm-12 col-md-5 text-form-label">Machine Name</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" value="Machine 1" disabled
                                                class="text-control bg-dark text-white">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-1">
                                        <label class="col-sm-12 col-md-5 text-form-label">Date</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" value="{{ date('d M Y') }}" disabled
                                                class="text-control bg-dark text-white">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-sm-12 col-md-5 text-form-label">Time</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" disabled
                                                class="text-control bg-dark text-white time-active">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-1">
                                <label class="col-sm-2 text-form-label">Status</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control bg-success text-white fw-bold text-center" style="font-size: 25px;height: 50%;" disabled>Running</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="chart">
                                <div id="chartSimple" style="height: 370px; width: 100%;"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="chart">
                                <div id="chartRing" style="height: 370px; width: 100%;"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row mt-5">
                                <div class="col-md-4 col-sm-12 align-items-stretch px-1">
                                    <div class="card bg-secondary text-white" style="min-height: 200px;">
                                        <div class="card-header bg-primary text-white text-center px-0">
                                            Avaibility
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span style="font-size: .575em;">Uptime</span><br>
                                                    <span>373 min</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 p-0">
                                                    <span style="font-size: .575em;">Planned Production Time</span><br>
                                                    <span>420 min</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 align-items-stretch px-1">
                                    <div class="card bg-secondary text-white" style="min-height: 200px;">
                                        <div class="card-header bg-success text-white text-center px-0">
                                            Performance
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span style="font-size: .575em;">Total Units</span><br>
                                                    <span>19.271 pcs</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span style="font-size: .575em;">Uptime</span><br>
                                                    <span>373 min</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 px-0">
                                                    <span style="font-size: .575em;" class="p-0">Ideal Manufacturing
                                                        Speed</span><br>
                                                    <span>60 pcs/min</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 align-items-stretch px-1">
                                    <div class="card bg-secondary text-white" style="min-height: 200px;">
                                        <div class="card-header bg-warning text-white text-center px-0">
                                            Quality
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span style="font-size: .575em;">Approved Units</span><br>
                                                    <span>18.848 pcs</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 p-0">
                                                    <span style="font-size: .575em;">Total Units</span><br>
                                                    <span>19.271 pcs</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pb-4">
                            <div class="text-center">
                                <div id="tooltip">
                                </div>
                                <div width="100%" id="timelineRelativeTime"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12 px-1">
                            <div class="card bg-secondary text-white">
                                <div class="card-header bg-primary text-white text-center px-0">
                                    Avaibility
                                </div>
                                <div class="card-body text-center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="chart">
                                                <div id="chartBar-1"
                                                    style="height: 370px; width: 100%;margin-top: -90px;margin-bottom: -150px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 px-1">
                            <div class="card bg-secondary text-white">
                                <div class="card-header bg-success text-white text-center px-0">
                                    Performance
                                </div>
                                <div class="card-body text-center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="chart">
                                                <div id="chartBar-2"
                                                    style="height: 370px; width: 100%;margin-top: -90px;margin-bottom: -150px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 px-1">
                            <div class="card bg-secondary text-white">
                                <div class="card-header bg-warning   text-white text-center px-0">
                                    Quality
                                </div>
                                <div class="card-body text-center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="chart">
                                                <div id="chartBar-3"
                                                    style="height: 370px; width: 100%;margin-top: -90px;margin-bottom: -150px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
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
        var width = 1000;

        var testDataRelative = [{
            times: [{
                    name: 'Machine 1',
                    event: 'Running',
                    color: "green",
                    starting_time: 1693810800000,
                    ending_time: 1693815043000,
                    starting_date: 1693810800,
                    ending_date: 1693815043
                },
                {
                    name: 'Machine 1',
                    event: 'Mechanical Fault',
                    color: "yellow",
                    starting_time: 1693815043000,
                    ending_time: 1693816963000,
                    starting_date: 1693815043,
                    ending_date: 1693816963
                },
                {
                    name: 'Machine 1',
                    event: 'Running',
                    color: "green",
                    starting_time: 1693816963000,
                    ending_time: 1693821600000,
                    starting_date: 1693816963,
                    ending_date: 1693821600
                },
                {
                    name: 'Machine 1',
                    event: 'Former Rusak',
                    color: "yellow",
                    starting_time: 1693821600000,
                    ending_time: 1693823423000,
                    starting_date: 1693821600,
                    ending_date: 1693823423
                },
                {
                    name: 'Machine 1',
                    event: 'Running',
                    color: "green",
                    starting_time: 1693823423000,
                    ending_time: 1693828800000,
                    starting_date: 1693823423,
                    ending_date: 1693828800
                },
                {
                    name: 'Machine 1',
                    event: 'Running',
                    color: "green",
                    starting_time: 1693828800000,
                    ending_time: 1693832400000,
                    starting_date: 1693828800,
                    ending_date: 1693832400
                },
                {
                    name: 'Machine 1',
                    event: 'Breakdowns',
                    color: "yellow",
                    starting_time: 1693832400000,
                    ending_time: 1693838743000,
                    starting_date: 1693832400,
                    ending_date: 1693838743
                },
                {
                    name: 'Machine 1',
                    event: 'Running',
                    color: "green",
                    starting_time: 1693838743000,
                    ending_time: 1693848223000,
                    starting_date: 1693838743,
                    ending_date: 1693848223
                },
            ]
        }, ];

        function timelineRelativeTime() {
            //This solution is for relative time is from
            var chart = d3
                .timeline()
                .relativeTime()
                .itemHeight(40)
                .tickFormat({
                    format: function(d) {
                        return d3.time.format("%H:%M")(d);
                    },
                    tickTime: d3.time.minutes,
                    tickInterval: 30,
                    tickSize: 15
                });
            d3
                .select("#timelineRelativeTime")
                .append("svg")
                .attr("fill", "white")
                .attr("width", width)
                .datum(testDataRelative)
                .call(chart);
        }
    </script>

    <script>
        $(function() {
            timelineRelativeTime();
            // START CHART PICTORIAL BAR
            chartPictorialBar(1, "Avaibility", 100, 55)
            chartPictorialBar(2, "Performance", 100, 83)
            chartPictorialBar(3, "Quality", 100, 79)

            // START CHARTS RING
            chartRing()

            // START CHART SIMPLE
            chartSimple()

            initClock()
        });

        function randomNumber(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function chartRing() {
            let chartRing = document.getElementById('chartRing');
            let myChartRing = echarts.init(chartRing);
            let optionRing;

            const gaugeDataRing = [{
                    value: 64,
                    name: 'Avaibility',
                    title: {
                        offsetCenter: ['0%', '-37%'],
                        color: '#fff'
                    },
                    detail: {
                        valueAnimation: true,
                        offsetCenter: ['0%', '-22%']
                    }
                },
                {
                    value: 75,
                    name: 'Performance',
                    title: {
                        offsetCenter: ['0%', '-5%'],
                        color: '#fff'
                    },
                    detail: {
                        valueAnimation: true,
                        offsetCenter: ['0%', '9%']
                    }
                },
                {
                    value: 78,
                    name: 'Quality',
                    title: {
                        offsetCenter: ['0%', '25%'],
                        color: '#fff'
                    },
                    detail: {
                        valueAnimation: true,
                        offsetCenter: ['0%', '40%']
                    }
                }
            ];
            optionRing = {
                series: [{
                    type: 'gauge',
                    startAngle: 90,
                    endAngle: -270,
                    pointer: {
                        show: false
                    },
                    progress: {
                        show: true,
                        overlap: false,
                        roundCap: true,
                        clip: false,
                        itemStyle: {
                            borderWidth: 1,
                            borderColor: '#464646',
                        }
                    },
                    axisLine: {
                        lineStyle: {
                            width: 40
                        }
                    },
                    splitLine: {
                        show: false,
                        distance: 0,
                        length: 10
                    },
                    axisTick: {
                        show: false
                    },
                    axisLabel: {
                        show: false,
                        distance: 50
                    },
                    data: gaugeDataRing,
                    title: {
                        fontSize: 14
                    },
                    detail: {
                        width: 50,
                        height: 14,
                        fontSize: 14,
                        color: 'inherit',
                        borderColor: 'inherit',
                        borderRadius: 20,
                        borderWidth: 1,
                        formatter: '{value}%'
                    }
                }]
            };
            setInterval(function() {
                gaugeDataRing[0].value = +(randomNumber(64, 100)).toFixed(0);
                gaugeDataRing[1].value = +(randomNumber(75, 100)).toFixed(0);
                gaugeDataRing[2].value = +(randomNumber(78, 100)).toFixed(0);
                myChartRing.setOption({
                    series: [{
                        data: gaugeDataRing,
                        pointer: {
                            show: false
                        }
                    }]
                });
            }, 10000);

            optionRing && myChartRing.setOption(optionRing);
            $(window).on('resize', function() {
                if (myChartRing != null && myChartRing != undefined) {
                    myChartRing.resize();
                }
            });
        }

        function chartSimple() {
            let chartSimple = document.getElementById('chartSimple');
            let myChartSimple = echarts.init(chartSimple);
            let optionSimple;

            const gaugeDataSimple = [{
                value: 72,
                name: 'OEE',
                title: {
                    color: '#fff'
                },
            }]
            optionSimple = {
                series: [{
                    name: 'Pressure',
                    type: 'gauge',
                    progress: {
                        show: true,
                    },
                    detail: {
                        valueAnimation: true,
                        color: '#fff',
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
                    data: gaugeDataSimple
                }]
            };

            setInterval(function() {
                gaugeDataSimple[0].value = +(randomNumber(72, 100)).toFixed(0);
                myChartSimple.setOption({
                    series: [{
                        data: gaugeDataSimple,
                        name: 'OEE',
                        title: {
                            color: '#fff'
                        }
                    }]
                });
            }, 10000);

            optionSimple && myChartSimple.setOption(optionSimple);
            $(window).on('resize', function() {
                if (myChartSimple != null && myChartSimple != undefined) {
                    myChartSimple.resize();
                }
            });
        }

        function chartPictorialBar(id, label, normal_speed, actual_speed) {
            var chartDom = document.getElementById(`chartBar-${id}`);
            var myChart = echarts.init(chartDom);
            var option;

            const labelSetting = {
                color: '#fff',
                show: true,
                position: 'right',
                offset: [0, 0],
                formatter: function(params) {
                    return typeof params.value == 'number' ? params.value + '%' : '';
                },
                fontSize: 12,
            };

            function makeOption(type, symbol) {
                return {
                    legend: {
                        data: ['Normal Speed', 'Actual Speed'],
                        top: "23%",
                        textStyle: {
                            color: "#fff"
                        }
                    },
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    grid: {
                        containLabel: true,
                        left: 20
                    },
                    yAxis: {
                        data: [label],
                        inverse: true,
                        axisLine: {
                            show: false
                        },
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            color: '#fff',
                            margin: 20,
                            fontSize: 12,
                        }
                    },
                    xAxis: {
                        splitLine: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        },
                        axisTick: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        }
                    },
                    animationDurationUpdate: 500,
                    series: [{
                            name: 'Normal Speed',
                            id: 'bar1',
                            type: type,
                            label: labelSetting,
                            symbolRepeat: true,
                            symbolSize: ['50%', '40%'],
                            barCategoryGap: '50%',
                            universalTransition: {
                                enabled: true,
                                delay: function(idx, total) {
                                    return (idx / total) * 1000;
                                }
                            },
                            data: [{
                                value: normal_speed,
                                symbol: symbol
                            }]
                        },
                        {
                            name: 'Actual Speed',
                            id: 'bar2',
                            type: type,
                            barGap: '10%',
                            label: labelSetting,
                            symbolRepeat: true,
                            symbolSize: ['50%', '40%'],
                            universalTransition: {
                                enabled: true,
                                delay: function(idx, total) {
                                    return (idx / total) * 1000;
                                }
                            },
                            data: [{
                                value: actual_speed,
                                symbol: symbol
                            }]
                        }
                    ]
                };
            }
            const options = [
                makeOption('pictorialBar'),
                makeOption('pictorialBar', 'diamond')
            ];
            var optionIndex = 0;
            option = options[optionIndex];

            setInterval(function() {
                optionIndex = (optionIndex + 1) % options.length;
                myChart.setOption(options[optionIndex]);
            }, 2500);

            option && myChart.setOption(option);
            $(window).on('resize', function() {
                if (myChart != null && myChart != undefined) {
                    myChart.resize();
                }
            });
        }
    </script>
    <script>
        setTimeout(() => {
            waktu()
        }, 1000);

        function addZero(i) {
            if (i < 10) {
                i = "0" + i
            }
            return i;
        }

        function waktu() {
            var waktu = new Date();
            setTimeout("waktu()", 1000);
            let time = `${addZero(waktu.getHours())}:${addZero(waktu.getMinutes())}:${addZero(waktu.getSeconds())}`;
            $(".time-active").val(time);
        }

        function updateClock() {
            var now = new Date();
            var dname = now.getDay(),
                mo = now.getMonth(),
                dnum = now.getDate(),
                yr = now.getFullYear(),
                hou = now.getHours(),
                min = now.getMinutes(),
                sec = now.getSeconds(),
                pe = "AM";

            if (hou >= 12) {
                pe = "PM";
            }

            if (hou == 0) {
                hou = 12;
            }

            Number.prototype.pad = function(digits) {
                for (var n = this.toString(); n.length < digits; n = 0 + n);
                return n;
            }

            var months = ["January", "February", "March", "April", "May", "June", "July", "Augest", "September", "October",
                "November", "December"
            ];
            var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds"];
            var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2)];
            for (var i = 0; i < ids.length; i++)
                document.getElementById(ids[i]).firstChild.nodeValue = values[i];
        }

        function initClock() {
            updateClock();
            window.setInterval("updateClock()", 1);
        }
    </script>
@endsection
