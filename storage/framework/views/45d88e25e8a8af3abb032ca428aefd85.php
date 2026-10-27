<?php
    /** @var \App\Models\Lead $lead */
    use App\Enums\LeadType;
    $d = $lead->details ?? [];
    $rows = match ($lead->type) {
        LeadType::Tour => [
            'Tour' => $lead->visit_date ? $lead->visit_date->format('l j F Y').' at '.\App\Support\Tours::label((string) $lead->visit_time) : null,
            'Adults (18+)' => $d['adults'] ?? null,
            'Under 18' => $d['children'] ?? null,
            'Party' => gdl('tours.group_types.'.($d['group_type'] ?? '')),
            'Staying at' => $d['staying'] ?? null,
            'Visiting from' => $lead->country,
            'Access needs' => $d['access'] ?? null,
        ],
        LeadType::Trade => [
            'Company' => $lead->organisation,
            'Job title' => $d['job_title'] ?? null,
            'Country' => $lead->country,
            'Business' => gdl('trade.business_types.'.($d['business_type'] ?? '')),
            'Markets' => $d['markets'] ?? null,
            'Interested in' => $lead->productNames() ?: 'Not specified',
            'First order' => gdl('trade.volumes.'.($d['volume'] ?? '')),
            'Import licence' => ['yes' => 'Yes', 'in_progress' => 'Applying', 'no' => 'No'][$d['licensed'] ?? ''] ?? null,
            'Website' => $d['company_site'] ?? null,
        ],
        LeadType::Application => [
            'Vacancy' => $lead->jobPosting->title ?? 'General application',
            'Parish' => gdl('parishes.'.($d['parish'] ?? '')),
            'Experience' => gdl('careers.experience.'.($d['experience'] ?? '')),
            'Highest qualification' => gdl('careers.qualifications.'.($d['qualification'] ?? '')),
            'Current or last job' => $d['current_role'] ?? null,
            'Can start' => isset($d['available_from']) ? \Illuminate\Support\Carbon::parse($d['available_from'])->format('j M Y') : 'Not stated',
            'Consent to keep for 12 months' => $lead->consented_at?->format('j M Y H:i'),
        ],
        LeadType::Enquiry => [
            'Topic' => gdl('enquiry_topics.'.($d['topic'] ?? '')),
            'Country' => $lead->country,
        ],
    };
    $replyLabel = match ($lead->type) {
        LeadType::Tour => 'I confirmed the booking with the guest',
        LeadType::Application => 'I acknowledged the application',
        default => 'I replied to them',
    };
    $waText = 'Hello '.strtok($lead->name, ' ').", this is Clarke's Court about your ".strtolower($lead->type->label()).' ('.$lead->reference.').';
?>
<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => $lead->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lead->name)]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($neighbours['prev']): ?><a href="<?php echo e(route('admin.leads.show', $neighbours['prev'])); ?>" class="a-btn a-btn-ghost w-11 px-0" aria-label="Previous request in the inbox"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'chevron-left','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chevron-left','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a><?php endif; ?>
        <?php if($neighbours['next']): ?><a href="<?php echo e(route('admin.leads.show', $neighbours['next'])); ?>" class="a-btn a-btn-ghost w-11 px-0" aria-label="Next request in the inbox"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'chevron-right','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chevron-right','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></a><?php endif; ?>
        <a href="<?php echo e(route('admin.leads.index')); ?>" class="a-btn a-btn-ghost">Back to inbox</a>
     <?php $__env->endSlot(); ?>

    <div class="flex flex-wrap items-center gap-2 text-sm">
        <span class="chip num" data-tone="neutral"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $lead->type->icon()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lead->type->icon())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?><?php echo e($lead->type->label()); ?> · <?php echo e($lead->reference); ?></span>
        <?php if (isset($component)) { $__componentOriginal51ed764111e345fc11534f121cfeb451 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51ed764111e345fc11534f121cfeb451 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status','data' => ['status' => $lead->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lead->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $attributes = $__attributesOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__attributesOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $component = $__componentOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__componentOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
        <?php if($lead->isOverdue()): ?><span class="chip" data-tone="critical"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Waiting <?php echo e($lead->created_at->diffForHumans(null, true)); ?></span><?php endif; ?>
        <span class="text-ink-3">Received <?php echo e($lead->created_at->format('D j M Y, H:i')); ?></span>
    </div>

    <div class="mt-5 grid gap-6 xl:grid-cols-[1.4fr_1fr]">
        <div class="min-w-0 space-y-6">
            <section class="a-card p-5" aria-labelledby="contact-title">
                <h2 id="contact-title" class="font-semibold">Contact</h2>
                <div class="mt-3 grid gap-4 sm:grid-cols-2">
                    <div class="min-w-0">
                        <p class="break-words text-lg font-semibold"><?php echo e($lead->email); ?></p>
                        <?php if($lead->phone): ?><p class="num text-ink-2"><?php echo e(format_phone($lead->phone)); ?></p><?php endif; ?>
                        <p class="mt-1 text-sm text-ink-3">Prefers <?php echo e(['phone' => 'a phone call', 'whatsapp' => 'WhatsApp', 'email' => 'email'][$lead->contact_pref] ?? $lead->contact_pref); ?></p>
                    </div>
                    <div class="flex flex-wrap content-start gap-2">
                        <a href="mailto:<?php echo e($lead->email); ?>?subject=<?php echo e(rawurlencode("Clarke's Court: ".$lead->reference)); ?>" class="a-btn a-btn-primary"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'mail','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'mail','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Email</a>
                        <?php if($lead->phone): ?>
                            <a href="<?php echo e(tel_href($lead->phone)); ?>" class="a-btn a-btn-ghost"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'phone','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'phone','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Call</a>
                            <a href="<?php echo e(wa_href($lead->phone, $waText)); ?>" class="a-btn a-btn-ghost" target="_blank" rel="noopener"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'whatsapp','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'whatsapp','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>WhatsApp</a>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <section class="a-card p-5" aria-labelledby="req-title">
                <h2 id="req-title" class="font-semibold"><?php echo e($lead->type->label()); ?></h2>
                <?php if (isset($component)) { $__componentOriginal3e4ed714fb881ce08c27f12e285053ac = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e4ed714fb881ce08c27f12e285053ac = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.spec','data' => ['class' => 'mt-3 max-w-xl','rows' => $rows]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('spec'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-3 max-w-xl','rows' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rows)]); ?>
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
                <?php if($lead->message): ?>
                    <blockquote class="mt-4 whitespace-pre-line rounded-lg bg-surface-2 p-4"><?php echo e($lead->message); ?></blockquote>
                <?php endif; ?>
                <?php if($lead->source_url): ?><p class="mt-3 truncate text-xs text-ink-3">From <?php echo e($lead->source_url); ?></p><?php endif; ?>
            </section>

            <?php if($lead->files->isNotEmpty()): ?>
                <section class="a-card p-5" aria-labelledby="files-title">
                    <h2 id="files-title" class="font-semibold">Uploads</h2>
                    <ul class="mt-3 divide-y divide-line">
                        <?php $__currentLoopData = $lead->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex flex-wrap items-center gap-3 py-3">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => $f->isImage() ? 'image' : 'file','class' => 'h-5 w-5 text-ink-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($f->isImage() ? 'image' : 'file'),'class' => 'h-5 w-5 text-ink-3']); ?>
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
                                <div class="min-w-0 flex-1"><p class="font-semibold"><?php echo e($f->label()); ?></p><p class="truncate text-sm text-ink-3"><?php echo e($f->original_name); ?> · <?php echo e(number_format($f->size / 1024)); ?> KB</p></div>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('openFile', [$lead, $f])): ?>
                                    <a href="<?php echo e(route('admin.leads.file', [$lead, $f])); ?>" class="a-btn a-btn-ghost"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'download','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'download','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Download</a>
                                <?php else: ?>
                                    <span class="chip" data-tone="muted"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'lock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'lock']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>HR only</span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php if($lead->type === LeadType::Application): ?><p class="mt-2 text-sm text-ink-3">Every download is recorded on the timeline.</p><?php endif; ?>
                </section>
            <?php endif; ?>
        </div>

        <div class="min-w-0 space-y-6">
            <section class="a-card p-5" aria-labelledby="manage-title">
                <h2 id="manage-title" class="font-semibold">Manage</h2>
                <form method="POST" action="<?php echo e(route('admin.leads.update', $lead)); ?>" class="mt-3 space-y-4">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <div><label for="status" class="mb-1 block text-sm font-semibold">Status</label>
                        <select id="status" name="status" class="a-input w-full"><?php $__currentLoopData = $lead->type->statuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s->value); ?>" <?php if($lead->status === $s): echo 'selected'; endif; ?>><?php echo e($s->label()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                        <?php if($lead->type === LeadType::Tour): ?><p class="mt-1 text-xs text-ink-3">Cancelling frees the guests' places for others.</p><?php endif; ?>
                    </div>
                    <div><label for="assigned_to" class="mb-1 block text-sm font-semibold">Assigned to</label>
                        <select id="assigned_to" name="assigned_to" class="a-input w-full"><option value="">Nobody</option><?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($u->id); ?>" <?php if($lead->assigned_to === $u->id): echo 'selected'; endif; ?>><?php echo e($u->name); ?> (<?php echo e($u->role->label()); ?>)</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                    <button class="a-btn a-btn-primary w-full">Save</button>
                </form>
            </section>

            <section id="timeline" class="a-card p-5" aria-labelledby="tl-title">
                <h2 id="tl-title" class="font-semibold">Timeline</h2>
                <form method="POST" action="<?php echo e(route('admin.leads.note', $lead)); ?>" class="mt-3 space-y-2">
                    <?php echo csrf_field(); ?>
                    <label for="body" class="sr-only">Add a note</label>
                    <textarea id="body" name="body" rows="3" class="a-input w-full" placeholder="Emailed, called, sent samples…" required maxlength="3000"></textarea>
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <?php if($lead->status === \App\Enums\LeadStatus::New): ?>
                            <label class="flex min-h-11 items-center gap-2 text-sm"><input type="checkbox" name="contacted" value="1" class="h-5 w-5" checked><?php echo e($replyLabel); ?></label>
                        <?php endif; ?>
                        <button class="a-btn a-btn-primary ml-auto">Add note</button>
                    </div>
                </form>
                <ol class="mt-5 space-y-4 border-l-2 border-line pl-5">
                    <?php $__currentLoopData = $lead->notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="relative">
                            <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['absolute -left-[1.6rem] top-1.5 h-2.5 w-2.5 rounded-full', 'bg-accent' => $n->kind === 'note', 'bg-[color:var(--series-1)]' => in_array($n->kind, ['status', 'assign'], true), 'bg-line-strong' => $n->kind === 'system']); ?>" aria-hidden="true"></span>
                            <p class="<?php echo \Illuminate\Support\Arr::toCssClasses(['whitespace-pre-line break-words', 'text-ink-2' => $n->kind !== 'note']); ?>"><?php echo e($n->body); ?></p>
                            <p class="mt-0.5 text-xs text-ink-3"><?php echo e($n->user->name ?? 'Website'); ?> · <?php echo e($n->created_at->format('j M, H:i')); ?></p>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </section>
        </div>
    </div>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/admin/leads/show.blade.php ENDPATH**/ ?>