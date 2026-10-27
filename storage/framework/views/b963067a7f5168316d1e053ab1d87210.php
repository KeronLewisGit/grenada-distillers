<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['abv', 'small' => false]));

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

foreach (array_filter((['abv', 'small' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<span <?php echo e($attributes->class(['seal', 'sm' => $small])); ?> role="img" aria-label="<?php echo e($abv); ?>% alcohol by volume"><span aria-hidden="true"><b><?php echo e($abv); ?><span class="text-[0.6em] align-top">%</span></b><small>ABV</small></span></span>
<?php /**PATH /Users/keronlewis/grenada-distillers/resources/views/components/seal.blade.php ENDPATH**/ ?>