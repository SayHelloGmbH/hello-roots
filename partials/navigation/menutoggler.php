<?php

$data = $data ?? [];

if (!isset($data['target_id'])) {
	$data['target_id'] = 'mobile-menu';
}

?><button class=" o-menutoggler" aria-controls="<?php echo $data['target_id'];?>" aria-expanded="false">
	<span class="o-menutoggler__line"></span>
	<span class="o-menutoggler__line"></span>
	<span class="o-menutoggler__line"></span>
</button>
