@extends('layouts.master')
@section('css')
<style>
    @media print {
        #print-Button {
            display: none;
        }
    }

</style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعة فاتورة</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice" id="print">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">منصة الدفع الالكتروني</h1>
										<div class="billed-from">
											<h6>company , Inc.</h6>
											<p>201 Something St., Something Town, YT 242, Country 6546<br>
											Tel No: 324 445-4544<br>
											Email: youremail@companyname.com</p>
										</div><!-- billed-from -->
									</div><!-- invoice-header -->
									<div class="row mg-t-20">
										<div class="col-md">
											<label class="tx-gray-600">Billed To</label>
											<div class="billed-to">
												<h6> {{Auth::user()->name}}</h6>
												<p>4033 Patterson Road, Staten Island, NY 10301<br>
												Tel No: 324 445-4544<br>
												Email: {{Auth::user()->email}}</p>
											</div>
										</div>
										<div class="col-md">
                                            @php $total = $invoices->Amount_collection + $invoices->Amount_Commission  @endphp

											<label class="tx-gray-600">Invoice Information</label>
											<p class="invoice-info-row"><span> رقم الفاتورة</span> <span>{{$invoices->invoice_number}}</span></p>
											<p class="invoice-info-row"><span> اسم المنتج</span> <span>{{$invoices->product}}</span></p>
											<p class="invoice-info-row"><span>تاريخ الفاتورة :</span> <span>{{$invoices->Invoice_Date}}</span></p>
											<p class="invoice-info-row"><span>تاريخ الاستحقاق :</span> <span>{{$invoices->due_date}}</span></p>
                                            <p class="invoice-info-row"><span> مبلغ التحصيل:</span> <span>{{$invoices->Amount_collection}}</span></p>
											<p class="invoice-info-row"><span>مبلغ العمولة :</span> <span>{{$invoices->Amount_Commission}}</span></p>
                                            <p class="invoice-info-row"><span>نسبة ضريبة القيمة المضافة :</span> <span>{{$invoices->rate_vat}}</span></p>
                                            <p class="invoice-info-row"><span>المبلغ الاجمالي :</span> <span>{{$total}}</span></p>

										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">القسم</th>
													<th class="wd-40p">وصف القسم</th>
													<th class="tx-center">الخصم ان وجد! </th>
													<th class="tx-right">الاجمالي شامل الضريبة</th>

												</tr>
											</thead>
											<tbody>
                                                <tr>
                                                    <td>{{$invoices->section->section_name}}</td>
                                                    <td>{{$invoices->section->description}}</td>
                                                    <td >{{$invoices->discount}}</td>
                                                    <td>{{$invoices->total}}</td>
                                                </tr>
                                            </tbody>
										</table>
									</div>
									<hr class="mg-b-40">
									<a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print-Button" onclick="printDiv()">
										<i class="mdi mdi-printer ml-1"></i>طباعة
									</a>

								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<script type="text/javascript">
    function printDiv() {
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

</script>
@endsection
