<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>{$page.title}</title>
	<meta name="keywords" content="{$page.keywords}"/>
	<meta name="description" content="{$page.description}"/>

    {$htmlHead}
    <link rel="stylesheet" type="text/css" href="{$content_url}/{$page.template}/css/default.css"/>
  </head>
<body>

 <div class="container header">
 	<div class="row">
		<div class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-4 col-sm-offset-8">
			<div class="header-menu">
				<a href="#" class="sitemap-ico"></a>
				<span class="top-delimiter"></span>
				<a href="#" class="mail-ico"></a>
				<span class="top-delimiter"></span>
				<a href="#" class="top-lang">ua</a>
				
			</div>
		</div>
 		
 	</div>
 	<div  class="row">
		<div class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-4 col-sm-offset-8">
			<div class="search-block">
			<form action="" method="post">
				<input type="text" name="search" value="" placeholder="найти"/>
				<button type="submit" value="search"></button>
				
			</form>
				
			</div>
		</div>
 	</div>
 	<div class="row">
 	    <div class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-4 col-sm-offset-8">
            <div class="phone-block">
 		       <table cellpadding="0" cellspacing="0" width="170" style="margin-top:15px">
				<tr>
					<td style="padding-right: 10px;"><img src="{$content_url}/{$page.template}/images/pic_s_tel.gif" width="14" height="14" alt="Контактные телефоны"></td>
					<td style="font-size: 13px; white-space: nowrap; color: #FFF;">
					+380 (44) 536-00-66<br/>
					+380 (93) 898-33-70
					</td>
				</tr>
				</table>
            </div>    
		</div>
        
 	</div>
 	<div class="row">
 		<div class="logo-block">
 			<a href="{$lang_url}/">
 				<img src="{$content_url}/{$page.template}/images/sitograph_logo.png"/>
 			</a>
 		</div>
 	</div>
 	
 </div>
