@extends('layouts.admin')

@section('title', 'Quản Lý Bài Đăng - HUIT Admin')

@section('content')
<div class="card card-admin p-4 border-0 shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div>
            <span class="badge bg-primary text-uppercase mb-1">Kiểm duyệt nội dung</span>
            <h1 class="h4 fw-bold text-dark mb-0">QUẢN LÝ TOÀN BỘ BÀI ĐĂNG</h1>
        </div>
        <div>
            <a href="{{ route('items.create') }}" target="_blank" class="btn btn-warning btn-sm fw-bold">
                [+] ĐĂNG TIN MỚI (PHÍA CLIENT)
            </a>
        </div>
    </div>

    <!-- Bộ lọc bài đăng -->
    <form action="{{ route('admin.items.index') }}" method="GET" class="row g-2 mb-4 bg-light p-3 rounded border">
        <div class="col-md-4">
            <label for="keyword" class="form-label small fw-bold text-secondary text-uppercase mb-1">Tìm theo tiêu đề/mô tả:</label>
            <input type="text" name="keyword" id="keyword" class="form-control form-control-sm" value="{{ request('keyword') }}" placeholder="Nhập từ khóa...">
        </div>
        <div class="col-md-3">
            <label for="status" class="form-label small fw-bold text-secondary text-uppercase mb-1">Trạng thái duyệt:</label>
            <select name="status" id="status" class="form-select form-select-sm">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>[CHỜ DUYỆT]</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>[ĐÃ DUYỆT]</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>[TỪ CHỐI]</option>
                <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>[ĐÃ HOÀN TRẢ]</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="type" class="form-label small fw-bold text-secondary text-uppercase mb-1">Phân loại tin:</label>
            <select name="type" id="type" class="form-select form-select-sm">
                <option value="">-- Tất cả phân loại --</option>
                <option value="lost" {{ request('type') === 'lost' ? 'selected' : '' }}>[ĐỒ BỊ MẤT]</option>
                <option value="found" {{ request('type') === 'found' ? 'selected' : '' }}>[ĐỒ NHẶT ĐƯỢC]</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end gap-1">
            <button type="submit" class="btn btn-primary btn-sm fw-bold w-100">[LỌC]</button>
            <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary btn-sm">[XÓA]</a>
        </div>
    </form>

    <!-- Bảng danh sách bài đăng -->
    @if($items->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-bold">Không tìm thấy bài đăng nào theo tiêu chí lọc</h2>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small">
                <thead class="table-light">
                    <tr>
                        <th class="py-2">Mã</th>
                        <th class="py-2">Tiêu đề bài đăng</th>
                        <th class="py-2">Loại tin</th>
                        <th class="py-2">Người đăng</th>
                        <th class="py-2">Danh mục</th>
                        <th class="py-2">Địa điểm</th>
                        <th class="py-2">Trạng thái</th>
                        <th class="py-2 text-end">Hành động kiểm duyệt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>#{{ $item->id }}</td>
                            <td>
                                <a href="{{ route('items.show', $item) }}" target="_blank" class="fw-bold text-dark text-decoration-none">
                                    {{ Str::limit($item->title, 45) }}
                                </a>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    Ngày: {{ \Carbon\Carbon::parse($item->event_date)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td>
                                @if($item->type === 'lost')
                                    <span class="badge bg-danger">[MẤT]</span>
                                @else
                                    <span class="badge bg-success">[NHẶT ĐƯỢC]</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $item->user->name }}</span>
                                <div class="text-muted" style="font-size: 0.75rem;">{{ $item->user->email }}</div>
                            </td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->location->name }}</td>
                            <td>
                                @if($item->status === 'pending')
                                    <span class="badge bg-warning text-dark">[CHỜ DUYỆT]</span>
                                @elseif($item->status === 'approved')
                                    <span class="badge bg-primary">[ĐÃ DUYỆT]</span>
                                @elseif($item->status === 'rejected')
                                    <span class="badge bg-secondary">[TỪ CHỐI]</span>
                                @elseif($item->status === 'returned')
                                    <span class="badge bg-success">[ĐÃ TRẢ]</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex flex-wrap gap-1 justify-content-end">
                                    @if($item->status !== 'approved')
                                        <form action="{{ route('admin.items.status', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-outline-success py-0 px-2 fw-bold" title="Duyệt bài đăng này">[DUYỆT]</button>
                                        </form>
                                    @endif

                                    @if($item->status !== 'rejected')
                                        <form action="{{ route('admin.items.status', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-outline-warning py-0 px-2 fw-semibold" title="Từ chối duyệt">[TỪ CHỐI]</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.items.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài đăng này khỏi hệ thống?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2 fw-semibold">[XÓA]</button>
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
</div>
@endsection
