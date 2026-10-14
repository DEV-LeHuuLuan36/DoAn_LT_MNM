@extends('layouts.app')

@section('title', 'Thông Tin Cá Nhân - Campus Lost & Found HUIT')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<section class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <span class="badge bg-danger text-uppercase mb-1">Tài khoản sinh viên HUIT</span>
                <h1 class="h4 mb-0 fw-bold">HỒ SƠ CÁ NHÂN &amp; ĐỔI MẬT KHẨU</h1>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h2 class="h6 fw-bold text-uppercase border-start border-primary border-3 ps-2 mb-3">1. Thông Tin Cơ Bản</h2>

                    <div class="row align-items-center mb-4">
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            @if($user->avatar && file_exists(public_path('images/' . $user->avatar)))
                                <img src="{{ asset('images/' . $user->avatar) }}" alt="Ảnh đại diện của {{ $user->name }}" class="rounded-circle border" style="width: 100px; height: 100px; object-fit: cover;" loading="lazy">
                            @else
                                <div class="rounded-circle bg-secondary text-white d-inline-flex justify-content-center align-items-center fw-bold fs-3 border" style="width: 100px; height: 100px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <label for="avatar" class="form-label fw-semibold">Thay đổi ảnh đại diện:</label>
                            <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/jpeg,image/png,image/webp,image/jpg">
                            <div class="form-text small">Định dạng hỗ trợ: JPG, PNG, WEBP (Tối đa 2MB).</div>
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-semibold">Họ và tên: <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Email tài khoản:</label>
                            <input type="email" id="email" class="form-control bg-light" value="{{ $user->email }}" readonly disabled>
                            <div class="form-text small">Email không thể thay đổi sau khi đăng ký.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_code" class="form-label fw-semibold">Mã số sinh viên (MSSV):</label>
                            <input type="text" name="student_code" id="student_code" class="form-control @error('student_code') is-invalid @enderror" value="{{ old('student_code', $user->student_code) }}">
                            @error('student_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-semibold">Số điện thoại liên hệ:</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <h2 class="h6 fw-bold text-uppercase border-start border-warning border-3 ps-2 mb-3">2. Đổi Mật Khẩu (Để trống nếu không muốn đổi)</h2>

                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-semibold">Mật khẩu hiện tại:</label>
                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Nhập mật khẩu cũ để xác nhận thay đổi">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold">Mật khẩu mới:</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Tối thiểu 6 ký tự">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu mới:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('profile.my-items') }}" class="btn btn-outline-secondary">[HỦY BỎ]</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">[ LƯU THAY ĐỔI ]</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
