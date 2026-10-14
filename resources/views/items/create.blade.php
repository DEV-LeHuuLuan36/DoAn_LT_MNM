@extends('layouts.app')

@section('title', 'Đăng Tin Mới - Campus Lost & Found HUIT')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<section class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <span class="badge bg-warning text-dark text-uppercase mb-1">Cổng thông tin sinh viên</span>
                <h1 class="h4 mb-0 fw-bold">ĐĂNG TIN TÌM ĐỒ / BÁO NHẶT ĐƯỢC ĐỒ</h1>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Loại tin đăng: Đồ mất / Đồ nhặt được -->
                    <div class="mb-4 p-3 bg-light rounded border">
                        <label class="form-label fw-bold text-uppercase small text-secondary d-block">1. Chọn loại tin bạn muốn đăng: <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="type_lost" value="lost" {{ old('type', 'lost') === 'lost' ? 'checked' : '' }} required>
                                <label class="form-check-label fw-bold text-danger" for="type_lost">
                                    [TÔI BỊ MẤT ĐỒ] - Đang tìm kiếm lại tài sản
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="type_found" value="found" {{ old('type') === 'found' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-success" for="type_found">
                                    [TÔI NHẶT ĐƯỢC ĐỒ] - Muốn trao trả cho người đánh rơi
                                </label>
                            </div>
                        </div>
                        @error('type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tiêu đề bài đăng -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Tiêu đề bài đăng: <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Ví dụ: Rơi ví da nam màu nâu tại nhà xe Tòa B...">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Danh mục và Địa điểm -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label fw-semibold">Danh mục tài sản: <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="location_id" class="form-label fw-semibold">Địa điểm trong trường: <span class="text-danger">*</span></label>
                            <select name="location_id" id="location_id" class="form-select @error('location_id') is-invalid @enderror" required>
                                <option value="">-- Chọn địa điểm xảy ra --</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
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
                            <input type="date" name="event_date" id="event_date" max="{{ date('Y-m-d') }}" class="form-control @error('event_date') is-invalid @enderror" value="{{ old('event_date', date('Y-m-d')) }}" required>
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contact_info" class="form-label fw-semibold">Thông tin liên hệ (SĐT / Zalo / Email):</label>
                            <input type="text" name="contact_info" id="contact_info" class="form-control @error('contact_info') is-invalid @enderror" value="{{ old('contact_info') }}" placeholder="Ví dụ: 0912345678 (gặp Luân)">
                            @error('contact_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Mô tả chi tiết -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Mô tả đặc điểm chi tiết: <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" required placeholder="Ghi rõ màu sắc, kích thước, đặc điểm nhận dạng dễ thấy (tối thiểu 10 ký tự)...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tải lên hình ảnh -->
                    <div class="mb-4">
                        <label for="image" class="form-label fw-semibold">Hình ảnh đính kèm (nếu có):</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/webp,image/jpg">
                        <div class="form-text small">Hỗ trợ ảnh định dạng JPG, PNG, WEBP. Dung lượng tối đa: 2MB.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="p-3 bg-light rounded border mb-4 text-secondary small">
                        <strong>Lưu ý:</strong> Bài đăng sau khi gửi sẽ được Ban Quản trị phê duyệt trước khi hiển thị công khai trên hệ thống nhằm đảm bảo tính xác thực và an toàn thông tin.
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">[HỦY BỎ]</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">[ GỬI BÀI ĐĂNG DUYỆT ]</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
