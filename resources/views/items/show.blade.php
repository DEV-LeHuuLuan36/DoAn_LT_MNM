@extends('layouts.app')

@section('title', $item->title . ' - Campus Lost & Found HUIT')
@section('meta_description', Str::limit(strip_tags($item->description), 155))
@section('meta_robots', 'index, follow')
@section('canonical', route('items.show', $item))

@section('meta_tags')
<meta property="og:title" content="{{ $item->title }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($item->description), 155) }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ route('items.show', $item) }}">
<meta property="og:image" content="{{ $item->image ? asset('images/' . $item->image) : '' }}">
@endsection

@section('json_ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Trang chủ",
      "item": "{{ route('items.index') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "{{ $item->category->name }}",
      "item": "{{ route('items.index', ['category_id' => $item->category_id]) }}"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "{{ $item->title }}",
      "item": "{{ route('items.show', $item) }}"
    }
  ]
}
</script>
@endsection

@section('content')
<!-- Semantic Breadcrumbs -->
<nav aria-label="Đường dẫn phân cấp" class="mb-3">
    <ol class="breadcrumb small bg-white p-2 px-3 rounded-3 border">
        <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('items.index', ['category_id' => $item->category_id]) }}">{{ $item->category->name }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($item->title, 40) }}</li>
    </ol>
</nav>

<div class="row g-4">
    <!-- Cột trái: Chi tiết bài đăng chính -->
    <article class="col-lg-8">
        <div class="card card-custom p-4 mb-4 border-0 shadow-sm rounded-3">
            <!-- Header bài viết -->
            <header class="border-bottom pb-3 mb-3">
                <div class="d-flex flex-wrap gap-2 mb-2 align-items-center">
                    @if($item->type === 'lost')
                        <span class="badge bg-danger text-white rounded-pill px-3 py-1 fw-medium">Đồ bị mất</span>
                    @else
                        <span class="badge bg-success text-white rounded-pill px-3 py-1 fw-medium">Đồ nhặt được</span>
                    @endif

                    @if($item->status === 'pending')
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-medium">Chờ duyệt</span>
                    @elseif($item->status === 'approved')
                        <span class="badge bg-primary text-white rounded-pill px-3 py-1 fw-medium">Đang tìm kiếm</span>
                    @elseif($item->status === 'rejected')
                        <span class="badge bg-secondary text-white rounded-pill px-3 py-1 fw-medium">Từ chối</span>
                    @elseif($item->status === 'returned')
                        <span class="badge bg-success text-white rounded-pill px-3 py-1 fw-medium">Đã trả</span>
                    @endif

                    <span class="badge bg-light text-secondary border rounded-pill px-3 py-1">{{ $item->category->name }}</span>
                    <span class="badge bg-light text-secondary border rounded-pill px-3 py-1">{{ $item->location->name }}</span>
                </div>

                <h1 class="h3 fw-bold mb-2" style="color: #003366;">{{ $item->title }}</h1>

                <div class="small text-secondary">
                    <span>Đăng ngày: {{ $item->created_at->format('d/m/Y H:i') }}</span>
                    <span class="mx-1">•</span>
                    <span>Tác giả: <strong class="text-dark">{{ $item->user->name }}</strong></span>
                </div>
            </header>

            <!-- Hình ảnh bài đăng -->
            @if($item->image && file_exists(public_path('images/' . $item->image)))
                <div class="mb-4 text-center bg-light p-2 rounded-3 border">
                    <img src="{{ asset('images/' . $item->image) }}" alt="Hình ảnh chi tiết: {{ $item->title }}" class="img-fluid rounded-3" style="max-height: 420px; object-fit: contain;" loading="lazy">
                </div>
            @endif

            <!-- Bảng thông số chi tiết -->
            <section class="mb-4">
                <h2 class="h5 fw-bold text-dark border-start border-primary border-4 ps-2 mb-3">Thông tin chi tiết</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped small mb-0">
                        <tbody>
                            <tr>
                                <th class="w-25 bg-light">Loại tin đăng:</th>
                                <td>{{ $item->type === 'lost' ? 'Đồ dùng bị mất' : 'Đồ nhặt được trong trường' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Danh mục tài sản:</th>
                                <td>{{ $item->category->name }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Vị trí xảy ra:</th>
                                <td>{{ $item->location->name }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Ngày xảy ra sự việc:</th>
                                <td class="fw-bold text-danger">{{ \Carbon\Carbon::parse($item->event_date)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Thông tin liên hệ:</th>
                                <td class="fw-semibold">{{ $item->contact_info ?? 'Trao đổi qua bình luận hoặc gửi yêu cầu nhận đồ' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Trạng thái hiện tại:</th>
                                <td>
                                    @if($item->status === 'returned')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Đã trả</span>
                                    @elseif($item->status === 'approved')
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">Đang tìm kiếm</span>
                                    @elseif($item->status === 'pending')
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">Chờ duyệt</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">Từ chối</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Nội dung mô tả chi tiết -->
            <section class="mb-4">
                <h2 class="h5 fw-bold text-dark border-start border-primary border-4 ps-2 mb-3">Mô tả đặc điểm</h2>
                <div class="p-3 bg-light rounded-3 border text-break" style="white-space: pre-line; line-height: 1.7;">
                    {{ $item->description }}
                </div>
            </section>

            <!-- Thao tác của tác giả bài viết -->
            @if(Auth::check() && Auth::id() === $item->user_id)
                <div class="p-3 bg-body-secondary rounded-3 d-flex justify-content-between align-items-center">
                    <span class="small fw-semibold text-secondary">Bạn là tác giả bài đăng này</span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('items.edit', $item) }}" class="btn btn-warning btn-sm fw-semibold">
                            Chỉnh sửa bài đăng
                        </a>
                        <form action="{{ route('items.destroy', $item) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài đăng này không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm fw-semibold">Xóa bài đăng</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Section Bình luận (Comments) -->
        <section class="card card-custom p-4 border-0 shadow-sm rounded-3" aria-label="Khu vực trao đổi bình luận">
            <h2 class="h5 fw-bold text-dark border-start border-primary border-4 ps-2 mb-3">
                Bình luận &amp; Trao đổi ({{ $comments->count() }})
            </h2>

            <!-- Form gửi bình luận -->
            @auth
                <form action="{{ route('comments.store', $item) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-2">
                        <label for="comment_content" class="form-label small fw-semibold text-secondary text-uppercase">Nội dung trao đổi:</label>
                        <textarea name="content" id="comment_content" rows="3" class="form-control" required placeholder="Nhập lời nhắn, thông tin hỗ trợ hoặc câu hỏi liên quan đến đồ vật này..."></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-sm fw-semibold px-3">Gửi bình luận</button>
                    </div>
                </form>
            @else
                <div class="alert alert-light border py-2 small mb-4 rounded-3 text-secondary">
                    <span>Bạn cần <a href="{{ route('login') }}" class="fw-semibold text-primary">đăng nhập</a> để tham gia gửi bình luận trao đổi.</span>
                </div>
            @endauth

            <!-- Danh sách bình luận -->
            @if($comments->isEmpty())
                <p class="text-muted small text-center py-3 mb-0">Chưa có bình luận nào cho bài viết này. Hãy là người đầu tiên trao đổi thông tin!</p>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($comments as $comment)
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <strong class="text-dark">{{ $comment->user->name }}</strong>
                                    @if($comment->user->role === 'admin')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle ms-1" style="font-size: 0.7rem;">Quản trị viên</span>
                                    @elseif($comment->user->id === $item->user_id)
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle ms-1" style="font-size: 0.7rem;">Tác giả</span>
                                    @endif
                                    <span class="small text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>

                                @if(Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->role === 'admin'))
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none small fw-semibold">Xóa</button>
                                    </form>
                                @endif
                            </div>
                            <div class="text-secondary small" style="white-space: pre-wrap;">{{ $comment->content }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </article>

    <!-- Cột phải: Form Yêu cầu nhận đồ (Claim) & Bài đăng liên quan -->
    <aside class="col-lg-4">
        <!-- Khung Yêu cầu nhận lại đồ (F05) -->
        <section class="card card-custom p-4 mb-4 border-0 shadow-sm rounded-3 border-top border-4 border-warning">
            <h2 class="h5 fw-bold text-dark mb-2">Yêu cầu nhận lại đồ</h2>
            <p class="small text-secondary mb-3">
                Nếu đây là tài sản của bạn, hãy điền các đặc điểm nhận dạng đặc trưng mà chỉ chủ sở hữu mới biết để đối chiếu xác minh.
            </p>

            @if($item->status === 'returned')
                <div class="alert alert-success border-0 small mb-0 fw-semibold rounded-3">
                    Đồ vật này đã được trao trả hoàn tất cho chủ sở hữu.
                </div>
            @elseif($item->status !== 'approved')
                <div class="alert alert-warning border-0 small mb-0 rounded-3">
                    Bài đăng đang chờ phê duyệt từ Ban Quản trị trước khi có thể gửi yêu cầu nhận đồ.
                </div>
            @elseif(Auth::check() && Auth::id() === $item->user_id)
                <div class="alert alert-info border-0 small mb-0 rounded-3">
                    Đây là bài đăng do chính bạn tạo. Bạn không thể gửi yêu cầu nhận đồ cho bài của mình.
                </div>
            @elseif($userPendingClaim)
                <div class="alert alert-warning border-0 small mb-0 rounded-3">
                    <strong class="d-block mb-1">Đã gửi yêu cầu xác minh</strong>
                    Bạn đã gửi một yêu cầu xác minh cho bài đăng này và đang chờ xét duyệt.
                    <hr class="my-2">
                    <form action="{{ route('claims.destroy', $userPendingClaim) }}" method="POST" onsubmit="return confirm('Bạn có muốn hủy yêu cầu này không?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-semibold">Hủy yêu cầu đã gửi</button>
                    </form>
                </div>
            @elseif(Auth::check())
                <form action="{{ route('claims.store', $item) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="claim_message" class="form-label small fw-semibold text-secondary text-uppercase">Mô tả đặc điểm chứng minh sở hữu <span class="text-danger">*</span></label>
                        <textarea name="message" id="claim_message" rows="4" class="form-control @error('message') is-invalid @enderror" required placeholder="Mô tả màu sắc chi tiết, số seri, vết xước riêng, hình nền điện thoại, hoặc chi tiết đặc biệt (tối thiểu 20 ký tự)...">{{ old('message') }}</textarea>
                        <div class="form-text small">Yêu cầu tối thiểu 20 ký tự để Admin và người nhặt đối chiếu.</div>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-warning fw-semibold w-100 py-2">
                        Gửi yêu cầu nhận lại đồ
                    </button>
                </form>
            @else
                <div class="alert alert-secondary border-0 small mb-0 rounded-3">
                    Vui lòng <a href="{{ route('login') }}" class="fw-semibold text-dark">đăng nhập</a> tài khoản HUIT để gửi yêu cầu nhận lại đồ.
                </div>
            @endif
        </section>

        <!-- Khung Bài đăng liên quan -->
        <section class="card card-custom p-4 border-0 shadow-sm rounded-3">
            <h2 class="h6 fw-bold text-uppercase border-start border-primary border-3 ps-2 mb-3">
                Bài đăng liên quan
            </h2>

            @if($relatedItems->isEmpty())
                <p class="small text-muted mb-0">Chưa có bài đăng nào khác cùng khu vực hoặc danh mục này.</p>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($relatedItems as $rel)
                        <div class="border-bottom pb-2">
                            <div class="mb-1">
                                @if($rel->type === 'lost')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill" style="font-size: 0.7rem;">Mất đồ</span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill" style="font-size: 0.7rem;">Nhặt được</span>
                                @endif
                                <span class="small text-secondary ms-1">{{ $rel->location->name }}</span>
                            </div>
                            <h3 class="h6 mb-1">
                                <a href="{{ route('items.show', $rel) }}" class="text-decoration-none text-dark fw-semibold small">
                                    {{ Str::limit($rel->title, 50) }}
                                </a>
                            </h3>
                            <span class="small text-muted" style="font-size: 0.75rem;">Ngày: {{ \Carbon\Carbon::parse($rel->event_date)->format('d/m/Y') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </aside>
</div>
@endsection
