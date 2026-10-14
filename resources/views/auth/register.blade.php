@extends('layouts.app')

@section('title', 'Đăng Ký Tài Khoản - Campus Lost & Found HUIT')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<section class="row justify-content-center py-4">
    <div class="col-md-7 col-lg-6">
        <div class="card card-custom border-0 shadow-sm">
            <div class="card-header bg-primary text-white text-center py-3">
                <span class="badge bg-danger text-uppercase mb-1">Cổng sinh viên HUIT</span>
                <h1 class="h4 mb-0 fw-bold">ĐĂNG KÝ TÀI KHOẢN MỚI</h1>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Họ và tên đầy đủ: <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Ví dụ: Nguyễn Văn A">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_code" class="form-label fw-semibold">Mã số sinh viên (MSSV):</label>
                            <input type="text" name="student_code" id="student_code" class="form-control @error('student_code') is-invalid @enderror" value="{{ old('student_code') }}" placeholder="Ví dụ: 2001230482">
                            @error('student_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-semibold">Số điện thoại liên hệ:</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Ví dụ: 0912345678">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Địa chỉ Email: <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="nhap-email@huit.edu.vn">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold">Mật khẩu: <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Tối thiểu 6 ký tự">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu: <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Nhập lại mật khẩu trên">
                        </div>
                    </div>

                    <div class="d-grid mb-3 mt-2">
                        <button type="submit" class="btn btn-primary fw-bold py-2 text-uppercase">[ HOÀN TẤT ĐĂNG KÝ ]</button>
                    </div>

                    <div class="text-center small border-top pt-3">
                        <span>Đã có tài khoản sinh viên?</span>
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Đăng nhập tại đây</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
