<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Photo credits','description' => 'Licences and authors for the photographs used on this website.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Photo credits','description' => 'Licences and authors for the photographs used on this website.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Photo credits','lead' => gdl('credits_lead'),'no' => '©','label' => 'Credits','photo' => 'casks']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Photo credits','lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(gdl('credits_lead')),'no' => '©','label' => 'Credits','photo' => 'casks']); ?>
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
    <section class="wrap mt-12 md:mt-16">
        <p class="measure text-ink-2">Photos credited to Grenada Distillers or Clarke's Court are the company's own, taken from its earlier website and social media for this proposal. The others are from Wikimedia Commons and are used under the licences shown. Some show other distilleries or places in Grenada and should be replaced with the distillery's own photography before launch.</p>
        <ul class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = config('photo-credits'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="panel overflow-hidden">
                    <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => $key,'alt' => $c['title'],'sizes' => '(min-width: 1024px) 30vw, (min-width: 640px) 45vw, 100vw','class' => 'aspect-[3/2]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($key),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($c['title']),'sizes' => '(min-width: 1024px) 30vw, (min-width: 640px) 45vw, 100vw','class' => 'aspect-[3/2]']); ?>
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
                    <div class="p-5 text-[0.9375rem]">
                        <p class="font-semibold text-ink"><?php echo e($c['title']); ?></p>
                        <p class="mt-1 text-ink-2">By <?php echo e($c['author']); ?></p>
                        <p class="mt-1 text-ink-2">
                            <?php if($c['license_url']): ?><a class="text-link" href="<?php echo e($c['license_url']); ?>" rel="license noopener" target="_blank"><?php echo e($c['license']); ?></a><?php else: ?><?php echo e($c['license']); ?><?php endif; ?>
                            · <a class="text-link" href="<?php echo e($c['source']); ?>" rel="noopener" target="_blank">Source</a>
                        </p>
                        <?php if(! empty($c['used_for'])): ?><p class="mt-1 text-sm text-ink-3">Note: <?php echo e($c['used_for']); ?></p><?php endif; ?>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <p class="mt-8 text-sm text-ink-3">Photos were resized and cropped for the web. CC BY-SA photos remain under their original licence.</p>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/pages/credits.blade.php ENDPATH**/ ?>