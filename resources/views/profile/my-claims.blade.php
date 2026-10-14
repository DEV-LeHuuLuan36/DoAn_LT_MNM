@extends('layouts.app')

@section('title', 'Yêu Cầu Nhận Đồ Đã Gửi - Campus Lost & Found HUIT')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<section class="card card-custom border-0 shadow-sm p-4">
    <div class="mb-4 pb-2 border-bottom">
        <span class="badge bg-primary text-uppercase mb-1">Khu vực cá nhân</span>
        <h1 class="h4 fw-bold text-primary mb-0">LỊCH SỬ YÊU CẦU NHẬN ĐỒ ĐÃ GỬI</h1>
    </div>

    @if($claims->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-bold mb-2">Bạn chưa gửi yêu cầu nhận lại đồ nào</h2>
            <p class="text-muted small mb-3">Nếu bạn thấy bài đăng có đồ vật trùng khớp với tài sản bị thất lạc của mình, hãy gửi yêu cầu xác nhận sở hữu tại trang chi tiết bài viết.</p>
            <a href="{{ route('items.index') }}" class="btn btn-primary btn-sm fw-bold">[VỀ TRANG TÌM KIẾM]</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small">
                <thead class="table-light">
                    <tr>
                        <th class="py-3">Bài đăng đồ vật</th>
                        <th class="py-3">Nội dung chứng minh bạn đã gửi</th>
                        <th class="py-3">Ngày gửi yêu cầu</th>
                        <th class="py-3">Trạng thái xử lý</th>
                        <th class="py-3">Ghi chú từ Ban Quản trị</th>
                        <th class="py-3 text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($claims as $claim)
                        <tr>
                            <td>
                                <a href="{{ route('items.show', $claim->item) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ Str::limit($claim->item->title, 40) }}
                                </a>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    {{ $claim->item->category->name }} • {{ $claim->item->location->name }}
                                </div>
                            </td>
                            <td>
                                <div class="text-secondary" style="max-width: 250px; white-space: pre-wrap;">
                                    {{ Str::limit($claim->message, 80) }}
                                </div>
                            </td>
                            <td>{{ $claim->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($claim->status === 'pending')
                                    <span class="badge badge-status-pending">[ĐANG CHỜ DUYỆT]</span>
                                @elseif($claim->status === 'approved')
                                    <span class="badge badge-status-returned">[ĐÃ XÁC NHẬN SỞ HỮU]</span>
                                @elseif($claim->status === 'rejected')
                                    <span class="badge badge-status-rejected">[BỊ TỪ CHỐI]</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $claim->admin_note ?? 'Chưa có ghi chú' }}</small>
                            </td>
                            <td class="text-end">
                                @if($claim->status === 'pending')
                                    <form action="{{ route('claims.destroy', $claim) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn hủy yêu cầu nhận đồ này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2 fw-semibold">[HỦY YÊU CẦU]</button>
                                    </form>
                                @else
                                    <span class="text-muted" style="font-size: 0.75rem;">[ĐÃ ĐÓNG]</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $claims->links('pagination::bootstrap-5') }}
        </div>
    @endif
</section>
@endsection
