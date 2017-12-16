<?php

msv_include_jsfile("/content/js/tinymce/tinymce.min.js", "", "admin");
$theme_css_path = msv_get_config("theme_css_path");
$theme_use_bootstrap = msv_get_config("theme_use_bootstrap");

$cssList = "";
if ($theme_use_bootstrap > 0) {
    $cssList .= "'/content/css/bootstrap.min.css',\n";
}
if (!empty($theme_css_path)) {
    $cssList .= "'$theme_css_path',\n";
}

// include this code only in admin pages: /admin/*
msv_include_js("
$(document).ready(function() {
	tinymce.init({
		selector: '.editor',
		language: '".LANG."',
		height: 350,
		verify_html : false,
		convert_urls : false,
		menubar: false,
		toolbar_items_size: 'small',
		plugins: [
				'advlist autolink autosave lists link image charmap print preview anchor pagebreak hr',
				'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
				'table contextmenu directionality emoticons textcolor paste fullpage textcolor colorpicker textpattern'
		],
		toolbar1: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect',
        toolbar2: 'cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
        toolbar3: 'table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking pagebreak restoredraft',
	  content_css: [
		$cssList
	  ]
	});
 });
", "/admin/", "admin");

// include this code globaly, if admin logged
msv_include_js("
$(document).ready(function() {
	tinymce.init({
		selector: '.editor-inline',
		language: '".LANG."',
		inline: true,
		verify_html : false,
		convert_urls : false,
		menubar: false,
		plugins: [
				'advlist autolink lists link image charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste code'
		],
	toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code',
	  content_css: [
		$cssList
	  ]
	});
 });
", "", "admin");

foreach($_REQUEST as $name => $value) {
    if (strpos($name, "mce_") === 0) {
        $_REQUEST["updateValue"] = $value;
    }
}
