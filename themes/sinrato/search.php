<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Sinrato_Theme
 * @since Sinrato 1.0
 */
$sinrato_opt = get_option( 'sinrato_opt' );
get_header();
$sinrato_bloglayout = 'sidebar';
if(isset($sinrato_opt['blog_layout']) && $sinrato_opt['blog_layout']!=''){
	$sinrato_bloglayout = $sinrato_opt['blog_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$sinrato_bloglayout = $_GET['layout'];
}
$sinrato_blogsidebar = 'right';
if(isset($sinrato_opt['sidebarblog_pos']) && $sinrato_opt['sidebarblog_pos']!=''){
	$sinrato_blogsidebar = $sinrato_opt['sidebarblog_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$sinrato_blogsidebar = $_GET['sidebar'];
}
if ( !is_active_sidebar( 'sidebar-1' ) )  {
	$sinrato_bloglayout = 'nosidebar';
}
$sinrato_blog_main_extra_class = NULl;
if($sinrato_blogsidebar=='left') {
	$sinrato_blog_main_extra_class = 'order-lg-last';
}
$main_column_class = NULL;
switch($sinrato_bloglayout) {
	case 'nosidebar':
		$sinrato_blogclass = 'blog-nosidebar';
		$sinrato_blogcolclass = 12;
		$sinrato_blogsidebar = 'none';
		Sinrato_Class::sinrato_post_thumbnail_size('sinrato-post-thumb');
		break;
	case 'largeimage':
		$sinrato_blogclass = 'blog-large';
		$sinrato_blogcolclass = 9;
		$main_column_class = 'main-column';
		Sinrato_Class::sinrato_post_thumbnail_size('sinrato-post-thumbwide');
		break;
	case 'grid':
		$sinrato_blogclass = 'grid';
		$sinrato_blogcolclass = 9;
		$main_column_class = 'main-column';
		Sinrato_Class::sinrato_post_thumbnail_size('sinrato-post-thumbwide');
		break;
	default:
		$sinrato_blogclass = 'blog-sidebar';
		$sinrato_blogcolclass = 9;
		$main_column_class = 'main-column';
		Sinrato_Class::sinrato_post_thumbnail_size('sinrato-post-thumb');
}
?>
<div class="main-container">
	<div class="breadcrumb-container">
		<div class="container">
			<?php Sinrato_Class::sinrato_breadcrumb(); ?>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12 <?php echo 'col-lg-'.$sinrato_blogcolclass; ?> <?php echo ''.$main_column_class; ?> <?php echo esc_attr($sinrato_blog_main_extra_class);?>">
				<header class="entry-header">
					<h2 class="entry-title"><?php printf( wp_kses(__( 'Search Results for: %s', 'sinrato' ), array('span'=>array())), '<span>' . get_search_query() . '</span>' ); ?></h2>
				</header>
				<div class="page-content blog-page blogs <?php echo esc_attr($sinrato_blogclass); if($sinrato_blogsidebar=='left') {echo ' left-sidebar'; } if($sinrato_blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php if ( have_posts() ) : ?>
						<div class="post-container">
							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', get_post_format() ); ?>
							<?php endwhile; ?>
						</div>
						<?php Sinrato_Class::sinrato_pagination(); ?>
					<?php else : ?>
						<article id="post-0" class="post no-results not-found">
							<header class="entry-header">
								<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'sinrato' ); ?></h1>
							</header>
							<div class="entry-content">
								<p><?php esc_html_e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'sinrato' ); ?></p>
								<?php get_search_form(); ?>
							</div><!-- .entry-content -->
						</article><!-- #post-0 -->
					<?php endif; ?>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<!-- brand logo -->
	<?php 
		if(isset($sinrato_opt['inner_brand']) && function_exists('sinrato_brands_shortcode') && shortcode_exists( 'ourbrands' ) ){
			if($sinrato_opt['inner_brand'] && isset($sinrato_opt['brand_logos'][0]) && $sinrato_opt['brand_logos'][0]['thumb']!=null) { ?>
				<div class="inner-brands">
					<div class="container">
						<?php if(isset($sinrato_opt['inner_brand_title']) && $sinrato_opt['inner_brand_title']!=''){ ?>
							<div class="heading-title style1 ">
								<h3><?php echo esc_html( $sinrato_opt['inner_brand_title'] ); ?></h3>
							</div>
						<?php } ?>
						<?php echo do_shortcode('[ourbrands]'); ?>
					</div>
				</div>
			<?php }
		}
	?>
	<!-- end brand logo --> 
</div>
<?php get_footer(); ?>