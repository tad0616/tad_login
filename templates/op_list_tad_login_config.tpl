<!-- 上標下格 -->
<div class="vtable">
    <ul class="vhead">
        <li><{$smarty.const._MA_TADLOGIN_ITEM}></li>
        <li><{$smarty.const._MA_TADLOGIN_JOB}></li>
        <li><{$smarty.const._MA_TADLOGIN_GROUP_ID}></li>
        <li><{$smarty.const._TAD_FUNCTION}></li>
    </ul>

    <{foreach from=$all_content item=data}>
        <ul>
            <li class="vcell"><{$smarty.const._MA_TADLOGIN_ITEM}></li>
            <li class="vm"><{$data.item}></li>
            <li class="vcell"><{$smarty.const._MA_TADLOGIN_JOB}></li>
            <li class="vm"><{$data.kind}></li>
            <li class="vcell"><{$smarty.const._MA_TADLOGIN_GROUP_ID}></li>
            <li class="vm"><span class="badge"><{$data.group_id}></span><{$data.group_name}></li>
            <li class="vcell"><{$smarty.const._TAD_FUNCTION}></li>
            <li class="vm"><a href="javascript:delete_tad_login_config_func(<{$data.config_id}>);" class="btn btn-sm btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> <{$smarty.const._TAD_DEL}></a>
                <a href="<{$action|default:''}>?op=tad_login_config_form&config_id=<{$data.config_id}>" class="btn btn-sm btn-xs btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i>  <{$smarty.const._TAD_EDIT}></a></li>
        </ul>
    <{/foreach}>
</div>


<div class="text-center" style="margin: 30px;">
    <a href="<{$action|default:''}>?op=tad_login_config_form" class="btn btn-info"><i class="fa fa-square-plus" aria-hidden="true"></i>  <{$smarty.const._TAD_ADD}></a>
</div>
