<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Are you of legal drinking age?','chrome' => false,'description' => 'Clarke\'s Court rum is for adults of legal drinking age. Please confirm your age to enter.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Are you of legal drinking age?','chrome' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'description' => 'Clarke\'s Court rum is for adults of legal drinking age. Please confirm your age to enter.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['photo' => 'hero','position' => gdl('photos.hero.position', 'center'),'no' => gdl('legal_age').'+','label' => 'Age check','title' => $declined ? 'Thank you for your honesty.' : 'Welcome to Clarke\'s Court.','lead' => $declined ? 'This website is about rum, so it is only for adults of legal drinking age. Please come back when you are '.gdl('legal_age').'.' : 'Our rums are for adults. Are you '.gdl('legal_age').' or older, the legal drinking age in Grenada?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['photo' => 'hero','position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(gdl('photos.hero.position', 'center')),'no' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(gdl('legal_age').'+'),'label' => 'Age check','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($declined ? 'Thank you for your honesty.' : 'Welcome to Clarke\'s Court.'),'lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($declined ? 'This website is about rum, so it is only for adults of legal drinking age. Please come back when you are '.gdl('legal_age').'.' : 'Our rums are for adults. Are you '.gdl('legal_age').' or older, the legal drinking age in Grenada?')]); ?>
        <?php if (! ($declined)): ?>
            <form method="POST" action="<?php echo e(route('age.store')); ?>" class="mt-8 max-w-xl">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="next" value="<?php echo e($next); ?>">
                <div class="flex flex-wrap gap-3">
                    <button type="submit" name="answer" value="yes" class="btn btn-accent min-w-40 text-lg">Yes, I am <?php echo e(gdl('legal_age')); ?> or older</button>
                    <button type="submit" name="answer" value="no" class="btn btn-on-dark min-w-32 text-lg">No</button>
                </div>
                <label class="mt-5 flex min-h-11 items-center gap-3 text-white/85"><input type="checkbox" name="remember" value="1" class="h-5 w-5 accent-[var(--accent)]">Remember me on this device for 30 days</label>
                <p class="mt-3 max-w-md text-sm text-white/70">If you are visiting from a country where the legal drinking age is higher, please follow your local law. By entering you accept our <a href="<?php echo e(route('privacy')); ?>" class="text-link">privacy notice</a>; we set one small cookie to remember your answer.</p>
            </form>
        <?php else: ?>
            <p class="mt-8"><a href="<?php echo e(route('age.show')); ?>" class="btn btn-on-dark">I answered by mistake</a></p>
        <?php endif; ?>
        <div class="ribbon mt-10 max-w-40" aria-hidden="true"></div>
        <p class="mt-4 flex items-center gap-2 text-sm text-white/70"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'glass','class' => 'h-4 w-4 text-accent']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'glass','class' => 'h-4 w-4 text-accent']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Enjoy responsibly. Never drink and drive.</p>
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
    <div class="wrap flex flex-col items-start gap-3 py-8 text-sm text-ink-3 sm:flex-row sm:items-center sm:justify-between">
        <?php if (isset($component)) { $__componentOriginal987d96ec78ed1cf75b349e2e5981978f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal987d96ec78ed1cf75b349e2e5981978f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal987d96ec78ed1cf75b349e2e5981978f)): ?>
<?php $attributes = $__attributesOriginal987d96ec78ed1cf75b349e2e5981978f; ?>
<?php unset($__attributesOriginal987d96ec78ed1cf75b349e2e5981978f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal987d96ec78ed1cf75b349e2e5981978f)): ?>
<?php $component = $__componentOriginal987d96ec78ed1cf75b349e2e5981978f; ?>
<?php unset($__componentOriginal987d96ec78ed1cf75b349e2e5981978f); ?>
<?php endif; ?>
        <p><?php echo e(gdl('name')); ?> · <?php echo e(gdl('address.locality')); ?>, <?php echo e(gdl('address.parish')); ?>, Grenada · <a href="<?php echo e(route('credits')); ?>" class="text-link">Photo credits</a></p>
    </div>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/pages/age.blade.php ENDPATH**/ ?>