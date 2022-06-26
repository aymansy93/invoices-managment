@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <!--div-->
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="col-xl-12">

            <div class="card mg-b-20">
                <div class="card-body">
                    @can('اضافة فاتورة')
                        <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                            <a class="btn btn-primary" href="{{ route('invoices.create') }}">اضافة فاتورة</a>
                        </div><br>
                    @endcan

                    <!--  ==================================================-->
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                    <th class="border-bottom-0">الاجمالي</th>
                                    <th class="border-bottom-0">الحالة</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>


                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $x = 0;
                                @endphp
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        @php $x++ @endphp

                                        {{-- {{dd($invoices)}} --}}

                                        <td>{{ $x }}</td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->Invoice_Date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>
                                            <a class=""
                                                href="{{ route('invoicesdetalis', ['id' => $invoice->id]) }}">
                                                {{ $invoice->section->section_name }}</a>
                                        </td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        @if ($invoice->value_status == 1)
                                            <th class="border-bottom-0 text-white bg-success">{{ $invoice->status }}
                                            </th>
                                        @elseif ($invoice->value_status == 2)
                                            <th class="border-bottom-0 text-white bg-danger">{{ $invoice->status }}</th>
                                        @else
                                            <th class="border-bottom-0 text-white bg-secondary">{{ $invoice->status }}
                                            </th>
                                        @endif
                                        <td>{{ $invoice->note }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    عمليات
                                                </button>
                                                <div class="dropdown-menu bg-primary" aria-labelledby="dropdownMenuButton">
                                                    @can('تعديل الفاتورة')
                                                        <a class="dropdown-item"
                                                            href="{{ route('invoices.edit', ['invoice' => $invoice->id]) }}">تعديل</a>
                                                    @endcan
                                                    {{-- delete --}}
                                                    @can('حذف الفاتورة')
                                                        <button class="dropdown-item btn btn-warning">
                                                            <a class="modal-effect text-dark"
                                                                data-invoice_name="{{ $invoice->invoice_number }}"
                                                                data-invoice_id="{{ $invoice->id }}"
                                                                data-effect="effect-flip-horizontal" data-toggle="modal"
                                                                href="#modaldemo2">حذف</a>
                                                        </button>
                                                    @endcan
                                                    @can('تغير حالة الدفع')
                                                        <a class="dropdown-item bg-danger"
                                                            href="{{ route('invoices.show', ['invoice' => $invoice->id]) }}">
                                                            تغيير حالة الدفع</a>
                                                    @endcan
                                                    @can('ارشفة الفاتورة')
                                                    <button class="dropdown-item btn btn-warning">
                                                        <a class="modal-effect text-dark"
                                                            data-invoice_name="{{ $invoice->invoice_number }}"
                                                            data-invoice_id="{{ $invoice->id }}"
                                                            data-effect="effect-flip-horizontal" data-toggle="modal"
                                                            href="#modaldemo">نقل الى الارشيف</a>
                                                    </button>
                                                    @endcan
                                                    @can('طباعةالفاتورة')
                                                    <a class="dropdown-item"
                                                        href="{{ route('print.invoices', ['id' => $invoice->id]) }}">طباعة
                                                        الفاتورة</a>
                                                    @endcan

                                                </div>
                                            </div>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- delete --}}
                    <div class="modal" id="modaldemo2">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">حذف فاتورة</h6><button aria-label="Close" class="close"
                                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <h6>هل انت متاكد من حذف الفاتورة برقم</h6>
                                    <input class="form-control" name="invoice_name" id="invoice_name" type="text"
                                        readonly>
                                    <form action="" id="id" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="m-1 btn btn-danger">نعم</button>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                                            type="button">اغلاق</button>

                                    </form>


                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- delete --}}

                    {{-- Archive --}}
                    <div class="modal" id="modaldemo" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title"> ارشفة فاتورة</h6><button aria-label="Close" class="close"
                                        data-dismiss="modal" type="button"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <h6>هل انت متاكد من ارشفة الفاتورة برقم</h6>
                                    <input class="form-control" name="invoice_name" id="invoice_name" type="text"
                                        readonly>
                                    <form action="" id="id-archive" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="id_archive" id="id_archive" value="2">
                                        <button type="submit" class="m-1 btn btn-danger">نعم</button>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                                            type="button">اغلاق</button>

                                    </form>


                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- Archive --}}

                </div>
            </div>
        </div>
    </div>
    <!--/div-->


    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script>
        $('#modaldemo2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('invoice_id')
            var invoice_name = button.data('invoice_name')
            var modal = $(this)
            $('#id').attr('action', 'invoices/' + id);
            // modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #invoice_name').val(invoice_name);
        })
    </script>
    <script>
        $('#modaldemo').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('invoice_id')
            var invoice_name = button.data('invoice_name')
            var modal = $(this)
            $('#id-archive').attr('action', 'invoices/' + id);
            // modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #invoice_name').val(invoice_name);
        })
    </script>
@endsection
