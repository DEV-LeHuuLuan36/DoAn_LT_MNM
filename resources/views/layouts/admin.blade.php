<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản Trị Hệ Thống - Campus Lost & Found HUIT')</title>
    <!-- Trang quản trị bắt buộc noindex, nofollow -->
    <meta name="robots" content="noindex, nofollow">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --admin-sidebar-bg: #0f172a;
            --admin-sidebar-hover: #1e293b;
            --admin-primary: #003366;
            --admin-accent: #c8102e;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 260px;
            min-width: 260px;
            flex-shrink: 0;
            min-height: 100vh;
            background-color: var(--admin-sidebar-bg);
            color: #e2e8f0;
            border-right: 1px solid #1e293b;
        }

        .admin-brand {
            padding: 1.25rem 1.25rem;
            border-bottom: 1px solid #1e293b;
            background-color: #0b1120;
        }

        .admin-nav-link {
            color: #94a3b8;
            padding: 0.65rem 1.25rem;
            font-size: 0.925rem;
            font-weight: 500;
            display: block;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.15s ease-in-out;
            white-space: nowrap;
        }

        .admin-nav-link:hover, .admin-nav-link.active {
            color: #ffffff;
            background-color: var(--admin-sidebar-hover);
            border-left-color: var(--admin-accent);
        }

        .admin-nav-section-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.75px;
            color: #64748b;
            padding: 1.1rem 1.25rem 0.35rem;
            font-weight: 700;
        }

        .admin-topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
        }

        .card-admin {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            background-color: #ffffff;
        }

        .table > :not(caption) > * > * {
            padding: 0.85rem 0.75rem;
        }
    </style>
</head>
<body>
    <div class="d-flex min-vh-100">
        <!-- Semantic Aside: Admin Sidebar (Fixed 260px) -->
        <aside class="admin-sidebar d-none d-md-flex flex-column" aria-label="Thanh điều hướng quản trị viên">
            <div class="admin-brand">
                <span class="d-block fw-bold text-white fs-6">HUIT ADMIN PORTAL</span>
                <span class="badge bg-danger text-uppercase mt-1" style="font-size: 0.7rem; font-weight: 600;">Campus Lost &amp; Found</span>
            </div>

            <nav class="py-2 flex-grow-1" aria-label="Menu chức năng quản trị">
                <div class="admin-nav-section-title">Tổng quan</div>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Bảng điều khiển
                </a>

                <div class="admin-nav-section-title">Nghiệp vụ cốt lõi</div>
                <a href="{{ route('admin.items.index') }}" class="admin-nav-link {{ request()->routeIs('admin.items.*') ? 'active' : '' }}">
                    Quản lý bài đăng
                </a>
                <a href="{{ route('admin.claims.index') }}" class="admin-nav-link {{ request()->routeIs('admin.claims.*') ? 'active' : '' }}">
                    Xử lý yêu cầu nhận đồ
                </a>

                <div class="admin-nav-section-title">Danh mục &amp; Dữ liệu</div>
                <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    Danh mục đồ vật
                </a>
                <a href="{{ route('admin.locations.index') }}" class="admin-nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                    Địa điểm trong trường
                </a>

                <div class="admin-nav-section-title">Hệ thống</div>
                <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    Quản lý người dùng
                </a>

                <hr class="border-secondary mx-3 my-3">

                <a href="{{ route('items.index') }}" class="admin-nav-link text-info">
                    Về trang chủ website
                </a>
            </nav>
        </aside>

        <!-- Main Layout Wrapper (flex-grow: 1, min-width: 0, overflow-x: hidden) -->
        <div class="flex-grow-1 d-flex flex-column min-vh-100" style="min-width: 0; overflow-x: hidden;">
            <!-- Semantic Header: Admin Topbar -->
            <header class="admin-topbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <span class="fw-semibold text-secondary small">Khu vực kiểm soát Quản trị viên HUIT</span>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="small fw-semibold text-dark">
                        {{ Auth::user()->name }}
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle ms-1">Quản trị viên</span>
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger fw-medium px-3">Đăng xuất</button>
                    </form>
                </div>
            </header>

            <!-- Semantic Main Content -->
            <main class="p-4 flex-grow-1">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 py-3 px-4 mb-4" role="alert">
                        <span class="fw-medium">{{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 py-3 px-4 mb-4" role="alert">
                        <span class="fw-medium">{{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 py-3 px-4 mb-4" role="alert">
                        <div class="fw-semibold mb-1">Vui lòng kiểm tra lại thông tin:</div>
                        <ul class="mb-0 ps-3 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Semantic Footer -->
            <footer class="bg-white border-top py-3 px-4 text-secondary small text-center text-md-start">
                <span>Campus Lost &amp; Found HUIT - Hệ thống quản trị nội bộ Nhóm 4 | Khoa Công nghệ Thông tin</span>
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5.3 Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
