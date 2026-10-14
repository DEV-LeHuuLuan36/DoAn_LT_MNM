<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Campus Lost & Found - HUIT | Tìm Kiếm Đồ Thất Lạc')</title>
    <meta name="description" content="@yield('meta_description', 'Hệ thống hỗ trợ tìm kiếm và trao trả đồ dùng thất lạc trong khuôn viên Trường Đại học Công Thương TP. HCM (HUIT). Minh bạch, nhanh chóng và an toàn.')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph Meta Tags -->
    @yield('meta_tags')

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS Phong cách Chuẩn SEO & Zero-Icon Tinh Tế -->
    <style>
        :root {
            --huit-primary: #003366;
            --huit-primary-hover: #002244;
            --huit-accent: #c8102e;
            --huit-light-bg: #f8fafc;
            --huit-border: #e2e8f0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #1e293b;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }

        .navbar-huit {
            background-color: var(--huit-primary);
            border-bottom: 3px solid var(--huit-accent);
        }

        .navbar-brand-text {
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #ffffff !important;
        }

        .brand-badge {
            background-color: var(--huit-accent);
            color: #ffffff;
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 700;
            margin-left: 6px;
            text-transform: uppercase;
        }

        .nav-link-custom {
            color: #e2e8f0 !important;
            font-weight: 500;
            padding: 0.5rem 0.85rem !important;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.12);
        }

        .btn-post-item {
            background-color: #ffcc00;
            color: #002244;
            font-weight: 600;
            border: none;
            padding: 0.45rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .btn-post-item:hover {
            background-color: #e6b800;
            color: #001122;
        }

        .card-custom {
            border: 1px solid var(--huit-border);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            background-color: #ffffff;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .card-custom:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        footer {
            background-color: #0f172a;
            color: #cbd5e1;
            border-top: 4px solid var(--huit-accent);
        }

        footer a {
            color: #94a3b8;
            text-decoration: none;
        }

        footer a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .breadcrumb-item a {
            color: var(--huit-primary);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item.active {
            color: #64748b;
            font-weight: 500;
        }
    </style>

    <!-- Schema Structured Data (JSON-LD) -->
    @yield('json_ld')
</head>
<body>
    <!-- Header & Navigation Semantics -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark navbar-huit py-2" aria-label="Điều hướng chính Campus Lost and Found">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('items.index') }}">
                    <span class="navbar-brand-text">CAMPUS LOST &amp; FOUND</span>
                    <span class="brand-badge">HUIT</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Chuyển đổi menu điều hướng">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('items.index') && !request()->has('type') ? 'active' : '' }}" href="{{ route('items.index') }}">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->get('type') === 'lost' ? 'active' : '' }}" href="{{ route('items.index', ['type' => 'lost']) }}">Đồ bị mất</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->get('type') === 'found' ? 'active' : '' }}" href="{{ route('items.index', ['type' => 'found']) }}">Đồ nhặt được</a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('items.create') }}" class="btn btn-post-item">
                            Đăng tin mới
                        </a>

                        @auth
                            <div class="dropdown">
                                <button class="btn btn-outline-light btn-sm dropdown-toggle fw-medium px-3 rounded-2" type="button" id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                    <span class="badge {{ Auth::user()->role === 'admin' ? 'bg-danger' : 'bg-primary' }} ms-1" style="font-size: 0.7rem;">
                                        {{ Auth::user()->role === 'admin' ? 'Quản trị viên' : 'Sinh viên' }}
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3" aria-labelledby="userMenuDropdown">
                                    <li><h6 class="dropdown-header text-uppercase fw-semibold" style="font-size: 0.75rem;">{{ Auth::user()->email }}</h6></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('profile.my-items') }}">Tin đăng của tôi</a></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('profile.my-claims') }}">Yêu cầu nhận đồ đã gửi</a></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}">Cập nhật thông tin cá nhân</a></li>
                                    @if(Auth::user()->role === 'admin')
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item py-2 text-danger fw-semibold" href="{{ route('admin.dashboard') }}">Trang quản trị hệ thống</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-secondary">Đăng xuất</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm fw-medium px-3">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="btn btn-light btn-sm fw-semibold px-3">Đăng ký</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content Area -->
    <main class="py-4">
        <div class="container">
            <!-- Thông báo Alert Flash Message Dịu Nhẹ -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 py-3 px-4 mb-4" role="alert">
                    <span class="fw-medium">{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng thông báo"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 py-3 px-4 mb-4" role="alert">
                    <span class="fw-medium">{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng thông báo"></button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng thông báo"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Semantic Footer -->
    <footer class="py-4 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-6">
                    <h5 class="text-white text-uppercase fw-bold mb-3">Campus Lost &amp; Found - HUIT</h5>
                    <p class="small text-secondary mb-2">
                        Hệ thống tìm kiếm và trao trả đồ thất lạc trực tuyến dành cho sinh viên, giảng viên và cán bộ nhân viên Trường Đại học Công Thương TP. Hồ Chí Minh.
                    </p>
                    <p class="small text-secondary mb-0">
                        Địa chỉ: 140 Lê Trọng Tấn, P. Tây Thạnh, Q. Tân Phú, TP. Hồ Chí Minh
                    </p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white text-uppercase fw-bold mb-3">Đồ Án Học Phần</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1 text-secondary">Học phần: Lập trình mã nguồn mở</li>
                        <li class="mb-1 text-secondary">Đơn vị: Khoa Công nghệ Thông tin</li>
                        <li class="mb-1 text-secondary">Trường: ĐH Công Thương TP. HCM (HUIT)</li>
                        <li class="mb-1 text-secondary">Công nghệ: Laravel 11 &amp; Bootstrap 5.3</li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h6 class="text-white text-uppercase fw-bold mb-3">Thành Viên Nhóm 4</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1 text-secondary"><strong class="text-white">Lê Hữu Luân</strong> - MSSV: 2001230482 (Nhóm trưởng)</li>
                        <li class="mb-1 text-secondary"><strong class="text-white">Nguyễn Khánh Duy</strong> - MSSV: 2001230124</li>
                        <li class="mb-1 text-secondary"><strong class="text-white">Trương Quang Diệu</strong> - MSSV: 2001230097</li>
                        <li class="mb-1 text-secondary"><strong class="text-white">Phạm Hải Nguyên</strong> - MSSV: 2001230581</li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary my-3">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center small text-secondary">
                <span>&copy; {{ date('Y') }} Campus Lost &amp; Found HUIT - Nhóm 4. All rights reserved.</span>
                <span>Trường Đại học Công Thương TP. HCM (HUIT) – Khoa Công nghệ Thông tin</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
