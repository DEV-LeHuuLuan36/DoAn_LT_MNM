@extends('layouts.app')

@section('title', 'Đăng Nhập - Campus Lost & Found HUIT')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<section class="row justify-content-center py-5">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-sm rounded-3 border-top border-4 border-primary bg-white">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h1 class="h3 fw-bold mb-2" style="color: #0f172a;">Đăng nhập tài khoản</h1>
                    <p class="text-secondary small mb-0">Hệ thống quản lý đồ thất lạc trực tuyến – HUIT</p>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-secondary">Địa chỉ Email:</label>
                        <input type="email" name="email" id="email" class="form-control py-2 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="nhap-email@huit.edu.vn">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small fw-semibold text-secondary">Mật khẩu:</label>
                        <input type="password" name="password" id="password" class="form-control py-2 @error('password') is-invalid @enderror" required placeholder="Nhập tối thiểu 6 ký tự">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="form-check-label small text-secondary">Ghi nhớ đăng nhập trên thiết bị này</label>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">Đăng nhập</button>
                    </div>

                    <div class="text-center small text-secondary border-top pt-3">
                        <span>Chưa có tài khoản sinh viên?</span>
                        <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-none ms-1">Đăng ký ngay tại đây</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
