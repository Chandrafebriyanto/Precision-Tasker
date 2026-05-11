<div class="glass-panel p-5 rounded-2xl group hover:border-outline-variant/30 transition-all duration-300 relative overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex items-start sm:items-center gap-4 relative z-10">
        <div class="w-10 h-10 rounded-xl bg-surface-container-high border border-outline-variant/20 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-primary text-[20px]">task_alt</span>
        </div>
        
        <div>
            <h3 class="text-base font-bold text-on-surface line-through opacity-70">{{ $task->title }}</h3>
            <div class="flex flex-wrap items-center gap-3 mt-1.5 text-xs">
                <div class="flex items-center gap-1 text-on-surface-variant bg-surface-container-high px-2 py-1 rounded-md border border-outline-variant/10">
                    <span class="material-symbols-outlined text-[14px]">school</span>
                    <span class="font-medium">{{ $task->course->name ?? __('app.noCourseAssigned') }}</span>
                </div>
                
                <div class="flex items-center gap-1 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[14px]">done_all</span>
                    <span>{{ __('app.completedOn') }} {{ \Carbon\Carbon::parse($task->completed_at)->format('M d, Y') }}</span>
                </div>

                @if($task->priority === 'High')
                    <div class="flex items-center gap-1 text-error px-2 py-0.5 rounded border border-error/20 bg-error/10">
                        <span class="material-symbols-outlined text-[12px]">priority_high</span>
                        <span class="text-[9px] uppercase tracking-widest font-bold">{{ __('app.highPriorityLabel') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center gap-2 relative z-10 w-full sm:w-auto justify-end border-t border-outline-variant/10 sm:border-0 pt-3 sm:pt-0">
        <form method="POST" action="{{ route('archive.restore', $task) }}" class="inline-block">
            @csrf
            <button type="submit" class="h-9 px-4 rounded-lg bg-surface-container flex items-center gap-2 text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-colors border border-outline-variant/20 text-sm font-medium">
                <span class="material-symbols-outlined text-[18px]">restore</span>
                <span class="hidden sm:inline">Restore</span>
            </button>
        </form>

        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('{{ __('app.confirmPermanentDelete') }}')" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-9 h-9 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-error/10 hover:text-error transition-colors border border-outline-variant/20">
                <span class="material-symbols-outlined text-[18px]">delete_forever</span>
            </button>
        </form>
    </div>
</div>
