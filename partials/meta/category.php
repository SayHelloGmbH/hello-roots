<?php
if (!empty(get_the_terms(get_the_ID(), 'category'))) :
	?>
	<div class="c-taxonomy c-taxonomy--category">
		<h3 class="c-taxonomy__title"><?php _ex('Kategorien', 'Taxonomy title (singular view)', 'sht');?></h3>
		<?php
		the_terms(
			get_the_ID(),
			'category',
			'<ul class="c-taxonomy__entries c-taxonomy__entries--category"><li class="c-taxonomy__entry c-taxonomy__entry--category">',
			'</li><li class="c-taxonomy__entry c-taxonomy__entry--category">',
			'</li></ul>'
		);
		?>
	</div>
<?php endif;
