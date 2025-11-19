<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админ Панел') - Collection CMS</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- ЛЯВА КОЛОНА – АДМИН МЕНЮ -->
        <aside class="col-lg-2 d-none d-lg-block bg-white shadow-sm p-4" style="min-height: 100vh; position: sticky; top: 0;">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-user-shield text-primary me-2"></i>
                <div>
                    <strong>{{ auth()->user()->name }}</strong><br>
                    <small class="text-muted">Администратор</small>
                </div>
            </div>

            <hr>


            <nav class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-dark mb-2 {{ request()->routeIs('admin.dashboard') ? 'active bg-primary text-white' : '' }} rounded px-3 py-2">
                    <i class="fas fa-tachometer-alt me-2"></i> Панел
                </a>
                <a href="{{ route('admin.pages.index') }}" class="nav-link text-dark mb-2 {{ request()->routeIs('admin.pages.*') ? 'active bg-primary text-white' : '' }} rounded px-3 py-2">
                    <i class="fas fa-file-alt me-2"></i> Страници
                    <span class="badge bg-success">{{ \App\Models\Page::count() }}</span>
                </a>
                <a href="{{ route('admin.news.index') }}" class="nav-link text-dark mb-2 {{ request()->routeIs('admin.news.*') ? 'active bg-primary text-white' : '' }} rounded px-3 py-2">
                    <i class="fas fa-newspaper me-2"></i> Новини
                    <span class="badge bg-success">{{ \App\Models\News::count() }}</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link text-dark mb-2 {{ request()->routeIs('admin.categories.*') ? 'active bg-primary text-white' : '' }} rounded px-3 py-2">
                    <i class="fas fa-folder me-2"></i> Категории
                    <span class="badge bg-primary">{{ \App\Models\Category::count() }}</span>
                </a>
                <a href="{{ route('admin.menu.index') }}" class="nav-link text-dark mb-2 {{ request()->routeIs('admin.menu.*') ? 'active bg-primary text-white' : '' }} rounded px-3 py-2">
                    <i class="fas fa-bars me-2"></i> Меню
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-link text-dark mb-2 {{ request()->routeIs('admin.users.*') ? 'active bg-primary text-white' : '' }} rounded px-3 py-2">
                    <i class="fas fa-users me-2"></i> Потребители
                </a>
            </nav>

            <hr>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="fas fa-sign-out-alt me-2"></i> Изход
                </button>
            </form>
        </aside>

        <!-- ГЛАВНО СЪДЪРЖАНИЕ – ДЯСНО -->
        <main class="col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-primary">@yield('title')</h1>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    Към сайта
                </a>
            </div>

            <!-- СЪОБЩЕНИЯ -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- СЪДЪРЖАНИЕ -->
            @yield('content')
        </main>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Мобилно меню (ляво) -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const aside = document.querySelector('aside');
    if (window.innerWidth < 992) {
      aside.classList.add('position-fixed', 'top-0', 'start-0', 'h-100', 'bg-white', 'shadow-lg', 'p-4');
      aside.style.transform = 'translateX(-100%)';
      aside.style.transition = 'transform 0.3s ease';
      aside.style.zIndex = '1050';
      aside.style.width = '280px';

      const toggleBtn = document.createElement('button');
      toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
      toggleBtn.className = 'btn btn-primary position-fixed top-0 start-0 m-3 d-lg-none';
      toggleBtn.style.zIndex = '1060';
      toggleBtn.onclick = () => {
        const isOpen = aside.style.transform === 'translateX(0%)';
        aside.style.transform = isOpen ? 'translateX(-100%)' : 'translateX(0%)';
      };
      document.body.appendChild(toggleBtn);
    }
  });
</script>
</body>
</html>