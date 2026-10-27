<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Careers','description' => 'Work at Grenada Distillers, the home of Clarke\'s Court rum, at Woodlands, St George. See open vacancies and apply online with your CV.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Careers','description' => 'Work at Grenada Distillers, the home of Clarke\'s Court rum, at Woodlands, St George. See open vacancies and apply online with your CV.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['photo' => ''.e(gdl('careers.photo')).'','no' => 'C','label' => 'Careers','title' => 'Work at the distillery.','lead' => gdl('careers.lead')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['photo' => ''.e(gdl('careers.photo')).'','no' => 'C','label' => 'Careers','title' => 'Work at the distillery.','lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(gdl('careers.lead'))]); ?>
        <p class="mt-7 flex flex-wrap gap-3"><a href="#vacancies" class="btn btn-accent">See the vacancies<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?></a><a href="<?php echo e(route('careers.apply')); ?>" class="btn btn-on-dark">Send a general application</a></p>
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

    <section id="vacancies" class="wrap mt-14 scroll-mt-28 md:mt-20">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <?php if (isset($component)) { $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stamp','data' => ['no' => $jobs->count()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stamp'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['no' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($jobs->count())]); ?>Open now <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $attributes = $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $component = $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
                <h2 class="display-2 mt-5">Current vacancies</h2>
            </div>
            <p class="text-ink-3">All roles are based at <?php echo e(gdl('address.locality')); ?>, <?php echo e(gdl('address.parish')); ?>.</p>
        </div>

        <?php if($jobs->isEmpty()): ?>
            <div class="label-frame mt-10 max-w-2xl p-8">
                <h3 class="font-sans text-lg font-bold">No vacancies are open right now</h3>
                <p class="mt-2 text-ink-2">You can still send us your CV. HR keeps general applications for twelve months and contacts you if a suitable role opens.</p>
                <p class="mt-5"><a href="<?php echo e(route('careers.apply')); ?>" class="btn btn-primary">Send your CV</a></p>
            </div>
        <?php else: ?>
            <ul class="mt-10 grid gap-5 md:grid-cols-2">
                <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="card-link label-frame flex flex-col p-6 md:p-8">
                        <p class="kicker flex flex-wrap items-center gap-3 text-ink-3"><?php echo e($job->department); ?><?php if($job->is_demo): ?><span class="demo-badge">Sample</span><?php endif; ?></p>
                        <h3 class="font-display mt-3 text-[1.75rem] leading-tight"><a class="stretch" href="<?php echo e(route('careers.show', $job)); ?>"><?php echo e($job->title); ?></a></h3>
                        <p class="mt-3 text-ink-2"><?php echo e($job->summary); ?></p>
                        <p class="mt-auto flex flex-wrap gap-x-5 gap-y-1 pt-5 text-[0.9375rem] text-ink-3">
                            <span class="inline-flex items-center gap-1.5"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'briefcase','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'briefcase','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e($job->employment_type->label()); ?></span>
                            <span class="inline-flex items-center gap-1.5"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'calendar','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'calendar','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e($job->closes_on ? 'Closes '.$job->closes_on->format('j F Y') : 'Open until filled'); ?></span>
                        </p>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </section>

    <section class="wrap mt-20 grid gap-10 md:mt-28 lg:grid-cols-[1fr_1fr] lg:items-center">
        <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => gdl('careers.side_photo'),'alt' => gdl('careers.side_alt'),'sizes' => '(min-width: 1024px) 45vw, 100vw','class' => 'aspect-[4/3] rounded-md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(gdl('careers.side_photo')),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(gdl('careers.side_alt')),'sizes' => '(min-width: 1024px) 45vw, 100vw','class' => 'aspect-[4/3] rounded-md']); ?>
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
        <div>
            <?php if (isset($component)) { $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stamp','data' => ['no' => '?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stamp'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['no' => '?']); ?>How to apply <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $attributes = $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $component = $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
            <h2 class="display-3 mt-5">Apply online in about five minutes</h2>
            <ol class="ledger mt-6">
                <li><span class="yr">01</span><p>Choose a vacancy, or send a general application if nothing fits yet.</p></li>
                <li><span class="yr">02</span><p>Tell us about your experience and attach your CV as a PDF or Word file (up to 5 MB).</p></li>
                <li><span class="yr">03</span><p>You get a reference number by email. Only our HR team can open your CV.</p></li>
            </ol>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/pages/careers/index.blade.php ENDPATH**/ ?>