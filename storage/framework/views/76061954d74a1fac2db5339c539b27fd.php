<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['tone' => 'auto', 'small' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['tone' => 'auto', 'small' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<span <?php echo e($attributes->merge(['class' => 'inline-flex flex-col leading-none '.($tone === 'light' ? 'text-white' : 'text-ink')])); ?>>
    <span class="font-display whitespace-nowrap <?php echo e($small ? 'text-[1.3rem]' : 'text-[1.45rem] min-[400px]:text-[1.7rem]'); ?> tracking-[0.005em]">Clarke's Court</span>
    <span class="mt-1 flex items-center gap-1.5 whitespace-nowrap border-t pt-1 text-[0.625rem] font-bold uppercase tracking-[0.2em] <?php echo e($tone === 'light' ? 'border-accent/70 text-white/75' : 'border-cask text-ink-3'); ?>">Grenada Distillers<span aria-hidden="true">·</span>1937</span>
</span>
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/components/logo.blade.php ENDPATH**/ ?>