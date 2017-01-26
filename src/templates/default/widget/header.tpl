<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$page.title}</title>
	<meta name="keywords" content="{$page.keywords}">
	<meta name="description" content="{$page.description}">

    {$htmlHead}
  </head>
<body>

<div class="container">

<div class="">
{include file="$themePath/widget/menu-user.tpl"}
</div>

<h2 class="text-center"><a href="{$home.$lang}">{$masterhost}</a></h2>
{include file="$themePath/widget/menu-top.tpl"}
</div>


<div class="container">
{include file="$themePath/widget/messages.tpl"}
</div>