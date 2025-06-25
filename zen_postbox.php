<?php
/**
 * Name: Zen Postbox
 * Description: Adds a button to editor to insert color background. Called Zen to load last.
 * Version: 1.2
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
		['White Smoke', 'whitesmoke'],
		['Dark Grey', 'darkgrey'],
		['Black', 'black'],
		['Pink', 'pink'],
		['Red', 'red'],
		['Dark Red', 'darkred'],
		['Light Pink', 'lightpink'],
		['Hot Pink', 'hotpink'],
		['Medium Violet Red', 'mediumvioletred'],
		['Peach Puff', 'peachpuff'],
		['Dark Orange (Orange)', 'darkorange'],
		['Sienna', 'sienna'],
		['Light Yellow', 'lightyellow'],
		['Gold', 'gold'],
		['Goldenrod', 'goldenrod'],
		['Honeydew', 'honeydew'],
		['Yellow Green', 'yellowgreen'],
		['Olive Drab', 'olivedrab'],
		['Pale Green', 'palegreen'],
		['Lime Green (Green)', 'limegreen'],
		['Forest Green (Forest)', 'forestgreen'],
		['Mint Cream', 'mintcream'],
		['Medium Aquamarine', 'mediumaquamarine'],
		['Sea Green', 'seagreen'],
		['Sky Blue', 'skyblue'],
		['Cornflower Blue (Blue)', 'cornflowerblue'],
		['Dark Slate Blue', 'darkslateblue'],
		['Lavender', 'lavender'],
		['Medium Slate Blue', 'mediumslateblue'],
		['Dark Blue (Ocean)', 'darkblue'],
		['Thistle', 'thistle'],
		['Violet', 'violet'],
		['Purple', 'purple'],
		['Light Salmon (Salmon)', 'lightsalmon'],

		['Aurora', 'aurora'],
		['Blue-Gray', 'bluegray'],
		['Gray-Grey', 'graygrey'],
		['Gray-Black', 'grayblack'],
		['Green-Gray', 'greengray'],
		['Lavender-Gray', 'lavendergray'],
		['Minty', 'minty'],
		['Mint-Gray', 'mintgray'],
		['Rainbow', 'rainbow'],
		['Red-Blue', 'redblue'],
		['Sherbet', 'sherbet'],
		['Spectrum', 'spectrum'],
		['Strawberry-Cream', 'strawberrycream'],
		['Sunset', 'sunset'],
		['Teal-Blue', 'tealblue'],
		['Teal-Gray', 'tealgray'],
		['Violets', 'violets'],
		['Violet-Blue', 'violetblue'],

		['Blueprint', 'blueprint'],
		['Birds', 'birds'],
		['Checkered', 'checkered'],
		['Cubes', 'cubes'],
		['Lemon-Lime', 'lemonlime'],
		['Gingham', 'gingham'],
		['Grid', 'grid'],
		['Hearts', 'hearts'],
		['Honeycomb', 'honeycomb'],
		['Notebook', 'notebook'],
		['Plaid', 'plaid'],
		['Polkadots', 'polkadots'],
		['Shade Dots', 'shadedots'],
		['Shadowbox', 'shadowbox'],
		['Stars', 'stars'],
		['Warp Grid', 'warpgrid'],
		['Wavy', 'wavy'],

		['Ani-Gradient', 'anigradient'],	
		['Blob', 'blob'],
		['Color Fade', 'colorfade'],
		['Grid Runner', 'gridrunner'],	
		['Heartbeat', 'heartbeat'],
		['Moonrise', 'moonrise'],
		['Rainy', 'rainy'],
		['Rocket', 'rocket'],
		['Snowy', 'snowy'],
		['Sunrise', 'sunrise'],
		['Waves', 'waves'],
	];

	// Generate Postbox Buttons
	$s = '<div class="preview-postbox"><tr>';
	for ($x = 0; $x < count($labels); $x++){
		$s .= '<button type="button" title="' . $labels[$x][0] . '" onclick="postbox_addbox(\'[class=postbox-' . $labels[$x][1] . ']\')"><div class="pick-postbox postbox-' . $labels[$x][1] . '"></div></button>';
	}
	$s .= '</div>';

	//Add control css to header
	$css_file = __DIR__ . '/view/' . DI::app()->getCurrentTheme() . '.min.css';
	if (!file_exists($css_file)) {
		$css_file = __DIR__ . '/view/default.min.css';
	}

	DI::page()->registerStylesheet($css_file);
	
		/* Add Postbox Styling to Header
		   DI::page()->registerStylesheet($path) might load before theme
		   so we will append with DI::page()['htmlhead'] to make it load much much later
		*/
		$path = __DIR__ . '/view/postbox.min.css?v=1.2';	
		if (mb_strpos($path, DI::basePath() . DIRECTORY_SEPARATOR) === 0) {
			$path = mb_substr($path, mb_strlen(DI::basePath() . DIRECTORY_SEPARATOR));
		}
		DI::page()['htmlhead'] .= '<link rel="stylesheet" href="'.$path.'" media="screen"/>';
		
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

