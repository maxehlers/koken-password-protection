<?php
	class pwSecuredAlbums extends KokenPlugin {

		function __construct(){
			$this->require_setup = true;
		    $this->register_shortcode('max_pw_form', 'max_render_form');
		    $this->register_shortcode('max_pw_result', 'max_render_result');
		    $this->register_hook('before_closing_body', 'max_add_scripts');
		}

		function max_render_form($attributes){
		    return '<form action="/storage/plugins/pw-secured-albums/secure/" method="POST" id="maxPWForm">
		        <input type="password" name="maxPw"><input type="submit" name="submit" value="Submit">
		    </form>';
		}

		function max_render_result($attributes){
		    return '<p class="maxProtectedAlbums"></p>';
		}

		function max_add_scripts(){
			echo '<script>
				    $(document).ready(function(){
				    	$("'.$this->data->navi_selector.'").append(\'<div class="maxProtectedAlbums"></div>\');
				        $(".maxProtectedAlbums").load("/storage/plugins/pw-secured-albums/secure/render.php");				        
				        if(window.location.hash == "#wrongPw"){$("#maxPWForm").append(\'<span style="color:red;">Wrong password</span>\');}
				    });
				</script>';
		}
	}
?>