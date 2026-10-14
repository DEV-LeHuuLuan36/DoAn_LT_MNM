@extends('layouts.app')

@section('title', 'Tin Đăng Của Tôi - Campus Lost & Found HUIT')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<section class="card card-custom border-0 shadow-sm p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <span class="badge bg-primary text-uppercase mb-1">Khu vực cá nhân</span>
            <h1 class="h4 fw-bold text-primary mb-0">DANH SÁCH BÀI ĐĂNG CỦA TÔI</h1>
        </div>
        <div>
            <a href="{{ route('items.create') }}" class="btn btn-post-item fw-bold">[+] ĐĂNG BÀI MỚI</a>
        </div>
    </div>

    @if($items->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-bold mb-2">Bạn chưa có bài đăng nào trên hệ thống</h2>
            <p class="text-muted small mb-3">Nếu bạn đánh rơi hoặc nhặt được tài sản trong trường, hãy tạo bài đăng để mọi người cùng hỗ trợ.</p>
            <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm fw-bold">[+] ĐĂNG TIN NGAY</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small">
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
                                <strong class="d-block">{{ Str::limit($item->title, 45) }}</strong>
                                <span class="text-muted" style="font-size: 0.75rem;">Đăng ngày: {{ $item->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                @if($item->type === 'lost')
                                    <span class="badge bg-danger">[MẤT ĐỒ]</span>
                                @else
                                    <span class="badge bg-success">[NHẶT ĐƯỢC]</span>
                                @endif
                            </td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->location->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->event_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($item->status === 'pending')
                                    <span class="badge badge-status-pending">[CHỜ DUYỆT]</span>
                                @elseif($item->status === 'approved')
                                    <span class="badge badge-status-approved">[ĐÃ DUYỆT]</span>
                                @elseif($item->status === 'rejected')
                                    <span class="badge badge-status-rejected">[TỪ CHỐI]</span>
                                @elseif($item->status === 'returned')
                                    <span class="badge badge-status-returned">[ĐÃ TRAO TRẢ]</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('items.show', $item) }}" class="btn btn-outline-primary btn-sm py-1 px-2 fw-semibold">
                                        [XEM]
                                    </a>
                                    <a href="{{ route('items.edit', $item) }}" class="btn btn-outline-warning btn-sm py-1 px-2 fw-semibold">
                                        [SỬA]
                                    </a>
                                    <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài đăng này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2 fw-semibold">[XÓA]</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $items->links('pagination::bootstrap-5') }}
        </div>
    @endif
</section>
@endsection
