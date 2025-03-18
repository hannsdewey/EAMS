@extends("Staff.Layouts.Master")
@section('Title', 'Staff Login')
@section('Content')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
                        </div>
                        <h4>Staff Login</h4>
                        <h6 class="font-weight-light">Sign in to continue.</h6>
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="pt-3" method="POST" action="{{ route('staff.login.post') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                            </div>
                            <div class="text-center mt-4">
                                <a href="{{ route('admin.login') }}" class="text-primary">Admin Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 