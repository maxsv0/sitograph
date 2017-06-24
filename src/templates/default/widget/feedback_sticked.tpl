<br>

<div class="clearfix">
{foreach from=$feedback_sticked key=feedback_id item=feedback}

<div class="col-sm-4">
    <div style="backround:#eee;min-height:500px;">
        <div style="background: url('{$feedback.pic}') no-repeat center center; background-size: cover; height:300px;"></div>

        <div style="padding:20px;">
            {$feedback.text}
<h3>
{$feedback.name}
{if $feedback.name_title}
    <small>{$feedback.name_title}</small>
{/if}
</h3>
        </div>
    </div>
</div>

{/foreach}
</div>

<br>