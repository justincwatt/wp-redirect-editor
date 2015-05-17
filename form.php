<div class='wrap'>
	<?php screen_icon(); ?>
	<h2>Redirect Editor</h2>
	
	<form method='post' name='redirect-editor' >

		<?php wp_nonce_field( 'redirect-editor' ); ?>
		
		<p>Enter each redirect rule in the following format, starting with the 
		relative path of the URL to match, followed by the absolute URL of the 
		destination to redirect to, separated by a space. Each redirect should 
		be on its own line. Blank lines and lines that start with # (hash) are 
		ignored and can be used for spacing and comments.</p>

		<p><pre><code>/2012/09/old-post/ http://www.example.com/2012/09/new-post/</code></pre></p>

		<p><textarea name='redirects' style='width:100%;height:15em;white-space:pre;font-family:Consolas,Monaco,monospace;'><?php print esc_textarea( $redirects ); ?></textarea></p>

		<p><button type='submit' name='function' class='button button-primary' value='redirect-editor-save'>Save</button></p>

	</form>
</div>
