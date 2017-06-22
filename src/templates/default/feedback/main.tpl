<form class="form-horizontal" method="POST" action="{$lang_url}{$feedback.baseUrl}" enctype="multipart/form-data">
    <div class="form-group">
        <label for="inputEmail" class="col-sm-4 control-label">{_t("feedback.form.email")}</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmail" placeholder="{_t("feedback.form.email")}" name="feedback_email" value="{$feedback_email}">
        </div>
    </div>
    <div class="form-group">
        <label for="inputName" class="col-sm-4 control-label">{_t("feedback.form.name")}</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputName" placeholder="{_t("feedback.form.name")}" name="feedback_name" value="{$feedback_name}">
        </div>
    </div>
    <div class="form-group">
        <label for="inputNameTitle" class="col-sm-4 control-label">{_t("feedback.form.name_title")}</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputNameTitle" placeholder="{_t("feedback.form.name_title")}" name="feedback_name_title" value="{$feedback_name_title}">
        </div>
    </div>
    <div class="form-group">
        <label for="inputText" class="col-sm-4 control-label">{_t("feedback.form.text")}</label>
        <div class="col-sm-8">
            <textarea class="form-control" id="inputText" name="feedback_text">{$feedback_text}</textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPic" class="col-sm-4 control-label">{_t("feedback.form.pic")}</label>
        <div class="col-sm-8">
            <input type="file" class="form-control" id="inputPic" name="feedback_pic">
        </div>
    </div>
    <div class="form-group">
        <label for="inputStars" class="col-sm-4 control-label">{_t("feedback.form.stars")}</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputStars" placeholder="{_t("feedback.form.stars")}" name="feedback_stars" value="{$feedback_stars}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12 text-center">
            <button type="submit" name="doSendFeedback" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span>{_t("feedback.form.send")}</button>
        </div>
    </div>
</form>
