<?php
/* Template Name: Page Left Sidebar */
get_header();
the_post();
?>
<!-- Page Heading -->
<section class="page-heading">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h1><?php the_title(); ?></h1>
			</div>
			<div class="col-md-6">
				<?php fortune_breadcrumbs(); ?>
			</div>
		</div>
	</div>
</section>
<!-- Page Content -->
<section class="page-content">
  <div class="container">
  	<div class="row">
		<div class="content col-md-8 col-md-offset-1 col-md-push-3">
			<div class="title-accent">
			  <h3><?php the_title(); ?></h3>
			</div>
			<?php if(has_post_thumbnail()){ $img_class = array('class'=>'img_responsive'); ?>
			<figure class="alignleft"> <?php the_post_thumbnail('fortune_page_thumb', $img_class); ?> </figure>
			<?php } ?>
			<?php the_content(); ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
  </div>
</section>
<!-- Page Content / End -->
<?php get_footer(); ?>