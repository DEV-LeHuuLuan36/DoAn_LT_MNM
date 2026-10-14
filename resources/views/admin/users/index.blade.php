@extends('layouts.admin')

@section('title', 'Quản Lý Người Dùng - HUIT Admin')

@section('content')
<div class="card card-admin p-4 border-0 shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <span class="badge bg-danger text-uppercase mb-1">Kiểm soát bảo mật</span>
            <h1 class="h4 fw-bold text-dark mb-0">QUẢN LÝ TÀI KHOẢN NGƯỜI DÙNG (F16)</h1>
        </div>
        <div>
            <span class="small text-muted">Tổng số tài khoản: {{ $users->total() }}</span>
        </div>
    </div>

    <!-- Bộ lọc tìm kiếm người dùng -->
    <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 mb-4 bg-light p-3 rounded border">
        <div class="col-md-5">
            <label for="keyword" class="form-label small fw-bold text-secondary text-uppercase mb-1">Tìm theo Tên, Email hoặc MSSV:</label>
            <input type="text" name="keyword" id="keyword" class="form-control form-control-sm" value="{{ request('keyword') }}" placeholder="Nhập từ khóa tìm kiếm...">
        </div>
        <div class="col-md-3">
            <label for="role" class="form-label small fw-bold text-secondary text-uppercase mb-1">Phân quyền vai trò:</label>
            <select name="role" id="role" class="form-select form-select-sm">
                <option value="">-- Tất cả vai trò --</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>[SINH VIÊN / USER]</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>[QUẢN TRỊ VIÊN / ADMIN]</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end gap-1">
            <button type="submit" class="btn btn-primary btn-sm fw-bold w-100">[TÌM]</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">[XÓA]</a>
        </div>
    </form>

    @if($users->isEmpty())
        <div class="text-center py-5">
            <h2 class="h5 text-secondary fw-bold">Không tìm thấy tài khoản người dùng nào</h2>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle small">
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
                                    <span class="badge bg-info text-dark ms-1">[BẠN]</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->student_code ?? '-' }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger">[QUẢN TRỊ VIÊN]</span>
                                @else
                                    <span class="badge bg-secondary">[SINH VIÊN]</span>
                                @endif
                            </td>
                            <td>
                                @if($user->is_locked)
                                    <span class="badge bg-dark text-warning">[ĐÃ BỊ KHÓA]</span>
                                @else
                                    <span class="badge bg-success">[HOẠT ĐỘNG]</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($user->id !== Auth::id())
                                    <div class="d-inline-flex flex-wrap gap-1 justify-content-end">
                                        <!-- Khóa / Mở khóa -->
                                        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="toggle_lock" value="1">
                                            @if($user->is_locked)
                                                <button type="submit" class="btn btn-outline-success btn-sm py-0 px-2 fw-semibold" onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản này?');">[MỞ KHÓA]</button>
                                            @else
                                                <button type="submit" class="btn btn-outline-warning btn-sm py-0 px-2 fw-semibold text-dark" onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?');">[KHÓA TK]</button>
                                            @endif
                                        </form>

                                        <!-- Thay đổi vai trò Admin / User -->
                                        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if($user->role === 'admin')
                                                <input type="hidden" name="role" value="user">
                                                <button type="submit" class="btn btn-outline-secondary btn-sm py-0 px-2 fw-semibold" onclick="return confirm('Bạn có chắc muốn giáng quyền Admin thành User?');">[HẠ QUYỀN]</button>
                                            @else
                                                <input type="hidden" name="role" value="admin">
                                                <button type="submit" class="btn btn-outline-primary btn-sm py-0 px-2 fw-semibold" onclick="return confirm('Bạn có chắc muốn nâng tài khoản này lên Admin?');">[THÀNH ADMIN]</button>
                                            @endif
                                        </form>

                                        <!-- Xóa tài khoản -->
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('CẢNH BÁO: Xóa tài khoản sẽ đồng thời xóa tất cả bài đăng, yêu cầu và bình luận liên quan. Bạn có chắc chắn không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2 fw-semibold">[XÓA]</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted" style="font-size: 0.75rem;">[TÀI KHOẢN HIỆN TẠI]</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
