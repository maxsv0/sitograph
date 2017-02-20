 <div class="container footer">
 	<div class="row contact-block">
 		<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
			<span class="contact-title">Наши контакты</span>
			<table cellpadding="5" cellspacing="0" style="color: #FFF;">

			<tr valign="top">
				<td style="color: #FFF;">Телефоны:</td>
				<td style="color: #FFF;">+380 (44) 536-00-66<br>+380 (93) 898-33-70
				<!--+380 (44) 531-90-76-->
				</td>
			</tr>
			<tr valign="top">
				<td style="color: #FFF;">Адрес:</td>
				<td style="color: #FFF;">01054, г. Киев, ул. Бульварно-Кудрявская 35, офис № 18</td>
			</tr>
			<tr valign="top">
				<td style="color: #FFF;">E-mail:</td>
				<td style="color: #FFF;">advert@mcg.net.ua</td>
			</tr>
			</table>	
 		</div>
		<div class="col-lg-6 col-md-4 col-sm-4 col-xs-4">
			<div class="social_block">
                    <a href="https://www.facebook.com/MCGAgency" class="f_big"></a>
                    <a href="http://vk.com/mcgagency" class="b_big"></a>
             </div>
		</div>
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-4">
			<div class="bottom_menu">
                {include file="$themePath/widget/menu-bottom.tpl"}    
             </div>
		</div> 	
 	</div>
 	<div class="row footer-copyright">
 		<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="52"><img src="{$content_url}/{$page.template}/images/line_bottom_p1.gif" width="52" height="43" alt="&nbsp;"/></td>
		<td bgcolor="#000" width="100%">
		
		<p class="copyright" >Marketing Consulting Group © 2012-2017</p>
		

		
		</td>
		<td width="17"><img src="{$content_url}/{$page.template}/images/line_bottom_p2.png" width="17" height="43" alt="&nbsp;"/></td>
	</tr>
	</table>
	
 	</div>
 </div>   
<!--
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
</footer>-->

{$htmlFooter}
{$admin_menu}

</body>
</html>