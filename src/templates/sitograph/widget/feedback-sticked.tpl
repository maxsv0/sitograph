<br>

<div class="clearfix">
{foreach from=$feedback_sticked key=feedback_id item=feedback}

<div class="col-md-4">
    <div class="feedbackItem" data-id="{$feedback.id}" style="margin-bottom: 15px;">
        <div style="min-height:300px;background:#fff;">
            <img src="{$feedback.pic}" class="img-responsive">
        </div>

        <div style="padding:20px;background:#fff;min-height:250px;">
            {$feedback.text}
<h3>
{$feedback.name}
{if $feedback.name_title}
    <br><small>{$feedback.name_title}</small>
{/if}
</h3>
        </div>
    </div>
</div>

{/foreach}
</div>

<br>