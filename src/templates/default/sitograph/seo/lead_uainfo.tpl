{if $info}

{if $info.browser}
    <p>
        {if $info.browser == "Chrome"}
            <img src="{$contentUrl}/images/sitograph/browser/chrome.png" width="16" height="16">
        {elseif $info.browser == "Firefox"}
            <img src="{$contentUrl}/images/sitograph/browser/firefox.png" width="16" height="16">
        {elseif $info.browser == "Safari"}
            <img src="{$contentUrl}/images/sitograph/browser/safari.png" width="16" height="16">
        {elseif $info.browser == "Internet Explorer"}
            <img src="{$contentUrl}/images/sitograph/browser/internet_explorer.png" width="16" height="16">
        {/if}

        {$info.browser}

        {if $info.browser_version && $info.browser_version != "Unknown"}
            {$info.browser_version}
        {/if}
    </p>
{/if}

{if $info.os}
    <p>
        {$info.os} {$info.os_version}
    </p>
{/if}

{if $info.device_brand && $info.device_brand != "Unknown"}
    <p>
        {$info.device_brand}
        {if $info.device_model && $info.device_model != "Emulator"}
            {$info.device_model}
        {/if}
    </p>
{/if}

{else}
    <i>empty</i>
{/if}