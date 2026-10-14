@extends('layouts.admin')

@section('title', 'Quản Lý Danh Mục - HUIT Admin')

@section('content')
<div class="card card-admin p-4 border-0 shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <span class="badge bg-primary text-uppercase mb-1">Dữ liệu phân loại</span>
            <h1 class="h4 fw-bold text-dark mb-0">QUẢN LÝ DANH MỤC TÀI SẢN</h1>
        </div>
        <div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm fw-bold">
                [+] THÊM DANH MỤC MỚI
            </a>
        </div>
    </div>

    @if($categories->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-bold">Chưa có danh mục nào</h2>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small">
                <thead class="table-light">
                    <tr>
                        <th class="py-2">Mã</th>
                        <th class="py-2">Tên danh mục</th>
                        <th class="py-2">Đường dẫn định danh (Slug)</th>
                        <th class="py-2">Mô tả</th>
                        <th class="py-2">Số bài đăng</th>
                        <th class="py-2 text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>#{{ $category->id }}</td>
                            <td><strong class="text-dark">{{ $category->name }}</strong></td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td><span class="text-secondary">{{ Str::limit($category->description, 50) ?? 'Không có' }}</span></td>
                            <td><span class="badge bg-secondary">{{ $category->items_count }} bài</span></td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-warning btn-sm py-1 px-2 fw-semibold">
                                        [SỬA]
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
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
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
