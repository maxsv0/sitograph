{if $email_step_preview}


<form method="POST" action="{$lang_url}{$admin_url}" class="form-horizontal">

    <h1>{_t("email.label.step_2")}</h1>
    <br>
    <table class="table table-bordered">
        <tr>
            <td class="col-sm-4">{_t("email.label.to")}</td>
            <td class="col-sm-8">{$email_to}</td>
        </tr>
        <tr>
            <td class="col-sm-4">{_t("email.label.from")}</td>
            <td class="col-sm-8">{$email_from}</td>
        </tr>
        <tr>
            <td class="col-sm-4">{_t("email.label.subject")}</td>
            <td class="col-sm-8">{$email_subject}</td>
        </tr>
        <tr>
            <td colspan="2" class="col-sm-12" style="padding:50px;" contentEditable="true" oncut="return false" onpaste="return false" onkeydown="if(event.metaKey) return true; return false;">
{$email_body}
            </td>
        </tr>
    </table>

    <div class="form-group">
        <div class="text-left col-sm-6">
            <button type="submit" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove-circle">&nbsp;</span>{$t["btn.cancel"]}</button>
        </div>
        <div class="text-right col-sm-6">
            <button type="submit" name="email_send" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-envelope">&nbsp;</span> {_t("btn.send_email")}</button>
        </div>
    </div>

    <input type="hidden" value="{$email_to}" name="email_to">
    <input type="hidden" value="{$email_from}" name="email_from">
    <input type="hidden" value="{$email_subject}" name="email_subject">
    <input type="hidden" value="{$email_body|htmlspecialchars}" name="email_body">
    <input type="hidden" value="{$admin_section}" name="section">
</form>
{else}

<form method="POST" action="{$lang_url}{$admin_url}" class="form-horizontal">
    <h2>{_t("email.label.step_1")}</h2>
    <div class="form-group">
        <label for="inputEmailFrom" class="col-sm-4 control-label">
            {_t("email.label.from")}
            <small class="field-help">
                {_t("email.label.edit_from")} <a href="{$lang_url}{$admin_url}?section=site_settings">{_t("email.label.site_settings")}</a>
            </small>
        </label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmailFrom" value="{$email_from}" disabled>
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmailTemplate" class="col-sm-4 control-label">
            {_t("email.label.template")}
        </label>
        <div class="col-sm-8">
            <select class="form-control" id="inputEmailTemplate" name="email_template" onchange="location.href='{$admin_url}?section=send_email&email_template='+this.value">
{foreach from=$email_templates item=template}
    <option value="{$template.name}">{$template.name}</option>
{/foreach}
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmailTo" class="col-sm-4 control-label">
            {_t("email.label.to")}
            <small class="field-help">
                {_t("email.label.use_comma")}
            </small>
        </label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmailTo" value="{$email_to}" placeholder="" name="email_to">
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmailSubject" class="col-sm-4 control-label">{_t("email.label.subject")}</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmailSubject" value="{$email_subject}" placeholder="" name="email_subject">
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmailBody" class="col-sm-12 control-label">{_t("email.label.body")}</label>
        <div class="col-sm-12">
            <textarea class="form-control editor" id="inputEmailBody" rows="25" name="email_body">{$email_body}</textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="text-left col-sm-6">
            <button type="submit" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove-circle">&nbsp;</span>{$t["btn.cancel"]}</button>
            <button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-ban-circle">&nbsp;</span>{$t["btn.reset"]}</button>
        </div>
        <div class="text-right col-sm-6">
            <button type="submit" name="email_preview" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open">&nbsp;</span> {_t("email.label.save_and_preview")}</button>
        </div>
    </div>

    <input type="hidden" value="{$admin_section}" name="section">
</form>

{/if}