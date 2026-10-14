@extends('layouts.admin')

@section('title', 'Bảng Điều Khiển Quản Trị - Campus Lost & Found HUIT')

@section('content')
<!-- Header trang -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle text-uppercase mb-1 px-3 py-1 rounded-pill" style="font-size: 0.75rem;">Thống kê tổng hợp</span>
        <h1 class="h3 fw-bold text-dark mb-0">Bảng điều khiển quản trị viên</h1>
    </div>
    <div>
        <span class="badge bg-light text-secondary border px-3 py-2 rounded-3">Hôm nay: {{ date('d/m/Y') }}</span>
    </div>
</div>

<!-- 4 Thẻ Thống Kê Chỉ Số Chính -->
<section class="row g-3 mb-4" aria-label="Các chỉ số thống kê hệ thống">
    <!-- Sinh viên -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-admin p-3 border-start border-primary border-4 shadow-sm rounded-3">
            <span class="text-uppercase small fw-semibold text-secondary mb-1">Tài khoản sinh viên</span>
            <div class="h2 fw-bold text-primary mb-1">{{ number_format($stats['users']) }}</div>
            <a href="{{ route('admin.users.index') }}" class="small text-decoration-none fw-medium text-primary">Xem chi tiết</a>
        </div>
    </div>

    <!-- Bài đăng chờ duyệt -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-admin p-3 border-start border-warning border-4 shadow-sm rounded-3">
            <span class="text-uppercase small fw-semibold text-secondary mb-1">Bài đăng chờ duyệt</span>
            <div class="h2 fw-bold text-warning mb-1">{{ number_format($stats['pending_items']) }}</div>
            <a href="{{ route('admin.items.index', ['status' => 'pending']) }}" class="small text-decoration-none fw-medium text-warning">Kiểm duyệt ngay</a>
        </div>
    </div>

    <!-- Đồ đã trao trả -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-admin p-3 border-start border-success border-4 shadow-sm rounded-3">
            <span class="text-uppercase small fw-semibold text-secondary mb-1">Đồ đã trao trả thành công</span>
            <div class="h2 fw-bold text-success mb-1">{{ number_format($stats['returned_items']) }}</div>
            <a href="{{ route('admin.items.index', ['status' => 'returned']) }}" class="small text-decoration-none fw-medium text-success">Xem danh sách</a>
        </div>
    </div>

    <!-- Yêu cầu nhận đồ chờ duyệt -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-admin p-3 border-start border-danger border-4 shadow-sm rounded-3">
            <span class="text-uppercase small fw-semibold text-secondary mb-1">Yêu cầu nhận đồ chờ duyệt</span>
            <div class="h2 fw-bold text-danger mb-1">{{ number_format($stats['pending_claims']) }}</div>
            <a href="{{ route('admin.claims.index', ['status' => 'pending']) }}" class="small text-decoration-none fw-medium text-danger">Đối chiếu xử lý</a>
        </div>
    </div>
</section>

<!-- Bảng 5 Yêu Cầu Nhận Đồ Mới Nhất -->
<section class="card card-admin p-4 border-0 shadow-sm rounded-3 mb-4" aria-label="Yêu cầu nhận đồ mới nhất">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <h2 class="h5 fw-bold text-dark mb-0 border-start border-primary border-4 ps-2">
            5 yêu cầu nhận lại đồ mới nhất cần xử lý
        </h2>
        <a href="{{ route('admin.claims.index') }}" class="btn btn-outline-primary btn-sm fw-medium px-3">
            Xem tất cả yêu cầu
        </a>
    </div>

    @if($latestClaims->isEmpty())
        <p class="text-muted small text-center py-4 mb-0">Hiện tại không có yêu cầu nhận đồ nào trong hệ thống.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small mb-0">
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
                                <strong class="d-block text-dark">{{ $claim->user->name }}</strong>
                                <span class="text-muted" style="font-size: 0.75rem;">MSSV: {{ $claim->user->student_code ?? 'Chưa cập nhật' }}</span>
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
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Chờ duyệt</span>
                                @elseif($claim->status === 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Đã duyệt</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Từ chối</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($claim->status === 'pending')
                                    <a href="{{ route('admin.claims.index') }}" class="btn btn-primary btn-sm py-1 px-3 fw-medium">
                                        Xử lý
                                    </a>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">Đã hoàn tất</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
@endsection
