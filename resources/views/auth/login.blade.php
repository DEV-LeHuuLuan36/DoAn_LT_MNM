@extends('layouts.app')

@section('title', 'Đăng Nhập - Campus Lost & Found HUIT')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<section class="row justify-content-center py-4">
    <div class="col-md-6 col-lg-5">
        <div class="card card-custom border-0 shadow-sm">
            <div class="card-header bg-primary text-white text-center py-3">
                <span class="badge bg-danger text-uppercase mb-1">Cổng thông tin HUIT</span>
                <h1 class="h4 mb-0 fw-bold">ĐĂNG NHẬP HỆ THỐNG</h1>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Địa chỉ Email HUIT / Cá nhân:</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="nhap-email@huit.edu.vn">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Mật khẩu:</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Nhập tối thiểu 6 ký tự">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="form-check-label small text-secondary">Ghi nhớ đăng nhập trên thiết bị này</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary fw-bold py-2 text-uppercase">[ XÁC NHẬN ĐĂNG NHẬP ]</button>
                    </div>

                    <div class="text-center small border-top pt-3">
                        <span>Chưa có tài khoản sinh viên?</span>
                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Đăng ký ngay tại đây</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
