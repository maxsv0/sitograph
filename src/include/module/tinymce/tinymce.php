<?php

msv_include_jsfile("/content/js/tinymce/tinymce.min.js", "", "admin");

// include this code only in admin pages: /admin/*
msv_include_js("
$(document).ready(function() {
	tinymce.init({
		selector: '.editor',
		language: '".LANG."',
		height: 500,
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
		'/content/css/bootstrap.min.css',
		'/content/css/default.css',
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
		'/content/css/bootstrap.min.css',
		'/content/css/default.css',
	  ]
	});
 });
", "", "admin");

foreach($_REQUEST as $name => $value) {
    if (strpos($name, "mce_") === 0) {
        $_REQUEST["updateValue"] = $value;
    }
}
