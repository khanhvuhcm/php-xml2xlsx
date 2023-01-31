
function _(el) {
    return document.getElementById(el);
}
function uploadFile() {
    var file = _("file1").files[0];
    //alert(file.name+" | "+file.size+" | "+file.type);
    var formdata = new FormData();
    formdata.append("file1", file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", "/upload-ajax");
    ajax.send(formdata);
}
function progressHandler(event) {
    _("loaded_n_total").innerHTML = "<small>Uploaded "+event.loaded+" bytes of "+event.total+"</small>";
    var percent = (event.loaded / event.total) * 100;
    _("progressBar").value = Math.round(percent);
    _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
}
function completeHandler(event) {
    if (event.target.responseText.indexOf('ERROR') !== -1) {
        _("status").innerHTML = "<small><span class='text-danger'>" + event.target.responseText + "</span></small>";
    } else {
        _("status").innerHTML = "<a target='_blank' href='/download/" + event.target.responseText + "'>" + event.target.responseText + "</a>";
        _("progressBar").value = 0;
    }

}
function errorHandler(event) {
    _("status").innerHTML = "<span class='.text-danger'>Upload Failed: " + event.target.responseText + "</span>";
}
function abortHandler(event) {
    _("status").innerHTML = "<span class='.text-danger'>Upload Aborted</span>";
}
