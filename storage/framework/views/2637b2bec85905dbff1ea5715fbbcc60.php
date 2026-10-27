<?php
    $weeks = collect($grid)->groupBy(fn (array $d) => $d['date']->copy()->startOfWeek()->toDateString());
    $oldSlot = (string) old('slot');
    $openWeek = $oldSlot !== '' ? \Illuminate\Support\Carbon::parse(substr($oldSlot, 0, 10))->startOfWeek()->toDateString() : $weeks->keys()->first();
    $tour = gdl('tours.about');
?>
<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Distillery tours','description' => 'Book a guided tour of the Clarke\'s Court distillery at Woodlands, St George, Grenada. Choose a day and time and get a reference straight away.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Distillery tours','description' => 'Book a guided tour of the Clarke\'s Court distillery at Woodlands, St George, Grenada. Choose a day and time and get a reference straight away.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['photo' => ''.e(gdl('tours.photo', 'mill')).'','no' => 'T','label' => 'Distillery tours','title' => 'See where Grenada\'s rum is made.','lead' => $tour['lead']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['photo' => ''.e(gdl('tours.photo', 'mill')).'','no' => 'T','label' => 'Distillery tours','title' => 'See where Grenada\'s rum is made.','lead' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tour['lead'])]); ?>
        <p class="mt-7 flex flex-wrap gap-3"><a href="#book" class="btn btn-accent">Choose a tour time<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
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
<?php endif; ?></a><a href="<?php echo e(route('contact')); ?>#directions" class="btn btn-on-dark">Directions to Woodlands</a></p>
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

    <section class="wrap mt-14 grid gap-12 md:mt-20 lg:grid-cols-[1.1fr_1fr] lg:gap-16">
        <div>
            <?php if (isset($component)) { $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stamp','data' => ['no' => '1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stamp'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['no' => '1']); ?>On the tour <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $attributes = $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $component = $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
            <h2 class="display-3 mt-5"><?php echo e($tour['heading']); ?></h2>
            <ul class="ledger mt-8">
                <?php $__currentLoopData = $tour['stops']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $stop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><span class="yr"><?php echo e(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></span><div><h3 class="text-lg font-bold"><?php echo e($stop['title']); ?></h3><p class="mt-1 text-ink-2"><?php echo e($stop['text']); ?></p></div></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <aside class="space-y-5">
            <?php if (isset($component)) { $__componentOriginalbc843bb087146ea7bf90eaac3fe60783 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc843bb087146ea7bf90eaac3fe60783 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.photo','data' => ['key' => $tour['side_photo'],'alt' => $tour['side_alt'],'sizes' => '(min-width: 1024px) 40vw, 100vw','class' => 'aspect-[4/3] rounded-md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tour['side_photo']),'alt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tour['side_alt']),'sizes' => '(min-width: 1024px) 40vw, 100vw','class' => 'aspect-[4/3] rounded-md']); ?>
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
            <div class="label-frame p-6 md:p-8">
                <h2 class="font-sans text-lg font-bold">Good to know</h2>
                <?php if (isset($component)) { $__componentOriginal3e4ed714fb881ce08c27f12e285053ac = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e4ed714fb881ce08c27f12e285053ac = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.spec','data' => ['class' => 'mt-3','rows' => [
                    'Tour days' => $tour['days_text'],
                    'Places per tour' => $capacity.' guests',
                    'Book online for' => 'Up to '.$maxParty.' people',
                    'Tasting' => 'Adults '.gdl('legal_age').'+ only',
                    'Where' => gdl('address.locality').', '.gdl('address.parish'),
                ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('spec'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-3','rows' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    'Tour days' => $tour['days_text'],
                    'Places per tour' => $capacity.' guests',
                    'Book online for' => 'Up to '.$maxParty.' people',
                    'Tasting' => 'Adults '.gdl('legal_age').'+ only',
                    'Where' => gdl('address.locality').', '.gdl('address.parish'),
                ])]); ?>
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
                <p class="mt-4 text-[0.9375rem] text-ink-2">Bigger group, cruise excursion or school visit? <a class="text-link" href="<?php echo e(route('contact')); ?>?topic=tour_group">Ask us about a group tour</a>.</p>
            </div>
        </aside>
    </section>

    <section id="book" class="wrap mt-20 scroll-mt-28 md:mt-28">
        <div class="max-w-3xl">
            <?php if (isset($component)) { $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stamp','data' => ['no' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stamp'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['no' => '2']); ?>Book <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $attributes = $__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__attributesOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a)): ?>
<?php $component = $__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a; ?>
<?php unset($__componentOriginal09bf7ddb5912aea8f1bb99bd61a6e33a); ?>
<?php endif; ?>
            <h2 class="display-2 mt-5">Choose a day and a time</h2>
            <p class="lead mt-4 text-ink-2">Each tour takes <?php echo e($capacity); ?> guests. The places left are shown under every time, and your places are held as soon as you send the form.</p>
        </div>

        <form method="POST" action="<?php echo e(route('tours.store')); ?>" class="mt-10 grid gap-12 lg:grid-cols-[1.35fr_1fr]" x-data="leadForm" @submit="submit">
            <?php echo csrf_field(); ?>
            <?php if (isset($component)) { $__componentOriginal3d251db05a714ec6b2f220d3dccfef6d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d251db05a714ec6b2f220d3dccfef6d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-errors','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d251db05a714ec6b2f220d3dccfef6d)): ?>
<?php $attributes = $__attributesOriginal3d251db05a714ec6b2f220d3dccfef6d; ?>
<?php unset($__attributesOriginal3d251db05a714ec6b2f220d3dccfef6d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d251db05a714ec6b2f220d3dccfef6d)): ?>
<?php $component = $__componentOriginal3d251db05a714ec6b2f220d3dccfef6d; ?>
<?php unset($__componentOriginal3d251db05a714ec6b2f220d3dccfef6d); ?>
<?php endif; ?>
            <fieldset class="lg:row-span-2">
                <legend class="fieldset-title mb-5"><span class="step">1</span>Tour day and time</legend>
                <?php if (isset($component)) { $__componentOriginal26e98e8e5cc4164d9d54ab94efc26e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26e98e8e5cc4164d9d54ab94efc26e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.error','data' => ['for' => 'slot']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'slot']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal26e98e8e5cc4164d9d54ab94efc26e46)): ?>
<?php $attributes = $__attributesOriginal26e98e8e5cc4164d9d54ab94efc26e46; ?>
<?php unset($__attributesOriginal26e98e8e5cc4164d9d54ab94efc26e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal26e98e8e5cc4164d9d54ab94efc26e46)): ?>
<?php $component = $__componentOriginal26e98e8e5cc4164d9d54ab94efc26e46; ?>
<?php unset($__componentOriginal26e98e8e5cc4164d9d54ab94efc26e46); ?>
<?php endif; ?>
                <?php if($grid === []): ?>
                    <p class="panel p-6">There are no tours open for booking right now. Please <a class="text-link" href="<?php echo e(route('contact')); ?>">contact us</a>.</p>
                <?php endif; ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week => $days): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ($free = collect($days)->sum(fn ($d) => array_sum($d['slots']))); ?>
                        <details class="panel group" <?php if($week === $openWeek): ?> open <?php endif; ?>>
                            <summary class="flex min-h-14 cursor-pointer list-none items-center gap-3 px-5 py-3 font-semibold [&::-webkit-details-marker]:hidden">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'calendar','class' => 'h-5 w-5 flex-none text-accent-text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'calendar','class' => 'h-5 w-5 flex-none text-accent-text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                                <span>Week of <?php echo e(\Illuminate\Support\Carbon::parse($week)->format('j F')); ?></span>
                                <span class="ml-auto text-sm font-normal text-ink-3"><?php echo e($free > 0 ? $free.' places' : 'Fully booked'); ?></span>
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'chevron-down','class' => 'h-4 w-4 flex-none transition-transform group-open:rotate-180']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chevron-down','class' => 'h-4 w-4 flex-none transition-transform group-open:rotate-180']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                            </summary>
                            <div class="border-t border-line px-5 pb-2">
                                <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="slot-day py-4">
                                        <p class="font-display text-xl"><?php echo e($d['date']->format('l j F')); ?></p>
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <?php $__currentLoopData = $d['slots']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time => $left): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php ($value = $d['date']->toDateString().' '.$time); ?>
                                                <label class="choice slot" data-full="<?php echo e($left === 0 ? 'true' : 'false'); ?>">
                                                    <input type="radio" name="slot" value="<?php echo e($value); ?>" required <?php if($oldSlot === $value): echo 'checked'; endif; ?> <?php if($left === 0): echo 'disabled'; endif; ?>>
                                                    <span class="t"><?php echo e(\App\Support\Tours::label($time)); ?></span>
                                                    <span class="left"><?php echo e($left === 0 ? 'Full' : ($left === 1 ? '1 place left' : $left.' places left')); ?></span>
                                                </label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </details>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </fieldset>

            <div class="space-y-12">
                <fieldset class="space-y-5">
                    <legend class="fieldset-title mb-5"><span class="step">2</span>Your party</legend>
                    <div class="grid grid-cols-2 gap-4">
                        <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'adults','label' => 'Adults','type' => 'number','required' => true,'min' => '1','max' => $maxParty,'value' => 1,'inputmode' => 'numeric']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'adults','label' => 'Adults','type' => 'number','required' => true,'min' => '1','max' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($maxParty),'value' => 1,'inputmode' => 'numeric']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $attributes = $__attributesOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $component = $__componentOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__componentOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'children','label' => 'Under 18','type' => 'number','min' => '0','max' => $maxParty,'value' => 0,'inputmode' => 'numeric','hint' => 'No tasting.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'children','label' => 'Under 18','type' => 'number','min' => '0','max' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($maxParty),'value' => 0,'inputmode' => 'numeric','hint' => 'No tasting.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $attributes = $__attributesOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $component = $__componentOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__componentOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
                    </div>
                    <?php if (isset($component)) { $__componentOriginaled2cde6083938c436304f332ba96bb7c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled2cde6083938c436304f332ba96bb7c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.select','data' => ['name' => 'group_type','label' => 'Who is coming?','options' => gdl('tours.group_types'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'group_type','label' => 'Who is coming?','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(gdl('tours.group_types')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $attributes = $__attributesOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__attributesOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled2cde6083938c436304f332ba96bb7c)): ?>
<?php $component = $__componentOriginaled2cde6083938c436304f332ba96bb7c; ?>
<?php unset($__componentOriginaled2cde6083938c436304f332ba96bb7c); ?>
<?php endif; ?>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'country','label' => 'Country you live in','optional' => true,'maxlength' => '80','autocomplete' => 'country-name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'country','label' => 'Country you live in','optional' => true,'maxlength' => '80','autocomplete' => 'country-name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $attributes = $__attributesOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $component = $__componentOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__componentOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'staying','label' => 'Staying at','optional' => true,'maxlength' => '120','hint' => 'Hotel, villa or ship.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'staying','label' => 'Staying at','optional' => true,'maxlength' => '120','hint' => 'Hotel, villa or ship.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $attributes = $__attributesOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $component = $__componentOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__componentOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
                    </div>
                    <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'access','label' => 'Access needs','type' => 'textarea','optional' => true,'maxlength' => '500','rows' => '2','hint' => 'Tell us if anyone needs step-free access or a seat.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'access','label' => 'Access needs','type' => 'textarea','optional' => true,'maxlength' => '500','rows' => '2','hint' => 'Tell us if anyone needs step-free access or a seat.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $attributes = $__attributesOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $component = $__componentOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__componentOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
                </fieldset>
                <?php if (isset($component)) { $__componentOriginalbb1209e37896c727d4c623f730746632 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb1209e37896c727d4c623f730746632 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.contact-fields','data' => ['step' => 3,'emailHint' => 'We email your booking and reference here.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('contact-fields'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['step' => 3,'email-hint' => 'We email your booking and reference here.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb1209e37896c727d4c623f730746632)): ?>
<?php $attributes = $__attributesOriginalbb1209e37896c727d4c623f730746632; ?>
<?php unset($__attributesOriginalbb1209e37896c727d4c623f730746632); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb1209e37896c727d4c623f730746632)): ?>
<?php $component = $__componentOriginalbb1209e37896c727d4c623f730746632; ?>
<?php unset($__componentOriginalbb1209e37896c727d4c623f730746632); ?>
<?php endif; ?>
                <div>
                    <?php if (isset($component)) { $__componentOriginalae4c123bc9806121d87d234de2f27a3b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae4c123bc9806121d87d234de2f27a3b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.field','data' => ['name' => 'message','label' => 'Anything else?','type' => 'textarea','optional' => true,'maxlength' => '1000','rows' => '3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'message','label' => 'Anything else?','type' => 'textarea','optional' => true,'maxlength' => '1000','rows' => '3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $attributes = $__attributesOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__attributesOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae4c123bc9806121d87d234de2f27a3b)): ?>
<?php $component = $__componentOriginalae4c123bc9806121d87d234de2f27a3b; ?>
<?php unset($__componentOriginalae4c123bc9806121d87d234de2f27a3b); ?>
<?php endif; ?>
                    <div class="mt-6"><?php if (isset($component)) { $__componentOriginal115b46fcdf6e9400520dc8007e7b99a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.submit','data' => ['label' => 'Book my places']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Book my places']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1)): ?>
<?php $attributes = $__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1; ?>
<?php unset($__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal115b46fcdf6e9400520dc8007e7b99a1)): ?>
<?php $component = $__componentOriginal115b46fcdf6e9400520dc8007e7b99a1; ?>
<?php unset($__componentOriginal115b46fcdf6e9400520dc8007e7b99a1); ?>
<?php endif; ?></div>
                    <p class="mt-4 text-sm text-ink-3">Under-18s are welcome on the tour but cannot take part in the tasting. By booking you accept our <a class="text-link" href="<?php echo e(route('privacy')); ?>">privacy notice</a>.</p>
                </div>
            </div>
        </form>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/pages/tours.blade.php ENDPATH**/ ?>