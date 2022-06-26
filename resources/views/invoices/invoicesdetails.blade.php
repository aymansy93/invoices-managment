@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                    الفاتورة</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($errors->all())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">

        <div class="panel panel-primary tabs-style-2">
            <div class="tab-menu-heading">
                <div class="tabs-menu1">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs main-nav-line">
                        <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a></li>
                        <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                        <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body main-content-body-right border">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab4">
                        <div class="table-responsive">
                            <table id="example1" class="table key-buttons text-md-nowrap">
                                <tbody>
                                    <tr>
                                        <th class="border-bottom-0">رقم الفاتورة</th>
                                        <th class="border-bottom-0">{{ $invoices->invoice_number }}</th>
                                        <th class="border-bottom-0">تاريخ الاصدار</th>
                                        <th class="border-bottom-0">{{ $invoices->invoice_Date }}</th>
                                        <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                        <th class="border-bottom-0">{{ $invoices->due_date }}</th>
                                        <th class="border-bottom-0">المنتج</th>
                                        <th class="border-bottom-0">{{ $invoices->product }}</th>
                                    </tr>
                                    <tr>
                                        <th class="border-bottom-0">القسم</th>
                                        <th class="border-bottom-0">{{ $invoices->section->section_name }}</th>
                                        <th class="border-bottom-0">مبلغ التحصيل</th>
                                        <th class="border-bottom-0">{{ $invoices->Amount_collection }}</th>
                                        <th class="border-bottom-0">مبلغ العمولة</th>
                                        <th class="border-bottom-0">{{ $invoices->Amount_Commission }}</th>
                                        <th class="border-bottom-0">الخصم </th>
                                        <th class="border-bottom-0">{{ $invoices->discount }}</th>
                                    </tr>
                                    <tr>
                                        <th class="border-bottom-0">نسبة الضريبة</th>
                                        <th class="border-bottom-0">{{ $invoices->rate_vat }}</th>
                                        <th class="border-bottom-0">قيمة الضريبة</th>
                                        <th class="border-bottom-0">{{ $invoices->value_vat }}</th>
                                        <th class="border-bottom-0">الاجمالي مع الضريبة</th>
                                        <th class="border-bottom-0">{{ $invoices->total }}</th>
                                        <th class="border-bottom-0">الحالة الحالية</th>
                                        @if ($invoices->value_status == 1)
                                            <th class="border-bottom-0 text-white bg-success">{{ $invoices->status }}
                                            </th>
                                        @elseif ($invoices->value_status == 2)
                                            <th class="border-bottom-0 text-white bg-danger">{{ $invoices->status }}</th>
                                        @else
                                            <th class="border-bottom-0 text-white bg-secondary">{{ $invoices->status }}
                                            </th>
                                        @endif
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane" id="tab5">
                        <table id="example" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">نوع المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">حالات الدفع</th>
                                    <th class="border-bottom-0">تاريخ الدفع</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">تاريخ الاضافة</th>
                                    <th class="border-bottom-0">المستخدم</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php $x = 0 @endphp
                                @foreach ($details as $detail)
                                    @php $x ++ @endphp
                                    <tr>
                                        <td>{{ $x }}</td>
                                        <td>{{ $detail->invoice_numper }}</td>
                                        <td>{{ $detail->product }}</td>
                                        <td>{{ $invoices->section->section_name }}</td>

                                        @if ($detail->value_status == 1)
                                            <td class="border-bottom-0 text-white bg-success">{{ $detail->status }}</td>
                                        @elseif ($detail->value_status == 2)
                                            <td class="border-bottom-0 text-white bg-danger">{{ $detail->status }}</td>
                                        @else
                                            <td class="border-bottom-0 text-white bg-secondary">{{ $detail->status }}
                                            </td>
                                        @endif

                                        <td>{{ $detail->Payment_Date }}</td>
                                        <td>{{ $detail->note }}</td>
                                        <td>{{ $detail->created_at }}</td>
                                        <td>{{ $detail->user }}</td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane" id="tab6">
                        <div class="card-body">
                            @can('اضافة مرفق')
                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                <h5 class="card-title">اضافة مرفقات</h5>
                                <form method="post" action="{{ route('attachments.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="file_name"
                                            required>
                                        <input type="hidden" id="customFile" name="invoice_number"
                                            value="{{ $invoices->invoice_number }}">
                                        <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoices->id }}">
                                        <label class="custom-file-label" for="customFile">حدد
                                            المرفق</label>
                                    </div><br><br>
                                    <button type="submit" class="btn btn-primary btn-sm ">تاكيد</button>
                                </form>
                            @endcan
                        </div><br>
                        <table id="example" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم الملف </th>
                                    <th class="border-bottom-0"> قام بالأضافة</th>
                                    <th class="border-bottom-0">تاريخ الاضافة</th>
                                    <th class="border-bottom-0"> عمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0 @endphp
                                @foreach ($attachments as $x)
                                    @php $i ++ @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $x->filename }}</td>
                                        <td>{{ $x->created_by }}</td>
                                        <td>{{ $x->created_at }}</td>
                                        <td>
                                            <button class="btn btn-primary">
                                                <a class="text-white"
                                                    href="{{ route('openfile', ['invoices_numper' => $x->invoice_numper, 'file_name' => $x->filename]) }}">عرض</a></button>
                                            <button class="btn btn-primary">
                                                <a class="text-white"
                                                    href="{{ route('download', ['invoices_numper' => $x->invoice_numper, 'file_name' => $x->filename]) }}">تحميل</a></button>
                                            @can('حذف المرفق')
                                                <button class="btn btn-danger">
                                                    <a class="modal-effect text-white" data-effect="effect-flip-horizontal"
                                                        data-toggle="modal" href="#modaldemo2">حذف</a>
                                                </button>
                                            @endcan
                                            <div class="modal" id="modaldemo2">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content modal-content-demo">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">حذف مرفق الفاتورة</h6><button
                                                                aria-label="Close" class="close" data-dismiss="modal"
                                                                type="button"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6>هل انت متاكد من حذف المرفق</h6>
                                                            <form action="{{ route('delete.file') }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="invoice_numper"
                                                                    value="{{ $x->invoice_numper }}">
                                                                <input type="hidden" name="file_name"
                                                                    value="{{ $x->filename }}">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $x->id }}">
                                                                <button type="submit"
                                                                    class="m-1 btn btn-danger">نعم</button>
                                                                <button class="btn ripple btn-secondary"
                                                                    data-dismiss="modal" type="button">اغلاق</button>

                                                            </form>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </td>


                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
