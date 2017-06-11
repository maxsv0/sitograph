<?php

MSV_IncludeJSFile("/content/js/tinymce/tinymce.min.js", "", "admin");


MSV_includeJS("
$(document).ready(function() {

    var url = document.location.toString();
	if (url.match('#')) {
	    $('.nav-tabs a[href=\"#' + url.split('#')[1] + '\"]').tab('show');
	} 

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
", "", "admin");

