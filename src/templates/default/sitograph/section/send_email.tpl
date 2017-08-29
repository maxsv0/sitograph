{if $email_step_preview}


<form method="POST" action="{$lang_url}/admin/" class="form-horizontal">

    <h1>Step 2/2. Email sending confirmation</h1>
    <br>
    <table class="table table-bordered">
        <tr>
            <td class="col-sm-4">To</td>
            <td class="col-sm-8">{$email_to}</td>
        </tr>
        <tr>
            <td class="col-sm-4">From</td>
            <td class="col-sm-8">{$email_from}</td>
        </tr>
        <tr>
            <td class="col-sm-4">Subject</td>
            <td class="col-sm-8">{$email_subject}</td>
        </tr>
        <tr>
            <td colspan="2" class="col-sm-12" style="padding:50px;">
{$email_body}
            </td>
        </tr>
    </table>

    <div class="form-group">
        <div class="text-left col-sm-6">
            <button type="submit" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove-circle">&nbsp;</span>{$t["btn.cancel"]}</button>
        </div>
        <div class="text-right col-sm-6">
            <button type="submit" name="email_send" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-envelope">&nbsp;</span> Send Email</button>
        </div>
    </div>

    <input type="hidden" value="{$email_to}" name="email_to">
    <input type="hidden" value="{$email_from}" name="email_from">
    <input type="hidden" value="{$email_subject}" name="email_subject">
    <input type="hidden" value="{$email_body}" name="email_body">
    <input type="hidden" value="{$admin_section}" name="section">
</form>
{else}

<form method="POST" action="{$lang_url}/admin/" class="form-horizontal">
    <h1>Step 1/2. Send custom email</h1>
    <br>
    <div class="form-group">
        <label for="inputEmailFrom" class="col-sm-4 control-label">
            From
            <small class="field-help">
                to edit 'From' field go to <a href="/admin/?section=site_settings">Site Settings</a>
            </small>
        </label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmailFrom" value="{$email_from}" disabled>
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmailTo" class="col-sm-4 control-label">
            To
            <small class="field-help">
                use comma to separate recipients
            </small>
        </label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmailTo" value="{$email_to}" placeholder="" name="email_to">
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmailSubject" class="col-sm-4 control-label">Email Subject</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmailSubject" value="" placeholder="" name="email_subject">
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmailBody" class="col-sm-12 control-label">Email Body</label>
        <div class="col-sm-12">
            <textarea class="form-control" id="inputEmailBody" rows="15" name="email_body"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="text-left col-sm-6">
            <button type="submit" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove-circle">&nbsp;</span>{$t["btn.cancel"]}</button>
            <button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-ban-circle">&nbsp;</span>{$t["btn.reset"]}</button>
        </div>
        <div class="text-right col-sm-6">
            <button type="submit" name="email_preview" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open">&nbsp;</span> Save and Preview Email</button>
        </div>
    </div>

    <input type="hidden" value="{$admin_section}" name="section">
</form>

{/if}