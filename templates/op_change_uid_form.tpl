<h3 class="my"><{$smarty.const._MA_TADLOGIN_ABOUT_CHANGE_UID}></h3>
<div class="alert alert-info">
    <{$smarty.const._MA_TADLOGIN_ABOUT_CHANGE_UID_DESC}>
</div>

<h3 class="my"><{$smarty.const._MA_TADLOGIN_PICK_TWO_UESER}></h3>
<div class="alert alert-success">
    <{$smarty.const._MA_TADLOGIN_ABOUT_CHANGE_UID_TODO}>
</div>
<form action="change_uid.php" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="input-group">
        <div class="input-group-prepend input-group-addon">
            <span class="input-group-text"><{$smarty.const._MA_TADLOGIN_REAL_NAME_SEARCH}></span>
        </div>
        <input type="text" name="keyword" class="form-control" value="<{$keyword|default:''}>" placeholder="<{$smarty.const._MA_TADLOGIN_KEYWORD_REAL_NAME}>">
        <div class="input-group-append input-group-btn">
            <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SEARCH}></button>
        </div>
    </div>
</form>

<form action="change_uid.php" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal">
    <table class="table table-bordered table-hover table-striped table-sm table-condensed">
        <tr>
            <th>uid</th>
            <th><{$smarty.const._MA_TADLOGIN_NAME}></th>
            <th><{$smarty.const._MA_TADLOGIN_UNAME}></th>
            <th>Email</th>
            <th><{$smarty.const._MA_TADLOGIN_LAST_LOGIN}></th>
            <th><{$smarty.const._MA_TADLOGIN_SCHOOLCODE}></th>
        </tr>
    <{foreach from=$data key=k item=user name=data}>
        <tr>
            <td>
                <div class="form-check-inline checkbox-inline" style="position: relative;">
                    <label class="form-check-label">
                        <input class="form-check-input validate[required, minCheckbox[2], maxCheckbox[2]]" type="checkbox" name="change_uid[]" id="change_uid_<{$user.uid}>" value="<{$user.uid}>" >
                        <{$user.uid}>
                    </label>
                </div>
            </td>
            <td><{$user.name}></td>
            <td><{$user.uname}></td>
            <td><{$user.email}></td>
            <td><{$user.last_login|date_format:"%Y-%m-%d %H:%M:%S"}></td>
            <td><{$user.user_intrest}></td>
        </tr>
    <{/foreach}>
    </table>
    <div class="bar">
        <input type="hidden" name="op" value="change_uid">
        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-disk" aria-hidden="true"></i>  <{$smarty.const._TAD_SUBMIT}></button>
    </div>
</form>
<{$bar|default:''}>
