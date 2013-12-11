<?php get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>">
					<header>
						<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					<form id="send_cv" name="input" action="html_form_action.asp" method="get">
					Nome Completo:<br />
					<input type="text" name="nome_completo"><br />
					Endereço:<br />
					<input type="text" name="endereco"><br />
					Cidade/Bairro:<br />
					<input type="text" name="cidade_bairro"><br />
					Área de interesse:<br />
					<select name="area_interesse">
					 	<option value="Área de interesse" selected="">Área de interesse</option>
						<option value="Auxiliar Administrativo">Auxiliar Administrativo</option>
						<option value="Depto Contábil">Depto Contábil</option>
						<option value="Depto Fiscal">Depto Fiscal</option>
						<option value="Depto Pessoal">Depto Pessoal</option>
						<option value="Depto Legal">Depto Legal</option>
						<option value="Comercial">Comercial</option>
					</select> <br />

					<div id="uploader">
						<p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
					</div>
					<input type="submit" value="Submit">
					</form> 
				
				</article><!-- #post -->
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<!-- Load the queue CSS -->
<style type="text/css">@import url(<?php echo get_template_directory_uri(); ?>/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css);</style>
<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<script>
// Convert divs to queue widgets when the DOM is ready
$(function() {
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'gears,flash,silverlight,browserplus,html5',
		url : '<?php echo get_template_directory_uri(); ?>/plupload/upload.php',
		max_file_size : '20mb',
		chunk_size : '1mb',
		unique_names : true,

		// Resize images on clientside if we can
		resize : {width : 320, height : 240, quality : 90},

		// Specify what files to browse for
		filters : [
			/*{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Allowed files", extensions : "jpg,gif,png,bmp,jpeg,tif,tiff"},
			{title : "Zip files", extensions : "zip"}*/
			{title: "Excel Files", extensions: "xls,xlsx,csv"},
			{title : "Words files", extensions : "doc,docx"},
			{title : "PDF files", extensions : "pdf"},
			{title : "Compressed files", extensions : "zip,tar,gz"},
		],

		// Flash settings
		flash_swf_url : '<?php echo get_template_directory_uri(); ?>/plupload/js/Moxie.swf',

		// Silverlight settings
		silverlight_xap_url : '<?php echo get_template_directory_uri(); ?>/plupload/js/Moxie.xap'
	});

	// Client side form validation
	$('form').submit(function(e) {
        var uploader = $('#uploader').pluploadQueue();

        // Files in queue upload them first
        if (uploader.files.length > 0) {
            // When all files are uploaded submit form
            uploader.bind('StateChanged', function() {
                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $('form')[0].submit();
                }
            });
                
            uploader.start();
        } else {
            alert('You must queue at least one file.');
        }

        return false;
    });
});
</script>

<?php get_footer(); ?>