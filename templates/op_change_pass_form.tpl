<h2><{$smarty.const._MD_TADLOGIN_CHANGE_PASSEOWD}></h2>
<form action="<{$xoops_url}>/modules/tad_login/index.php" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal">
    <div class="alert alert-info">
        <div class="input-group">
            <div class="input-group-prepend input-group-addon">
                <span class="input-group-text"><{$smarty.const._MD_TADLOGIN_EDIT_PASSEOWD}></span>
            </div>
            <input type="text" name="newpass" class="form-control validate[required]" placeholder="<{$smarty.const._MD_TADLOGIN_SET_PASSWORD|sprintf:$uname}> ">
            <div class="input-group-append input-group-btn">
                <input type="hidden" name="op" value="change_pass">
                <button type="submit" class="btn btn-primary"><{$smarty.const._MD_TADLOGIN_COMPLETE_BINDING}></button>
            </div>
        </div>
        <ol style="line-height: 3rem;">
            <{if $mode=='edit'}>
                <li><{$smarty.const._MD_TADLOGIN_EDIT_PASSEOWD_DESC1}></li>
                <li><{$smarty.const._MD_TADLOGIN_EDIT_PASSEOWD_DESC2}>
                </li>
                <li>
                    <{$smarty.const._MD_TADLOGIN_AFTER_BINDING}>
                    <img src="<{$xoops_url}>/modules/tad_login/images/tad_login1.png" alt="<{$smarty.const._MD_TADLOGIN_LOGIN_ICON}>" style="display: block; float:right;margin:6px;">
                        <ul>
                            <li><{$smarty.const._MD_TADLOGIN_EDIT_PASSEOWD_DESC3}></li>
                            <li><{$smarty.const._MD_TADLOGIN_EDIT_PASSEOWD_DESC4|sprintf:$uname}>
                            </li>
                            <li><{$smarty.const._MD_TADLOGIN_EDIT_PASSEOWD_DESC5}><br><a href="<{$xoops_url}>/modules/tad_login/"><{$xoops_url}>/modules/tad_login/</a></li>
                        </ul>
                <li><{$smarty.const._MD_TADLOGIN_EDIT_PASSEOWD_DESC6}></li>
            <{elseif $mode=='modify'}>
                <li><{$smarty.const._MD_TADLOGIN_EDIT_PASSEOWD_DESC7}><{$hashed_date}>
                    <div class="input-group">
                        <div class="input-group-prepend input-group-addon">
                            <span class="input-group-text"><{$smarty.const._MD_TADLOGIN_MODIFY_PASSEOWD}></span>
                        </div>
                        <input type="text" name="newpass" class="form-control validate[required]" placeholder="">
                        <input type="hidden" name="op" value="change_pass">
                        <div class="input-group-append input-group-btn">
                            <button type="submit" class="btn btn-primary"><{$smarty.const._MD_TADLOGIN_COMPLETE_MODIFY}></button>
                        </div>
                    </div>
                </li>
                <li><{$smarty.const._MD_TADLOGIN_EDIT_PASSEOWD_DESC8|sprintf:$uname}></li>
            <{/if}>
        </ol>
    </div>
</form>