
<?php ($cover = ! empty($rum['cover'])); ?>
<li class="card-link group flex flex-col">
    <div class="card-img bottle-tile relative aspect-[3/4] overflow-hidden rounded-md <?php echo e($cover ? '' : 'px-4 pt-6'); ?>">
        <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => $rum['photo'],'alt' => $cover ? 'Nutmeg drying in Grenada, the spice in '.$rum['name'] : $rum['name'].' bottle','sizes' => '(min-width: 1024px) 20vw, (min-width: 640px) 30vw, 45vw','class' => $cover ? 'h-full w-full' : 'photo-contain h-full w-full !bg-transparent']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rum['photo']),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cover ? 'Nutmeg drying in Grenada, the spice in '.$rum['name'] : $rum['name'].' bottle'),'sizes' => '(min-width: 1024px) 20vw, (min-width: 640px) 30vw, 45vw','class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cover ? 'h-full w-full' : 'photo-contain h-full w-full !bg-transparent')]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seal','data' => ['abv' => $rum['abv'],'small' => true,'class' => 'absolute right-2 top-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['abv' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rum['abv']),'small' => true,'class' => 'absolute right-2 top-2']); ?>
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
    </div>
    <p class="kicker mt-4 text-ink-3"><?php echo e($rum['style']); ?></p>
    <h3 class="font-display mt-1 text-2xl leading-tight"><a class="stretch" href="<?php echo e(route('rums.show', $key)); ?>"><?php echo e($rum['name']); ?></a></h3>
</li>
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/pages/rums/card.blade.php ENDPATH**/ ?>