@extends('adminlte::page')
@section('css')
    <style>
        .c-dashboardInfo {
            margin-bottom: 15px;
        }

        .c-dashboardInfo .wrap {
            background: #ffffff;
            box-shadow: 0px 2px 20px rgba(1, 41, 112, 0.1);
            border-radius: 15px;
            text-align: center;
            position: relative;
            overflow: hidden;
            padding: 40px 25px 20px;
            height: 100%;
        }

        .c-dashboardInfo__title,
        .c-dashboardInfo__subInfo {
            color: #6c6c6c;
            font-size: 1.18em;
        }

        .c-dashboardInfo span {
            display: block;
        }

        .c-dashboardInfo__count {
            font-weight: 600;
            font-size: 2.5em;
            line-height: 64px;
            color: #323c43;
        }

        .c-dashboardInfo .wrap:after {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            content: "";
        }

        .c-dashboardInfo:hover .wrap:after {
            background: linear-gradient(to right, rgb(51, 139, 147), rgb(182, 244, 146));
            transition: 0.3s;
        }

        .c-dashboardInfo:hover {
            transform: scale(1.02);
            cursor: pointer;
        }

        .c-dashboardInfo__title svg {
            color: #d7d7d7;
            margin-left: 5px;
        }

        .MuiSvgIcon-root-19 {
            fill: currentColor;
            width: 1em;
            height: 1em;
            display: inline-block;
            font-size: 24px;
            transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
            user-select: none;
            flex-shrink: 0;
        }
    </style>
@endsection
@section('content')
    <div>
        <div class="p-3">
            <div class="row align-items-stretch">
                {{-- <a class="c-dashboardInfo col-lg-3 col-md-6" href="">
                    <div class="wrap">
                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                            รายการสินทรัพย์ที่ลงทะเบียน <i class="fas fa-hand-holding-usd ml-2"></i></h4>
                        <span class="hind-font caption-12 c-dashboardInfo__count count"></span>
                    </div>
                </a> --}}
                @if (Auth::user()->hasAnyPermission(['*', 'all article', 'create article']))
                    <a class="c-dashboardInfo col-lg-3 col-md-6" href="{{ route('article.index') }}">
                        <div class="wrap">
                            <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                                รายการบทความทั้งหมด<i class="fas fa-newspaper ml-2"></i></h4><span
                                class="hind-font caption-12 c-dashboardInfo__count count">{{ $article_total }}</span>
                        </div>
                    </a>
                @endif

                @if (Auth::user()->hasAnyPermission(['*', 'all article', 'create article']))
                    <a class="c-dashboardInfo col-lg-3 col-md-6" href="{{ route('member.index') }}">
                        <div class="wrap">
                            <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                                รายการสมาชิกทั้งหมด <i class="fas fa-user-plus ml-2"></i></h4><span
                                class="hind-font caption-12 c-dashboardInfo__count count">{{ $member_total }}</span>
                        </div>
                    </a>
                @endif

                <a class="c-dashboardInfo col-lg-3 col-md-6" href="{{ route('user.index') }}">
                    <div class="wrap">
                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                            รายการผู้ใช้งานทั้งหมด <i class="fas fa-users ml-2"></i></h4><span
                            class="hind-font caption-12 c-dashboardInfo__count count">{{ $user_total }}</span>
                    </div>
                </a>
            </div>

            {{-- <div class="card shadow-custom">

                <div class="card-body">
                    <h4 class="text-dark mb-4"> <i class="fas fa-chart-line text-danger mr-2"></i> สถิติการเข้าชม</h4>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="mb-3">
                                <label class="form-label">เลือกวันเพื่อดูสถิติ</label>
                                <input type="text" class="form-control " id="daterange" value=""
                                    style="width: 200px;" />
                            </div>
                        </div>
                        <div class="col-sm-6 mb-5 text-center">
                            <span class="info-box-text ">Traffic</span>
                            <canvas id="GA4Chart"></canvas>
                        </div>
                        <div class="col-sm-3 mb-5 text-center">
                            <span class="info-box-text">Browser</span>
                            <canvas id="GA4Pie"></canvas>
                        </div>
                        <div class="col-sm-3 mb-5 text-center">
                            <span class="info-box-text">Province</span>
                            <canvas id="GA4Donut"></canvas>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-2">
                            <div class="info-box shadow-custom border-custom">
                                <span class="info-box-icon text-danger"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">ผู้เข้าชม</span>
                                    <span class="info-box-number" id="visitors"></span>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-2">
                            <div class="info-box shadow-custom border-custom">
                                <span class="info-box-icon text-danger"><i class="fas fa-user-plus"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-  ext">ผู้เข้าชมใหม่</span>
                                    <span class="info-box-number" id="new_visitors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-2">
                            <div class="info-box shadow-custom border-custom">
                                <span class="info-box-icon text-danger"><i class="far fa-copy"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">จำนวนหน้าที่ชม</span>
                                    <span class="info-box-number" id="pageviews"></span>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-2">
                            <div class="info-box shadow-custom border-custom">
                                <span class="info-box-icon text-danger"><i class="fas fa-mouse-pointer"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">จำนวนการคลิก</span>
                                    <span class="info-box-number" id="event_count_users"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-2">
                            <div class="info-box shadow-custom border-custom">
                                <span class="info-box-icon text-danger"><i class="fas fa-scroll"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Scrolled Users</span>
                                    <span class="info-box-number" id="scrolled_users"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-2">
                            <div class="info-box shadow-custom border-custom">
                                <span class="info-box-icon text-danger"><i class="fas fa-chart-line"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Bounce Rate</span>
                                    <span class="info-box-number" id="bouncerate"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])

@push('js')
    <script>
        //count number function
        $('.count').each(function() {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 1000,
                easing: 'swing',
                step: function(now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });

        // const ctx = document.getElementById('GA4Chart');
        // const ptx = document.getElementById('GA4Pie');
        // const dtx = document.getElementById('GA4Donut');

        // var GA4Chart = new Chart(ctx, {
        //     type: 'line',
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 position: 'top',
        //             },
        //             title: {
        //                 display: true,
        //                 // text: 'Traffic',
        //             }
        //         }
        //     },
        // });

        // var GA4Pie = new Chart(ptx, {
        //     type: 'pie',
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 position: 'top',
        //             },
        //             title: {
        //                 display: true,
        //                 // text: 'Web Browser',
        //             }
        //         }
        //     },
        // });


        // var GA4Donut = new Chart(dtx, {
        //     type: 'doughnut',
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 position: 'top',
        //             },
        //             title: {
        //                 display: true,
        //                 // text: 'Province'
        //             }
        //         }
        //     },
        // });


        // $(document).ready(function() {
        //     let data = {
        //         _token: CSRF_TOKEN,
        //         startDate: null,
        //         endDate: null,
        //     };

        //     getGA4Data(data);
        // });

        // var start = moment();
        // var end = moment();

        // function cb(start, end) {
        //     $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        // }

        // $('#daterange').daterangepicker({
        //     startDate: start,
        //     endDate: end,
        //     maxDate: end,
        //     ranges: {
        //         'วันนี้': [moment(), moment()],
        //         'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //         '7 วันที่แล้ว': [moment().subtract(6, 'days'), moment()],
        //         '30 วันที่แล้ว': [moment().subtract(29, 'days'), moment()],
        //         'เดือนนี้': [moment().startOf('month'), moment().endOf('month')],
        //         'เดือนที่แล้ว': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
        //             .endOf('month')
        //         ]
        //     },
        //     locale: {
        //         format: 'DD/MM/YYYY'
        //     },
        //     applyButtonClasses: "btn-info",
        //     drop: 'auto',
        // }, cb);

        // cb(start, end);

        // $('#daterange').on('change', function() {
        //     daterange = $(this).val().replaceAll(' ', '');

        //     startDate = daterange.split('-')[0];
        //     endDate = daterange.split('-')[1];

        //     let data = {
        //         _token: CSRF_TOKEN,
        //         startDate: startDate,
        //         endDate: endDate,
        //     };

        //     getGA4Data(data);

        // });

        // function getGA4Data(data) {
        //     api_url = "{{ route('analytics') }}";

        //     $.ajax({
        //         type: "post",
        //         url: api_url,
        //         data: data,
        //         success: function(response) {
        //             visitors = (response.analytics.length > 0 ? response.analytics[0].activeUsers : 0);
        //             new_visitors = (response.analytics.length > 0 ? response.analytics[0].newUsers : 0)
        //             pageviews = (response.analytics.length > 0 ? response.analytics[0].screenPageViews : 0)
        //             bouncerate = (response.analytics.length > 0 ? parseFloat(response.analytics[0].bounceRate) :
        //                 0)
        //             scrolled_users = (response.analytics.length > 0 ? parseFloat(response.analytics[0]
        //                 .scrolledUsers) : 0)
        //             event_count_users = (response.analytics.length > 0 ? parseFloat(response.analytics[0]
        //                     .eventCount) + ' (' + (parseFloat(response.analytics[0].eventCountPerUser))
        //                 .toFixed(2) + ')' : 0)

        //             $('#visitors').text(visitors);
        //             $('#new_visitors').text(new_visitors);
        //             $('#pageviews').text(pageviews);
        //             $('#bouncerate').text(bouncerate.toFixed(2) + '%');
        //             $('#event_count_users').text(event_count_users);
        //             $('#scrolled_users').text(scrolled_users);

        //             ga4_report_graph(response.date, response.visitors, response.pageviews);
        //             ga4_report_pie(response.topbrowsers);
        //             ga4_report_donut(response.regions);
        //         }
        //     });
        // }

        // function ga4_report_graph(date, visitors, pageviews) {

        //     const labels = date;

        //     const data = {
        //         labels: labels,
        //         datasets: [{
        //                 label: 'ผู้เข้าชม',
        //                 data: visitors,
        //                 fill: false,
        //                 borderColor: '#17a2b8',
        //                 tension: 0.1
        //             },
        //             {
        //                 label: 'การเข้าชมหน้าเว็บ',
        //                 data: pageviews,
        //                 fill: false,
        //                 borderColor: '#E96479',
        //                 tension: 0.1
        //             }
        //         ]
        //     };

        //     GA4Chart.data = data;
        //     GA4Chart.update();

        // }

        // function ga4_report_pie(topbrowsers) {

        //     let browsers = [];
        //     let amount = [];

        //     topbrowsers.forEach(topbrowser => {
        //         browsers.push(topbrowser.browser == '(not set)' ? 'ไม่ระบุ' : topbrowser.browser);
        //         amount.push(topbrowser.screenPageViews);
        //     });

        //     const pie_data = {
        //         labels: browsers,
        //         datasets: [{
        //             label: 'จำนวนผู้เข้าชม',
        //             data: amount,
        //         }]
        //     };

        //     GA4Pie.data = pie_data;
        //     GA4Pie.update();
        // }

        // function ga4_report_donut(regions) {

        //     var hue = Math.floor(Math.random() * 360);
        //     var pastel = 'hsl(' + hue + ', 100%, 80%)';

        //     let region_data = [];
        //     let region_label = [];

        //     regions.forEach((region, index) => {
        //         if (region.country == 'Thailand') {
        //             region_label.push(region.region);
        //             region_data.push(region.screenPageViews);

        //         }
        //     });

        //     const donut_data = {
        //         labels: region_label,
        //         datasets: [{
        //             label: 'การเข้าชมหน้าเว็บ',
        //             data: region_data,
        //             backgroundColor: [
        //                 '#A7E9AF',
        //                 '#75B79E',
        //                 '#6A8CAF',
        //                 '#8AC6D1',
        //                 '#C2B0C9',
        //                 '#9EA1D4',
        //                 '#9656A1',
        //                 '#745C97',
        //                 '#9BE3DE',
        //                 '#C2E8CE',
        //                 '#DCFFCC',
        //                 '#F5FEC0',
        //                 '#F1F7B5',
        //                 '#FFDDD2',
        //                 '#FFACC7',
        //                 '#FF8AAE',
        //                 '#FD8A8A',
        //                 '#E36387',
        //                 '#D35D6E',
        //                 '#FA9191',
        //                 '#F5B971',
        //                 '#F6D186',
        //                 '#FCF7BB',
        //                 '#E4BAD4',
        //                 '#B983FF',
        //                 '#94D0CC',
        //                 '#99FEFF',
        //                 '#CAF7E3',
        //                 '#FDFFBC',
        //                 '#F7ECDE',
        //                 '#EFB08C',
        //             ],
        //             hoverOffset: 4
        //         }]
        //     };

        //     GA4Donut.data = donut_data;
        //     GA4Donut.update();
        // }
    </script>
@endpush
@endsection
