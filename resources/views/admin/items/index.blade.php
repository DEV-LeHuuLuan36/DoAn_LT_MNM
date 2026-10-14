@extends('layouts.admin')

@section('title', 'Quản Lý Bài Đăng - HUIT Admin')

@section('content')
<div class="card card-admin p-4 border-0 shadow-sm rounded-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle text-uppercase mb-1 px-3 py-1 rounded-pill" style="font-size: 0.75rem;">Kiểm duyệt nội dung</span>
            <h1 class="h4 fw-bold text-dark mb-0">Quản lý toàn bộ bài đăng</h1>
        </div>
        <div>
            <a href="{{ route('items.create') }}" target="_blank" class="btn btn-warning btn-sm fw-semibold px-3 py-2">
                Tạo bài đăng mới
            </a>
        </div>
    </div>

    <!-- Bộ lọc bài đăng -->
    <form action="{{ route('admin.items.index') }}" method="GET" class="row g-2 mb-4 bg-light p-3 rounded-3 border align-items-end">
        <div class="col-md-3">
            <label for="keyword" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Tìm theo tiêu đề hoặc mô tả:</label>
            <input type="text" name="keyword" id="keyword" class="form-control py-2" value="{{ request('keyword') }}" placeholder="Nhập từ khóa...">
        </div>
        <div class="col-md-3">
            <label for="status" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Trạng thái duyệt:</label>
            <select name="status" id="status" class="form-select py-2">
                <option value="">Tất cả trạng thái</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Từ chối</option>
                <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Đã trả</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="type" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Phân loại tin:</label>
            <select name="type" id="type" class="form-select py-2">
                <option value="">Tất cả phân loại</option>
                <option value="lost" {{ request('type') === 'lost' ? 'selected' : '' }}>Đồ bị mất</option>
                <option value="found" {{ request('type') === 'found' ? 'selected' : '' }}>Đồ nhặt được</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary text-nowrap px-3 py-2 flex-grow-1">Lọc</button>
            <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary text-nowrap px-3 py-2">Đặt lại</a>
        </div>
    </form>

    <!-- Bảng danh sách bài đăng -->
    @if($items->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-semibold">Không tìm thấy bài đăng nào theo tiêu chí lọc</h2>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-2 text-nowrap" style="width: 55px;">Mã</th>
                        <th class="py-2 text-nowrap">Thông tin bài đăng</th>
                        <th class="py-2 text-nowrap">Phân loại &amp; Địa điểm</th>
                        <th class="py-2 text-nowrap">Người đăng</th>
                        <th class="py-2 text-nowrap">Trạng thái</th>
                        <th class="py-2 text-end text-nowrap" style="width: 190px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td class="text-nowrap text-secondary">#{{ $item->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    @if($item->type === 'lost')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 text-nowrap">Mất</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 text-nowrap">Nhặt được</span>
                                    @endif
                                    <a href="{{ route('items.show', $item) }}" target="_blank" class="fw-bold text-dark text-decoration-none">
                                        {{ Str::limit($item->title, 55) }}
                                    </a>
                                </div>
                                <div class="small text-muted">Ngày sự việc: {{ \Carbon\Carbon::parse($item->event_date)->format('d/m/Y') }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $item->category->name }}</div>
                                <div class="small text-muted">Khu vực: {{ $item->location->name }}</div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark text-nowrap">{{ $item->user->name }}</div>
                                <div class="small text-muted">{{ $item->user->email }}</div>
                            </td>
                            <td class="text-nowrap">
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
                                <div class="d-inline-flex gap-1 flex-nowrap justify-content-end align-items-center">
                                    {{-- 1. Nếu pending: Duyệt, Từ chối, Xóa --}}
                                    @if($item->status === 'pending')
                                        <form action="{{ route('admin.items.status', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-outline-success py-1 px-2 fw-medium text-nowrap" title="Duyệt bài đăng">Duyệt</button>
                                        </form>

                                        <form action="{{ route('admin.items.status', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-outline-warning py-1 px-2 fw-medium text-nowrap text-dark" title="Từ chối duyệt bài">Từ chối</button>
                                        </form>

                                    {{-- 2. Nếu approved: Xem, Từ chối, Xóa --}}
                                    @elseif($item->status === 'approved')
                                        <a href="{{ route('items.show', $item) }}" target="_blank" class="btn btn-sm btn-outline-primary py-1 px-2 fw-medium text-nowrap">Xem</a>

                                        <form action="{{ route('admin.items.status', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-outline-warning py-1 px-2 fw-medium text-nowrap text-dark" title="Gỡ bài đăng khỏi trang chủ">Từ chối</button>
                                        </form>

                                    {{-- 3. Nếu rejected: Duyệt lại, Xóa --}}
                                    @elseif($item->status === 'rejected')
                                        <form action="{{ route('admin.items.status', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-outline-success py-1 px-2 fw-medium text-nowrap" title="Duyệt lại bài đăng này">Duyệt lại</button>
                                        </form>

                                    {{-- 4. Nếu returned: Xem, Xóa --}}
                                    @elseif($item->status === 'returned')
                                        <a href="{{ route('items.show', $item) }}" target="_blank" class="btn btn-sm btn-outline-primary py-1 px-2 fw-medium text-nowrap">Xem</a>
                                    @endif

                                    {{-- Nút Xóa bài đăng --}}
                                    <form action="{{ route('admin.items.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài đăng này khỏi hệ thống?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2 fw-medium text-nowrap">Xóa</button>
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
</div>
@endsection
