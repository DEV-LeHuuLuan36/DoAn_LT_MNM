@extends('layouts.admin')

@section('title', 'Quản Lý Danh Mục - HUIT Admin')

@section('content')
<div class="card card-admin p-4 border-0 shadow-sm rounded-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle text-uppercase mb-1 px-3 py-1 rounded-pill" style="font-size: 0.75rem;">Dữ liệu phân loại</span>
            <h1 class="h4 fw-bold text-dark mb-0">Quản lý danh mục tài sản</h1>
        </div>
        <div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm fw-semibold px-3 py-2">
                Thêm danh mục mới
            </a>
        </div>
    </div>

    @if($categories->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-semibold">Chưa có danh mục nào</h2>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-2">Mã</th>
                        <th class="py-2">Tên danh mục</th>
                        <th class="py-2">Chuỗi định danh (Slug)</th>
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
                            <td><span class="badge bg-secondary-subtle text-secondary border px-2 py-1">{{ $category->items_count }} bài</span></td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1 flex-nowrap justify-content-end">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-warning btn-sm py-1 px-2 fw-medium text-dark text-nowrap">
                                        Sửa
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2 fw-medium text-nowrap">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-top">
            {{ $categories->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
