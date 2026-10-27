<?php ($h = gdl('heritage')); ?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Heritage','description' => 'The story of Clarke\'s Court and Grenada Distillers: from the Woodlands sugar estate to Grenada\'s largest rum distillery, at work since 1937.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Heritage','description' => 'The story of Clarke\'s Court and Grenada Distillers: from the Woodlands sugar estate to Grenada\'s largest rum distillery, at work since 1937.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['photo' => ''.e($h['photo']).'','no' => ''.e(gdl('founded')).'','label' => 'Heritage','title' => $h['title'],'lead' => $h['lead']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['photo' => ''.e($h['photo']).'','no' => ''.e(gdl('founded')).'','label' => 'Heritage','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($h['title']),'lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($h['lead'])]); ?>
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

    <section class="wrap mt-14 grid gap-12 md:mt-20 lg:grid-cols-[1.25fr_1fr] lg:gap-16">
        <div class="prose-copy measure text-ink-2">
            <?php $__currentLoopData = $h['story']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $para): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($para); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <figure>
            <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => $h['side_photo'],'alt' => $h['side_alt'],'sizes' => '(min-width: 1024px) 40vw, 100vw','class' => 'aspect-[4/3] rounded-md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($h['side_photo']),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($h['side_alt']),'sizes' => '(min-width: 1024px) 40vw, 100vw','class' => 'aspect-[4/3] rounded-md']); ?>
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
            <figcaption class="mt-3 text-sm text-ink-3"><?php echo e($h['side_caption']); ?></figcaption>
        </figure>
    </section>

    <section class="wrap mt-20 md:mt-28" aria-labelledby="time-title">
        <?php if (isset($component)) { $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stamp','data' => ['no' => '⧗']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stamp'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['no' => '⧗']); ?>Timeline <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $attributes = $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $component = $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
        <h2 id="time-title" class="display-2 mt-5">Milestones</h2>
        <ol class="ledger mt-10 max-w-4xl">
            <?php $__currentLoopData = $h['timeline']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <span class="yr"><?php echo e($row['year']); ?></span>
                    <div>
                        <h3 class="text-lg font-bold"><?php echo e($row['title']); ?></h3>
                        <p class="mt-1 measure text-ink-2"><?php echo e($row['text']); ?></p>
                        <?php if(! empty($row['source'])): ?><p class="mt-1 text-sm text-ink-3">Source: <a class="text-link" href="<?php echo e($row['source']['url']); ?>" rel="noopener" target="_blank"><?php echo e($row['source']['label']); ?></a></p><?php endif; ?>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    </section>

    <?php if(! empty($h['gallery'])): ?>
        <section class="wrap mt-20 md:mt-28" aria-label="Archive photographs">
            <ul class="grid gap-5 sm:grid-cols-2 lg:grid-cols-<?php echo e(min(4, count($h['gallery']))); ?>">
                <?php $__currentLoopData = $h['gallery']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => $g['photo'],'alt' => $g['alt'],'sizes' => '(min-width: 1024px) 25vw, (min-width: 640px) 45vw, 100vw','class' => 'aspect-[4/3] rounded-md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($g['photo']),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($g['alt']),'sizes' => '(min-width: 1024px) 25vw, (min-width: 640px) 45vw, 100vw','class' => 'aspect-[4/3] rounded-md']); ?>
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
                        <p class="mt-2 text-sm text-ink-3"><?php echo e($g['caption']); ?></p>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>
    <?php endif; ?>

    <section class="wrap mt-20 md:mt-28">
        <div class="label-frame grid gap-6 p-6 md:grid-cols-[1fr_auto] md:items-center md:p-10">
            <div>
                <h2 class="display-3">See it for yourself</h2>
                <p class="mt-2 measure text-ink-2">The tour takes you through the distillery at Woodlands and ends with a tasting for adults.</p>
            </div>
            <a href="<?php echo e(route('tours')); ?>#book" class="btn btn-accent">Book a distillery tour<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/pages/heritage.blade.php ENDPATH**/ ?>