<?php if (isset($component)) { $__componentOriginalfefb4fd9b7004fa65f70c415ac76903e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefb4fd9b7004fa65f70c415ac76903e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.site','data' => ['title' => 'Privacy notice','description' => 'How Grenada Distillers handles the details you send through this website.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.site'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Privacy notice','description' => 'How Grenada Distillers handles the details you send through this website.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Privacy notice','lead' => 'What we collect through this website, why, who sees it and how long we keep it.','no' => '§','label' => 'Privacy','photo' => 'casks']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Privacy notice','lead' => 'What we collect through this website, why, who sees it and how long we keep it.','no' => '§','label' => 'Privacy','photo' => 'casks']); ?>
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
        <div class="prose-copy measure text-ink-2">
            <p><strong class="text-ink">Draft for review by Grenada Distillers' legal adviser before launch.</strong> Last updated <?php echo e(now()->format('j F Y')); ?>.</p>
            <h2>Who we are</h2>
            <p><?php echo e(gdl('name')); ?>, <?php echo e(gdl('address.street')); ?>, <?php echo e(gdl('address.locality')); ?>, <?php echo e(gdl('address.parish')); ?>, Grenada. Email <a href="mailto:<?php echo e(gdl('email')); ?>"><?php echo e(gdl('email')); ?></a><?php if(gdl('phone')): ?>, telephone <?php echo e(format_phone(gdl('phone'))); ?><?php endif; ?>.</p>
            <h2>What we collect</h2>
            <ul>
                <li>Your name, email address, phone number and how you prefer to be contacted, on every form.</li>
                <li>Tour bookings: the day and time, the number of adults and under-18s in your party, where you are staying and any access needs you tell us about.</li>
                <li>Trade and export enquiries: your company, country, type of business, the markets you serve, the rums you are interested in and an estimate of your first order.</li>
                <li>Job applications: the vacancy, your parish, experience, qualifications, start date and the CV you upload.</li>
            </ul>
            <h2>Why we use it</h2>
            <p>To answer your request: confirm a tour, reply to a trade enquiry, consider your application or answer your message. We don't sell your details or use them for unrelated marketing.</p>
            <h2>Who can see it</h2>
            <p>Grenada Distillers staff who handle your type of request: the tours team sees tour bookings, the trade team sees trade enquiries, and only Human Resources and administrators can see job applications. CVs are stored privately, outside the public website, and every time one is opened it is recorded.</p>
            <h2>How long we keep it</h2>
            <p>Tour bookings and enquiries for up to two years; trade enquiries for as long as we are in discussion and two years after; job applications for twelve months, after which the CV is deleted. You can ask us to delete your details sooner.</p>
            <h2>Your choices</h2>
            <p>You can ask for a copy of the details we hold about you, ask us to correct or delete them, or withdraw an application. Email us using the address above.</p>
            <h2>Cookies</h2>
            <p>This site uses only the cookies it needs: one that remembers you confirmed your age (for the browser session, or 30 days if you ask), one that sends forms securely, and one that keeps staff signed in. There are no advertising or tracking cookies. Your light or dark theme choice is kept in your browser.</p>
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
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/pages/privacy.blade.php ENDPATH**/ ?>