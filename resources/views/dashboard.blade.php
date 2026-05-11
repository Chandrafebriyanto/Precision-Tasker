@extends('layouts.app')

@section('title', __('app.dashboard') . ' - ' . __('app.appName'))

@section('content')
<div class="space-y-8 pb-12">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 glass-panel p-6 sm:p-8 rounded-[2rem] relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-primary/10 rounded-full blur-[80px] -mr-10 -mt-10 pointer-events-none"></div>
        <div class="absolute left-0 bottom-0 w-48 h-48 bg-tertiary/10 rounded-full blur-[60px] -ml-10 -mb-10 pointer-events-none"></div>

        <div class="flex items-center gap-6 z-10">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-surface-container-high border border-outline-variant/30 rounded-[1.5rem] flex items-center justify-center shadow-xl shrink-0 overflow-hidden relative group">
                <span class="material-symbols-outlined text-4xl sm:text-5xl text-on-surface-variant group-hover:text-primary transition-colors duration-300">face</span>
                <div class="absolute inset-0 ether-gradient opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
            </div>
            <div>
                <p class="text-sm sm:text-base font-medium text-primary mb-1">{{ __('app.hello') }},</p>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tighter text-on-surface">
                    {{ Auth::user()->full_name ?? Auth::user()->username }}
                </h1>
                <div class="flex items-center gap-2 mt-3 bg-surface-container-high px-4 py-1.5 rounded-full w-fit border border-outline-variant/20">
                    <span class="w-2 h-2 rounded-full {{ $pendingTasks > 0 ? 'bg-primary animate-pulse' : 'bg-secondary' }}"></span>
                    <span class="text-sm font-medium text-on-surface-variant">
                        <strong class="text-on-surface">{{ $pendingTasks }}</strong> {{ __('app.tasksPending') }}
                    </span>
                </div>
            </div>
        </div>

        @if($nearestTask)
            <div class="glass-panel px-6 py-4 rounded-2xl border border-primary/20 z-10 w-full md:w-auto relative overflow-hidden group">
                <div class="absolute inset-0 ether-gradient opacity-10 group-hover:opacity-20 transition-opacity"></div>
                <p class="text-xs font-bold uppercase tracking-widest text-primary mb-1">{{ __('app.nearestDeadlineCourse') }} <span class="text-on-surface">{{ $nearestTask->course->name ?? 'Course' }}</span></p>
                <p class="text-lg font-black text-on-surface truncate max-w-[200px]">{{ $nearestTask->title }}</p>
                <div class="mt-2 flex items-center gap-2 text-sm text-on-surface-variant">
                    <span class="material-symbols-outlined text-[16px] text-error">timer</span>
                    <span>{{ \Carbon\Carbon::parse($nearestTask->deadline)->diffForHumans() }}</span>
                </div>
            </div>
        @else
            <div class="glass-panel px-6 py-4 rounded-2xl border border-secondary/20 z-10 w-full md:w-auto">
                <p class="text-sm font-bold text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">task_alt</span>
                    {{ __('app.allTasksDone') }}
                </p>
            </div>
        @endif
    </header>

    @if($totalTasks === 0)
        <!-- Empty State -->
        <div class="glass-panel rounded-3xl p-12 flex flex-col items-center justify-center text-center max-w-2xl mx-auto border border-primary/20 relative overflow-hidden animate-slide-up">
            <div class="w-24 h-24 bg-surface-container-high rounded-full flex items-center justify-center mb-6 shadow-2xl relative">
                <div class="absolute inset-0 ether-gradient rounded-full animate-spin-slow opacity-20"></div>
                <span class="material-symbols-outlined text-5xl text-primary relative z-10">emoji_events</span>
            </div>
            <h3 class="text-2xl font-black text-on-surface mb-3">{{ __('app.congratsTitle') }}</h3>
            <p class="text-on-surface-variant font-medium mb-2">{{ __('app.congratsSubtitle') }}</p>
            <p class="text-on-surface-variant/60 text-sm mb-8">{{ __('app.congratsMessage') }}</p>
            <button onclick="window.location.href='{{ route('tasks.index', ['create' => 'true']) }}'" class="h-12 px-8 ether-gradient text-on-primary font-bold rounded-xl shadow-lg shadow-primary/25 hover:shadow-primary/40 hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                <span class="material-symbols-outlined text-xl">add_task</span>
                {{ __('app.createNewTask') }}
            </button>
        </div>
    @else
        <!-- Progress and Countdown Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 stagger-children">
            <!-- Progress Card -->
            <div class="glass-panel p-6 sm:p-8 rounded-[2rem] flex flex-col sm:flex-row items-center gap-8 relative overflow-hidden group hover:border-primary/30 transition-colors">
                <!-- SVG Progress Circle -->
                <div class="relative w-36 h-36 shrink-0">
                    <svg class="w-full h-full -rotate-90 transform" viewBox="0 0 100 100">
                        <circle class="text-surface-container-highest stroke-current" stroke-width="8" cx="50" cy="50" r="40" fill="transparent"></circle>
                        <circle class="text-primary stroke-current transition-all duration-1000 ease-out" 
                                stroke-width="8" 
                                stroke-linecap="round" 
                                cx="50" cy="50" r="40" 
                                fill="transparent" 
                                stroke-dasharray="251.2" 
                                stroke-dashoffset="{{ 251.2 - (251.2 * $progress) / 100 }}">
                        </circle>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-black text-on-surface">{{ $progress }}%</span>
                    </div>
                </div>

                <div class="flex-1 w-full text-center sm:text-left">
                    <h2 class="text-lg font-bold text-on-surface mb-1">{{ __('app.taskProgress') }}</h2>
                    <p class="text-sm text-on-surface-variant mb-6">{{ __('app.complete') }} {{ $completedTasks }} {{ __('app.ofDone') }} {{ $totalTasks }}</p>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-surface-container-high rounded-2xl p-4 border border-outline-variant/10">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-3 h-3 rounded-full bg-primary"></span>
                                <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">{{ __('app.done') }}</span>
                            </div>
                            <p class="text-2xl font-black text-on-surface">{{ $completedTasks }}</p>
                        </div>
                        <div class="bg-surface-container-high rounded-2xl p-4 border border-outline-variant/10">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-3 h-3 rounded-full bg-surface-container-highest border border-outline-variant/30"></span>
                                <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">{{ __('app.pending') }}</span>
                            </div>
                            <p class="text-2xl font-black text-on-surface">{{ $pendingTasks }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Countdown Card -->
            <div class="glass-panel p-6 sm:p-8 rounded-[2rem] relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-error/10 rounded-full blur-[50px] -mr-10 -mt-10"></div>
                
                <div class="flex justify-between items-center mb-8 relative z-10">
                    <h2 class="text-lg font-bold text-on-surface">{{ __('app.nextDeadline') }}</h2>
                    <div class="w-10 h-10 rounded-full bg-error-container/30 flex items-center justify-center text-error">
                        <span class="material-symbols-outlined">timer</span>
                    </div>
                </div>

                @if($nearestTask)
                    <div class="mb-8 relative z-10">
                        <p class="text-xl sm:text-2xl font-black text-on-surface mb-2 truncate" title="{{ $nearestTask->title }}">
                            {{ $nearestTask->title }}
                        </p>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-on-surface-variant">school</span>
                            <span class="text-sm text-on-surface-variant font-medium">
                                {{ $nearestTask->course->name ?? __('app.noCourseAssigned') }}
                            </span>
                        </div>
                    </div>

                    <!-- Alpine Countdown -->
                    <div x-data="countdown('{{ $nearestTask->deadline }}')" class="grid grid-cols-4 gap-2 sm:gap-4 relative z-10">
                        <template x-for="(unit, index) in units" :key="index">
                            <div class="flex flex-col items-center justify-center bg-surface-container-high border border-outline-variant/20 rounded-2xl py-3 sm:py-4">
                                <span class="text-2xl sm:text-3xl font-black text-on-surface font-mono" x-text="unit.value"></span>
                                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-widest text-on-surface-variant mt-1" x-text="unit.label"></span>
                            </div>
                        </template>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-[160px] text-center relative z-10">
                        <span class="material-symbols-outlined text-4xl text-primary mb-3">celebration</span>
                        <p class="text-lg font-bold text-on-surface mb-1">{{ __('app.allCaughtUp') }}</p>
                        <p class="text-sm text-on-surface-variant">{{ __('app.noPendingDeadlines') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 stagger-children mt-6">
            <!-- Left Column: Courses -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Course Overview -->
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-on-surface">{{ __('app.courseOverview') }}</h2>
                        <a href="{{ route('courses.index') }}" class="text-sm font-bold text-primary hover:text-primary-dim transition-colors flex items-center gap-1">
                            {{ __('app.viewList') }}
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                    
                    @if($courses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($topCourses as $course)
                                @php
                                    $cTasks = $course->tasks()->get();
                                    $cTotal = $cTasks->count();
                                    $cCompleted = $cTasks->where('status_task', 'Completed')->count();
                                    $cProgress = $cTotal > 0 ? round(($cCompleted / $cTotal) * 100) : 0;
                                @endphp
                                <div class="glass-panel p-5 rounded-2xl group hover:border-primary/30 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="relative z-10 flex flex-col h-full">
                                        <div class="w-12 h-12 rounded-xl ether-gradient flex items-center justify-center mb-4 shadow-lg shadow-primary/20">
                                            <span class="material-symbols-outlined text-on-primary">{{ $course->icon_string ?? 'school' }}</span>
                                        </div>
                                        <h3 class="font-bold text-on-surface mb-1 truncate" title="{{ $course->name }}">{{ $course->name }}</h3>
                                        @if($course->code)
                                            <p class="text-xs text-on-surface-variant font-medium mb-4">{{ $course->code }}</p>
                                        @else
                                            <div class="h-4 mb-4"></div>
                                        @endif
                                        <div class="mt-auto">
                                            <div class="flex justify-between text-xs font-bold mb-2">
                                                <span class="text-on-surface-variant uppercase tracking-wider">{{ __('app.tasks') }}</span>
                                                <span class="text-primary">{{ $cProgress }}%</span>
                                            </div>
                                            <div class="h-1.5 w-full bg-surface-container-highest rounded-full overflow-hidden">
                                                <div class="h-full bg-primary transition-all duration-1000 ease-out" style="width: {{ $cProgress }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="glass-panel rounded-2xl p-8 text-center border border-dashed border-outline-variant/30">
                            <span class="material-symbols-outlined text-3xl text-on-surface-variant mb-2">folder_off</span>
                            <p class="text-on-surface-variant text-sm">{{ __('app.noCoursesYet') }}</p>
                        </div>
                    @endif
                </section>

                <!-- Weekly Productivity Chart -->
                <section>
                    <h2 class="text-xl font-bold text-on-surface mb-4">{{ __('app.weeklyProductivity') }}</h2>
                    <div class="glass-panel p-6 rounded-[2rem] h-[300px]">
                        <canvas id="productivityChart"></canvas>
                    </div>
                </section>
            </div>

            <!-- Right Column: High Priority -->
            <div class="space-y-6">
                <section class="h-full flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-on-surface flex items-center gap-2">
                            {{ __('app.attentionRequired') }}
                            <span class="w-2 h-2 rounded-full bg-error animate-pulse"></span>
                        </h2>
                    </div>

                    <div class="glass-panel rounded-[2rem] p-2 flex-1 flex flex-col relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-b from-error/5 to-transparent pointer-events-none"></div>
                        
                        @if($highPriorityTasks->count() > 0)
                            <div class="flex flex-col gap-1 z-10">
                                @foreach($highPriorityTasks as $task)
                                    <div class="p-4 rounded-xl hover:bg-surface-container-high transition-colors group cursor-pointer border border-transparent hover:border-outline-variant/20">
                                        <div class="flex items-start justify-between gap-4 mb-2">
                                            <h4 class="font-bold text-on-surface text-sm line-clamp-2 group-hover:text-primary transition-colors">{{ $task->title }}</h4>
                                            <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest bg-error-container/30 text-error whitespace-nowrap">
                                                {{ __('app.highPriority') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between mt-3">
                                            <div class="flex items-center gap-1.5 text-xs text-on-surface-variant">
                                                <span class="material-symbols-outlined text-[14px]">school</span>
                                                <span class="truncate max-w-[120px]">{{ $task->course->name ?? __('app.noCourseAssigned') }}</span>
                                            </div>
                                            @if($task->deadline)
                                                <div class="flex items-center gap-1.5 text-xs font-medium {{ \Carbon\Carbon::parse($task->deadline)->isPast() ? 'text-error' : 'text-primary' }}">
                                                    <span class="material-symbols-outlined text-[14px]">event</span>
                                                    <span>{{ \Carbon\Carbon::parse($task->deadline)->format('M d') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex-1 flex flex-col items-center justify-center text-center p-6 z-10">
                                <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-3xl text-on-surface-variant">task_alt</span>
                                </div>
                                <p class="text-on-surface-variant font-medium">{{ __('app.noHighPriorityTasks') }}</p>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    @endif
</div>

<!-- Alpine Script for Countdown -->
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('countdown', (deadlineStr) => ({
        deadline: new Date(deadlineStr).getTime(),
        now: new Date().getTime(),
        units: [
            { label: '{{ __("app.days") }}', value: '00' },
            { label: '{{ __("app.hours") }}', value: '00' },
            { label: '{{ __("app.minutes") }}', value: '00' },
            { label: '{{ __("app.seconds") }}', value: '00' }
        ],
        interval: null,

        init() {
            this.update();
            this.interval = setInterval(() => this.update(), 1000);
        },

        update() {
            this.now = new Date().getTime();
            const distance = this.deadline - this.now;

            if (distance < 0) {
                clearInterval(this.interval);
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            this.units[0].value = days.toString().padStart(2, '0');
            this.units[1].value = hours.toString().padStart(2, '0');
            this.units[2].value = minutes.toString().padStart(2, '0');
            this.units[3].value = seconds.toString().padStart(2, '0');
        }
    }));
});
</script>

<!-- Chart.js Setup -->
@if($totalTasks > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('productivityChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($weeklyData['labels']) !!},
                datasets: [
                    {
                        label: '{{ __("app.tasksDone") }}',
                        data: {!! json_encode($weeklyData['completed']) !!},
                        backgroundColor: '#bdc2ff', // primary
                        borderRadius: 6,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    },
                    {
                        label: '{{ __("app.tasksCreated") }}',
                        data: {!! json_encode($weeklyData['created']) !!},
                        backgroundColor: '#2e3aa2', // primary-container
                        borderRadius: 6,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#acabaa', // on-surface-variant
                            font: { family: 'Inter', size: 12, weight: 600 },
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2020',
                        titleColor: '#e7e5e4',
                        bodyColor: '#acabaa',
                        borderColor: '#484848',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        boxPadding: 4
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#acabaa',
                            font: { family: 'Inter', size: 11, weight: 500 }
                        },
                        border: { display: false }
                    },
                    y: {
                        grid: {
                            color: 'rgba(72, 72, 72, 0.1)', // outline-variant
                            drawBorder: false,
                        },
                        ticks: {
                            color: '#acabaa',
                            font: { family: 'Inter', size: 11 },
                            stepSize: 1,
                            precision: 0
                        },
                        border: { display: false },
                        beginAtZero: true
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    }
});
</script>
@endif
@endsection
