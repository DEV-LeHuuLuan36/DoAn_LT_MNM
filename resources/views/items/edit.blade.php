@extends('layouts.app')

@section('title', 'Chỉnh Sửa Bài Đăng - Campus Lost & Found HUIT')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<section class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom border-0 shadow-sm">
            <div class="card-header bg-warning text-dark py-3">
                <span class="badge bg-dark text-white text-uppercase mb-1">Cập nhật tin đăng</span>
                <h1 class="h4 mb-0 fw-bold">CHỈNH SỬA THÔNG TIN BÀI ĐĂNG</h1>
            </div>

            <div class="card-body p-4">
                <div class="alert alert-warning small mb-4">
                    <strong>[LƯU Ý QUAN TRỌNG]</strong> Khi bạn thay đổi thông tin bài đăng, hệ thống sẽ tự động chuyển trạng thái bài viết về <strong>[CHỜ DUYỆT]</strong> để Ban Quản trị xác thực lại thông tin.
                </div>

                <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Loại tin -->
                    <div class="mb-4 p-3 bg-light rounded border">
                        <label class="form-label fw-bold text-uppercase small text-secondary d-block">1. Loại tin đăng: <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="type_lost" value="lost" {{ old('type', $item->type) === 'lost' ? 'checked' : '' }} required>
                                <label class="form-check-label fw-bold text-danger" for="type_lost">
                                    [TÔI BỊ MẤT ĐỒ]
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="type_found" value="found" {{ old('type', $item->type) === 'found' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-success" for="type_found">
                                    [TÔI NHẶT ĐƯỢC ĐỒ]
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Tiêu đề bài đăng -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Tiêu đề bài đăng: <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $item->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Danh mục và Địa điểm -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label fw-semibold">Danh mục tài sản: <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="location_id" class="form-label fw-semibold">Địa điểm: <span class="text-danger">*</span></label>
                            <select name="location_id" id="location_id" class="form-select @error('location_id') is-invalid @enderror" required>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id', $item->location_id) == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Ngày xảy ra và Thông tin liên hệ -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="event_date" class="form-label fw-semibold">Ngày xảy ra sự việc: <span class="text-danger">*</span></label>
                            <input type="date" name="event_date" id="event_date" max="{{ date('Y-m-d') }}" class="form-control @error('event_date') is-invalid @enderror" value="{{ old('event_date', \Carbon\Carbon::parse($item->event_date)->format('Y-m-d')) }}" required>
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contact_info" class="form-label fw-semibold">Thông tin liên hệ:</label>
                            <input type="text" name="contact_info" id="contact_info" class="form-control @error('contact_info') is-invalid @enderror" value="{{ old('contact_info', $item->contact_info) }}">
                            @error('contact_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Mô tả chi tiết -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Mô tả đặc điểm chi tiết: <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $item->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tải lên hình ảnh thay thế -->
                    <div class="mb-4">
                        <label for="image" class="form-label fw-semibold">Thay đổi hình ảnh (nếu cần):</label>
                        @if($item->image && file_exists(public_path('images/' . $item->image)))
                            <div class="mb-2">
                                <span class="small text-secondary d-block">Ảnh hiện tại:</span>
                                <img src="{{ asset('images/' . $item->image) }}" alt="Ảnh hiện tại của bài đăng" class="img-thumbnail" style="max-height: 120px;" loading="lazy">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/webp,image/jpg">
                        <div class="form-text small">Để trống nếu muốn giữ nguyên ảnh hiện tại.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('items.show', $item) }}" class="btn btn-outline-secondary">[HỦY THAY ĐỔI]</a>
                        <button type="submit" class="btn btn-warning fw-bold px-4">[ LƯU VÀ GỬI DUYỆT LẠI ]</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
