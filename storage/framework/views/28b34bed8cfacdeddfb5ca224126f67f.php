<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Tour calendar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tour calendar']); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('admin.tours.index', ['month' => $month->copy()->subMonth()->format('Y-m'), 'day' => $day->toDateString()])); ?>" class="a-btn a-btn-ghost w-11 px-0" aria-label="Previous month"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'chevron-left','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chevron-left','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a>
        <a href="<?php echo e(route('admin.tours.index')); ?>" class="a-btn a-btn-ghost">Today</a>
        <a href="<?php echo e(route('admin.tours.index', ['month' => $month->copy()->addMonth()->format('Y-m'), 'day' => $day->toDateString()])); ?>" class="a-btn a-btn-ghost w-11 px-0" aria-label="Next month"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'chevron-right','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chevron-right','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a>
        <button type="button" onclick="window.print()" class="a-btn a-btn-ghost no-print"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'printer','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'printer','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Print day sheet</button>
     <?php $__env->endSlot(); ?>

    <div class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
        <section class="a-card min-w-0 p-3 sm:p-5 no-print" aria-labelledby="month-title">
            <div class="flex flex-wrap items-baseline justify-between gap-2">
                <h2 id="month-title" class="text-lg font-semibold"><?php echo e($month->format('F Y')); ?></h2>
                <p class="text-sm text-ink-3"><?php echo e($capacity); ?> guests a tour <?php if(auth()->user()->isAdmin()): ?>· change in <a href="<?php echo e(route('admin.settings.edit')); ?>" class="underline">Settings</a><?php endif; ?></p>
            </div>
            <table class="mt-4 w-full table-fixed border-separate border-spacing-0.5 text-sm sm:border-spacing-1">
                <thead><tr><?php $__currentLoopData = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><th class="pb-1 text-left text-xs font-semibold uppercase tracking-wide text-ink-3" scope="col"><span class="sm:hidden"><?php echo e(substr($w, 0, 1)); ?></span><span class="hidden sm:inline"><?php echo e($w); ?></span></th><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tr></thead>
                <tbody>
                    <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <?php $__currentLoopData = $week; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cell): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $inMonth = $cell['date']->month === $month->month;
                                    $selected = $cell['date']->isSameDay($day);
                                    $full = $cell['places'] > 0 && $cell['guests'] >= $cell['places'];
                                ?>
                                <td class="align-top">
                                    <a href="<?php echo e(route('admin.tours.index', ['month' => $month->format('Y-m'), 'day' => $cell['date']->toDateString()])); ?>"
                                        class="<?php echo \Illuminate\Support\Arr::toCssClasses(['cal-day block min-h-11 overflow-hidden rounded-md border p-1 hover:bg-surface-2 sm:p-2', 'border-ink ring-1 ring-ink' => $selected, 'border-line' => ! $selected, 'opacity-50' => ! $inMonth, 'bg-surface-2/60' => ! $cell['open']]); ?>"
                                        aria-label="<?php echo e($cell['date']->format('l j F')); ?>: <?php echo e($cell['open'] ? $cell['guests'].' of '.$cell['places'].' places booked' : 'no tours'); ?>" <?php if($selected): ?> aria-current="date" <?php endif; ?>>
                                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['num font-semibold', 'rounded-full bg-accent px-1.5 text-accent-ink' => $cell['date']->isToday()]); ?>"><?php echo e($cell['date']->day); ?></span>
                                        <?php if($cell['open']): ?>
                                            <span class="mt-2 block text-xs num <?php echo e($full ? 'font-bold text-accent-text' : 'text-ink-3'); ?>"><?php echo e($cell['guests']); ?><span class="hidden sm:inline">/<?php echo e($cell['places']); ?></span></span>
                                            <span class="cal-meter mt-1 block" data-full="<?php echo e($full ? 'true' : 'false'); ?>"><span style="width: <?php echo e(min(100, $cell['guests'] / max(1, $cell['places']) * 100)); ?>%"></span></span>
                                        <?php else: ?>
                                            <span class="mt-2 block text-xs text-ink-3"><span class="sm:hidden" aria-hidden="true">–</span><span class="hidden sm:inline">No tours</span></span>
                                        <?php endif; ?>
                                    </a>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </section>

        <section class="a-card min-w-0" aria-labelledby="day-title">
            <div class="p-5 pb-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-ink-3">Day sheet</p>
                <h2 id="day-title" class="text-lg font-semibold"><?php echo e($day->format('l j F Y')); ?></h2>
                <p class="text-sm text-ink-3 num"><?php echo e($sheet->sum('guests')); ?> guests booked<?php echo e($sheet->isNotEmpty() ? ' across '.$sheet->count().' '.\Illuminate\Support\Str::plural('tour', $sheet->count()) : ''); ?></p>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $sheet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="border-t border-line">
                    <div class="flex items-center justify-between gap-3 bg-surface-2/60 px-5 py-2">
                        <p class="num font-semibold"><?php echo e(\App\Support\Tours::label($slot['time'])); ?></p>
                        <p class="num text-sm <?php echo e($slot['guests'] >= $capacity ? 'font-bold text-accent-text' : 'text-ink-3'); ?>"><?php echo e($slot['guests']); ?> of <?php echo e($capacity); ?> places</p>
                    </div>
                    <?php $__empty_2 = true; $__currentLoopData = $slot['bookings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                        <a href="<?php echo e(route('admin.leads.show', $b)); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['flex min-h-11 items-center gap-3 border-t border-line px-5 py-2.5 hover:bg-surface-2', 'opacity-60' => $b->status === \App\Enums\LeadStatus::Cancelled]); ?>">
                            <p class="w-9 flex-none text-center font-display text-xl num"><?php echo e($b->guests); ?></p>
                            <div class="min-w-0 flex-1">
                                <p class="truncate font-semibold"><?php echo e($b->name); ?></p>
                                <p class="truncate text-sm text-ink-3"><?php echo e($b->reference); ?> · <?php echo e(gdl('tours.group_types.'.$b->detail('group_type'), '')); ?><?php if($b->detail('children')): ?> · <?php echo e($b->detail('children')); ?> under 18 <?php endif; ?> <?php if($b->detail('access')): ?> · access needs <?php endif; ?></p>
                            </div>
                            <?php if (isset($component)) { $__componentOriginal51ed764111e345fc11534f121cfeb451 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51ed764111e345fc11534f121cfeb451 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status','data' => ['status' => $b->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($b->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $attributes = $__attributesOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__attributesOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $component = $__componentOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__componentOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <p class="border-t border-line px-5 py-3 text-sm text-ink-3">No bookings yet.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="border-t border-line px-5 py-6 text-ink-3">No tours run on this day.</p>
            <?php endif; ?>
        </section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/admin/tours/index.blade.php ENDPATH**/ ?>