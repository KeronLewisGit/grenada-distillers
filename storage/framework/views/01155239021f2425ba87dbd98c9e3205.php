<?php ($editing = $job->exists); ?>
<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => $editing ? 'Edit vacancy' : 'New vacancy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editing ? 'Edit vacancy' : 'New vacancy')]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('admin.vacancies.index')); ?>" class="a-btn a-btn-ghost">All vacancies</a>
     <?php $__env->endSlot(); ?>
    <form method="POST" action="<?php echo e($editing ? route('admin.vacancies.update', $job) : route('admin.vacancies.store')); ?>" class="grid max-w-5xl gap-6 xl:grid-cols-[1.5fr_1fr]">
        <?php echo csrf_field(); ?> <?php if($editing): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <section class="a-card space-y-4 p-5">
            <div><label for="title" class="mb-1 block text-sm font-semibold">Job title</label><input id="title" name="title" value="<?php echo e(old('title', $job->title)); ?>" class="a-input w-full" required maxlength="120"></div>
            <div><label for="summary" class="mb-1 block text-sm font-semibold">Summary</label><textarea id="summary" name="summary" rows="3" class="a-input w-full" required maxlength="600"><?php echo e(old('summary', $job->summary)); ?></textarea><p class="mt-1 text-xs text-ink-3">Two or three sentences, shown on the careers list.</p></div>
            <div><label for="duties" class="mb-1 block text-sm font-semibold">What you'll do</label><textarea id="duties" name="duties" rows="6" class="a-input w-full" maxlength="5000"><?php echo e(old('duties', $job->duties)); ?></textarea><p class="mt-1 text-xs text-ink-3">One duty per line.</p></div>
            <div><label for="requirements" class="mb-1 block text-sm font-semibold">What you'll need</label><textarea id="requirements" name="requirements" rows="6" class="a-input w-full" maxlength="5000"><?php echo e(old('requirements', $job->requirements)); ?></textarea><p class="mt-1 text-xs text-ink-3">One requirement per line.</p></div>
        </section>
        <div class="space-y-6">
            <section class="a-card space-y-4 p-5">
                <div><label for="status" class="mb-1 block text-sm font-semibold">Status</label>
                    <select id="status" name="status" class="a-input w-full"><?php $__currentLoopData = \App\Enums\JobStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s->value); ?>" <?php if(old('status', $job->status?->value) === $s->value): echo 'selected'; endif; ?>><?php echo e($s->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                    <p class="mt-1 text-xs text-ink-3">Only open vacancies show on the website.</p></div>
                <div><label for="department" class="mb-1 block text-sm font-semibold">Department</label><input id="department" name="department" value="<?php echo e(old('department', $job->department)); ?>" class="a-input w-full" required maxlength="60" list="departments">
                    <datalist id="departments"><?php $__currentLoopData = ['Production', 'Bottling', 'Warehouse & logistics', 'Finance & accounts', 'Sales & marketing', 'Tours & visitor centre', 'Administration']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($dep); ?>"><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></datalist></div>
                <div><label for="employment_type" class="mb-1 block text-sm font-semibold">Type</label>
                    <select id="employment_type" name="employment_type" class="a-input w-full"><?php $__currentLoopData = \App\Enums\EmploymentType::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($t->value); ?>" <?php if(old('employment_type', $job->employment_type?->value) === $t->value): echo 'selected'; endif; ?>><?php echo e($t->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                <div><label for="location" class="mb-1 block text-sm font-semibold">Location</label><input id="location" name="location" value="<?php echo e(old('location', $job->location)); ?>" class="a-input w-full" required maxlength="120"></div>
                <div><label for="closes_on" class="mb-1 block text-sm font-semibold">Applications close</label><input id="closes_on" name="closes_on" type="date" value="<?php echo e(old('closes_on', $job->closes_on?->toDateString())); ?>" class="a-input w-full"><p class="mt-1 text-xs text-ink-3">Blank = open until filled.</p></div>
                <button class="a-btn a-btn-primary w-full"><?php echo e($editing ? 'Save vacancy' : 'Create vacancy'); ?></button>
            </section>
        </div>
    </form>
    <?php if($editing): ?>
        <form method="POST" action="<?php echo e(route('admin.vacancies.destroy', $job)); ?>" class="mt-6" onsubmit="return confirm('Delete this vacancy? If anyone has applied it will be closed instead.')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button class="a-btn a-btn-ghost text-[color:var(--critical-text)]"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'trash','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'trash','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Delete vacancy</button>
        </form>
    <?php endif; ?>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/admin/vacancies/form.blade.php ENDPATH**/ ?>