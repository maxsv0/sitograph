{if $message_error}
<div class="container">
<div class="row">

<div class="alert alert-danger">
{$message_error}
</div>

</div>
</div>
{/if}


{if $message_success}
<div class="container">
<div class="row">

<div class="alert alert-success">
{$message_success}
</div>

</div>
</div>
{/if}