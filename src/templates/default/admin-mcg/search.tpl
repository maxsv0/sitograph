
<div class="filter_block" style="padding:0px">
        <div class="search_header"><b>Поиск</b></div>
        <form action="{$lang_url}/admin/?section=module_search&menu_block=module_search&search" method="POST">
        <table width="100%" cellpadding="0" cellspacing="0" class="search_table">
        <td width="130">Ключевое слово</td>
            <td valign="center">
                <input type="text" class="big" name="keyword" value=""/>
            </td>
        </tr>
        <tr>
        <td colspan="2" align="left">
        <div class="btn_Ok" style="margin-top:15px">
        <input type="submit" value="Искать" name="search"/> 
        </div></td>
        </tr>
        </table>
        <!--<input type="hidden" value="search" name="module"/>-->
        </form>
</div>


{if $search}
    {if $module_search}
    {assign var=i value=1}
    <div id="search_toogle"><a href="javascript:open_all();">Развернуть все</a></div>
    {foreach from=$module_search key=index item=ar}
        <div id="block_title_{$i}" class="block_title" onclick="change_view({$i})"><span style="color: #800000;">{$index} ({$module_search_num[$index]})</span></div>
        <div id="block_text_{$i}" class="block_text">
          {foreach from=$ar key=in item=links}
            <a href="{$links.url}">{$links.title}</a><br/>
            <p>{$links.text}</p><br/>
          {/foreach}
        </div>
        {assign var=i value=$i+1}
    {/foreach}
    
    {else}
    <div><b>По вашему запросу ничего не найдено.</b></div>
    
    {/if}
{/if}