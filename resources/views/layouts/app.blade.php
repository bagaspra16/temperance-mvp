<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Temperance'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Library -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#13151a',
                            50: '#f9fafb',
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                            300: '#d1d5db',
                            400: '#9ca3af',
                            500: '#6b7280',
                            600: '#4b5563',
                            700: '#374151',
                            800: '#1f2937',
                            900: '#111827',
                            950: '#0d1117',
                        },
                        accent: {
                            light: '#f472b6',
                            DEFAULT: '#ec4899',
                            dark: '#be185d',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 20px 0 rgba(0, 0, 0, 0.05)',
                        'glow': '0 0 15px rgba(236, 72, 153, 0.5)',
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    },
                    screens: {
                        '2xl': '1536px',
                        '3xl': '1920px',
                    },
                    maxWidth: {
                        '8xl': '1920px',
                    },
                },
            },
        };
    </script>
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Tailwind Configuration */
        :root {
            --color-primary: #111827;
            --color-secondary: #1f2937;
            --color-dark-100: #374151;
            --color-dark-200: #282c34;
            --color-dark-300: #1e2227; 
            --color-accent: #ec4899;
            --color-accent-light: #f472b6;
            --color-accent-dark: #db2777;
        }
        
        /* Base Styles */
        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--color-primary);
            color: #f3f4f6;
            line-height: 1.5;
        }
        
        /* Custom Box Shadows */
        .shadow-soft {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .shadow-glow {
            box-shadow: 0 0 15px rgba(236, 72, 153, 0.3);
        }
        
        /* Gradients */
        .gradient-pink {
            background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
        }
        
        .gradient-dark {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        }
        
        /* Button Styles */
        .btn {
            @apply inline-flex items-center justify-center px-4 py-2.5 rounded-xl font-medium transition-all duration-200 border border-transparent;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--color-accent), var(--color-accent-dark));
            @apply text-white shadow-md;
            box-shadow: 0 4px 10px rgba(236, 72, 153, 0.3), 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--color-accent-light), var(--color-accent));
            box-shadow: 0 6px 15px rgba(236, 72, 153, 0.4), 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
        
        .btn-primary:active {
            transform: translateY(1px);
            box-shadow: 0 2px 5px rgba(236, 72, 153, 0.3);
        }
        
        .btn-secondary {
            @apply bg-dark-100/80 text-white border-dark-100/50 shadow-md;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .btn-secondary:hover {
            @apply bg-dark-200 border-dark-100;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }
        
        .btn-outline {
            @apply border border-dark-100/50 text-gray-300 bg-transparent;
        }
        
        .btn-outline:hover {
            @apply border-accent/50 text-accent bg-accent/5;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
        
        .btn-link {
            @apply p-0 underline text-accent bg-transparent shadow-none flex items-center;
        }
        
        .btn-link:hover {
            @apply text-accent-light;
        }
        
        .btn-sm {
            @apply px-3 py-1.5 text-sm rounded-lg;
        }
        
        .btn-lg {
            @apply px-6 py-3 text-lg rounded-xl;
        }
        
        .btn-icon {
            @apply inline-flex items-center justify-center;
        }
        
        .btn-icon svg, 
        .btn-icon i {
            @apply mr-2;
        }
        
        /* Card Styles */
        .card {
            @apply rounded-xl shadow-md border border-dark-100/30 overflow-hidden;
            background: linear-gradient(145deg, rgba(30, 34, 39, 0.7), rgba(26, 30, 35, 0.9));
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(236, 72, 153, 0.1);
            border-color: rgba(236, 72, 153, 0.1);
            transform: translateY(-2px);
        }
        
        .card-header {
            @apply p-8 border-b border-dark-100/20 bg-dark-300/50;
        }
        
        .card-title {
            @apply text-xl font-bold text-white;
        }
        
        .card-body {
            @apply p-8;
        }
        
        .card-footer {
            @apply p-8 border-t border-dark-100/20 bg-dark-300/30;
        }
        
        /* Modern form components */
        /* Toggle switch */
        .toggle-switch {
            @apply relative appearance-none w-12 h-6 rounded-full transition-colors cursor-pointer;
            background: rgba(55, 65, 81, 0.5);
        }
        
        .toggle-switch:checked {
            background: linear-gradient(90deg, var(--color-accent), var(--color-accent-light));
            box-shadow: 0 0 10px rgba(236, 72, 153, 0.3);
        }
        
        .toggle-switch:before {
            content: '';
            @apply absolute left-1 top-1 bg-white rounded-full w-4 h-4 transition-transform;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }
        
        .toggle-switch:checked:before {
            @apply transform translate-x-6;
        }
        
        /* Select styles */
        select.form-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
            padding-right: 2.5rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        
        /* Date input styles */
        input[type="date"].form-input {
            @apply text-gray-300;
        }
        
        input[type="date"].form-input::-webkit-calendar-picker-indicator {
            filter: invert(0.7);
            opacity: 0.7;
        }
        
        /* File input */
        .file-input-container {
            @apply relative;
        }
        
        .file-input {
            @apply absolute inset-0 opacity-0 w-full h-full cursor-pointer;
        }
        
        .file-input-button {
            @apply flex items-center justify-center px-4 py-2.5 rounded-xl bg-dark-200 border border-dark-100/50 text-gray-300;
        }
        
        .file-input:focus + .file-input-button {
            @apply border-accent/50 ring-2 ring-accent/10;
        }
        
        /* Radio and Checkbox groups */
        .option-group {
            @apply flex flex-wrap gap-3;
        }
        
        .option-item {
            @apply px-4 py-2.5 rounded-xl border border-dark-100/50 cursor-pointer transition-all;
            background: rgba(30, 34, 39, 0.5);
        }
        
        .option-item.selected {
            @apply border-accent/50 bg-accent/10 text-white;
        }
        
        .option-item:hover:not(.selected) {
            @apply border-dark-100 bg-dark-100/30;
        }
        
        /* Badge Styles */
        .badge {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
        }
        
        /* Form Styles */
        .form-input, 
        .form-select, 
        .form-textarea {
            @apply bg-dark-200/70 border border-dark-100/50 rounded-xl px-6 py-4 w-full focus:outline-none transition duration-200 text-base;
            backdrop-filter: blur(5px);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            line-height: 1.5;
        }
        
        .form-input:focus, 
        .form-select:focus, 
        .form-textarea:focus {
            @apply border-accent/50 ring-2 ring-accent/10;
            box-shadow: 0 0 0 1px rgba(236, 72, 153, 0.1), inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .form-input::placeholder {
            @apply text-gray-500;
        }

        .form-label {
            @apply block text-gray-300 font-medium mb-3 text-base;
            font-size: 1rem;
        }
        
        .form-helper {
            @apply mt-2 text-sm text-gray-500;
        }
        
        .form-error {
            @apply mt-1 text-sm text-red-400;
        }
        
        .form-checkbox, 
        .form-radio {
            @apply rounded text-accent focus:ring-accent focus:ring-offset-0 focus:ring-offset-transparent bg-dark-300 border-dark-100;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 1.25rem;
            height: 1.25rem;
        }
        
        .form-group {
            @apply mb-10;
        }
        
        /* Main Content Settings */
        .main-content {
            @apply w-full;
        }
        
        /* Top Navbar */
        .top-navbar {
            background-color: #121212;
            box-shadow: 0 4px 20px rgba(236, 72, 153, 0.15);
            position: sticky;
            top: 0;
            z-index: 50;
            height: 70px; /* Increased navbar height */
        }
        
        .navbar-container {
            width: 100%;
            margin: 0 auto;
            height: 100%;
            padding: 0 16px;
            display: flex;
            justify-content: space-between;
        }
        
        .navbar-left {
            width: 25%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-left: 10px;
        }
        
        .navbar-center {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .navbar-right {
            width: 25%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-right: 10px;
        }
        
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
            background: linear-gradient(90deg, var(--color-accent), var(--color-accent-light));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.3s ease;
            font-size: 1.5rem;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
        }
        
        /* Navigation Links */
        .nav-link-compact {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link-compact i {
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .nav-link-compact:hover i,
        .nav-link-compact.active i {
            color: var(--color-accent);
        }
        
        .nav-link-compact::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--color-accent);
            transition: width 0.3s ease;
        }
        
        .nav-link-compact:hover::after,
        .nav-link-compact.active::after {
            width: 100%;
        }
        
        /* User Profile */
        .user-profile-button {
            @apply flex items-center justify-center focus:outline-none;
            transition: all 0.2s ease;
        }
        
        .user-avatar {
            background: linear-gradient(135deg, var(--color-accent-dark), var(--color-accent));
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px rgba(236, 72, 153, 0.2);
            border: 2px solid transparent;
        }
        
        .user-profile-button:hover .user-avatar {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(236, 72, 153, 0.5);
            border-color: rgba(236, 72, 153, 0.3);
        }
        
        /* Dropdown Menu */
        .dropdown-menu {
            position: absolute;
            width: 240px;
            background-color: #1e1e1e;
            border: 1px solid rgba(236, 72, 153, 0.2);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            right: 0;
            transform-origin: top right;
            border-radius: 0.375rem;
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
            z-index: 100;
            margin-top: 8px;
            top: 100%; /* Ensure it's below the button */
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            text-decoration: none;
            color: rgba(229, 231, 235, 0.8);
        }
        
        .dropdown-item:hover {
            background-color: rgba(236, 72, 153, 0.1);
            color: white;
        }
        
        /* Mobile menu */
        .mobile-menu-button {
            display: none;
        }
        
        @media (max-width: 1023px) {
            .top-navbar {
                height: 60px;
            }
            
            .navbar-center {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: #1e1e1e;
                padding: 1rem;
                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
                z-index: 40;
            }
            
            .navbar-center.active {
                display: block;
            }
            
            .navbar-center nav {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .nav-link-compact {
                width: 100%;
                padding: 0.75rem 0;
            }
            
            .mobile-menu-button {
                display: flex;
                cursor: pointer;
                padding: 8px;
                margin-right: 16px;
                border-radius: 6px;
                transition: all 0.2s ease;
            }
            
            .mobile-menu-button:hover {
                background-color: rgba(236, 72, 153, 0.1);
            }
        }
        
        /* Animation classes */
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }
    </style>
    
    <!-- Additional Styles -->
    @stack('styles')
    
    <style>
        /* Enhanced Dashboard Styles */
        .dashboard-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        /* Welcome Panel */
        .welcome-panel {
            position: relative;
            background: linear-gradient(135deg, rgba(40, 44, 52, 0.9), rgba(23, 26, 31, 0.95));
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .welcome-panel:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to right, rgba(236, 72, 153, 0.03), rgba(244, 114, 182, 0.06));
            mask-image: radial-gradient(ellipse at 30% 50%, black 0%, transparent 70%);
            pointer-events: none;
        }
        
        .welcome-content {
            position: relative;
            z-index: 2;
        }
        
        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white;
        }
        
        .welcome-date {
            color: rgba(229, 231, 235, 0.7);
            font-size: 1rem;
        }
        
        .welcome-decoration {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 40%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .decoration-circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.2), rgba(244, 114, 182, 0.1));
            width: 15rem;
            height: 15rem;
            top: -5rem;
            right: -5rem;
            opacity: 0.6;
            filter: blur(10px);
        }
        
        .decoration-circle.secondary {
            width: 10rem;
            height: 10rem;
            top: 50%;
            right: 10%;
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.1), rgba(244, 114, 182, 0.05));
            opacity: 0.4;
        }
        
        .gradient-text {
            background: linear-gradient(to right, var(--color-accent), var(--color-accent-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }
        
        /* Stat Tiles */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-bottom: 2.5rem;
        }
        
        .stat-tile {
            position: relative;
            background: linear-gradient(145deg, rgba(30, 34, 39, 0.7), rgba(26, 30, 35, 0.9));
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .stat-tile:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(236, 72, 153, 0.3);
            border-color: rgba(236, 72, 153, 0.3);
        }
        
        .stat-icon-wrapper {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.2), rgba(236, 72, 153, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
            font-size: 1.5rem;
            color: var(--color-accent);
            box-shadow: 0 5px 15px rgba(236, 72, 153, 0.15);
        }
        
        .stat-details {
            flex-grow: 1;
        }
        
        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            display: block;
            line-height: 1.1;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.875rem;
            color: rgba(229, 231, 235, 0.7);
        }
        
        .stat-decoration {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            opacity: 0.03;
        }
        
        .decoration-shape {
            fill: var(--color-accent);
        }
        
        /* Dashboard Cards */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-bottom: 2.5rem;
        }
        
        .dashboard-card {
            background: linear-gradient(145deg, rgba(30, 34, 39, 0.7), rgba(26, 30, 35, 0.9));
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(236, 72, 153, 0.1);
            border-color: rgba(236, 72, 153, 0.2);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(23, 26, 31, 0.5);
        }
        
        .header-title {
            display: flex;
            align-items: center;
        }
        
        .header-title h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: white;
            margin: 0;
        }
        
        .header-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.2), rgba(236, 72, 153, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.875rem;
            color: var(--color-accent);
            font-size: 1.25rem;
        }
        
        .header-action {
            display: flex;
            align-items: center;
            color: var(--color-accent);
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid transparent;
        }
        
        .header-action span {
            margin-right: 0.375rem;
        }
        
        .header-action:hover {
            background: rgba(236, 72, 153, 0.1);
            border-color: rgba(236, 72, 153, 0.2);
            color: var(--color-accent-light);
        }
        
        .card-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .card-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            flex-grow: 1;
        }
        
        .list-item {
            background: rgba(39, 43, 51, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 0.75rem;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }
        
        .list-item:hover {
            background: rgba(47, 51, 61, 0.7);
            border-color: rgba(236, 72, 153, 0.2);
            transform: translateX(5px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        .item-content {
            display: flex;
            align-items: center;
        }
        
        .item-marker {
            margin-right: 0.75rem;
        }
        
        .color-dot {
            display: block;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
        
        .color-dot.default {
            background: rgba(156, 163, 175, 0.5);
        }
        
        .item-title {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
        }
        
        
        .item-actions {
            display: flex;
            align-items: center;
        }
        
        .status-indicator {
            display: flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-indicator.completed {
            background: rgba(16, 185, 129, 0.1);
            color: rgba(16, 185, 129, 0.9);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        
        .status-indicator.missed {
            background: rgba(239, 68, 68, 0.1);
            color: rgba(239, 68, 68, 0.9);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        
        .status-indicator i {
            margin-right: 0.375rem;
        }
        
        .action-button {
            display: flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            background: rgba(236, 72, 153, 0.1);
            color: var(--color-accent);
            border: 1px solid rgba(236, 72, 153, 0.2);
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .action-button:hover {
            background: var(--color-accent);
            color: white;
        }
        
        .action-button i {
            margin-right: 0.375rem;
        }
        
        /* Goal Item */
        .goal-item {
            flex-direction: column;
            align-items: stretch;
        }
        
        .goal-info {
            width: 100%;
        }
        
        .goal-header {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        
        .goal-percentage {
            margin-left: auto;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--color-accent);
        }
        
        .progress-container {
            width: 100%;
            height: 0.375rem;
            background: rgba(31, 41, 55, 0.5);
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .progress-track {
            width: 100%;
            height: 100%;
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .progress-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(90deg, var(--color-accent-dark), var(--color-accent));
            border-radius: 1rem;
            transition: width 0.5s ease;
        }
        
        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.15) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            animation: shimmer 2s infinite linear;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Review Content */
        .review-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .review-header {
            margin-bottom: 1.25rem;
        }
        
        .review-date {
            display: flex;
            align-items: center;
            color: rgba(229, 231, 235, 0.7);
            font-size: 0.875rem;
        }
        
        .review-date i {
            margin-right: 0.5rem;
            color: var(--color-accent);
        }
        
        .review-section {
            background: rgba(39, 43, 51, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .review-section-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.75rem;
        }
        
        .rating-display {
            display: flex;
            align-items: center;
        }
        
        .rating-meter {
            flex-grow: 1;
            margin-right: 1rem;
        }
        
        .rating-track {
            width: 100%;
            height: 0.375rem;
            background: rgba(31, 41, 55, 0.5);
            border-radius: 1rem;
            overflow: hidden;
            position: relative;
        }
        
        .rating-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(90deg, var(--color-accent-dark), var(--color-accent));
            border-radius: 1rem;
        }
        
        .rating-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--color-accent);
        }
        
        .rating-value span {
            font-size: 0.875rem;
            font-weight: 400;
            color: rgba(229, 231, 235, 0.7);
        }
        
        .review-text {
            font-size: 0.875rem;
            color: rgba(229, 231, 235, 0.9);
            line-height: 1.5;
        }
        
        .review-action {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            background: rgba(236, 72, 153, 0.1);
            color: var(--color-accent);
            border: 1px solid rgba(236, 72, 153, 0.2);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            text-align: center;
            margin-top: 1rem;
        }
        
        .review-action:hover {
            background: var(--color-accent);
            color: white;
        }
        
        .review-action i {
            margin-left: 0.5rem;
            transition: transform 0.2s ease;
        }
        
        .review-action:hover i {
            transform: translateX(3px);
        }
        
        /* Empty State */
        .empty-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem 1rem;
            height: 100%;
        }
        
        .empty-illustration {
            width: 4rem;
            height: 4rem;
            background: rgba(31, 41, 55, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-accent);
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }
        
        .empty-title {
            font-size: 1rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.5rem;
        }
        
        .empty-subtitle {
            font-size: 0.875rem;
            color: rgba(229, 231, 235, 0.7);
            margin-bottom: 1.5rem;
        }
        
        .empty-action {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            background: rgba(236, 72, 153, 0.1);
            color: var(--color-accent);
            border: 1px solid rgba(236, 72, 153, 0.2);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .empty-action:hover {
            background: var(--color-accent);
            color: white;
        }
        
        .empty-action i {
            margin-right: 0.5rem;
        }
        
        /* Quick Actions */
        .quick-actions-container {
            margin-bottom: 2rem;
        }
        
        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 0.75rem;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            color: var(--color-accent);
            margin-right: 0.75rem;
        }
        
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }
        
        .quick-action-card {
            background: linear-gradient(145deg, rgba(30, 34, 39, 0.7), rgba(26, 30, 35, 0.9));
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .quick-action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(236, 72, 153, 0.2);
            border-color: rgba(236, 72, 153, 0.3);
            background: linear-gradient(145deg, rgba(36, 40, 47, 0.8), rgba(30, 34, 39, 1));
        }
        
        .quick-action-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.2), rgba(236, 72, 153, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: var(--color-accent);
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }
        
        .quick-action-card:hover .quick-action-icon {
            background: var(--color-accent);
            color: white;
            transform: scale(1.1);
        }
        
        .quick-action-title {
            font-size: 0.875rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
        }
        
        /* Calendar */
        .calendar-container {
            margin-bottom: 2rem;
        }
        
        .calendar-card {
            background: linear-gradient(145deg, rgba(30, 34, 39, 0.7), rgba(26, 30, 35, 0.9));
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
        }
        
        .day-column {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .day-header {
            font-size: 0.75rem;
            font-weight: 500;
            color: rgba(229, 231, 235, 0.7);
            margin-bottom: 0.75rem;
            text-align: center;
        }
        
        .day-circle {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: rgba(39, 43, 51, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            transition: all 0.2s ease;
        }
        
        .day-circle:hover {
            background: rgba(47, 51, 61, 0.7);
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .day-circle.today {
            background: rgba(236, 72, 153, 0.15);
            border-color: rgba(236, 72, 153, 0.3);
            color: var(--color-accent);
            box-shadow: 0 0 10px rgba(236, 72, 153, 0.2);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 1920px) {
            .dashboard-container {
                max-width: 100%;
            }
        }
        
        @media (max-width: 1536px) {
            .dashboard-container {
                max-width: 100%;
            }
        }
        
        @media (max-width: 1280px) {
            .dashboard-container {
                max-width: 100%;
            }
        }
        
        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .quick-actions-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .container.mx-auto.max-w-3xl {
                max-width: 900px;
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(1, 1fr);
            }
            
            .dashboard-grid {
                grid-template-columns: repeat(1, 1fr);
            }
            
            .day-circle {
                width: 2rem;
                height: 2rem;
                font-size: 0.75rem;
            }
            
            .day-header {
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen bg-primary overflow-x-hidden w-full">
    <div class="flex min-h-screen w-full">
        <!-- Main Content -->
        <div class="w-full">
            <!-- Top Navbar -->
            <header class="top-navbar">
                <div class="navbar-container flex items-center justify-between h-full">
                    <!-- Brand/Logo on the left -->
                    <div class="navbar-left flex items-center">
                        <button class="mobile-menu-button mr-4 text-gray-300 hover:text-pink-500 lg:hidden">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <a href="{{ route('dashboard') }}" class="navbar-brand">
                        Temperance
                    </a>
                </div>
                
                    <!-- Main Navigation in the center -->
                    <div class="navbar-center">
                        <nav class="flex flex-col lg:flex-row items-center space-y-4 lg:space-y-0 lg:space-x-8">
                            <a href="{{ route('dashboard') }}" class="nav-link-compact group flex items-center text-gray-300 hover:text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-th-large text-lg"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('habits.dashboard') }}" class="nav-link-compact group flex items-center text-gray-300 hover:text-white {{ request()->routeIs('habits.*') ? 'active' : '' }}">
                                <i class="fas fa-check-circle text-lg"></i>
                                <span>Habits</span>
                            </a>
                            <a href="{{ route('goals.dashboard') }}" class="nav-link-compact group flex items-center text-gray-300 hover:text-white {{ request()->routeIs('goals.*') ? 'active' : '' }}">
                                <i class="fas fa-bullseye text-lg"></i>
                                <span>Goals</span>
                            </a>
                            <a href="{{ route('weekly-evaluations.index') }}" class="nav-link-compact group flex items-center text-gray-300 hover:text-white {{ request()->routeIs('weekly-evaluations.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-week text-lg"></i>
                                <span>Weekly</span>
                            </a>
                            <a href="{{ route('categories.index') }}" class="nav-link-compact group flex items-center text-gray-300 hover:text-white {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                <i class="fas fa-tags text-lg"></i>
                                <span>Categories</span>
                            </a>
                            <a href="{{ route('schedule-templates.index') }}" class="nav-link-compact group flex items-center text-gray-300 hover:text-white {{ request()->routeIs('schedule-templates.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-alt text-lg"></i>
                                <span>Templates</span>
                            </a>
                        </nav>
                </div>
                
                    <!-- Right section: User Profile -->
                    <div class="navbar-right">
                        <!-- User Profile -->
                        <div class="user-dropdown relative" x-data="userDropdown">
                            <button @click="toggle()" class="user-profile-button flex items-center focus:outline-none">
                                <div class="user-avatar w-10 h-10 rounded-full flex items-center justify-center text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div 
                                x-show="isOpen" 
                                @click.away="isOpen = false" 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="dropdown-menu"
                                style="display: none;">
                                <div class="px-4 py-3 border-b border-gray-700">
                                    <p class="text-sm text-gray-300">Signed in as</p>
                                    <p class="text-sm font-medium text-pink-400 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('preferences.edit') }}" class="dropdown-item flex items-center px-4 py-2 text-sm text-gray-300 hover:text-white">
                                    <i class="fas fa-user mr-3 text-gray-400"></i>
                                    Your Profile
                                </a>
                                <a href="{{ route('preferences.edit') }}" class="dropdown-item flex items-center px-4 py-2 text-sm text-gray-300 hover:text-white">
                                    <i class="fas fa-cog mr-3 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="border-t border-gray-700 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item flex w-full items-center px-4 py-2 text-sm text-red-400 hover:text-red-300">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="p-6 md:p-8 lg:p-10 w-full">
                @if (session('success'))
                    <div class="alert alert-success" role="alert" x-data="{ open: true }" x-show="open">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-green-500/20 text-green-500">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-green-400">Success</h3>
                                <p class="mt-1 text-sm text-gray-300">{{ session('success') }}</p>
                            </div>
                        </div>
                        <div class="absolute top-4 right-4">
                            <button @click="open = false" class="text-gray-400 hover:text-gray-200 focus:outline-none">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-error" role="alert" x-data="{ open: true }" x-show="open">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-red-500/20 text-red-500">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-red-400">Error</h3>
                                <p class="mt-1 text-sm text-gray-300">{{ session('error') }}</p>
                            </div>
                        </div>
                        <div class="absolute top-4 right-4">
                            <button @click="open = false" class="text-gray-400 hover:text-gray-200 focus:outline-none">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-dark-400 px-6 py-4 text-center text-sm text-gray-500 border-t border-dark-100">
                &copy; {{ date('Y') }} Temperance. All rights reserved.
            </footer>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener('Alpine:init', function() {
            // Create a store for mobile menu state
            Alpine.store('mobileMenu', {
                open: false,
                toggle() {
                    this.open = !this.open;
                }
            });
            
            // Handle user dropdown positioning
            Alpine.data('userDropdown', () => ({
                isOpen: false,
                toggle() {
                    this.isOpen = !this.isOpen;
                    
                    if (this.isOpen) {
                        // Ensure dropdown appears properly after the toggle
                        setTimeout(() => {
                            const dropdown = document.querySelector('.dropdown-menu');
                            if (dropdown) {
                                dropdown.style.display = 'block';
                                dropdown.style.position = 'absolute';
                                dropdown.style.zIndex = '999'; // Higher z-index to ensure it's on top
                            }
                        }, 10);
                    }
                }
            }));
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: true,
                duration: 800,
                easing: 'ease-out'
            });
            
            // Mobile menu toggle
            $(".mobile-menu-button").click(function() {
                $(".navbar-center").toggleClass("active");
            });
            
            // Add hover effect animation
            $(".nav-link-compact").hover(
                function() {
                    $(this).find("i").addClass("animate-pulse");
                }, 
                function() {
                    $(this).find("i").removeClass("animate-pulse");
                }
            );
            
            // Add active class toggle for demo purposes
            $(".nav-link-compact").click(function(e) {
                if (!$(this).hasClass('has-route')) {
                    e.preventDefault();
                    $(".nav-link-compact").removeClass("active");
                    $(this).addClass("active");
                }
            });
            
            // Additional handling for user dropdown to ensure it's visible
            $('.user-profile-button').click(function() {
                setTimeout(function() {
                    $('.dropdown-menu').css({
                        'display': 'block',
                        'position': 'absolute',
                        'z-index': '999',
                        'top': '100%'
                    });
                }, 20);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
