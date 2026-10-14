@extends('layouts.admin')

@section('title', 'Thêm Danh Mục - HUIT Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-admin p-4 border-0 shadow-sm">
            <div class="mb-4 pb-2 border-bottom">
                <span class="badge bg-primary text-uppercase mb-1">Thiết lập dữ liệu</span>
                <h1 class="h4 fw-bold text-dark mb-0">THÊM DANH MỤC MỚI</h1>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Tên danh mục: <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Ví dụ: Laptop &amp; Máy tính xách tay">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-semibold">Chuỗi định danh (Slug - Để trống để tự sinh):</label>
                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="laptop-may-tinh-xach-tay">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Mô tả ngắn gọn:</label>
                    <textarea name="description" id="description" rows="3" class="form-control" placeholder="Mô tả nhóm đồ vật thuộc danh mục này...">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">[HỦY]</a>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold px-3">[LƯU DANH MỤC]</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
