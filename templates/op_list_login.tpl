<{foreach from=$auth_method item=openid}>
    <{if $openid|default:false}>
        <a href="<{$openid.url}>" class="btn btn-info" style="position: relative; width:140px; height:180px; margin:4px 2px;">
        <img src="<{$openid.logo}>" alt="<{$openid.text}> login icon">
        <div class="text-center" style="width:120px; height:50px; position: absolute; bottom: 0; left: 2; white-space: normal; text-align: center;"><{$openid.text}></div>
        </a>
    <{/if}>
<{/foreach}>
