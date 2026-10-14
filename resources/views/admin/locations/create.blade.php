@extends('layouts.admin')

@section('title', 'Thêm Địa Điểm - HUIT Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-admin p-4 border-0 shadow-sm">
            <div class="mb-4 pb-2 border-bottom">
                <span class="badge bg-primary text-uppercase mb-1">Thiết lập dữ liệu</span>
                <h1 class="h4 fw-bold text-dark mb-0">THÊM ĐỊA ĐIỂM MỚI</h1>
            </div>

            <form action="{{ route('admin.locations.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Tên địa điểm / Khu vực: <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Ví dụ: Giảng đường E">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Mô tả vị trí:</label>
                    <textarea name="description" id="description" rows="3" class="form-control" placeholder="Mô tả cụ thể vị trí trong khuôn viên trường...">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary btn-sm">[HỦY]</a>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold px-3">[LƯU ĐỊA ĐIỂM]</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
