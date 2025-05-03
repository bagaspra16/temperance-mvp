<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Temperance') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif']
                        },
                        colors: {
                            primary: '#0f0f13',
                            secondary: '#121218',
                            accent: '#ff4d8d',
                            'accent-dark': '#e6326c',
                            'accent-light': '#ff80aa',
                            dark: {
                                100: '#2a2a35',
                                200: '#232330',
                                300: '#1c1c25',
                                400: '#16161d',
                                500: '#0f0f13'
                            }
                        }
                    }
                }
            }
        </script>
        
        <!-- Custom styles section -->
            <style>
            /* Custom animation */
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
                100% { transform: translateY(0px); }
            }
            
            .floating {
                animation: float 4s ease-in-out infinite;
            }
            
            /* Gradient text */
            .gradient-text {
                background: linear-gradient(to right, #ff4d8d, #ff80aa);
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            
            /* Custom button styles */
            .btn {
                @apply px-6 py-3 rounded-md font-medium transition-all duration-300 inline-flex items-center;
            }
            
            .btn-primary {
                @apply bg-accent text-white hover:bg-accent-dark shadow-lg hover:shadow-xl hover:shadow-accent/20 shadow-accent/10;
            }
            
            .btn-secondary {
                @apply bg-dark-300 text-white hover:bg-dark-200 border border-dark-100 shadow-lg hover:shadow-xl;
            }
            
            .btn-outline {
                @apply border border-accent/50 text-accent hover:bg-accent/10 transition-all duration-300;
            }
            
            /* Card styles */
            .glass-card {
                @apply backdrop-blur-md bg-white/5 border border-white/10 rounded-2xl shadow-xl;
            }
            </style>
    </head>
    
    <body class="antialiased bg-primary text-gray-200 min-h-screen flex flex-col">
        <header class="w-full max-w-7xl mx-auto px-6 py-8">
            @if (Route::has('login'))
                <nav class="flex justify-end space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-outline px-5 py-2 rounded-md">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-accent transition-colors duration-300">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-outline px-5 py-2 rounded-md">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        
        <main class="flex-grow flex items-center justify-center p-6">
            <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center gap-12">
                <!-- Left content -->
                <div class="lg:w-1/2 space-y-8">
                    <div class="space-y-4">
                        <div class="inline-block bg-accent/20 text-accent rounded-full px-4 py-2 text-sm font-medium">
                            Self-Improvement App
                        </div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold">
                            <span class="gradient-text">Temperance</span>
                            <span class="block mt-2">Track Your Progress</span>
                        </h1>
                        <p class="text-lg text-gray-400 max-w-lg">
                            Grow better habits, achieve your goals, and improve yourself with our comprehensive tracking and analytics.
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Get Started
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                        <a href="#features" class="btn btn-secondary">
                            Learn More
                        </a>
                    </div>
                    
                    <div class="pt-6">
                        <div class="text-sm text-gray-500">Trusted by self-improvers everywhere</div>
                        <div class="flex items-center gap-6 mt-4">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-dark-100 flex items-center justify-center text-xs">JS</div>
                                <div class="w-8 h-8 rounded-full bg-dark-100 flex items-center justify-center text-xs">KL</div>
                                <div class="w-8 h-8 rounded-full bg-dark-100 flex items-center justify-center text-xs">MA</div>
                                <div class="w-8 h-8 rounded-full bg-dark-100 flex items-center justify-center text-xs">+2</div>
                            </div>
                            <div class="text-gray-400 text-sm">
                                <span class="text-white font-semibold">500+</span> users improving daily
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right hero image -->
                <div class="lg:w-1/2 floating">
                    <div class="relative">
                        <!-- Primary image -->
                        <div class="glass-card p-4 shadow-2xl shadow-accent/10">
                            <img src="https://placehold.co/600x400/121218/ff4d8d?text=Temperance+Dashboard" alt="Temperance Dashboard" class="rounded-lg w-full h-auto"/>
                        </div>
                        
                        <!-- Decorative elements -->
                        <div class="absolute -top-6 -right-6 w-24 h-24 bg-accent/20 rounded-full blur-xl"></div>
                        <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-accent/10 rounded-full blur-xl"></div>
                        
                        <!-- Feature highlights -->
                        <div class="absolute -bottom-4 -right-4 glass-card p-3 shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-accent/20 flex items-center justify-center text-accent">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium">Weekly Growth</div>
                                    <div class="text-accent text-sm">+15%</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="absolute -top-4 -left-4 glass-card p-3 shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-accent/20 flex items-center justify-center text-accent">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium">Habits Tracked</div>
                                    <div class="text-accent text-sm">124 days</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </main>
        
        <!-- Features section -->
        <section id="features" class="py-20 bg-secondary">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold">Features Designed For Your Growth</h2>
                    <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
                        Temperance offers a complete toolkit to help you develop better habits, achieve your goals, and track your progress.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="glass-card p-6 rounded-xl">
                        <div class="w-12 h-12 rounded-lg bg-accent/20 flex items-center justify-center text-accent mb-4">
                            <i class="bi bi-calendar-check text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Habit Tracking</h3>
                        <p class="text-gray-400">
                            Create and track daily habits with streaks, reminders, and detailed analytics.
                        </p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="glass-card p-6 rounded-xl">
                        <div class="w-12 h-12 rounded-lg bg-accent/20 flex items-center justify-center text-accent mb-4">
                            <i class="bi bi-trophy text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Goal Setting</h3>
                        <p class="text-gray-400">
                            Set SMART goals with milestones and track your progress towards achieving them.
                        </p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="glass-card p-6 rounded-xl">
                        <div class="w-12 h-12 rounded-lg bg-accent/20 flex items-center justify-center text-accent mb-4">
                            <i class="bi bi-graph-up-arrow text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Detailed Analytics</h3>
                        <p class="text-gray-400">
                            Visualize your progress with beautiful charts and insightful statistics.
                        </p>
                    </div>
                    
                    <!-- Feature 4 -->
                    <div class="glass-card p-6 rounded-xl">
                        <div class="w-12 h-12 rounded-lg bg-accent/20 flex items-center justify-center text-accent mb-4">
                            <i class="bi bi-clock-history text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Weekly Reviews</h3>
                        <p class="text-gray-400">
                            Reflect on your week with guided reviews to optimize your personal development.
                        </p>
                    </div>
                    
                    <!-- Feature 5 -->
                    <div class="glass-card p-6 rounded-xl">
                        <div class="w-12 h-12 rounded-lg bg-accent/20 flex items-center justify-center text-accent mb-4">
                            <i class="bi bi-bell text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Smart Reminders</h3>
                        <p class="text-gray-400">
                            Never miss a habit with customizable reminders and notifications.
                        </p>
                    </div>
                    
                    <!-- Feature 6 -->
                    <div class="glass-card p-6 rounded-xl">
                        <div class="w-12 h-12 rounded-lg bg-accent/20 flex items-center justify-center text-accent mb-4">
                            <i class="bi bi-shield-check text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Privacy Focused</h3>
                        <p class="text-gray-400">
                            Your data stays private and secure, giving you peace of mind.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <footer class="bg-dark-400 py-12">
            <div class="max-w-6xl mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-8 md:mb-0">
                        <div class="text-2xl font-bold text-accent">Temperance</div>
                        <p class="text-gray-400 mt-2">Your personal growth companion</p>
                    </div>
                    
                    <div class="flex flex-wrap gap-8">
                        <div>
                            <div class="text-white font-medium mb-3">Product</div>
                            <ul class="space-y-2 text-gray-400">
                                <li><a href="#" class="hover:text-accent transition-colors">Features</a></li>
                                <li><a href="#" class="hover:text-accent transition-colors">Pricing</a></li>
                                <li><a href="#" class="hover:text-accent transition-colors">FAQ</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <div class="text-white font-medium mb-3">Company</div>
                            <ul class="space-y-2 text-gray-400">
                                <li><a href="#" class="hover:text-accent transition-colors">About</a></li>
                                <li><a href="#" class="hover:text-accent transition-colors">Blog</a></li>
                                <li><a href="#" class="hover:text-accent transition-colors">Contact</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <div class="text-white font-medium mb-3">Legal</div>
                            <ul class="space-y-2 text-gray-400">
                                <li><a href="#" class="hover:text-accent transition-colors">Privacy</a></li>
                                <li><a href="#" class="hover:text-accent transition-colors">Terms</a></li>
                                <li><a href="#" class="hover:text-accent transition-colors">Cookie Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-dark-100 mt-12 pt-8 flex flex-col-reverse md:flex-row justify-between items-center">
                    <div class="text-gray-500 text-sm mt-6 md:mt-0">
                        &copy; {{ date('Y') }} Temperance. All rights reserved.
        </div>

                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-accent transition-colors">
                            <i class="bi bi-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-accent transition-colors">
                            <i class="bi bi-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-accent transition-colors">
                            <i class="bi bi-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-accent transition-colors">
                            <i class="bi bi-github text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
