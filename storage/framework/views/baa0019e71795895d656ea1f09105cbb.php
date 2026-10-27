<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Site map','description' => 'Every page on the Clarke\'s Court website.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Site map','description' => 'Every page on the Clarke\'s Court website.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Site map','no' => '↦','label' => 'All pages','photo' => 'casks']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Site map','no' => '↦','label' => 'All pages','photo' => 'casks']); ?>
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
    <section class="wrap mt-12 grid gap-10 md:mt-16 md:grid-cols-2 lg:grid-cols-4">
        <?php $__currentLoopData = [
            'Visit & taste' => ['Home' => route('home'), 'The rum range' => route('rums.index'), 'Heritage' => route('heritage'), 'Distillery tours' => route('tours')],
            'Work with us' => ['Trade & export enquiries' => route('trade'), 'Careers' => route('careers.index'), 'Send your CV' => route('careers.apply')],
            'Company' => ['Contact & directions' => route('contact'), 'Privacy notice' => route('privacy'), 'Photo credits' => route('credits')],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $links): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <h2 class="font-sans text-lg font-bold"><?php echo e($group); ?></h2>
                <ul class="mt-3 space-y-1"><?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><a class="text-link inline-flex min-h-11 items-center" href="<?php echo e($u); ?>"><?php echo e($t); ?></a></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div>
            <h2 class="font-sans text-lg font-bold">The rums</h2>
            <ul class="mt-3 space-y-1"><?php $__currentLoopData = \App\Support\Rums::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><a class="text-link inline-flex min-h-11 items-center" href="<?php echo e(route('rums.show', $k)); ?>"><?php echo e($r['name']); ?></a></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
        <?php if($jobs->isNotEmpty()): ?>
            <div class="md:col-span-2">
                <h2 class="font-sans text-lg font-bold">Vacancies</h2>
                <ul class="mt-3 space-y-1"><?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><a class="text-link inline-flex min-h-11 items-center" href="<?php echo e(route('careers.show', $j)); ?>"><?php echo e($j->title); ?></a></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
        <?php endif; ?>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/pages/sitemap.blade.php ENDPATH**/ ?>