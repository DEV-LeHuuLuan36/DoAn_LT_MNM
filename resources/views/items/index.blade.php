@extends('layouts.app')

@section('title', 'Tìm Kiếm Đồ Thất Lạc Trong Trường | Campus Lost & Found HUIT')
@section('meta_description', 'Tra cứu danh sách đồ dùng, giấy tờ, thiết bị thất lạc và nhặt được trong khuôn viên Trường Đại học Công Thương TP. HCM (HUIT).')
@section('meta_robots', 'index, follow')
@section('canonical', route('items.index'))

@section('json_ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "Campus Lost & Found - HUIT",
  "url": "{{ route('items.index') }}",
  "description": "Hệ thống hỗ trợ tìm kiếm và trao trả đồ dùng thất lạc tại Trường Đại học Công Thương TP. HCM",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{ route('items.index') }}?keyword={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
@endsection

@section('content')
<!-- Hero & Search Section -->
<section class="card card-custom p-4 mb-4 bg-white border-0 shadow-sm rounded-3">
    <div class="row align-items-center mb-3">
        <div class="col-lg-8">
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle text-uppercase fw-semibold mb-2 px-3 py-1 rounded-pill" style="font-size: 0.75rem;">Đại học Công Thương TP. HCM</span>
            <h1 class="h3 fw-bold mb-1" style="color: #003366;">Danh sách đồ thất lạc và nhặt được</h1>
            <p class="text-secondary small mb-0">Hỗ trợ kết nối nhanh chóng giữa người đánh rơi và người nhặt được đồ trong toàn khuôn viên trường HUIT.</p>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <a href="{{ route('items.create') }}" class="btn btn-post-item fw-semibold shadow-sm px-3 py-2">
                Đăng tin tìm hoặc trả đồ
            </a>
        </div>
    </div>

    <!-- Form Bộ Lọc Tìm Kiếm Chuẩn SEO -->
    <form action="{{ route('items.index') }}" method="GET" class="border-top pt-3 mt-2">
        <div class="row g-2">
            <div class="col-md-4 col-sm-12">
                <label for="keyword" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Từ khóa tìm kiếm:</label>
                <input type="text" name="keyword" id="keyword" class="form-control form-control-sm py-2" value="{{ request('keyword') }}" placeholder="Nhập tên đồ vật, đặc điểm nhận dạng...">
            </div>

            <div class="col-md-2 col-sm-6">
                <label for="type" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Loại tin đăng:</label>
                <select name="type" id="type" class="form-select form-select-sm py-2">
                    <option value="">Tất cả loại</option>
                    <option value="lost" {{ request('type') === 'lost' ? 'selected' : '' }}>Đồ bị mất</option>
                    <option value="found" {{ request('type') === 'found' ? 'selected' : '' }}>Đồ nhặt được</option>
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <label for="category_id" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Danh mục đồ vật:</label>
                <select name="category_id" id="category_id" class="form-select form-select-sm py-2">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-sm-12">
                <label for="location_id" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Địa điểm tại trường:</label>
                <select name="location_id" id="location_id" class="form-select form-select-sm py-2">
                    <option value="">Tất cả địa điểm</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('items.index') }}" class="btn btn-outline-secondary btn-sm fw-medium px-3">
                Đặt lại
            </a>
            <button type="submit" class="btn btn-primary btn-sm fw-semibold px-4">
                Tìm kiếm
            </button>
        </div>
    </form>
</section>

<!-- Items Grid Section -->
<section aria-label="Danh sách các bài đăng">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 fw-bold mb-0 text-dark border-start border-primary border-4 ps-2">
            Bài đăng đã kiểm duyệt (Tổng: {{ $items->total() }})
        </h2>
        <span class="small text-muted">Hiển thị tối đa 9 tin mỗi trang</span>
    </div>

    @if($items->isEmpty())
        <div class="card card-custom border-0 p-5 text-center shadow-sm rounded-3">
            <h3 class="h4 fw-bold text-secondary mb-2">Không tìm thấy bài đăng phù hợp</h3>
            <p class="text-muted mb-4">Hiện tại không có bài đăng nào khớp với từ khóa hoặc bộ lọc đã chọn. Bạn có thể thử tìm lại với từ khóa khác hoặc xóa bộ lọc.</p>
            <div>
                <a href="{{ route('items.index') }}" class="btn btn-outline-primary btn-sm fw-semibold me-2">Về tất cả bài đăng</a>
                <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm fw-semibold">Đăng bài mới ngay</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($items as $item)
                <article class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-3 d-flex flex-column bg-white overflow-hidden">
                        <!-- Khung hình ảnh tỷ lệ cố định -->
                        <div class="position-relative bg-light" style="height: 200px; overflow: hidden;">
                            @if($item->image && file_exists(public_path('images/' . $item->image)))
                                <img src="{{ asset('images/' . $item->image) }}" alt="Hình ảnh đồ vật thất lạc: {{ $item->title }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy" width="400" height="200">
                            @else
                                <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center p-3 text-secondary bg-body-secondary">
                                    <span class="badge bg-secondary mb-2 rounded-pill px-3 py-1">Chưa có ảnh</span>
                                    <small class="fw-medium">{{ $item->category->name }}</small>
                                </div>
                            @endif

                            <!-- Nhãn phân loại bo góc tròn không ngoặc vuông -->
                            <div class="position-absolute top-0 start-0 m-3">
                                @if($item->type === 'lost')
                                    <span class="badge bg-danger text-white rounded-pill px-3 py-1 fw-medium shadow-sm">Đồ bị mất</span>
                                @else
                                    <span class="badge bg-success text-white rounded-pill px-3 py-1 fw-medium shadow-sm">Đồ nhặt được</span>
                                @endif
                            </div>

                            <div class="position-absolute bottom-0 end-0 m-3">
                                <span class="badge bg-dark bg-opacity-75 text-white rounded-pill px-3 py-1 fw-normal shadow-sm">{{ $item->location->name }}</span>
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column p-4">
                            <div class="small text-secondary mb-2">
                                <span class="fw-semibold text-dark">{{ $item->category->name }}</span>
                                <span class="mx-1">•</span>
                                <span>Ngày: {{ \Carbon\Carbon::parse($item->event_date)->format('d/m/Y') }}</span>
                            </div>

                            <h3 class="h6 card-title fw-bold mb-2" style="line-height: 1.4;">
                                <a href="{{ route('items.show', $item) }}" class="text-decoration-none text-dark stretched-link">
                                    {{ Str::limit($item->title, 55) }}
                                </a>
                            </h3>

                            <p class="card-text text-secondary small mb-3 flex-grow-1" style="line-height: 1.6;">
                                {{ Str::limit($item->description, 95) }}
                            </p>

                            <div class="border-top pt-3 mt-auto d-flex justify-content-between align-items-center small text-muted">
                                <span>Đăng bởi: <strong class="text-dark">{{ $item->user->name }}</strong></span>
                                <span class="text-primary fw-semibold">Xem chi tiết</span>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Phân trang chuẩn 100% tiếng Việt -->
        <div class="mt-4 pt-3 border-top">
            {{ $items->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
</section>
@endsection
