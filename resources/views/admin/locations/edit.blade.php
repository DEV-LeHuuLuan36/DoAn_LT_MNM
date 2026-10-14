@extends('layouts.admin')

@section('title', 'Sửa Địa Điểm - HUIT Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-admin p-4 border-0 shadow-sm rounded-3">
            <div class="mb-4 pb-2 border-bottom">
                <span class="badge bg-warning-subtle text-dark border border-warning-subtle text-uppercase mb-1 px-3 py-1 rounded-pill" style="font-size: 0.75rem;">Cập nhật dữ liệu</span>
                <h1 class="h4 fw-bold text-dark mb-0">Chỉnh sửa địa điểm #{{ $location->id }}</h1>
            </div>

            <form action="{{ route('admin.locations.update', $location) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label small fw-semibold text-secondary">Tên địa điểm / Khu vực <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control py-2 @error('name') is-invalid @enderror" value="{{ old('name', $location->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label small fw-semibold text-secondary">Mô tả vị trí:</label>
                    <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $location->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary btn-sm px-3">Hủy</a>
                    <button type="submit" class="btn btn-warning btn-sm fw-semibold px-4">Cập nhật địa điểm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
