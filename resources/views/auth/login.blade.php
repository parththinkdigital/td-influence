@extends('layouts.app')

@section('title', 'Talent Sign In | Talent Marketplace')

@section('content')
    <div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50/50">
        <div class="w-full max-w-md space-y-6">
            <!-- Auth Card Component -->
            <div class="rounded-3xl border border-slate-200 bg-white text-slate-900 shadow-sm p-6 sm:p-8 space-y-6">
                <!-- Card Header -->
                <div class="flex flex-col space-y-2 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-pink-500 to-rose-600 text-white font-black text-sm flex items-center justify-center mx-auto shadow-xs">
                        <i data-lucide="sparkles" class="w-6 h-6"></i>
                    </div>
                    <h1 class="text-2xl font-black tracking-tight font-display">Talent Studio Sign In</h1>
                    <p class="text-xs text-slate-500">
                        Sign in to access your verified Media Kit, brand pitches & escrow earnings.
                    </p>
                </div>

                @if($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50/70 p-3.5 text-xs text-red-700 font-medium space-y-1">
                        @foreach($errors->all() as $error)
                            <p class="flex items-center space-x-1.5">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-red-500 shrink-0"></i>
                                <span>{{ $error }}</span>
                            </p>
                        @endforeach
                    </div>
                @endif

                @if(session('status'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50/70 p-3.5 text-xs text-emerald-800 font-medium flex items-center space-x-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Google 1-Click SSO -->
                <div>
                    <a href="{{ route('auth.google') }}" class="flex items-center justify-center space-x-2.5 w-full py-3 px-4 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-800 font-bold text-xs transition shadow-2xs">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Continue with Google</span>
                    </a>
                </div>

                <!-- Divider -->
                <div class="relative text-center my-2">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                    <span class="relative bg-white px-3 text-[11px] text-slate-400 font-bold uppercase tracking-wider">or sign in with credentials</span>
                </div>

                <!-- Standard Creator Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Email, Mobile, or @Handle</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </span>
                            <input type="text" 
                                   name="login_id" 
                                   value="{{ old('login_id') }}" 
                                   required 
                                   autofocus
                                   placeholder="creator@example.com, 9876543210, or @handle"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-3.5 py-2.5 text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-pink-600 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Password</label>
                            <a href="#" class="text-xs text-slate-500 hover:text-slate-900">Forgot?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </span>
                            <input type="password" 
                                   name="password" 
                                   required 
                                   placeholder="••••••••"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-3.5 py-2.5 text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-pink-600 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-500 pt-1">
                        <label class="flex items-center space-x-2 cursor-pointer font-medium select-none">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-pink-600 focus:ring-pink-600">
                            <span>Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-3 bg-pink-600 hover:bg-pink-700 text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-xs transition flex items-center justify-center space-x-2">
                        <span>Sign In to Creator Studio</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </form>

                <!-- Footer Card Links -->
                <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500 space-y-2.5">
                    <div>
                        <span>Don't have a Creator account?</span>
                        <a href="{{ route('register') }}" class="font-bold text-pink-600 hover:underline ml-1">
                            Join as Talent &rarr;
                        </a>
                    </div>
                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-slate-500">Are you a Brand or Client Agency?</span>
                        <a href="{{ route('brand.login') }}" class="font-bold text-indigo-600 hover:underline block mt-0.5">
                            Go to Brand Client Sign In &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
