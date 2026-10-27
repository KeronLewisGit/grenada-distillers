<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'The rum range','description' => 'The Clarke\'s Court rum range from Grenada Distillers: aged and dark rums, white and overproof rums, and flavoured rums and liqueurs.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'The rum range','description' => 'The Clarke\'s Court rum range from Grenada Distillers: aged and dark rums, white and overproof rums, and flavoured rums and liqueurs.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['photo' => ''.e(gdl('range.photo')).'','no' => 'R','label' => 'The range','title' => 'The Clarke\'s Court range','lead' => gdl('range.lead')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['photo' => ''.e(gdl('range.photo')).'','no' => 'R','label' => 'The range','title' => 'The Clarke\'s Court range','lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(gdl('range.lead'))]); ?>
        <nav class="mt-7 flex flex-wrap gap-2" aria-label="Rum families">
            <?php $__currentLoopData = $families; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $family => $rums): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="#<?php echo e($family); ?>" class="tag"><?php echo e(gdl('families.'.$family.'.label')); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    <?php $__currentLoopData = $families; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $family => $rums): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section id="<?php echo e($family); ?>" class="wrap mt-16 scroll-mt-28 md:mt-24" aria-labelledby="fam-<?php echo e($family); ?>">
            <div class="grid gap-4 md:grid-cols-[1fr_1.4fr] md:items-end">
                <div>
                    <?php if (isset($component)) { $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stamp','data' => ['no' => $loop->iteration]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stamp'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['no' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop->iteration)]); ?><?php echo e(gdl('families.'.$family.'.label')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $attributes = $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $component = $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
                    <h2 id="fam-<?php echo e($family); ?>" class="display-2 mt-5"><?php echo e(gdl('families.'.$family.'.title')); ?></h2>
                </div>
                <p class="measure text-ink-2"><?php echo e(gdl('families.'.$family.'.blurb')); ?></p>
            </div>
            <ul class="shelf mt-10 grid grid-cols-2 gap-x-4 gap-y-10 pb-8 sm:grid-cols-3 lg:grid-cols-4">
                <?php $__currentLoopData = $rums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('pages.rums.card', ['key' => $key, 'rum' => $rum], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <section class="wrap mt-20 md:mt-28">
        <div class="label-frame grid gap-6 p-6 md:grid-cols-[1fr_auto] md:items-center md:p-10">
            <div>
                <h2 class="display-3">Stocking Clarke's Court?</h2>
                <p class="mt-2 measure text-ink-2">Importers, distributors, duty-free and bars can ask the export team for specifications, case formats and samples.</p>
            </div>
            <a href="<?php echo e(route('trade')); ?>#enquire" class="btn btn-accent">Send a trade enquiry<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-right','class' => 'nudge h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-right','class' => 'nudge h-4 w-4']); ?>
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
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e)): ?>
<?php $attributes = $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e; ?>
<?php unset($__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfefb4fd9b7004fa65f70c415ac76903e)): ?>
<?php $component = $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e; ?>
<?php unset($__componentOriginalfefb4fd9b7004fa65f70c415ac76903e); ?>
<?php endif; ?>
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/pages/rums/index.blade.php ENDPATH**/ ?>