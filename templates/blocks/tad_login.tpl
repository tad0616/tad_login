<{if $block.mode=='login'}>
    <{foreach from=$block.auth_method item=openid}>
        <{if $openid|default:false}>
            <{if $block.use_big!='1'}>
                <{if $block.show_text=='1'}><div class="d-grid gap-2"><{/if}>
                    <a href="<{$openid.url}>" style="<{if $block.show_text=='1'}>width: 100%;<{elseif $block.show_btn=='1'}>width: 58px;<{else}>width: 48px;<{/if}> height: 48px; margin: 4px 2px; vertical-align: middle;<{if $block.show_btn!='1'}>display:inline-block;<{/if}>" <{if $block.show_btn=='1'}>class="btn btn-info <{if $block.show_text=='1'}>btn-block<{/if}>"<{/if}>><img src="<{$openid.logo}>" alt="<{$openid.text}> login icon" title="<{$openid.text}>" style="width: 32px; height: 32px; <{if $block.show_text=='1'}>float: left; margin-right:4px; white-space: normal;<{else}>marign:0px;<{/if}>">
                    <{if $block.show_text=='1'}><div style="padding-top:6px;"><{$openid.text}></div><div style="clear: both;"></div><{/if}>
                    </a>
                <{if $block.show_text=='1'}></div><{/if}>
            <{else}>
                <{if $block.show_btn!='1'}>
                    <div class="thumbnail" style="background-color: transparent; border: none;">
                        <a href="<{$openid.url}>"><img src="<{$openid.logo}>" alt="<{$openid.text}> login icon" title="<{$openid.text}>"></a>
                        <div class="text-center">
                        <h3><a href="<{$openid.url}>"><{$openid.text}></a></h3>
                        </div>
                    </div>
                <{else}>
                    <div class="d-grid gap-2">
                        <a href="<{$openid.url}>" class="btn btn-info btn-block bg-light text-dark">
                            <img src="<{$openid.logo}>" alt="<{$openid.text}> login icon" title="<{$openid.text}>">
                            <{if $block.show_text=='1'}><div class="text-center"><{$openid.text}></div><{/if}>
                        </a>
                    </div>
                <{/if}>
            <{/if}>
        <{/if}>
    <{/foreach}>
<{/if}>
