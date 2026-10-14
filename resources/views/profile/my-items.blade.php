@extends('layouts.app')

@section('title', 'Tin Đăng Của Tôi - Campus Lost & Found HUIT')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<section class="card card-custom border-0 shadow-sm rounded-3 p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle text-uppercase mb-1 px-3 py-1 rounded-pill" style="font-size: 0.75rem;">Khu vực cá nhân</span>
            <h1 class="h4 fw-bold mb-0" style="color: #003366;">Danh sách bài đăng của tôi</h1>
        </div>
        <div>
            <a href="{{ route('items.create') }}" class="btn btn-post-item fw-semibold px-3 py-2">Đăng bài mới</a>
        </div>
    </div>

    @if($items->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-bold mb-2">Bạn chưa có bài đăng nào trên hệ thống</h2>
            <p class="text-muted small mb-3">Nếu bạn đánh rơi hoặc nhặt được tài sản trong trường, hãy tạo bài đăng để mọi người cùng hỗ trợ.</p>
            <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm fw-semibold px-3">Đăng tin ngay</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3">Tiêu đề bài đăng</th>
                        <th class="py-3">Phân loại</th>
                        <th class="py-3">Danh mục</th>
                        <th class="py-3">Địa điểm</th>
                        <th class="py-3">Ngày xảy ra</th>
                        <th class="py-3">Trạng thái duyệt</th>
                        <th class="py-3 text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>
                                <strong class="d-block text-dark">{{ Str::limit($item->title, 45) }}</strong>
                                <span class="text-muted" style="font-size: 0.75rem;">Đăng ngày: {{ $item->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                @if($item->type === 'lost')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Đồ bị mất</span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Đồ nhặt được</span>
                                @endif
                            </td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->location->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->event_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($item->status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">Chờ duyệt</span>
                                @elseif($item->status === 'approved')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">Đã duyệt</span>
                                @elseif($item->status === 'rejected')
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">Từ chối</span>
                                @elseif($item->status === 'returned')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Đã trả</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1 flex-nowrap">
                                    <a href="{{ route('items.show', $item) }}" class="btn btn-outline-primary btn-sm py-1 px-2 fw-medium">
                                        Xem
                                    </a>
                                    <a href="{{ route('items.edit', $item) }}" class="btn btn-outline-warning btn-sm py-1 px-2 fw-medium text-dark">
                                        Sửa
                                    </a>
                                    <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài đăng này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2 fw-medium">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-top">
            {{ $items->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
</section>
@endsection
