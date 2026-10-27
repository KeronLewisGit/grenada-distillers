<?php
    $ld = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => "Clarke's Court ".$rum['name'],
        'brand' => ['@type' => 'Brand', 'name' => "Clarke's Court"],
        'manufacturer' => ['@type' => 'Organization', 'name' => gdl('name')],
        'category' => 'Rum',
        'description' => $rum['summary'],
        'image' => asset('img/'.$rum['photo'].'-960.webp'),
    ]);
?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => $rum['name'],'description' => \Illuminate\Support\Str::limit($rum['summary'], 155),'jsonLd' => [$ld],'ogImage' => $rum['photo']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rum['name']),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Str::limit($rum['summary'], 155)),'json-ld' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([$ld]),'og-image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rum['photo'])]); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['photo' => ''.e(gdl('families.'.$rum['family'].'.photo')).'','no' => 'R','label' => gdl('families.'.$rum['family'].'.label'),'title' => $rum['name'],'lead' => $rum['summary']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['photo' => ''.e(gdl('families.'.$rum['family'].'.photo')).'','no' => 'R','label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(gdl('families.'.$rum['family'].'.label')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rum['name']),'lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rum['summary'])]); ?>
        <p class="mt-6"><a href="<?php echo e(route('rums.index')); ?>#<?php echo e($rum['family']); ?>" class="inline-flex min-h-11 items-center gap-2 font-semibold text-white/85 hover:text-white"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-left','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-left','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>The whole range</a></p>
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

    <div class="wrap mt-12 grid gap-12 md:mt-16 md:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)] lg:gap-20">
        <div>
            <?php ($cover = ! empty($rum['cover'])); ?>
            <div class="bottle-tile label-frame relative flex aspect-[3/4] items-center justify-center overflow-hidden md:sticky md:top-28 <?php echo e($cover ? '' : 'p-8'); ?>">
                <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => $rum['photo'],'alt' => $cover ? 'Nutmeg drying on wooden racks at a Grenada co-operative' : 'Bottle of Clarke\'s Court '.$rum['name'],'sizes' => '(min-width: 768px) 35vw, 90vw','class' => $cover ? 'h-full w-full' : 'photo-contain h-full w-full !bg-transparent','eager' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rum['photo']),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cover ? 'Nutmeg drying on wooden racks at a Grenada co-operative' : 'Bottle of Clarke\'s Court '.$rum['name']),'sizes' => '(min-width: 768px) 35vw, 90vw','class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cover ? 'h-full w-full' : 'photo-contain h-full w-full !bg-transparent'),'eager' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $attributes = $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__attributesOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783)): ?>
<?php $component = $__componentOriginalbc843bb087146ea7bf90eaac3fe60783; ?>
<?php unset($__componentOriginalbc843bb087146ea7bf90eaac3fe60783); ?>
<?php endif; ?>
                <?php if(! empty($rum['abv'])): ?><?php if (isset($component)) { $__componentOriginala04d4f76939ca6fbfd6d251d0478d748 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala04d4f76939ca6fbfd6d251d0478d748 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seal','data' => ['abv' => $rum['abv'],'class' => 'absolute right-4 top-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['abv' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rum['abv']),'class' => 'absolute right-4 top-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala04d4f76939ca6fbfd6d251d0478d748)): ?>
<?php $attributes = $__attributesOriginala04d4f76939ca6fbfd6d251d0478d748; ?>
<?php unset($__attributesOriginala04d4f76939ca6fbfd6d251d0478d748); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala04d4f76939ca6fbfd6d251d0478d748)): ?>
<?php $component = $__componentOriginala04d4f76939ca6fbfd6d251d0478d748; ?>
<?php unset($__componentOriginala04d4f76939ca6fbfd6d251d0478d748); ?>
<?php endif; ?><?php endif; ?>
                <?php if($cover): ?><p class="absolute inset-x-0 bottom-0 bg-molasses-950/80 px-4 py-2 text-sm text-white">Bottle photo to come from Grenada Distillers.</p><?php endif; ?>
            </div>
        </div>
        <div>
            <?php if (isset($component)) { $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stamp','data' => ['no' => 'i']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stamp'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['no' => 'i']); ?><?php echo e($rum['style']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $attributes = $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $component = $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
            <div class="prose-copy measure mt-6 text-ink-2">
                <?php $__currentLoopData = (array) $rum['notes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $para): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($para); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if (isset($component)) { $__componentOriginal3e4ed714fb881ce08c27f12e285053ac = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e4ed714fb881ce08c27f12e285053ac = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.spec','data' => ['class' => 'mt-8 max-w-xl','rows' => array_filter([
                'Style' => $rum['style'],
                'Strength' => ! empty($rum['abv']) ? $rum['abv'].'% ABV' : null,
                'Bottle sizes' => ! empty($rum['sizes']) ? implode(', ', $rum['sizes']) : null,
                'Made at' => 'Woodlands, St George, Grenada',
            ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('spec'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-8 max-w-xl','rows' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(array_filter([
                'Style' => $rum['style'],
                'Strength' => ! empty($rum['abv']) ? $rum['abv'].'% ABV' : null,
                'Bottle sizes' => ! empty($rum['sizes']) ? implode(', ', $rum['sizes']) : null,
                'Made at' => 'Woodlands, St George, Grenada',
            ]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3e4ed714fb881ce08c27f12e285053ac)): ?>
<?php $attributes = $__attributesOriginal3e4ed714fb881ce08c27f12e285053ac; ?>
<?php unset($__attributesOriginal3e4ed714fb881ce08c27f12e285053ac); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3e4ed714fb881ce08c27f12e285053ac)): ?>
<?php $component = $__componentOriginal3e4ed714fb881ce08c27f12e285053ac; ?>
<?php unset($__componentOriginal3e4ed714fb881ce08c27f12e285053ac); ?>
<?php endif; ?>
            <?php if(! empty($rum['serve'])): ?>
                <div class="mt-8 max-w-xl border-l-4 border-accent pl-5">
                    <p class="kicker text-ink-3">How it's served</p>
                    <p class="mt-1 text-ink-2"><?php echo e($rum['serve']); ?></p>
                </div>
            <?php endif; ?>
            <div class="mt-10 flex flex-wrap gap-3">
                <a href="<?php echo e(route('trade')); ?>#enquire" class="btn btn-accent">Trade enquiry<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
                <a href="<?php echo e(route('tours')); ?>#book" class="btn btn-outline">Taste it on a tour</a>
            </div>
            <div class="mt-10 max-w-xl border-t border-line pt-5 text-sm text-ink-3">
                <p class="font-semibold text-ink-2">Sources for this page</p>
                <ul class="mt-1 space-y-1">
                    <?php $__currentLoopData = $rum['sources']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><a class="text-link" href="<?php echo e($s['url']); ?>" rel="noopener" target="_blank"><?php echo e($s['label']); ?></a></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <p class="mt-2">Strength and bottle sizes vary by market; check the label.</p>
            </div>
        </div>
    </div>

    <?php if($related !== []): ?>
        <section class="wrap mt-20 md:mt-28" aria-labelledby="more-title">
            <h2 id="more-title" class="display-3">More from the range</h2>
            <ul class="shelf mt-8 grid grid-cols-2 gap-x-4 gap-y-10 pb-8 sm:grid-cols-3">
                <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('pages.rums.card', ['key' => $k, 'rum' => $r], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>
    <?php endif; ?>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/pages/rums/show.blade.php ENDPATH**/ ?>