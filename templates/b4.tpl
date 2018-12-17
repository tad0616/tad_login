<{if $smarty.session.bootstrap==4}>
    <{includeq file="$xoops_rootpath/modules/tad_login/templates/b4/`$this_file`"}>
<{else}>
    <{includeq file="$xoops_rootpath/modules/tad_login/templates/b3/`$this_file`"}>
<{/if}>