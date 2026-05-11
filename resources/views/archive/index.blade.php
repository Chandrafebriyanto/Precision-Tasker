@extends('layouts.app')

@section('title', __('app.archive') . ' - ' . __('app.appName'))

@section('content')
<div class="space-y-8 pb-12 relative">
    <!-- Header -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 glass-panel p-6 sm:p-8 rounded-[2rem] relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-primary/10 rounded-full blur-[80px] -mr-10 -mt-10 pointer-events-none"></div>
        <div class="absolute left-0 bottom-0 w-48 h-48 bg-secondary/10 rounded-full blur-[60px] -ml-10 -mb-10 pointer-events-none"></div>

        <div class="flex items-center gap-6 z-10">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-surface-container-high border border-outline-variant/30 rounded-[1.5rem] flex items-center justify-center shadow-xl shrink-0">
                <span class="material-symbols-outlined text-4xl sm:text-5xl text-on-surface-variant">inventory_2</span>
            </div>
            <div>
                <p class="text-sm sm:text-base font-medium text-primary mb-1 uppercase tracking-widest">{{ __('app.historyManagement') }}</p>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tighter text-on-surface mb-2">{{ __('app.archiveTitle') }}</h1>
                <p class="text-sm sm:text-base text-on-surface-variant max-w-xl leading-relaxed">
                    {{ __('app.archiveSubtitle') }}
                </p>
            </div>
        </div>
    </header>

    @if(session('error'))
        <div class="glass-panel px-6 py-4 rounded-xl border border-error/20 bg-error-container/10 text-error flex items-center gap-3 animate-fade-in">
            <span class="material-symbols-outlined">error</span>
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Archive List -->
        <div class="lg:col-span-2 space-y-8">
            @if($tasks->count() > 0)
                
                @if(count($recentlyCompleted) > 0)
                    <section class="animate-slide-up" style="animation-delay: 0.1s;">
                        <h2 class="text-xl font-bold text-on-surface mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">history</span>
                            {{ __('app.recentlyCompleted') }}
                        </h2>
                        <div class="space-y-4">
                            @foreach($recentlyCompleted as $task)
                                @include('archive._task-card', ['task' => $task])
                            @endforeach
                        </div>
                    </section>
                @endif

                @if(count($lastMonth) > 0)
                    <section class="animate-slide-up" style="animation-delay: 0.2s;">
                        <h2 class="text-xl font-bold text-on-surface mb-4 flex items-center gap-2 mt-8">
                            <span class="material-symbols-outlined text-on-surface-variant">calendar_month</span>
                            {{ __('app.lastMonth') }}
                        </h2>
                        <div class="space-y-4">
                            @foreach($lastMonth as $task)
                                @include('archive._task-card', ['task' => $task])
                            @endforeach
                        </div>
                    </section>
                @endif

                @if(count($older) > 0)
                    <section class="animate-slide-up" style="animation-delay: 0.3s;">
                        <h2 class="text-xl font-bold text-on-surface mb-4 flex items-center gap-2 mt-8">
                            <span class="material-symbols-outlined text-on-surface-variant">inventory</span>
                            {{ __('app.older') }}
                        </h2>
                        <div class="space-y-4">
                            @foreach($older as $task)
                                @include('archive._task-card', ['task' => $task])
                            @endforeach
                        </div>
                    </section>
                @endif

            @else
                <!-- Empty State -->
                <div class="glass-panel rounded-[2rem] p-12 flex flex-col items-center justify-center text-center border border-dashed border-outline-variant/30 animate-slide-up">
                    <div class="w-20 h-20 bg-surface-container-high rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant opacity-50">inbox</span>
                    </div>
                    <h3 class="text-2xl font-black text-on-surface mb-2">{{ __('app.archiveEmpty') }}</h3>
                    <p class="text-on-surface-variant">{{ __('app.archiveEmptySubtitle') }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar Stats -->
        <div class="space-y-6">
            <!-- Summary Card -->
            <div class="glass-panel p-6 rounded-3xl animate-slide-in-right" style="animation-delay: 0.2s;">
                <h3 class="text-lg font-bold text-on-surface mb-6">{{ __('app.totalCompleted') }}</h3>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-3xl">task_alt</span>
                    </div>
                    <div>
                        <p class="text-4xl font-black text-on-surface">{{ $tasks->count() }}</p>
                        <p class="text-xs text-on-surface-variant uppercase tracking-widest font-bold mt-1">{{ __('app.tasksArchivedTotal') }}</p>
                    </div>
                </div>
            </div>

            <!-- Course Breakdown -->
            <div class="glass-panel p-6 rounded-3xl animate-slide-in-right" style="animation-delay: 0.3s;">
                <h3 class="text-lg font-bold text-on-surface mb-6">{{ __('app.courseBreakdown') }}</h3>
                
                @if(count($courseStats) > 0)
                    <div class="space-y-4">
                        @foreach($courseStats as $courseName => $count)
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-2">
                                    <span class="text-on-surface">{{ $courseName }}</span>
                                    <span class="text-on-surface-variant">{{ $count }}</span>
                                </div>
                                <div class="h-2 w-full bg-surface-container-highest rounded-full overflow-hidden">
                                    <div class="h-full bg-primary" style="width: {{ ($count / max(1, $tasks->count())) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-on-surface-variant text-sm">
                        {{ __('app.noDataYet') }}
                    </div>
                @endif
            </div>

            <!-- Info Card -->
            <div class="bg-surface-container-high border border-outline-variant/20 rounded-3xl p-6 relative overflow-hidden animate-slide-in-right" style="animation-delay: 0.4s;">
                <div class="absolute -right-6 -top-6 text-on-surface-variant/5">
                    <span class="material-symbols-outlined text-9xl">info</span>
                </div>
                <h3 class="text-sm font-bold text-on-surface mb-2 relative z-10 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">policy</span>
                    {{ __('app.storagePolicy') }}
                </h3>
                <p class="text-xs text-on-surface-variant leading-relaxed relative z-10">
                    {{ __('app.storagePolicyText') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
