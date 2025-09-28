<?php

$page = 'sales-dashboard'; ?>
@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('customer.sidebar.dashboard'))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss'],'build/modules/theme')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js'],'build/modules/theme')
@endsection

@section('page-script')
    @vite(['resources/assets/js/charts-apex.js'],'build/modules/theme')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content">
            {{--<div class="row mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-2 mb-1">
                            <h5 class="">{{trans('customer.sidebar.dashboard')}}</h5>
                        </div>

                    </div>
                </div>
            </div>--}}
            <div class="row mb-5">
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="badge p-2 bg-label-success mb-3 rounded"><i
                                        class="icon-base ti tabler-stethoscope icon-28px"></i>
                            </div>
                            <h5 class="card-title mb-1">{{trans('doctor::doctor.reports.numberOfDoctors')}}</h5>
                            <p class="text-heading mb-3 mt-1">{{$data['numberOfDoctors']}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="badge p-2 bg-label-success mb-3 rounded"><i
                                        class="icon-base ti tabler-users icon-28px"></i>
                            </div>
                            <h5 class="card-title mb-1">{{trans('doctor::doctor.reports.numberOfPatients')}}</h5>
                            <p class="text-heading mb-3 mt-1">{{$data['numberOfPatients']}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="badge p-2 bg-label-success mb-3 rounded"><i
                                        class="icon-base ti tabler-hospital-circle icon-28px"></i>
                            </div>
                            <h5 class="card-title mb-1">{{trans('doctor::doctor.reports.numberOfClinics')}}</h5>
                            <p class="text-heading mb-3 mt-1">{{$data['numberOfClinics']}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="badge p-2 bg-label-success mb-3 rounded"><i
                                        class="icon-base ti tabler-nurse icon-28px"></i>
                            </div>
                            <h5 class="card-title mb-1">{{trans('doctor::doctor.reports.numberOfMedicalPreviews')}}</h5>
                            <p class="text-heading mb-3 mt-1">{{$data['numberOfMedicalPreviews']}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-0">Expense Ratio</h5>
                                <p class="card-subtitle my-0">Spending on various categories</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="donutChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <p class="card-subtitle text-body-secondary mb-1">Balance</p>
                                <h5 class="card-title mb-0">$74,382.72</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="horizontalBarChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>


        (function () {
            let headingColor, legendColor, fontFamily;

            const chartColors = {
                column: {
                    series1: '#826af9',
                    series2: '#d2b0ff',
                    bg: '#f8d3ff'
                },
                donut: {
                    series1: '#fee802',
                    series2: '#3fd0bd',
                    series3: '#826bf8',
                    series4: '#2b9bf4'
                },
                area: {
                    series1: '#29dac7',
                    series2: '#60f2ca',
                    series3: '#a5f8cd'
                },
                bar: {
                    bg: '#1D9FF2'
                }
            };
            headingColor = '#826af9';
            legendColor = '#2b9bf4';
            fontFamily = '#1D9FF2';
            // Donut Chart
            // --------------------------------------------------------------------
            const donutChartEl = document.querySelector('#donutCharts'),
                donutChartConfig = {
                    chart: {
                        height: 357.8,
                        type: 'donut'
                    },
                    labels: ['Operational', 'Networking', 'Hiring', 'R&D'],
                    series: [42, 7, 25, 25],
                    colors: [
                        chartColors.donut.series1,
                        chartColors.donut.series4,
                        chartColors.donut.series3,
                        chartColors.donut.series2
                    ],
                    stroke: {
                        show: false,
                        curve: 'straight'
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val, opt) {
                            return parseInt(val, 10) + '%';
                        }
                    },
                    grid: {
                        padding: {
                            bottom: 20
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        offsetY: -10,
                        markers: {
                            size: '5px',
                            offsetX: -3
                        },
                        itemMargin: {
                            vertical: 3,
                            horizontal: 10
                        },
                        labels: {
                            colors: legendColor,
                            useSeriesColors: false
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    name: {
                                        fontSize: '2rem',
                                        fontFamily: fontFamily
                                    },
                                    value: {
                                        fontSize: '1.2rem',
                                        color: legendColor,
                                        fontFamily: fontFamily,
                                        formatter: function (val) {
                                            return parseInt(val, 10) + '%';
                                        }
                                    },
                                    total: {
                                        show: true,
                                        fontSize: '1.5rem',
                                        color: headingColor,
                                        label: 'Operational',
                                        formatter: function (w) {
                                            return '42%';
                                        }
                                    }
                                }
                            }
                        }
                    },
                    responsive: [
                        {
                            breakpoint: 992,
                            options: {
                                chart: {
                                    height: 380
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        colors: legendColor,
                                        useSeriesColors: false
                                    },
                                    offsetY: -10
                                }
                            }
                        },
                        {
                            breakpoint: 576,
                            options: {
                                chart: {
                                    height: 300
                                },
                                plotOptions: {
                                    pie: {
                                        donut: {
                                            labels: {
                                                show: true,
                                                name: {
                                                    fontSize: '1.5rem'
                                                },
                                                value: {
                                                    fontSize: '1rem'
                                                },
                                                total: {
                                                    fontSize: '1.5rem'
                                                }
                                            }
                                        }
                                    }
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        colors: legendColor,
                                        useSeriesColors: false
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 420,
                            options: {
                                chart: {
                                    height: 280
                                }
                            }
                        },
                        {
                            breakpoint: 360,
                            options: {
                                chart: {
                                    height: 250
                                },
                                legend: {
                                    show: false
                                }
                            }
                        }
                    ]
                };
            if (typeof donutChartEl !== undefined && donutChartEl !== null) {
                const donutChart = new ApexCharts(donutChartEl, donutChartConfig);
                donutChart.render();
            }
        })();
    </script>

@endpush