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

					<form id="send_cv" action="<?php echo site_url('process?action=trabalhe_conosco') ?>" action="POST">
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

					<div id="uploader_cv" style="border:1px solid red;">
						<h2>Upload CV</h2>
						<div id="hiddenvalue"></div>
						
						<div id="filelist"></div>
						<div id="status" style="background-color:#fff;">%</div>

						<div id="abrir_btn"><a href="#">Escolher arquivo</a></div>
						<div id="upload_btn"><a href="#">Upload</a></div>

						<div id="preview"></div>
					</div>
					<input type="submit" name="enviar" value="Submit">
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
$(document).ready(function($) {

	$('#status').hide();
	$('#upload_btn').hide();

	$("#send_cv").submit(function(event) {
		event.preventDefault(); 
		var $form 					= $( this );
		var url 					= $form.attr( 'action' );
		var nome_completo			= $form.find( 'input[name="nome_completo"]').val();
		var endereco				= $form.find( 'input[name="endereco"]').val();
		var cidade_bairro			= $form.find( 'input[name="cidade_bairro"]').val();
		var area_interesse			= $form.find( 'select[name="area_interesse"]').val();
		var doc						= $form.find( 'input[name="doc"]').val();

		$.post( url, { 
			nome_completo: nome_completo,
			endereco: endereco,
			cidade_bairro: cidade_bairro,
			area_interesse: area_interesse,
			doc: doc,
			}, retorno);		
			
			$form.find( 'input[name="enviar"]' ).attr("disabled", true);

	});

	var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		browse_button : 'abrir_btn',
		container : 'uploader_cv',
		max_file_size : '20mb',
		chunk_size: '1mb',
		url : '<?php echo get_template_directory_uri(); ?>/plupload/upload.php',
		// Flash settings
		flash_swf_url : '<?php echo get_template_directory_uri(); ?>/plupload/js/Moxie.swf',
		// Silverlight settings
		silverlight_xap_url : '<?php echo get_template_directory_uri(); ?>/plupload/js/Moxie.xap',
		// Specify what files to browse for
		filters : [
			/*{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Allowed files", extensions : "jpg,gif,png,bmp,jpeg,tif,tiff"},
			{title : "Zip files", extensions : "zip"}
			{title: "Excel Files", extensions: "xls,xlsx,csv"},
			{title : "Words files", extensions : "doc,docx"},
			{title : "PDF files", extensions : "pdf"},
			{title : "Compressed files", extensions : "zip,tar,gz"}*/
		],
		resize : {width : 942, quality : 90}
	});

	uploader.bind('Init', function(up, params) {
		$('#filelist').html("");
	});

	$('#upload_btn').click(function(e) {
		$("#status").show();
		uploader.start();
		e.preventDefault();
	});

	uploader.bind('FilesAdded', function(up, files) {
		$("#upload_btn").show();
		$.each(files, function(i, file) {
			$('#filelist').html(
			'<span style="margin-left:5px;font-size:24px;line-height:44px;">' + file.name + ' (' + plupload.formatSize(file.size) + ') </span>');
		});

		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('UploadProgress', function(up, file) {
		$('#status').html(file.percent + "%");
	});

	uploader.bind('Error', function(up, err) {
		$('#filelist').append("<div>Error: " + err.code + ", Message: " + err.message +(err.file ? ", File: " + err.file.name : "") +"</div>");
		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('FileUploaded', function(up, file, response) {
		var res = JSON.parse(response.response);
		$("#preview").show();
		$("#preview").html("<?php bloginfo('wpurl');?>/wp-content/uploads/" + res.result );

		$("#hiddenvalue").html("<input type=\'hidden\' id=\'" + res.result + "\' name=\'doc\' value=\'" + res.result + "\'>");
		$("#upload_btn").hide();
		$('#status').hide();
		$("#loading_gude").hide();
	});
	
	uploader.init();
});

function retorno( data ) {
	
	var $form = $( "#send_cv" );
	$form.find( 'input[name="enviar"]' ).attr("disabled", false);
	
	var js = $.parseJSON(data);
	if(js.ok){
		alert(js.msg)
		window.location = js.redirect;
	}else{
		alert(js.error);
	};
}

</script>

<?php get_footer(); ?>