<header class="h-20 glass-nav border-b border-outline-variant/20 flex items-center justify-between px-8 z-10 sticky top-0 animate-fade-in">
    <div>
        <h2 class="text-on-surface font-bold text-lg tracking-tight">{{ __('app.workspace') }}</h2>
        <p class="text-xs text-on-surface-variant font-medium">{{ date('l, d F Y') }}</p>
    </div>

    <div class="flex items-center gap-4">
        <!-- Language Switcher -->
        <div class="relative" x-data="{ open: false }">
            <button 
                @click="open = !open"
                @click.away="open = false"
                class="h-10 px-4 rounded-xl bg-surface-container border border-outline-variant/20 flex items-center gap-2 hover:bg-surface-container-high transition-colors"
            >
                <span class="material-symbols-outlined text-[18px] text-on-surface-variant">language</span>
                <span class="text-sm font-bold text-on-surface uppercase">{{ app()->getLocale() }}</span>
                <span class="material-symbols-outlined text-[18px] text-on-surface-variant transition-transform" :class="{'rotate-180': open}">expand_more</span>
            </button>

            <!-- Dropdown -->
            <div 
                x-show="open" 
                x-transition.opacity.duration.200ms
                class="absolute right-0 mt-2 w-32 bg-surface-container-high border border-outline-variant/30 rounded-xl shadow-xl overflow-hidden z-50"
                style="display: none;"
            >
                <a href="{{ route('lang.switch', 'en') }}" class="w-full px-4 py-3 flex items-center gap-3 hover:bg-primary/10 transition-colors {{ app()->getLocale() === 'en' ? 'text-primary' : 'text-on-surface' }}">
                    <span class="text-sm font-medium">English</span>
                    @if(app()->getLocale() === 'en')
                        <span class="material-symbols-outlined text-[16px] ml-auto">check</span>
                    @endif
                </a>
                <a href="{{ route('lang.switch', 'id') }}" class="w-full px-4 py-3 flex items-center gap-3 hover:bg-primary/10 transition-colors {{ app()->getLocale() === 'id' ? 'text-primary' : 'text-on-surface' }}">
                    <span class="text-sm font-medium">Indonesia</span>
                    @if(app()->getLocale() === 'id')
                        <span class="material-symbols-outlined text-[16px] ml-auto">check</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button 
                @click="open = !open"
                @click.away="open = false"
                class="w-10 h-10 rounded-xl bg-surface-container border border-outline-variant/20 flex items-center justify-center hover:bg-surface-container-high transition-colors"
            >
                <span class="material-symbols-outlined text-on-surface">person</span>
            </button>

            <!-- Dropdown Menu -->
            <div 
                x-show="open"
                x-transition.opacity.duration.200ms
                class="absolute right-0 mt-2 w-48 bg-surface-container-high border border-outline-variant/30 rounded-xl shadow-xl overflow-hidden z-50 p-1"
                style="display: none;"
            >
                <div class="px-3 py-2 border-b border-outline-variant/20 mb-1">
                    <p class="text-sm font-bold text-on-surface truncate">{{ Auth::user()->full_name ?? Auth::user()->username }}</p>
                    <p class="text-xs text-on-surface-variant truncate">{{ Auth::user()->email }}</p>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-3 py-2 flex items-center gap-2 hover:bg-error/10 text-error rounded-lg transition-colors text-sm font-medium">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                        {{ __('app.signOut') }}
                    </button>
                </form>
            </div>
        </div>
        
        <button onclick="enableNotifications()" class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg transition">
            <span class="material-symbols-outlined text-xl">notifications_active</span>
            <span class="hidden md:inline text-sm font-medium">Aktifkan Notifikasi</span>
        </button>
    </div>
</header>
