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

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
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

        <div class="modal-body">
            <form action="{{ route('sections.update', ['section' => $sections->id]) }}" method="post">
                @csrf
                {{ method_field('PUT') }}
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label text-danger"> اسم القسم </label>
                    <input type="text" class="form-control" value="{{ $sections->section_name }}" name="section">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label text-danger"> الوصف </label>
                    <input type="text" class="form-control" value="{{ $sections->description }}" name="description">
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-success" type="submit">تأكيد </button>

                </div>

            </form>

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
