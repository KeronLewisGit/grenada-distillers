<?php
    $qs = fn (array $extra) => array_filter(array_merge($filters, $extra), fn ($v) => $v !== null && $v !== '');
?>
<?php
    $selectedType = \App\Enums\LeadType::tryFrom((string) $filters['type']);
    // One type: its own stages. All types: only the stages that have requests in them.
    $tabs = $selectedType ? $selectedType->statuses() : array_values(array_filter(\App\Enums\LeadStatus::cases(), fn ($s) => ($counts[$s->value] ?? 0) > 0 || $s === \App\Enums\LeadStatus::New));
?>
<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Requests inbox']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Requests inbox']); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('admin.leads.export', $qs([]))); ?>" class="a-btn a-btn-ghost"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'download','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'download','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Export CSV</a>
     <?php $__env->endSlot(); ?>

    <nav class="tag-row !mx-0 !px-0" aria-label="Status">
        <a href="<?php echo e(route('admin.leads.index', $qs(['status' => null]))); ?>" class="tag" <?php if(! $filters['status']): ?> aria-current="true" <?php endif; ?>>All <span class="count"><?php echo e($counts->sum()); ?></span></a>
        <a href="<?php echo e(route('admin.leads.index', $qs(['status' => 'open']))); ?>" class="tag" <?php if($filters['status'] === 'open'): ?> aria-current="true" <?php endif; ?>>Open</a>
        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.leads.index', $qs(['status' => $s->value]))); ?>" class="tag" <?php if($filters['status'] === $s->value): ?> aria-current="true" <?php endif; ?>><?php echo e($s->label()); ?> <span class="count"><?php echo e($counts[$s->value] ?? 0); ?></span></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>

    <form method="GET" class="mt-4 flex flex-wrap items-end gap-3" x-data @change="$el.requestSubmit()">
        <?php if($filters['status']): ?><input type="hidden" name="status" value="<?php echo e($filters['status']); ?>"><?php endif; ?>
        <div><label for="type" class="mb-1 block text-xs font-semibold text-ink-3">Type</label>
            <select id="type" name="type" class="a-input"><option value="">All types</option><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($t->value); ?>" <?php if($filters['type'] === $t->value): echo 'selected'; endif; ?>><?php echo e($t->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div><label for="assigned" class="mb-1 block text-xs font-semibold text-ink-3">Assigned to</label>
            <select id="assigned" name="assigned" class="a-input"><option value="">Anyone</option><option value="<?php echo e(auth()->id()); ?>" <?php if($filters['assigned'] === (string) auth()->id()): echo 'selected'; endif; ?>>Me</option><option value="none" <?php if($filters['assigned'] === 'none'): echo 'selected'; endif; ?>>Nobody</option><?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($u->id); ?>" <?php if($filters['assigned'] === (string) $u->id): echo 'selected'; endif; ?>><?php echo e($u->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <label class="flex min-h-11 items-center gap-2 text-sm font-semibold"><input type="checkbox" name="overdue" value="1" class="h-4 w-4" <?php if($filters['overdue']): echo 'checked'; endif; ?>>Waiting over a day</label>
        <div class="flex-1"><label for="q2" class="mb-1 block text-xs font-semibold text-ink-3">Search</label><input id="q2" name="q" value="<?php echo e($filters['q']); ?>" class="a-input w-full min-w-48" placeholder="Name, company, phone, email or reference"></div>
        <button class="a-btn a-btn-primary">Filter</button>
        <?php if(array_filter($filters)): ?><a href="<?php echo e(route('admin.leads.index')); ?>" class="a-btn a-btn-ghost">Clear</a><?php endif; ?>
    </form>

    <div class="a-card table-box relative mt-5">
        <table class="data-table">
            <thead><tr><th>Received</th><th>From</th><th>Type</th><th>About</th><th>Status</th><th>Assigned</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="relative">
                        <td class="whitespace-nowrap">
                            <p class="num"><?php echo e($l->created_at->format('j M, H:i')); ?></p>
                            <?php if($l->isOverdue()): ?><p class="chip mt-1 num" data-tone="critical"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e($l->created_at->diffForHumans(null, true, true)); ?> waiting</p><?php endif; ?>
                        </td>
                        <td><a href="<?php echo e(route('admin.leads.show', $l)); ?>" class="whitespace-nowrap font-semibold underline-offset-2 hover:underline after:absolute after:inset-0"><?php echo e($l->name); ?></a><p class="num whitespace-nowrap text-sm text-ink-3"><?php echo e($l->reference); ?><?php if($l->organisation): ?><br><?php echo e($l->organisation); ?><?php endif; ?></p></td>
                        <td class="whitespace-nowrap"><span class="inline-flex items-center gap-1.5"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $l->type->icon(),'class' => 'h-4 w-4 text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($l->type->icon()),'class' => 'h-4 w-4 text-ink-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e($l->type->label()); ?></span></td>
                        <td class="max-w-56 truncate"><?php echo e($l->subject() ?? '—'); ?></td>
                        <td><?php if (isset($component)) { $__componentOriginal51ed764111e345fc11534f121cfeb451 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51ed764111e345fc11534f121cfeb451 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status','data' => ['status' => $l->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($l->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $attributes = $__attributesOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__attributesOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $component = $__componentOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__componentOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?></td>
                        <td class="whitespace-nowrap"><?php echo e($l->assignee->name ?? '—'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="py-10 text-center text-ink-3">No requests match.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-5"><?php echo e($leads->links()); ?></div>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/admin/leads/index.blade.php ENDPATH**/ ?>