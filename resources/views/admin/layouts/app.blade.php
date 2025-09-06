<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Administration</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

            <!-- Tailwind CSS Optimisé -->
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                        colors: {
                            primary: {
                                50: '#eff6ff',
                                100: '#dbeafe',
                                200: '#bfdbfe',
                                300: '#93c5fd',
                                400: '#60a5fa',
                                500: '#3b82f6',
                                600: '#2563eb',
                                700: '#1d4ed8',
                                800: '#1e40af',
                                900: '#1e3a8a',
                            }
                        }
                    }
                }
            }
        </script>
        
        <!-- JavaScript Admin -->
        <script src="{{ asset('js/admin.js') }}"></script>
    
    <style>
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        
        .content-transition {
            transition: margin-left 0.3s ease-in-out;
        }
        
        @media (max-width: 768px) {
            .sidebar-mobile {
                transform: translateX(-100%);
            }
            
            .sidebar-mobile.open {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-transition bg-white dark:bg-gray-800 shadow-lg w-64 fixed h-full z-30 sidebar-mobile">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-flag text-white text-sm"></i>
                    </div>
                    <span class="text-lg font-semibold text-gray-800 dark:text-white">RCA Admin</span>
                </div>
                <button id="closeSidebar" class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="mt-4">
                <div class="px-4 mb-4">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu Principal</span>
                </div>
                
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                            <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                            <span>{{ __('admin.dashboard') }}</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.speeches.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 {{ request()->routeIs('admin.speeches.*') ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                            <i class="fas fa-microphone w-5 h-5 mr-3"></i>
                            <span>{{ __('admin.speeches') }}</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.news.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 {{ request()->routeIs('admin.news.*') ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                            <i class="fas fa-newspaper w-5 h-5 mr-3"></i>
                            <span>{{ __('admin.news') }}</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.quotes.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 {{ request()->routeIs('admin.quotes.*') ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                            <i class="fas fa-quote-right w-5 h-5 mr-3"></i>
                            <span>{{ __('admin.quotes') }}</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.photos.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 {{ request()->routeIs('admin.photos.*') ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                            <i class="fas fa-images w-5 h-5 mr-3"></i>
                            <span>{{ __('admin.photos') }}</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.videos.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 {{ request()->routeIs('admin.videos.*') ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                            <i class="fas fa-video w-5 h-5 mr-3"></i>
                            <span>{{ __('admin.videos') }}</span>
                        </a>
                    </li>
                </ul>

                <div class="px-4 mt-6 mb-4">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Gestion</span>
                </div>
                
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                            <i class="fas fa-tags w-5 h-5 mr-3"></i>
                            <span>{{ __('admin.categories') }}</span>
                        </a>
                    </li>
                    
                    
                    <li>
                        <a href="{{ route('admin.social-links.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 {{ request()->routeIs('admin.social-links.*') ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                            <i class="fas fa-share-alt w-5 h-5 mr-3"></i>
                            <span>{{ __('admin.social_links') }}</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.biographies.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 {{ request()->routeIs('admin.biographies.*') ? 'bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                            <i class="fas fa-user w-5 h-5 mr-3"></i>
                            <span>{{ __('admin.biographies') }}</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="content-transition flex-1 lg:ml-64">
            <!-- Top Navigation -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center">
                        <button id="openSidebar" class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mr-3">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800 dark:text-white">@yield('title', 'Administration')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Language switcher -->
                        <div class="relative">
                            <form id="languageForm" method="POST" action="{{ route('language.switch') }}" class="inline">
                                @csrf
                                <select id="languageSelect" name="locale" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>🇫🇷 Français</option>
                                    <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇺🇸 English</option>
                                </select>
                            </form>
                        </div>
                        
                        <!-- Dark mode toggle -->
                        <button id="darkModeToggle" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <i class="fas fa-moon dark:hidden"></i>
                            <i class="fas fa-sun hidden dark:block"></i>
                        </button>
                        
                        <!-- User menu -->
                        <div class="relative">
                            <button id="userMenuButton" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <span class="hidden md:block">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50">
                                <div class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                    Connecté en tant que<br>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->email }}</span>
                                </div>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        {{ __('admin.logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-md">
                        <div class="flex">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-md">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-md">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <div>
                                <strong>Erreurs :</strong>
                                <ul class="mt-1 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden"></div>

    <script>
        // Sidebar toggle
        document.getElementById('openSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.remove('hidden');
        });

        document.getElementById('closeSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        });

        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        });

        // User menu toggle
        document.getElementById('userMenuButton').addEventListener('click', function() {
            document.getElementById('userMenu').classList.toggle('hidden');
        });

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userMenuButton = document.getElementById('userMenuButton');
            
            if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Dark mode toggle
        document.getElementById('darkModeToggle').addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
        });

        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }

        // Save dark mode preference
        document.getElementById('darkModeToggle').addEventListener('click', function() {
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        });

        // Language switcher
        document.getElementById('languageSelect').addEventListener('change', function() {
            document.getElementById('languageForm').submit();
        });
    </script>
</body>
</html>
