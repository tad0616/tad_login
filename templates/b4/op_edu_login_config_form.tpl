<form action="oidc" method="post" id="myForm" enctype="multipart/form-data">
    <{foreach from=$all_oidc key=unit  item=oidc}>
        <div class="form-group row">
            <label class="col-form-label text-md-right col-sm-2">
                <{$oidc.title}>
            </label>
            <div class="col-sm-5">
                <input type="text" name="oidc[<{$unit}>][clientid]" class="form-control " value="<{$oidc_setup.$unit.clientid}>" placeholder="<{$smarty.const._MA_TADLOGIN_CLIENTID}>">
            </div>
            <div class="col-sm-5">
                <input type="text" name="oidc[<{$unit}>][clientsecret]" class="form-control " value="<{$oidc_setup.$unit.clientsecret}>" placeholder="<{$smarty.const._MA_TADLOGIN_CLIENTSECRET}>">
            </div>
        </div>
    <{/foreach}>
    <{foreach from=$all_oidc2 key=unit item=oidc}>
        <!--學校代碼或Email-->
        <div class="form-group">
            <label class="control-label col-sm-2">
                <{$oidc.title}>
            </label>
            <div class="col-sm-5">
                <input type="text" name="oidc[<{$unit}>][clientid]" class="form-control " value="<{$oidc_setup.$unit.clientid}>" placeholder="<{$smarty.const._MA_TADLOGIN_CLIENTID}>">
            </div>
            <div class="col-sm-5">
                <input type="text" name="oidc[<{$unit}>][clientsecret]" class="form-control " value="<{$oidc_setup.$unit.clientsecret}>" placeholder="<{$smarty.const._MA_TADLOGIN_CLIENTSECRET}>">
            </div>
        </div>
    <{/foreach}>
    <div class="text-center">
        <!--編號-->
        <input type="hidden" name="op" value="save_tad_login_edu_config">
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
    </div>
</form>