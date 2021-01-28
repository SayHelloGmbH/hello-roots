<?php

get_header();

echo '<h1>PREACT</h1>';
echo '<div id="preact"></div>';

get_template_part('partials/archive', get_post_type());

get_footer();
