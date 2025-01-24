<{$TadLoginBootstrapEditableCode}>
<h2><{$smarty.const._MA_TADLOGIN_MANAGE_PASSWORD}></h2>

<div class="alert alert-info" style="margin-top:10px;">
    <ol>
        <li><{$smarty.const._MA_TADLOGIN_BIND_DESC1}></li>
        <li><{$smarty.const._MA_TADLOGIN_BIND_DESC2}></li>
        <li><{$smarty.const._MA_TADLOGIN_BIND_DESC3}></li>
        <li><{$smarty.const._MA_TADLOGIN_BIND_DESC4}></li>
        <li><{$smarty.const._MA_TADLOGIN_BIND_DESC5|sprintf:$mid}></li>
    </ol>
</div>
    <div class="row">
        <div class="col-sm-7">
            <{if $count > 0}>
                <form action="ps_tool.php" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-addon">
                            <span class="input-group-text"><{$smarty.const._MA_TADLOGIN_BIND_ALL_ID|sprintf:$count}></span>
                        </div>
                        <input type="text" name="passwd" class="form-control validate[required]" placeholder="<{$smarty.const._MA_TADLOGIN_SET_PASSWORD}>">
                        <div class="input-group-append input-group-btn">
                            <button type="submit" class="btn btn-warning" name="op" value="change_all_pass"><{$smarty.const._MA_TADLOGIN_BIND_ID}></button>
                        </div>
                    </div>
                </form>
            <{/if}>
        </div>
        <div class="col-sm-5">
            <form action="ps_tool.php" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal">
                <div class="input-group">
                    <div class="input-group-prepend input-group-addon">
                        <span class="input-group-text"><{$smarty.const._MA_TADLOGIN_KEYWORD}></span>
                    </div>
                    <input type="text" name="keyword" class="form-control" value="<{$keyword|default:''}>" placeholder="<{$smarty.const._MA_TADLOGIN_KEYWORD_DESC}>">
                    <div class="input-group-append input-group-btn">
                        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SEARCH}></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<table class="table table-bordered table-hover table-striped table-sm table-condensed mt-3">
    <tr>
        <th><{$smarty.const._MA_TADLOGIN_NAME}></th>
        <th><{$smarty.const._MA_TADLOGIN_UNAME}></th>
        <th>Email</th>
        <th><{$smarty.const._MA_TADLOGIN_LAST_LOGIN}></th>
        <th><{$smarty.const._MA_TADLOGIN_HASHED_DATE}></th>
        <th><{$smarty.const._MA_TADLOGIN_SCHOOLCODE}></th>
    </tr>
<{foreach from=$data key=k item=user name=data}>
    <tr>
        <td><{$user.name}></td>
        <td><{$user.uname}></td>
        <td><{$user.email}></td>
        <td><{$user.last_login|date_format:"%Y-%m-%d %H:%M:%S"}></td>
        <td>
            <{if $user.hashed_date=='0000-00-00 00:00:00'}>
                <i class="fa fa-pen-to-square" aria-hidden="true"></i>
                <span class="c n editable" data-type="text" data-pk="<{$user.uname}>" data-params="{op: 'change_pass'}" data-value=""><{$smarty.const._MA_TADLOGIN_CHANGE_BINDING_PASSWORD}></span>
            <{else}>
                <{$user.hashed_date}>
                <i class="fa fa-pen-to-square" aria-hidden="true"></i>
                <span class="c n editable" data-type="text" data-pk="<{$user.uname}>" data-params="{op: 'change_pass'}" data-value=""><{$smarty.const._MA_TADLOGIN_MODIFY_PASSWORD}></span>
            <{/if}>
        </td>
        <td><{$user.user_intrest}></td>
    </tr>
<{/foreach}>
</table>
<{$bar|default:''}>
