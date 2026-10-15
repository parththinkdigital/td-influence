@extends('layouts.app')

@section('title', 'Brand Client Sign In | Talent Marketplace')

@section('content')
    <div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50/50">
        <div class="w-full max-w-sm space-y-6">
            <!-- shadcn Card Component -->
            <div class="rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xs p-6 sm:p-8 space-y-6">
                <!-- Card Header -->
                <div class="flex flex-col space-y-2 text-center">
                    <div class="w-10 h-10 rounded-lg bg-indigo-600 text-white font-black text-sm flex items-center justify-center mx-auto shadow-xs">
                        <i data-lucide="building-2" class="w-5 h-5"></i>
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight font-display">Brand Studio Sign In</h1>
                    <p class="text-xs text-slate-500">
                        Access campaign briefs, review creator pitches & manage milestone escrow contracts.
                    </p>
                </div>

                @if($errors->any())
                    <div class="rounded-lg border border-red-200 bg-red-50/50 p-3 text-xs text-red-700 font-medium space-y-1">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('brand.login') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold uppercase tracking-wider text-slate-700">Issued Brand Email</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               placeholder="company@brand.com"
                               class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-2xs transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-indigo-600">
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-semibold uppercase tracking-wider text-slate-700">Password</label>
                        </div>
                        <input type="password" 
                               name="password" 
                               required 
                               placeholder="••••••••"
                               class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-2xs transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-indigo-600">
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-500 pt-1">
                        <label class="flex items-center space-x-2 cursor-pointer font-medium">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                            <span>Remember company</span>
                        </label>
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 w-full bg-indigo-600 text-white hover:bg-indigo-700 h-9 px-4 py-2 shadow-xs">
                        Sign In to Brand Studio
                    </button>
                </form>

                <!-- Footer Card Links -->
                <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500 space-y-1.5">
                    <p>Are you an Influencer, Model or UGC Creator?</p>
                    <a href="{{ route('login') }}" class="font-semibold text-pink-600 hover:underline inline-block">
                        Switch to Talent Sign In &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
