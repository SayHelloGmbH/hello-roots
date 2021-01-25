<?php

$args = $args ?? [];

if (!isset($args['target_id'])) {
	$args['target_id'] = 'mobile-menu';
}

?><button class="o-menutoggler" aria-controls="<?php echo $args['target_id']; ?>" aria-expanded="false">
	<span class="o-menutoggler__line"></span>
	<span class="o-menutoggler__line"></span>
	<span class="o-menutoggler__line"></span>
</button>
