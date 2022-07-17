@extends('layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحبا {{ Auth::user()->name }} اهلا بعودتك</h2>
                <p class="mg-b-0">منصة الدفع الالكتروني -تحصيل الفواتير</p>
            </div>
        </div>

    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    @php
    $invoices_count = App\Models\invoices::count();
    $invoices_sum = number_format(App\Models\invoices::sum('total'), 2);

    $invoices_count_1 = App\Models\invoices::where('value_status', 1)->count();
    $invoices_count_2 = App\Models\invoices::where('value_status', 2)->count();
    $invoices_count_3 = App\Models\invoices::where('value_status', 3)->count();

    $invoices_sum_1 = number_format(App\Models\invoices::where('value_status', 1)->sum('total'), 2);
    $invoices_sum_2 = number_format(App\Models\invoices::where('value_status', 2)->sum('total'), 2);
    $invoices_sum_3 = number_format(App\Models\invoices::where('value_status', 3)->sum('total'), 2);

    $n = $invoices_count == 0 ? 0 : ($invoices_count / $invoices_count) * 100;
    $n_1 = $invoices_count == 0 ? 0 : round(($invoices_count_1 / $invoices_count) * 100,0);
    $n_2 = $invoices_count == 0 ? 0 : round(($invoices_count_2 / $invoices_count) * 100,0);
    $n_3 = $invoices_count == 0 ? 0 : round(($invoices_count_3 / $invoices_count) * 100,0);

    @endphp
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">اجمالي الفواتير</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $invoices_sum }}</h4>
                                <p class="mb-0 fs-2 text text-white op-7">عدد الفواتير الكلي :{{ $invoices_count }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"> {{ $n }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
                @if ($invoices_count == 0)
                    <span id="compositeline" class="pt-1"></span>
                @else
                    <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                @endif
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير الغير مدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $invoices_sum_2 }}</h4>
                                <p class="mb-0 fs-2 text text-white op-7">عدد الفواتير الغير مدفوعة:{{ $invoices_count_2 }}
                                </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7"> {{ $n_2 }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
                @if ($invoices_count_2 == 0)
                    <span id="compositeline" class="pt-1"></span>
                @else
                    <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
                @endif

            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $invoices_sum_1 }}</h4>
                                <p class="mb-0 fs-2 text text-white op-7">عدد الفواتير المدفوعة:{{ $invoices_count_1 }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"> {{ $n_1 }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
                @if ($invoices_count_1 == 0)
                    <span id="compositeline" class="pt-1"></span>
                @else
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
                @endif
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة جزئيا</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $invoices_sum_3 }}</h4>
                                <p class="mb-0 fs-2 text text-white op-7">عدد الفواتير المدفوعة
                                    جزئيا:{{ $invoices_count_3 }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7">{{ $n_3 }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
                @if ($invoices_count_3 == 0)
                    <span id="compositeline" class="pt-1"> </span>
                @else
                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                @endif
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-7">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">احصائيات الفواتير</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 text-muted mb-0">حسب الرسم البياني</p>
                </div>
                <div class="card-body" style="width:75%;">
                    {!! $chartjs->render() !!}

                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-5">
            <div class="card card-dashboard-map-one">
                <label class="main-content-label">احصائية الفواتير</label>
                <div class="" style="width: 100%">
                    {!! $chartjs_2->render() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-4 col-md-12 col-lg-12">

        </div>
    </div>
    <!-- row close -->

    <!-- row opened -->
    {{-- <div class="row row-sm row-deck">
        <div class="col-md-12 col-lg-4 col-xl-4">
            <div class="card card-dashboard-eight pb-2">
            </div>
        </div>
    </div> --}}
    <!-- /row -->
    <!-- Container closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <!--Internal  Flot js-->
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
@endsection
