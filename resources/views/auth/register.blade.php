@extends('layouts.app')

@section('title', 'Đăng Ký Tài Khoản - Campus Lost & Found HUIT')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<section class="row justify-content-center py-4">
    <div class="col-md-7 col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 border-top border-4 border-primary bg-white">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h1 class="h3 fw-bold mb-2" style="color: #0f172a;">Đăng ký tài khoản</h1>
                    <p class="text-secondary small mb-0">Hệ thống quản lý đồ thất lạc trực tuyến – HUIT</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label small fw-semibold text-secondary">Họ và tên đầy đủ <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control py-2 @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Ví dụ: Nguyễn Văn A">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_code" class="form-label small fw-semibold text-secondary">Mã số sinh viên (MSSV)</label>
                            <input type="text" name="student_code" id="student_code" class="form-control py-2 @error('student_code') is-invalid @enderror" value="{{ old('student_code') }}" placeholder="Ví dụ: 2001230482">
                            @error('student_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label small fw-semibold text-secondary">Số điện thoại liên hệ</label>
                            <input type="text" name="phone" id="phone" class="form-control py-2 @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Ví dụ: 0912345678">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-secondary">Địa chỉ Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control py-2 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="nhap-email@huit.edu.vn">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label small fw-semibold text-secondary">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control py-2 @error('password') is-invalid @enderror" required placeholder="Tối thiểu 6 ký tự">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control py-2" required placeholder="Nhập lại mật khẩu">
                        </div>
                    </div>

                    <div class="d-grid mb-4 mt-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">Hoàn tất đăng ký</button>
                    </div>

                    <div class="text-center small text-secondary border-top pt-3">
                        <span>Đã có tài khoản sinh viên?</span>
                        <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-none ms-1">Đăng nhập tại đây</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
