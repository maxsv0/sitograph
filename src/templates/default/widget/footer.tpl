

<footer class="footer">
<div class="container">
<hr>


<div class="row">
    <div class="col-md-4 text-left">
		{$host}
		<br>
		{$home.$lang}
    </div>
    <div class="col-md-4 text-left">
{include file="$themePath/widget/menu-bottom.tpl"}
    </div>
	<div class="col-md-4 text-right">
{if $languages|count > 1}

Language: 
{foreach from=$languages item=langID} 
{assign var="link" value=$home[$langID]}
<a href="{$link}"> {$langID}</a>
{/foreach} 

{/if} 


    </div>
</div>
</div>
</footer>

{$htmlFooter}
{$admin_menu}

</body>
</html>