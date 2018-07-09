<br>

<div class="clearfix">
{foreach from=$feedback_sticked key=feedback_id item=feedback}

<div class="col-md-4">
    <div class="feedbackItem" data-id="{$feedback.id}">
        <img src="{$feedback.pic}" class="img-thumbnail">

        <p>
            {$feedback.text}
<h3>
{$feedback.name}
{if $feedback.name_title}
    <br><small>{$feedback.name_title}</small>
{/if}
</h3>
        </p>
    </div>
</div>

{/foreach}
</div>

<br>