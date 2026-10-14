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

    <!-- Bootstrap 5.3 CSS (Zero-Icon: Tuyệt đối không dùng thư viện Icon) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --admin-sidebar-bg: #1e293b;
            --admin-sidebar-hover: #334155;
            --admin-primary: #003366;
            --admin-accent: #c8102e;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
        }

        .admin-sidebar {
            background-color: var(--admin-sidebar-bg);
            min-height: 100vh;
            color: #e2e8f0;
            border-right: 1px solid #0f172a;
        }

        .admin-brand {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid #334155;
            background-color: #0f172a;
        }

        .admin-nav-link {
            color: #94a3b8;
            padding: 0.75rem 1.25rem;
            font-weight: 500;
            display: block;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.2s ease-in-out;
        }

        .admin-nav-link:hover, .admin-nav-link.active {
            color: #ffffff;
            background-color: var(--admin-sidebar-hover);
            border-left-color: var(--admin-accent);
        }

        .admin-nav-section-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            padding: 1rem 1.25rem 0.25rem;
            font-weight: 700;
        }

        .admin-topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
        }

        .card-admin {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            background-color: #ffffff;
        }

        .table > :not(caption) > * > * {
            padding: 0.85rem 0.75rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Semantic Aside: Admin Sidebar -->
            <aside class="col-lg-2 col-md-3 admin-sidebar d-none d-md-block" aria-label="Thanh điều hướng quản trị viên">
                <div class="admin-brand">
                    <span class="d-block fw-bold text-white fs-6">HUIT ADMIN PORTAL</span>
                    <span class="badge bg-danger text-uppercase mt-1">Campus Lost &amp; Found</span>
                </div>

                <nav class="py-2" aria-label="Menu chức năng quản trị">
                    <div class="admin-nav-section-title">Tổng quan</div>
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        [BẢNG ĐIỀU KHIỂN]
                    </a>

                    <div class="admin-nav-section-title">Nghiệp vụ cốt lõi</div>
                    <a href="{{ route('admin.items.index') }}" class="admin-nav-link {{ request()->routeIs('admin.items.*') ? 'active' : '' }}">
                        [QUẢN LÝ BÀI ĐĂNG]
                    </a>
                    <a href="{{ route('admin.claims.index') }}" class="admin-nav-link {{ request()->routeIs('admin.claims.*') ? 'active' : '' }}">
                        [XỬ LÝ YÊU CẦU NHẬN ĐỒ]
                    </a>

                    <div class="admin-nav-section-title">Danh mục &amp; Dữ liệu</div>
                    <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        [DANH MỤC ĐỒ VẬT]
                    </a>
                    <a href="{{ route('admin.locations.index') }}" class="admin-nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                        [ĐỊA ĐIỂM TRONG TRƯỜNG]
                    </a>

                    <div class="admin-nav-section-title">Hệ thống</div>
                    <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        [QUẢN LÝ NGƯỜI DÙNG]
                    </a>

                    <hr class="border-secondary mx-3 my-3">

                    <a href="{{ route('items.index') }}" class="admin-nav-link text-info">
                        [&lt;-- VỀ TRANG CHỦ WEB]
                    </a>
                </nav>
            </aside>

            <!-- Main Layout Wrapper -->
            <div class="col-lg-10 col-md-9 d-flex flex-column min-vh-100">
                <!-- Semantic Header: Admin Topbar -->
                <header class="admin-topbar d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="fw-bold text-uppercase text-secondary small">Khu vực kiểm soát Quản trị viên HUIT</span>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <span class="small fw-semibold">[ADMIN] {{ Auth::user()->name }} ({{ Auth::user()->email }})</span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold">[ĐĂNG XUẤT]</button>
                        </form>
                    </div>
                </header>

                <!-- Semantic Main Content -->
                <main class="p-4 flex-grow-1">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-start border-success border-4 fw-medium mb-4" role="alert">
                            <strong>[THÀNH CÔNG]</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-start border-danger border-4 fw-medium mb-4" role="alert">
                            <strong>[CẢNH BÁO / LỖI]</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-start border-danger border-4 mb-4" role="alert">
                            <strong class="d-block mb-1">[LỖI XÁC THỰC]</strong>
                            <ul class="mb-0 ps-3">
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
                    <span>Campus Lost &amp; Found HUIT - Hệ thống quản trị nội bộ Nhóm 4 | Năm học {{ date('Y') }}</span>
                </footer>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
