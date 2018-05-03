
<div class="filter_block" style="padding:0px">
        <div class="search_header"><b>{$t["form.search_lable"]}</b></div>
        <form action="{$lang_url}{$admin_url}?section=module_search&search" method="POST">
        <table width="100%" cellpadding="0" cellspacing="0" class="search_table">
        <td width="130">{$t["form.search_word"]}</td>
            <td valign="center">
                <input type="text" class="big" name="keyword" value="{$keyword}"/>
            </td>
        </tr>
        <tr>
        <td colspan="2" align="left">
        <div class="btn_Ok" style="margin-top:15px">
        <input type="submit" value="{$t["btn.search"]}" name="search"/> 
        </div></td>
        </tr>
        </table>
        <!--<input type="hidden" value="search" name="module"/>-->
        </form>
</div>


{if $search}
    {if $module_search}
    {assign var=i value=1}
    <div id="search_toogle"><a href="javascript:open_all();">{$t["search.expand_all"]}</a></div>
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
    
    {elseif $keyword}
    <div style="margin-top:20px"><b>{$t["search.error_mcg"]}</b></div>
    
    {/if}
{/if}