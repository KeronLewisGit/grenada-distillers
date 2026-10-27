<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Settings']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Settings']); ?>
    <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" class="max-w-2xl space-y-6">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <section class="a-card space-y-4 p-5">
            <h2 class="font-semibold">Distillery tours</h2>
            <p class="text-sm text-ink-2">How many guests one tour takes, and the largest party that can book online. Tours that reach capacity show as full on the website; bigger groups are asked to send an enquiry instead.</p>
            <div class="grid gap-4 sm:grid-cols-2">
                <div><label for="cap" class="mb-1 block text-sm font-semibold">Guests per tour</label>
                    <input id="cap" name="tour_slot_capacity" type="number" min="1" max="500" value="<?php echo e(old('tour_slot_capacity', $capacity)); ?>" class="a-input w-full" required></div>
                <div><label for="party" class="mb-1 block text-sm font-semibold">Largest online party</label>
                    <input id="party" name="tour_max_party" type="number" min="1" max="500" value="<?php echo e(old('tour_max_party', $maxParty)); ?>" class="a-input w-full" required></div>
            </div>
            <p class="text-xs text-ink-3">Tour days and times are set in <code>config/gdl.php</code> (tours.slots), with public holidays in <code>closed_dates</code>.</p>
        </section>
        <button class="a-btn a-btn-primary">Save settings</button>
    </form>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/admin/settings.blade.php ENDPATH**/ ?>