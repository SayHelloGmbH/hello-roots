<?php
if (!empty(get_the_terms(get_the_ID(), 'post_tag'))) :
	?>
	<div class="c-taxonomy c-taxonomy--post_tag">
		<?php
		the_terms(
			get_the_ID(),
			'post_tag',
			'<ul class="c-taxonomy__entries c-taxonomy__entries--post_tag"><li class="c-taxonomy__entry c-taxonomy__entry--post_tag">',
			'</li><li class="c-taxonomy__entry c-taxonomy__entry--post_tag">',
			'</li></ul>'
		);
		?>
	</div>
<?php endif;
