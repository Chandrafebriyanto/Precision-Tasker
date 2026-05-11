@extends('layouts.auth')

@section('title', __('app.registerTitle') . ' - ' . __('app.appName'))

@section('content')
<div class="bg-background text-on-surface min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
    <!-- Ambient Background Texture -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/10 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-tertiary-container/5 rounded-full blur-[120px]"></div>
    </div>

    <!-- Register Container -->
    <main class="w-full max-w-[420px] px-6 z-10 animate-slide-up">
        <!-- Logo/Header -->
        <div class="flex flex-col items-center mb-10">
            <div class="w-12 h-12 ether-gradient rounded-lg mb-6 flex items-center justify-center shadow-2xl shadow-primary/20">
                <span class="material-symbols-outlined text-on-primary text-2xl">checklist</span>
            </div>
            <h1 class="text-3xl font-black tracking-tighter text-on-surface mb-2">{{ __('app.registerTitle') }}</h1>
            <p class="text-on-surface-variant text-sm tracking-tight text-center">
                {{ __('app.registerSubtitle') }}
            </p>
        </div>

        <!-- Glassmorphism Card -->
        <div class="glass-panel p-8 rounded-xl shadow-2xl shadow-black/60">
            @if ($errors->any())
                <div class="mb-6 px-4 py-3 rounded-lg bg-error-container/20 border border-error/20 text-error text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">error</span>
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="space-y-5" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">
                        {{ __('app.usernameLabel') }}
                    </label>
                    <input
                        class="w-full h-11 bg-surface-container-lowest border border-outline-variant/20 rounded-lg px-4 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-on-surface-variant/40"
                        placeholder="{{ __('app.usernamePlaceholder') }}"
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        autofocus
                    />
                </div>

                <div class="space-y-2">
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">
                        Email
                    </label>
                    <input
                        class="w-full h-11 bg-surface-container-lowest border border-outline-variant/20 rounded-lg px-4 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-on-surface-variant/40"
                        placeholder="{{ __('app.registerEmailPlaceholder') }}"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                    />
                </div>

                <div class="space-y-2">
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">
                        {{ __('app.passwordLabel') }}
                    </label>
                    <input
                        class="w-full h-11 bg-surface-container-lowest border border-outline-variant/20 rounded-lg px-4 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-on-surface-variant/40"
                        placeholder="{{ __('app.registerPasswordPlaceholder') }}"
                        type="password"
                        name="password"
                        required
                        minlength="6"
                    />
                </div>

                <div class="space-y-2">
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">
                        {{ __('app.studyProgramLabel') }}
                    </label>
                    <input
                        class="w-full h-11 bg-surface-container-lowest border border-outline-variant/20 rounded-lg px-4 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-on-surface-variant/40"
                        placeholder="{{ __('app.studyProgramPlaceholder') }}"
                        type="text"
                        name="study_program"
                        value="{{ old('study_program') }}"
                    />
                </div>

                <button
                    type="submit"
                    class="w-full h-11 ether-gradient text-on-primary font-bold rounded-lg text-sm mt-4 shadow-lg shadow-primary-container/20 hover:opacity-90 transition-opacity flex items-center justify-center gap-2"
                >
                    {{ __('app.createWorkspace') }}
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-outline-variant/10 flex flex-col items-center gap-4">
                <p class="text-xs text-on-surface-variant">
                    {{ __('app.alreadyHaveAccount') }}
                    <a class="text-primary font-semibold hover:underline" href="{{ route('login') }}">
                        {{ __('app.signIn') }}
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer Tagline -->
        <div class="mt-12 text-center">
            <blockquote class="italic text-on-surface-variant/40 text-sm font-light">
                {{ __('app.registerQuote') }}
            </blockquote>
        </div>
    </main>

    <!-- Support Links -->
    {{-- <footer class="fixed bottom-8 w-full flex justify-center gap-8 px-6">
        <a class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors" href="#">
            {{ __('app.systemStatus') }}
        </a>
        <a class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors" href="#">
            {{ __('app.privacy') }}
        </a>
        <a class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant hover:text-on-surface transition-colors" href="#">
            {{ __('app.terms') }}
        </a>
    </footer> --}}
</div>
@endsection
