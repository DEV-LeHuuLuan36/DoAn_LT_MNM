@extends('layouts.admin')

@section('title', 'Bảng Điều Khiển Quản Trị - Campus Lost & Found HUIT')

@section('content')
<!-- Header trang -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <span class="badge bg-primary text-uppercase mb-1">Thống Kê Tổng Hợp</span>
        <h1 class="h3 fw-bold text-dark mb-0">BẢNG ĐIỀU KHIỂN QUẢN TRỊ VIÊN</h1>
    </div>
    <div>
        <span class="badge bg-secondary p-2">Hôm nay: {{ date('d/m/Y') }}</span>
    </div>
</div>

<!-- 4 Thẻ Thống Kê Chỉ Số Chính (F11 - Dashboard) -->
<section class="row g-3 mb-4" aria-label="Các chỉ số thống kê hệ thống">
    <!-- Sinh viên -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-admin p-3 border-start border-primary border-4 shadow-sm">
            <span class="text-uppercase small fw-bold text-secondary mb-1">Tài khoản Sinh viên</span>
            <div class="h2 fw-bold text-primary mb-1">{{ number_format($stats['users']) }}</div>
            <a href="{{ route('admin.users.index') }}" class="small text-decoration-none fw-semibold">[Xem chi tiết &gt;&gt;]</a>
        </div>
    </div>

    <!-- Bài đăng chờ duyệt -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-admin p-3 border-start border-warning border-4 shadow-sm">
            <span class="text-uppercase small fw-bold text-secondary mb-1">Bài đăng chờ duyệt</span>
            <div class="h2 fw-bold text-warning mb-1">{{ number_format($stats['pending_items']) }}</div>
            <a href="{{ route('admin.items.index', ['status' => 'pending']) }}" class="small text-decoration-none fw-semibold text-warning">[Kiểm duyệt ngay &gt;&gt;]</a>
        </div>
    </div>

    <!-- Đồ đã trao trả -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-admin p-3 border-start border-success border-4 shadow-sm">
            <span class="text-uppercase small fw-bold text-secondary mb-1">Đồ đã trao trả thành công</span>
            <div class="h2 fw-bold text-success mb-1">{{ number_format($stats['returned_items']) }}</div>
            <a href="{{ route('admin.items.index', ['status' => 'returned']) }}" class="small text-decoration-none fw-semibold text-success">[Xem danh sách &gt;&gt;]</a>
        </div>
    </div>

    <!-- Yêu cầu nhận đồ chờ duyệt -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-admin p-3 border-start border-danger border-4 shadow-sm">
            <span class="text-uppercase small fw-bold text-secondary mb-1">Yêu cầu nhận đồ chờ duyệt</span>
            <div class="h2 fw-bold text-danger mb-1">{{ number_format($stats['pending_claims']) }}</div>
            <a href="{{ route('admin.claims.index', ['status' => 'pending']) }}" class="small text-decoration-none fw-semibold text-danger">[Đối chiếu xử lý &gt;&gt;]</a>
        </div>
    </div>
</section>

<!-- Bảng 5 Yêu Cầu Nhận Đồ Mới Nhất -->
<section class="card card-admin p-4 border-0 shadow-sm mb-4" aria-label="Yêu cầu nhận đồ mới nhất">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <h2 class="h5 fw-bold text-dark text-uppercase mb-0 border-start border-primary border-4 ps-2">
            5 Yêu Cầu Nhận Lại Đồ Mới Nhất Cần Xử Lý
        </h2>
        <a href="{{ route('admin.claims.index') }}" class="btn btn-outline-primary btn-sm fw-bold">
            [XEM TẤT CẢ YÊU CẦU]
        </a>
    </div>

    @if($latestClaims->isEmpty())
        <p class="text-muted small text-center py-4 mb-0">Hiện tại không có yêu cầu nhận đồ nào trong hệ thống.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small">
                <thead class="table-light">
                    <tr>
                        <th class="py-2">Người yêu cầu</th>
                        <th class="py-2">Bài đăng tài sản</th>
                        <th class="py-2">Nội dung chứng minh</th>
                        <th class="py-2">Thời gian gửi</th>
                        <th class="py-2">Trạng thái</th>
                        <th class="py-2 text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestClaims as $claim)
                        <tr>
                            <td>
                                <strong class="d-block">{{ $claim->user->name }}</strong>
                                <span class="text-muted" style="font-size: 0.75rem;">MSSV: {{ $claim->user->student_code ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('items.show', $claim->item) }}" target="_blank" class="fw-semibold text-dark text-decoration-none">
                                    {{ Str::limit($claim->item->title, 40) }}
                                </a>
                            </td>
                            <td>
                                <div class="text-secondary" style="max-width: 250px;">
                                    {{ Str::limit($claim->message, 70) }}
                                </div>
                            </td>
                            <td>{{ $claim->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($claim->status === 'pending')
                                    <span class="badge bg-warning text-dark">[CHỜ DUYỆT]</span>
                                @elseif($claim->status === 'approved')
                                    <span class="badge bg-success">[ĐÃ DUYỆT]</span>
                                @else
                                    <span class="badge bg-secondary">[TỪ CHỐI]</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.claims.index') }}" class="btn btn-outline-primary btn-sm py-1 px-2 fw-semibold">
                                    [XỬ LÝ]
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>

<!-- Các phím tắt quản lý nhanh -->
<section class="row g-3" aria-label="Phím tắt quản lý">
    <div class="col-md-3">
        <div class="card card-admin p-3 text-center">
            <h3 class="h6 fw-bold mb-2">QUẢN LÝ BÀI ĐĂNG</h3>
            <p class="small text-muted mb-3">Kiểm duyệt, phê duyệt hoặc gỡ bài đăng sai quy định.</p>
            <a href="{{ route('admin.items.index') }}" class="btn btn-outline-primary btn-sm fw-bold">[TRUY CẬP]</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3 text-center">
            <h3 class="h6 fw-bold mb-2">QUẢN LÝ DANH MỤC</h3>
            <p class="small text-muted mb-3">Thêm mới, sửa đổi hoặc kiểm tra các danh mục đồ dùng.</p>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary btn-sm fw-bold">[TRUY CẬP]</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3 text-center">
            <h3 class="h6 fw-bold mb-2">QUẢN LÝ ĐỊA ĐIỂM</h3>
            <p class="small text-muted mb-3">Quản trị các khu vực khuôn viên trường (Thư viện, Căn tin...).</p>
            <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-primary btn-sm fw-bold">[TRUY CẬP]</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3 text-center">
            <h3 class="h6 fw-bold mb-2">QUẢN LÝ NGƯỜI DÙNG</h3>
            <p class="small text-muted mb-3">Phân quyền tài khoản, khóa hoặc xóa thành viên vi phạm.</p>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm fw-bold">[TRUY CẬP]</a>
        </div>
    </div>
</section>
@endsection
