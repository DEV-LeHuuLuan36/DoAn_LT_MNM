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
    <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 mb-4 bg-light p-3 rounded-3 border align-items-end">
        <div class="col-md-5">
            <label for="keyword" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Tìm theo Tên, Email hoặc MSSV:</label>
            <input type="text" name="keyword" id="keyword" class="form-control py-2" value="{{ request('keyword') }}" placeholder="Nhập từ khóa tìm kiếm...">
        </div>
        <div class="col-md-3">
            <label for="role" class="form-label small fw-semibold text-secondary text-uppercase mb-1">Phân quyền vai trò:</label>
            <select name="role" id="role" class="form-select py-2">
                <option value="">Tất cả vai trò</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Sinh viên / User</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Quản trị viên / Admin</option>
            </select>
        </div>
        <div class="col-md-auto d-flex gap-2 align-items-end">
            <button type="submit" class="btn btn-primary text-nowrap px-3 py-2">Tìm</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary text-nowrap px-3 py-2">Đặt lại</a>
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
                        <th class="py-2 text-nowrap" style="width: 60px;">Mã</th>
                        <th class="py-2 text-nowrap">Thông tin tài khoản</th>
                        <th class="py-2 text-nowrap">MSSV &amp; Điện thoại</th>
                        <th class="py-2 text-nowrap">Vai trò &amp; Trạng thái</th>
                        <th class="py-2 text-end text-nowrap" style="width: 240px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $isCurrentSuperAdmin = (Auth::id() === 1 || (Auth::user() && Auth::user()->email === 'admin@huit.edu.vn'));
                    @endphp
                    @foreach($users as $user)
                        @php
                            $isTargetSuperAdmin = ($user->id === 1 || $user->email === 'admin@huit.edu.vn');
                        @endphp
                        <tr>
                            <td class="text-nowrap text-secondary">#{{ $user->id }}</td>
                            <td>
                                <strong class="text-dark">{{ $user->name }}</strong>
                                @if($user->id === Auth::id())
                                    <span class="badge bg-info-subtle text-info border border-info-subtle ms-1">Bạn</span>
                                @endif
                                <div class="small text-muted">{{ $user->email }}</div>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">MSSV: {{ $user->student_code ?? 'Chưa cập nhật' }}</div>
                                <div class="small text-muted">SĐT: {{ $user->phone ?? 'Chưa cập nhật' }}</div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1 align-items-center">
                                    @if($isTargetSuperAdmin)
                                        <span class="badge bg-danger text-white border border-danger px-2 py-1 fw-semibold">Quản trị viên gốc</span>
                                    @elseif($user->role === 'admin')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Quản trị viên</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">Sinh viên</span>
                                    @endif

                                    @if($user->is_locked)
                                        <span class="badge bg-dark text-warning border px-2 py-1">Đã khóa</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Đang hoạt động</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end">
                                {{-- Trường hợp 1: Tài khoản đang đăng nhập --}}
                                @if($user->id === Auth::id())
                                    <span class="badge bg-secondary-subtle text-secondary border">Tài khoản đang dùng</span>

                                {{-- Trường hợp 2: Quản trị viên tối cao (Super Admin gốc) --}}
                                @elseif($isTargetSuperAdmin)
                                    <span class="badge bg-primary-subtle text-primary border">Quản trị viên tối cao</span>

                                {{-- Trường hợp 3: Các tài khoản khác --}}
                                @else
                                    @if($isCurrentSuperAdmin)
                                        <div class="d-inline-flex gap-1 flex-nowrap justify-content-end">
                                            <!-- Khóa / Mở khóa -->
                                            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="toggle_lock" value="1">
                                                @if($user->is_locked)
                                                    <button type="submit" class="btn btn-outline-success btn-sm py-1 px-2 fw-medium text-nowrap" onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản này?');">Mở khóa</button>
                                                @else
                                                    <button type="submit" class="btn btn-outline-warning btn-sm py-1 px-2 fw-medium text-nowrap text-dark" onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?');">Khóa</button>
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
                                                    <button type="submit" class="btn btn-outline-primary btn-sm py-1 px-2 fw-medium text-nowrap" onclick="return confirm('Bạn có chắc muốn nâng tài khoản này lên Admin?');">Cấp Admin</button>
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
                                        {{-- Admin phụ đang đăng nhập --}}
                                        @if($user->role === 'admin')
                                            <span class="badge bg-secondary-subtle text-secondary border">Đồng quản trị viên</span>
                                        @else
                                            <div class="d-inline-flex gap-1 flex-nowrap justify-content-end">
                                                <!-- Khóa / Mở khóa -->
                                                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="toggle_lock" value="1">
                                                    @if($user->is_locked)
                                                        <button type="submit" class="btn btn-outline-success btn-sm py-1 px-2 fw-medium text-nowrap" onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản này?');">Mở khóa</button>
                                                    @else
                                                        <button type="submit" class="btn btn-outline-warning btn-sm py-1 px-2 fw-medium text-nowrap text-dark" onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?');">Khóa</button>
                                                    @endif
                                                </form>

                                                <!-- Xóa tài khoản -->
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('CẢNH BÁO: Xóa tài khoản sẽ đồng thời xóa tất cả bài đăng, yêu cầu và bình luận liên quan. Bạn có chắc chắn không?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2 fw-medium text-nowrap">Xóa</button>
                                                </form>
                                            </div>
                                        @endif
                                    @endif
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
