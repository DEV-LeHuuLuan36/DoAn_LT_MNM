@extends('layouts.admin')

@section('title', 'Quản Lý Người Dùng - HUIT Admin')

@section('content')
<div class="card card-admin p-4 border-0 shadow-sm rounded-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle text-uppercase mb-1 px-3 py-1 rounded-pill" style="font-size: 0.75rem;">Kiểm soát bảo mật</span>
            <h1 class="h4 fw-bold text-dark mb-0">Quản lý tài khoản người dùng</h1>
        </div>
        <div>
            <span class="small text-muted">Tổng số tài khoản: {{ $users->total() }}</span>
        </div>
    </div>

    <!-- Bộ lọc tìm kiếm người dùng -->
    <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 mb-4 bg-light p-3 rounded-3 border">
        <div class="col-md-5">
            <label for="keyword" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Tìm theo Tên, Email hoặc MSSV:</label>
            <input type="text" name="keyword" id="keyword" class="form-control form-control-sm py-2" value="{{ request('keyword') }}" placeholder="Nhập từ khóa tìm kiếm...">
        </div>
        <div class="col-md-3">
            <label for="role" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Phân quyền vai trò:</label>
            <select name="role" id="role" class="form-select form-select-sm py-2">
                <option value="">Tất cả vai trò</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Sinh viên / User</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Quản trị viên / Admin</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end gap-1">
            <button type="submit" class="btn btn-primary btn-sm fw-semibold w-100 py-2">Tìm</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm py-2 px-3">Đặt lại</a>
        </div>
    </form>

    @if($users->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-semibold">Không tìm thấy tài khoản người dùng nào</h2>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-2">Mã</th>
                        <th class="py-2">Họ và tên</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">MSSV</th>
                        <th class="py-2">Số điện thoại</th>
                        <th class="py-2">Vai trò</th>
                        <th class="py-2">Trạng thái</th>
                        <th class="py-2 text-end">Hành động quản lý</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td>
                                <strong class="text-dark">{{ $user->name }}</strong>
                                @if($user->id === Auth::id())
                                    <span class="badge bg-info-subtle text-info border border-info-subtle ms-1">Bạn</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->student_code ?? '-' }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Quản trị viên</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">Sinh viên</span>
                                @endif
                            </td>
                            <td>
                                @if($user->is_locked)
                                    <span class="badge bg-dark text-warning border px-2 py-1">Đã bị khóa</span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Đang hoạt động</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($user->id !== Auth::id())
                                    <div class="d-inline-flex gap-1 flex-nowrap justify-content-end">
                                        <!-- Khóa / Mở khóa -->
                                        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="toggle_lock" value="1">
                                            @if($user->is_locked)
                                                <button type="submit" class="btn btn-outline-success btn-sm py-1 px-2 fw-medium text-nowrap" onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản này?');">Mở khóa</button>
                                            @else
                                                <button type="submit" class="btn btn-outline-warning btn-sm py-1 px-2 fw-medium text-nowrap text-dark" onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?');">Khóa tài khoản</button>
                                            @endif
                                        </form>

                                        <!-- Thay đổi vai trò Admin / User -->
                                        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if($user->role === 'admin')
                                                <input type="hidden" name="role" value="user">
                                                <button type="submit" class="btn btn-outline-secondary btn-sm py-1 px-2 fw-medium text-nowrap" onclick="return confirm('Bạn có chắc muốn giáng quyền Admin thành User?');">Hạ quyền</button>
                                            @else
                                                <input type="hidden" name="role" value="admin">
                                                <button type="submit" class="btn btn-outline-primary btn-sm py-1 px-2 fw-medium text-nowrap" onclick="return confirm('Bạn có chắc muốn nâng tài khoản này lên Admin?');">Cấp quyền Admin</button>
                                            @endif
                                        </form>

                                        <!-- Xóa tài khoản -->
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('CẢNH BÁO: Xóa tài khoản sẽ đồng thời xóa tất cả bài đăng, yêu cầu và bình luận liên quan. Bạn có chắc chắn không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2 fw-medium text-nowrap">Xóa</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small">Tài khoản hiện tại</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-3 border-top">
            {{ $users->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
