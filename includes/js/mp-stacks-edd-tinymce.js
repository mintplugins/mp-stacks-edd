/* global tinymce - Use this after WordPress 3.9 when they mess everything up.

global tinymce - P.S. TinyMCE is by far the WORST part of WordPress. Possibly the worst part of the internet as a whole. Maybe the entire universe. So now that you know that, you get to look at crappy code related to it: */

tinymce.PluginManager.add('mpstacksedd', function( editor ) {
	
	function replaceMPStackEddShortcodes( content ) {
		return content.replace( /\[mp_stacks_edd_purchase_link([^\]]*)\]/g, function( match ) {
			return html( 'mp-stacks-edd', match );
		});
	}

	function html( cls, data ) {
		data = window.encodeURIComponent( data );
		return '<img src="' + tinymce.Env.transparentSrc + '" class="mceItem ' + cls + '" ' +
			'data-wp-media="' + data + '" data-mce-resize="false" data-mce-placeholder="1" />';
	}


	// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('...');
	editor.addCommand('MP_Stacks_Edd', function() {
							
		jQuery(document).ready(function($){
			
			//Set the content of the active editor
			tinyMCE.activeEditor.setContent(
				//To be the replaced content from the _do_stack function in this class
				t._do_stack(tinyMCE.activeEditor.getContent())
			);
							 
		});
		
	});

	editor.on( 'BeforeSetContent', function( event ) {
			
		event.content = replaceMPStackEddShortcodes( event.content );		
		
	});
});