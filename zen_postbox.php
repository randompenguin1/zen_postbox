<?php
/**
 * Name: Zen Postbox
 * Description: Adds a button to editor to insert color background. Called Zen to load last.
 * Version: 1.0
 * Author: Random Penguin <https://gitlab.com/randompenguin>
 */

use Friendica\App;
use Friendica\Core\Hook;
use Friendica\DI;

function zen_postbox_install()
{
	//Register hooks
	Hook::register('jot_tool', 'addon/zen_postbox/zen_postbox.php', 'zen_postbox_jot_tool');
}

function zen_postbox_jot_tool(string &$body)
{
	
	$labels = [
		'Black',
		'Red',
		'Green',
		'Blue',
		'Orange',
		'Purple',
		'Forest',
		'Ocean',
		'Pink',
		'Salmon',
		'Dark Gray',
		'Minty',
		'Mint Gray',
		'Red-Blue',
		'Violets',
		'Gray-Black',
		'Teal Blue',
		'Green Gray',
		'Teal Gray',
		'Blue Gray',
		'Lavender Gray',
		'Sunset',
		'Sherbert',
	];

	$texts = [
		'[class=postbox-black]',
		'[class=postbox-red]',
		'[class=postbox-green]',
		'[class=postbox-blue]',
		'[class=postbox-orange]',
		'[class=postbox-purple]',
		'[class=postbox-forest]',
		'[class=postbox-ocean]',
		'[class=postbox-pink]',
		'[class=postbox-salmon]',
		'[class=postbox-darkgray]',
		'[class=postbox-minty]',
		'[class=postbox-mintgray]',
		'[class=postbox-redblue]',
		'[class=postbox-violets]',
		'[class=postbox-grayblack]',
		'[class=postbox-tealblue]',
		'[class=postbox-greengray]',
		'[class=postbox-tealgray]',
		'[class=postbox-bluegray]',
		'[class=postbox-lavendergray]',
		'[class=postbox-sunset]',
		'[class=postbox-sherbert]',
	];

	$icons = [
		'<div class="pick-postbox postbox-black"></div>',
		'<div class="pick-postbox postbox-red"></div>',
		'<div class="pick-postbox postbox-green"></div>',
		'<div class="pick-postbox postbox-blue"></div>',
		'<div class="pick-postbox postbox-orange"></div>',
		'<div class="pick-postbox postbox-purple"></div>',
		'<div class="pick-postbox postbox-forest"></div>',
		'<div class="pick-postbox postbox-ocean"></div>',
		'<div class="pick-postbox postbox-pink"></div>',
		'<div class="pick-postbox postbox-salmon"></div>',
		'<div class="pick-postbox postbox-darkgray"></div>',
		'<div class="pick-postbox postbox-minty"></div>',
		'<div class="pick-postbox postbox-mintgray"></div>',
		'<div class="pick-postbox postbox-redblue"></div>',
		'<div class="pick-postbox postbox-violets"></div>',
		'<div class="pick-postbox postbox-grayblack"></div>',
		'<div class="pick-postbox postbox-tealblue"></div>',
		'<div class="pick-postbox postbox-greengray"></div>',
		'<div class="pick-postbox postbox-tealgray"></div>',
		'<div class="pick-postbox postbox-bluegray"></div>',
		'<div class="pick-postbox postbox-lavendergray"></div>',
		'<div class="pick-postbox postbox-sunset"></div>',
		'<div class="pick-postbox postbox-sherbert"></div>',
	];
	$params = ['texts' => $texts, 'icons' => $icons, 'string' => '', 'labels' => $labels];
	//Generate html for smiley list
	$s = '<div class="preview-postbox"><tr>';
	for ($x = 0; $x < count($params['texts']); $x++) {
		$icon = $params['icons'][$x];
		$s .= '<button type="button" title="' . $params['labels'][$x] . '" onclick="postbox_addbox(\'' . $params['texts'][$x] . '\')">' . $icon . '</button>';
	}
	$s .= '</div>';

	//Add control css to header
	$css_file = __DIR__ . '/view/' . DI::app()->getCurrentTheme() . '.min.css';
	if (!file_exists($css_file)) {
		$css_file = __DIR__ . '/view/default.min.css';
	}

	DI::page()->registerStylesheet($css_file);
	
	// Add zen_postbox Styling to Header
	$box_styles = __DIR__ . '/view/postbox.min.css';
	DI::page()->registerStylesheet($box_styles);

	//Get the correct image for the theme
		$image = 'addon/zen_postbox/view/default.png';

	$image_url = DI::baseUrl() . '/' . $image;

	//Append the hmtl and script to the page
	$body .= <<< EOT
	<div id="profile-postbox-wrapper">
		<button type="button" class="btn btn-link postbox_button" onclick="toggle_postboxbutton()"><img src="$image_url" alt="postbox"></button>
		<div id="postboxbutton">
		$s
		</div>
	</div>

	<script>
		// store states
		var postboxbutton_is_shown = 0;
		var sel_start, sel_end;
		var selected_text = "";
		var area = {};
		// open/close background choices
		function toggle_postboxbutton() {
			postbox_selection();
			if (! postboxbutton_is_shown) {
				$("#postboxbutton").show();
				postboxbutton_is_shown = 1;
			} else {
				$("#postboxbutton").hide();
				postboxbutton_is_shown = 0;
			}
		}
		// get textarea selected text (if any)
		function postbox_selection(){
			// modal or compose?
			if (document.getElementsByTagName('body')[0].className.match(/mod-compose/)){
				area = document.getElementById('comment-edit-text-0');
			} else {
				area = document.getElementById('profile-jot-text');
			}
			var val = area.value;
			sel_start = area.selectionStart;
			sel_end   = area.selectionEnd;
			selected_text = val.substr( sel_start, sel_end - sel_start );
			area.focus();
			area.setSelectionRange(sel_start,sel_end);
		}
		// select and apply postbox
		function postbox_addbox(bbcode){
			postbox_selection();
			if (selected_text != ""){
				area.value = area.value.substr(0, sel_start)+bbcode+selected_text+'[/class]'+area.value.substr(sel_end);
			} else {
				area.value += bbcode+'...[/class]';
			}
			// clear out selection
			selected_text = "";
			sel_start = stel_end = null;
			// close background box and shift focus back to textarea
			toggle_postboxbutton();
			area.focus();
		}		
	</script>
EOT;
}

