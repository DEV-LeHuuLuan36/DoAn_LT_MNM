@extends('layouts.admin')

@section('title', 'Quản Lý Địa Điểm - HUIT Admin')

@section('content')
<div class="card card-admin p-4 border-0 shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <span class="badge bg-primary text-uppercase mb-1">Dữ liệu khuôn viên trường</span>
            <h1 class="h4 fw-bold text-dark mb-0">QUẢN LÝ ĐỊA ĐIỂM TRONG TRƯỜNG</h1>
        </div>
        <div>
            <a href="{{ route('admin.locations.create') }}" class="btn btn-primary btn-sm fw-bold">
                [+] THÊM ĐỊA ĐIỂM MỚI
            </a>
        </div>
    </div>

    @if($locations->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-bold">Chưa có địa điểm nào trong hệ thống</h2>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small">
                <thead class="table-light">
                    <tr>
                        <th class="py-2">Mã</th>
                        <th class="py-2">Tên địa điểm / Khu vực</th>
                        <th class="py-2">Mô tả vị trí</th>
                        <th class="py-2">Số bài đăng liên kết</th>
                        <th class="py-2 text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($locations as $location)
                        <tr>
                            <td>#{{ $location->id }}</td>
                            <td><strong class="text-dark">{{ $location->name }}</strong></td>
                            <td><span class="text-secondary">{{ Str::limit($location->description, 60) ?? 'Không có' }}</span></td>
                            <td><span class="badge bg-secondary">{{ $location->items_count }} bài</span></td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-outline-warning btn-sm py-1 px-2 fw-semibold">
                                        [SỬA]
                                    </a>
                                    <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa điểm này?');">
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
            {{ $locations->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
