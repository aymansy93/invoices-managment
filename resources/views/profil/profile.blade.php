@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الملف الشخصي</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/الرئيسية</span>
            </div>
        </div>
        @if (session('profil'))
            <h5 class="alert alert-danger">{{ session('profil') }}</h5>
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

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                @php $img = Auth::user()->profil->image_path @endphp
                                @if($img)
                                <img alt="user-img"
                                    src="{{ url($img)}}">
                                @else
                                <img alt="" src="{{ asset('assets/img/faces/NevaCoin.svg')}}">
                                @endif
                                <form id="form" action="{{route('profil.set_img')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <label for="img"> <i class="fas fa-camera profile-edit"></i></label>
                                    <input type="file" class="upload-image" name="image" id="img" style="display: none;visibility:none;">
                                </form>
                            </div>
                            <div class="d-flex mt-4 justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{ Auth::user()->name }}</h5>

                                    <p class="main-profile-name-text">{{ $profil->role }}</p>
                                </div>
                            </div>

                            <div class="main-profile-bio">
                                {{ $profil->description }}
                            </div><!-- main-profile-bio -->

                            <hr class="mg-y-30">
                            <label class="main-content-label tx-13 mg-b-20">مواقع التواصل الاجتماعي</label>
                            <div class="main-profile-social-list">
                                <div class="media">
                                    <div class="media-icon bg-primary-transparent text-primary">
                                        <i class="icon ion-logo-github"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Github</span> <a href="{{ $profil->github }}">{{ $profil->github }}</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-success-transparent text-success">
                                        <i class="icon ion-logo-twitter"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Twitter</span> <a href="{{ $profil->twitter }}">{{ $profil->twitter }}</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-info-transparent text-info">
                                        <i class="icon ion-logo-linkedin"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Linkedin</span> <a href="{{ $profil->linkedin }}">{{ $profil->linkedin }}</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-danger-transparent text-danger">
                                        <i class="icon ion-logo-facebook"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Facebook</span> <a href="{{ $profil->facebook }}">{{ $profil->facebook }}</a>
                                    </div>
                                </div>
                            </div>
                            <hr class="mg-y-30">

                            @php
                                $user_id = Auth::user()->id;
                                $invoices_count = App\Models\invoices::where('user_id', $user_id)->count();
                                $invoices_count_1 = App\Models\invoices::where('value_status', 1)
                                    ->where('user_id', $user_id)
                                    ->count();
                                $invoices_count_3 = App\Models\invoices::where('value_status', 3)
                                    ->where('user_id', $user_id)
                                    ->count();

                            @endphp



                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row row-sm">
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-primary-transparent">
                                    <i class="icon-layers text-primary"></i>
                                </div>
                                <div class="mr-auto">
                                    <h5 class="tx-13">الفواتير المضافة بواسطتك</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">{{ $invoices_count }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-danger-transparent">
                                    <i class="icon-paypal text-danger"></i>
                                </div>
                                <div class="mr-auto">
                                    <h5 class="tx-13">الفواتير التي قمت بدفعها</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">{{ $invoices_count_1 }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-success-transparent">
                                    <i class="icon-rocket text-success"></i>
                                </div>
                                <div class="mr-auto">
                                    <h5 class="tx-13">الفواتير المدفوعة بشكل جزئي</h5>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">{{ $invoices_count_3 }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                            <li class="active">
                                <a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i
                                            class="las la-user-circle tx-16 mr-1"></i></span> <span
                                        class="hidden-xs">عني</span> </a>
                            </li>
                            <li class="">
                                <a href="#profile" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i
                                            class="las la-images tx-15 mr-1"></i></span> <span
                                        class="hidden-xs">الصور</span> </a>
                            </li>
                            <li class="">
                                <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i
                                            class="las la-cog tx-16 mr-1"></i></span> <span class="hidden-xs">ضبط الملف
                                        الشخصي</span> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content border-left border-bottom border-right border-top-0 p-4">
                        <div class="tab-pane active" id="home">
                            <h4 class="tx-15 text-uppercase mb-3">{{ Auth::user()->name }}</h4>
                            <p class="m-b-5">{{ $profil->description }}</p>
                            <div class="m-t-30">

                                <hr>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile">
                            <div class="row">
                                <h3> جزئية الصور لم تنتهي بعد .. وجاري العمل عليها </h3>

                                {{-- <div class="col-sm-4">
												<div class=" border p-1 card thumb  mb-xl-0">
													<a href="#" class="image-popup" title="Screenshot-2"> <img src="{{URL::asset('assets/img/photos/5.jpg')}}" class="thumb-img" alt="work-thumbnail"> </a>
													<h4 class="text-center tx-14 mt-3 mb-0">Gallary Image</h4>
													<div class="ga-border"></div>
													<p class="text-muted text-center"><small>Photography</small></p>
												</div>
											</div> --}}
                            </div>
                        </div>
                        <div class="tab-pane" id="settings">
                            <form method="post" action="{{ route('profil.setting') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="FullName">الاسم</label>
                                    <input type="text" name="name" id="FullName" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Email">البريد الالكتروني</label>
                                    <input type="email" name="email" id="Email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Username">اسم المستخدم</label>
                                    <input type="text" name="username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Username">github</label>
                                    <input type="text" name="github" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Username">twitter</label>
                                    <input type="text" name="twitter" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Username">linkedin</label>
                                    <input type="text" name="linkedin" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Username">facebook</label>
                                    <input type="text" name="facebook" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Password">كلمة المرور</label>
                                    <input type="password" placeholder="6 - 15 Characters" name="password"
                                        id="Password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="RePassword">تاكيد كلمة المرور</label>
                                    <input type="password" placeholder="6 - 15 Characters" name="password_confirmation"                                        id="RePassword" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="AboutMe">السيرة الذاتية</label>
                                    <textarea id="AboutMe" name="description" class="form-control"></textarea>
                                </div>
                                <button class="btn btn-primary waves-effect waves-light w-md" type="submit">حفظ</button>
                            </form>
                        </div>
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
<script>
    document.getElementById("img").onchange = function() {
    document.getElementById("form").submit();
};
</script>
@endsection
