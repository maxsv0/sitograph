jQuery(document).ready(function() {
    // load inline editor in 0.5 sec after page is loaded
    setTimeout(function() {
        $('.form-text-inline').submit(function (e) {
            $form = $(this);
            e.preventDefault();

            msg = $form.find(".alert");
            msg.removeClass("alert-success alert-danger hide");
            msg.addClass("alert-warning").html("Loading ... ");
            console.log($form.serialize());
            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize(),
                success: function (data) {
                    console.log('Submission was successful.');
                    console.log(data);
                    obj = JSON.parse(data);
                    if(obj.ok) {
                        msg.html("Successfully saved");
                        msg.removeClass("alert-warning").addClass("alert-success", 500);
                    } else {
                        msg.html(obj.msg);
                        msg.removeClass("alert-warning").addClass("alert-danger", 500);
                    }
                },
                error: function (data) {
                    msg.html('An error occurred.').removeClass("alert-warning").addClass("alert-danger");
                    console.log(data);
                },
            });
        });
    }, 500);

    $('#reset').click(function (e) {
        $form = $("#admin-edit");
        msg = $form.find(".alert");
        msg.html();
    });

    $('#admin-edit').submit(function (e) {
        $form = $(this);

        // find a button that was clicked
        // following solution:
        // https://stackoverflow.com/questions/2066162/how-can-i-get-the-button-that-caused-the-submit-from-the-form-submit-event
        var $btn = $(document.activeElement);
        if (!(
                $btn.length &&
                $form.has($btn) &&
                $btn.is('button[type="submit"], input[type="submit"], input[type="image"]') &&
                $btn.is('[name]')
            )) {
            // some error, continue form execution
            return true;
        }

        e.preventDefault();

        if ($btn.attr("name") == "cancel") {
            // close modal if in inline edit mode
            // or go back
            if ($("#adminModal").lenght && $("#adminModal").data('bs.modal').isShown) {
                $("#adminModal").modal('toggle');
            } else if ($("#referer").val()) {
                window.location.href = $("#referer").val();
            } else {
                window.location.href = "/admin/?section=" + $("#section").val() + "&table=" + $("#table").val() + "";
            }

            return false;
        }

        // add AJAX call marker
        if (!$("#ajaxcall").length) {
            var input = $("<input>")
                .attr("type", "hidden")
                .attr("name", "ajaxcall").val("1");
            $form.append($(input));
        }

        // add save button to a form
        if (!$("#save").length) {
            var input = $("<input>")
                .attr("type", "hidden")
                .attr("name", "save").val("1");
            $form.append($(input));
        }

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),
            success: function (data) {
                console.log('Submission was successful.');
                obj = JSON.parse(data);
                msg = $form.find(".alert");
                msg.removeClass("alert-danger alert-success hide");
                msg.html(obj.msg);

                if(obj.ok) {
                    msg.addClass("alert-success", 500);

                    // post action
                    if ($btn.attr("name") == "save_exit") {

                        // close modal if in inline edit mode
                        // or go back
                        if ($("#adminModal").lenght && $("#adminModal").data('bs.modal').isShown) {
                            $("#adminModal").modal('toggle');
                        } else if ($("#referer").val()) {
                            window.location.href = $("#referer").val();
                        } else {
                            window.location.href = "/admin/?section=" + $("#section").val() + "&table=" + $("#table").val() + "";
                        }
                    }
                } else {
                    msg.addClass("alert-danger", 500);
                }

            },
            error: function (data) {
                msg.html('An error occurred.').addClass("alert-danger");
                console.log(data);
            },
        });

        $form.remove("#ajaxcall");
        $form.remove("#save");
    });

});

$(document).ready(function() {

    // Admin menu
    $("#menu_left div.mod_box").unbind('click').click(function() {
        if ($(this).hasClass("mod_box_active")) {
            $(this).addClass("mod_box")
            $(this).removeClass("mod_box_active")
        } else {
            $(this).removeClass("mod_box")
            $(this).addClass("mod_box_active")
        }
    });

    // Site structure -> hide all sub-levels
    if ($("#structure-table").size()>0) {
        $("#structure-table tr").each(function(){
            if ($(this).data("level")>1) {
                $(this).hide();
            }
        });
        $("#structure-table").find(".selected").each(function(){
            if ($(this).data("show")>0) {
                var show_index = $(this).data("show");
                $("#block_"+$(this).data("show")).attr("src","/content/images/adminmcg/arrow_down.png");
                $("#structure-table tr").each(function(){
                    if ($(this).data("index")== show_index) {
                        $(this).show();
                    }
                });
            }
        });
    }

    // TODO: find out why is this here
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('.tab-content').resize();
    })

    // open tab with save name as #hash in URL
    var hash = window.location.hash;
    $('.nav-tabs a[href="' + hash + '"]').tab('show');

    $('#uploadModal').on('shown.bs.modal', function() {
        clearUploadModal();
    })

    // bind auto form submit on file change
    $("#iUploadFile").change(function (){
        var fileName = $(this).val();
        if (fileName != '') {
            // submit form.
            $("#fUploadForm")[0].submit();
        }
    });

    // enable tooltips
    $('[data-toggle="tooltip"]').tooltip();
});

function removeLink(x) {
    $('#path-'+x).val('');
    $('#img-'+x).css('opacity', "0.2");
    $('#value-'+x).css('text-decoration', "line-through");

    return true;
}

function uploadFrameLoad(iframe) {
    var doc = iframe.contentDocument || iframe.contentWindow.document;
    var path = doc.body.innerHTML;

    if (path) {
        $("#uploadFilePath").val(path);
        $("#uploadAlert").addClass("alert alert-success").html("File successfully saved");

        $("#uploadPreview").removeClass("hide");
        $("#uploadPreview img").attr("src", path);

        $("#btnUploadSave").trigger('click');
    } else {
        $("#uploadAlert").addClass("alert alert-danger").html("Error saving file");
    }

    $("#uploadStatus").removeClass("hide");
}

function clearUploadModal() {
    $("#fUploadForm")[0].reset();
    $("#uploadPreview").addClass("hide");
    $("#uploadAlert").addClass("hide");
    $("#iUploadFile").attr("src", "");
}

function openUploadModal(x) {
    clearUploadModal();

    $("#iUploadField").val(x);

    $("#uploadModal").modal('show');

    $("#iUploadFile").trigger('click');
}

function closeUploadModal(x) {
    var id = $("#iUploadField").val();
    var path = $("#uploadFilePath").val();

    if (id && path) {
        $("#img-"+id).attr("src", path);
        $("#value-"+id).html(path);
        $("#path-"+id).val(path);
        $("#alert-"+id).hide();

        $("#uploadModal").modal('hide');
    }
}


function openPicLibraryModal(x) {
    $("#iUploadField").val(x);

    var pic_path = $("#img-"+x).attr("src");
    var pic_path = pic_path.substr(0,pic_path.indexOf('?'));

    if (pic_path && pic_path.lastIndexOf("data", 0) !== 0) {
        $("#picPreview").attr("src", pic_path);
    } else {
        var pic_path = $("#img-pic").attr("src");
        if (pic_path) {
            $("#picPreview").attr("src", pic_path);
        } else {
            var path = $("#uploadFilePath").val();
            if (path) {
                $("#picPreview").attr("src", path);
            }
        }
    }

    var ext = pic_path.split('.').pop();
    if (ext == "jpg") {
        // browser req
        ext = "jpeg";
    }
    console.log("File: "+$("#picPreview").attr("src")+", type: "+ext);

    $("#type-"+x).val(ext);

    var aspect = $("#aspectRatio-"+x).val();
    var imgWidth = $("#width-"+x).val();
    var imgHeight = $("#height-"+x).val();

    console.log("aspect:"+aspect+", imgWidth:"+imgWidth+", imgHeight:"+imgHeight);

    $("#libraryModal").modal('show');

    var cropBoxData;
    var canvasData;

    $('#libraryModal').on('shown.bs.modal', function () {
        $('#picPreview').cropper({
            aspectRatio: aspect,
            responsive: true,
            movable: true,
            zoomable: true,
            rotatable: true,
            scalable: true,
            built: function () {
                $('#picPreview').cropper('setCropBoxData', { width: imgWidth, height: imgHeight });
            }
        });
    });
}


function closePicLibraryModal() {
    $('#picPreview').cropper('getCroppedCanvas').toBlob(function (blob) {
        var formData = new FormData();
        var field = $("#iUploadField").val();
        var table = $("#iUploadTable").val();
        var id = $("#itemID").val();

        formData.append('uploadFile', blob, field);
        formData.append('table', table);
        formData.append('field', field);
        formData.append('itemID', id);

        $.ajax('/api/uploadpic/', {
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (path) {
                console.log('Upload success');
                console.log(path);

                $("#uploadFilePath").val(path);
                $("#img-"+field).attr("src", path+"?"+Math.random());
                $("#value-"+field).html(path);
                $("#path-"+field).val(path);
            },
            error: function () {
                console.log('Upload error');
            }
        });
    }, "image/"+$("#type-"+$("#iUploadField").val()).val(), 1);


    $("#libraryModal").modal('hide');
}

var active_block = 0;

function change_view(x) {
    var d = document.getElementById("block_title_"+x);
    var t = document.getElementById("block_text_"+x);

    if (d.className == "block_title") {
        d.className = "block_title_a";
        t.style.display = "block";

        if (active_block != 0) {
            change_view(active_block);
        }
        active_block = x;
    } else {
        d.className = "block_title";
        t.style.display = "none";

        active_block = 0;
    }
}
function open_all() {
    i = 1;
    var d = document.getElementById("block_title_"+i);
    var t = document.getElementById("block_text_"+i);
    while (d && t) {
        d.className = "block_title_a";
        t.style.display = "block";

        i++;
        var d = document.getElementById("block_title_"+i);
        var t = document.getElementById("block_text_"+i);
    }
    $("#search_toogle").html("<a href='javascript:close_all();'>Свернуть все</a>");
}
function close_all() {
    i = 1;
    var d = document.getElementById("block_title_"+i);
    var t = document.getElementById("block_text_"+i);
    while (d && t) {
        d.className = "block_title";
        t.style.display = "none";

        i++;
        var d = document.getElementById("block_title_"+i);
        var t = document.getElementById("block_text_"+i);
    }
    $("#search_toogle").html("<a href='javascript:open_all();'>Развернуть все</a>");
}

function toogle_parent(e,id, level) {
    if ($(e).parent().parent().hasClass('selected')) {
        $(e).parent().parent().removeClass('selected');
        $("#block_"+id).attr("src","/content/images/sitograph/arrow_right.png");
        set_structure_status('remove', $(e).parent().parent().data("index"), $(e).parent().parent().data("level"), id);
        $("#structure-table tr").each(function(){
            if ($(this).data("index") == id && $(this).data("level")== parseInt(level)+1) {
                $(this).hide();
            }
        });
    } else {
        $(e).parent().parent().addClass('selected');
        $("#block_"+id).attr("src","/content/images/sitograph/arrow_down.png");
        set_structure_status('add', $(e).parent().parent().data("index"), $(e).parent().parent().data("level"),id);
        $("#structure-table tr").each(function(){
            if ($(this).data("index") == id && $(this).data("level") == parseInt(level)+1) {
                $(this).show();
            }
        });
    }
}



function set_structure_status (mode, index, level, show){
    $.ajax({
        type     : "GET",
        dataType : 'json',
        async    : false,
        url      : "/api/set_structure_status/",

        data: ({mode : mode, index : index, level : level, show:show}),

        success: function(data){
            if(data.ok){
            }
            return false;
        }
    });
}

function Get_More_Search (e) {
    $.ajax({
        type     : "GET",
        dataType : 'json',
        async    : false,
        url      : "/api/more_search/",
        data: ({nextpage        : $(e).data('nextpage'), keyword : $(e).data('search')}),
        success: function(data){
            if(data.ok){
                $(".btn_more").remove();
                $('.search_list').append(data.data);
            }
            return false;
        }
    });
}

function load_ajax(dest) {
    console.log($(dest).attr("href"));

    $.ajax({
        type     : "GET",
        dataType : 'json',
        async    : false,
        url      : $(dest).attr("href") + "?tohtml",
        success: function(data){
            $(dest).html(data);
            return false;
        }
    });
    return false;
}