@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Empty</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    @if (session('product'))
        <h5 class="alert alert-danger">{{ session('product') }}</h5>
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
        @can('اضافة منتج')
            <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-flip-horizontal"
                    data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
            </div>
        @endcan


        <div class="modal" id="modaldemo8">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('products.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label text-danger">اضافة منتج </label>
                                <input type="text" class="form-control" name="products_name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label text-danger"> القسم </label>
                                <select class="form-control" name="section">
                                    @foreach ($sections as $s)
                                        <option class="form-control" value="{{ $s->id }}">{{ $s->section_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label text-danger">الوصف</label>
                                <input type="text" class="form-control" name="description">
                            </div>

                            <div class="modal-footer">
                                <button class="btn ripple btn-success" type="submit">تأكيد </button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table key-buttons text-md-nowrap">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">اسم المنتج</th>
                            <th class="border-bottom-0">القسم</th>
                            <th class="border-bottom-0">الوصف</th>
                            <th class="border-bottom-0">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $x = 0 @endphp
                        @foreach ($products as $product)
                            @php $x ++ @endphp
                            <tr>
                                <td>{{ $x }}</td>
                                <td>{{ $product->products_name }}</td>
                                <td>{{ $product->section->section_name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    @can('تعديل منتج')
                                        <button class="btn btn-primary">
                                            <a class="text-white"
                                                href="{{ route('products.edit', ['product' => $product->id]) }}">تعديل</a>
                                        </button>
                                    @endcan

                                    {{-- delete ... view modal bootstrap --}}
                                    @can('حذف منتج')
                                    <button class="btn btn-danger">
                                        <a class="modal-effect text-white" data-effect="effect-flip-horizontal"
                                            data-id="{{ $product->id }}"
                                            data-product_name="{{ $product->products_name }}" data-toggle="modal"
                                            href="#modaldemo2">حذف</a>
                                    </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{-- delete --}}
                <div class="modal" id="modaldemo2">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">حذف المنتج</h6><button aria-label="Close" class="close"
                                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <h6>هل انت متاكد من حذف المنتج؟؟</h6>

                                <form action="" id="id" method="post">
                                    @csrf
                                    @method('DELETE')
                                    {{-- <input type="text" name="id" id="id" value=""> --}}
                                    <input class="form-control" name="product_name" id="product_name" type="text"
                                        readonly>

                                    <button type="submit" class="m-1 btn btn-danger">نعم</button>
                                    <button class="btn ripple btn-secondary" data-dismiss="modal"
                                        type="button">اغلاق</button>

                                </form>


                            </div>

                        </div>
                    </div>
                </div>
                {{-- ================================== --}}
            </div>
        </div>
    </div>
    </div>


    </div>
@endsection
@section('js')
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
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
    <script>
        $('#modaldemo2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var product_name = button.data('product_name')
            var modal = $(this)
            $('#id').attr('action', 'products/' + id);
            // modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
        })
    </script>
@endsection
