<?php global $options;
	foreach ($options as $value) {
		if ((isset($value['id'])) && (isset($value['std']))) {
			if (FALSE === get_option( $value['id'])) { $$value['id'] = $value['std']; } else { $$value['id'] = get_option( $value['id'] ); }
		}
	}
?>
<?php $template_file = get_post_meta( get_the_ID(), '_wp_page_template', TRUE ); ?>
<?php if ( has_nav_menu( 'primary' ) ) : ?>
<header id="menu-top" class="home-top <?php if (!get_option('fw_nav_menu')){ ?>hide-menu<?php }?>">
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<div id="mini-logo">
					<a href="#page-1" id="mini-link">
						<img src="<?php echo $fw_logo_mini; ?>" alt="<?php bloginfo('name') ?>"/>
					</a>
				</div>
				<div id="btn-menu-container">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="nav-collapse collapse">
					<ul class="nav top-nav" id="nav-menu">
						<?php wp_nav_menu( array( 'theme_location' => 'primary','items_wrap' => '%3$s','container' => '' ) ); ?>
				   </ul>
				</div>
			</div>
		</div>
	</nav>
</header>
<?php endif; ?>
