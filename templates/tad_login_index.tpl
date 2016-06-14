<{$bootstrap}>
<{$jquery}>
<{$toolbar}>


<{if "facebook"|in_array:$auth_method}>
  <a href="<{$facebook}>" class="btn btn-default btn-lg btn-block"><img src="images/facebook.png" alt="<{$smarty.const._FACEBOOK}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._FACEBOOK}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "google"|in_array:$auth_method}>
<a href="<{$google}>" class="btn btn-default btn-lg btn-block"><img src="images/google.png" alt="<{$smarty.const._GOOGLE}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._GOOGLE}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>


<{if "yahoo"|in_array:$auth_method}>
<a href="index.php?login&op=yahoo" class="btn btn-default btn-lg btn-block"><img src="images/yahoo.png" alt="<{$smarty.const._YAHOO}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._YAHOO}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "myid"|in_array:$auth_method}>
<a href="index.php?login&op=myid" class="btn btn-default btn-lg btn-block"><img src="images/openid.png" alt="<{$smarty.const._MYID}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._MYID}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "kl"|in_array:$auth_method}>
<a href="index.php?login&op=kl" class="btn btn-default btn-lg btn-block"><img src="images/kl.png" alt="<{$smarty.const._KL}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._KL}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "tp"|in_array:$auth_method}>
<a href="index.php?login&op=tp" class="btn btn-default btn-lg btn-block"><img src="images/tp.png" alt="<{$smarty.const._TP}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._TP}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "ntpc"|in_array:$auth_method}>
<a href="index.php?login&op=ntpc" class="btn btn-default btn-lg btn-block"><img src="images/ntpc.png" alt="<{$smarty.const._NTPC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._NTPC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "tyc"|in_array:$auth_method}>
<a href="index.php?login&op=tyc" class="btn btn-default btn-lg btn-block"><img src="images/tyc.png" alt="<{$smarty.const._TYC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._TYC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>


<{if "hcc"|in_array:$auth_method}>
<a href="index.php?login&op=hcc" class="btn btn-default btn-lg btn-block"><img src="images/hcc.png" alt="<{$smarty.const._HCC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._HCC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>


<{if "hc"|in_array:$auth_method}>
<a href="index.php?login&op=hc" class="btn btn-default btn-lg btn-block"><img src="images/hc.png" alt="<{$smarty.const._HC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._HC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "mlc"|in_array:$auth_method}>
<a href="index.php?login&op=mlc" class="btn btn-default btn-lg btn-block"><img src="images/mlc.png" alt="<{$smarty.const._MLC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._MLC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "tc"|in_array:$auth_method}>
<a href="index.php?login&op=tc" class="btn btn-default btn-lg btn-block"><img src="images/tc.png" alt="<{$smarty.const._TC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._TC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "chc"|in_array:$auth_method}>
<a href="index.php?login&op=chc" class="btn btn-default btn-lg btn-block"><img src="images/chc.png" alt="<{$smarty.const._CHC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._CHC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "ntct"|in_array:$auth_method}>
<a href="index.php?login&op=ntct" class="btn btn-default btn-lg btn-block"><img src="images/ntct.png" alt="<{$smarty.const._NTCT}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._NTCT}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "ylc"|in_array:$auth_method}>
<a href="index.php?login&op=ylc" class="btn btn-default btn-lg btn-block"><img src="images/ylc.png" alt="<{$smarty.const._YLC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._YLC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "cyc"|in_array:$auth_method}>
<a href="index.php?login&op=cyc" class="btn btn-default btn-lg btn-block"><img src="images/cyc.png" alt="<{$smarty.const._CYC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._CYC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "cy"|in_array:$auth_method}>
<a href="index.php?login&op=cy" class="btn btn-default btn-lg btn-block"><img src="images/cy.png" alt="<{$smarty.const._CY}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._CY}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "tn"|in_array:$auth_method}>
<a href="index.php?op=tn" class="btn btn-default btn-lg btn-block"><img src="images/tn.png" alt="<{$smarty.const._TN}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._TN}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "kh"|in_array:$auth_method}>
<a href="index.php?op=kh" class="btn btn-default btn-lg btn-block"><img src="images/kh.png" alt="<{$smarty.const._KH}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._KH}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>



<{if "ptc"|in_array:$auth_method}>
<a href="index.php?login&op=ptc" class="btn btn-default btn-lg btn-block"><img src="images/ptc.png" alt="<{$smarty.const._PTC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._PTC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "ilc"|in_array:$auth_method}>
<a href="index.php?login&op=ilc" class="btn btn-default btn-lg btn-block"><img src="images/ilc.png" alt="<{$smarty.const._ILC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._ILC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "hlc"|in_array:$auth_method}>
<a href="index.php?login&op=hlc" class="btn btn-default btn-lg btn-block"><img src="images/hlc.png" alt="<{$smarty.const._HLC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._HLC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "ttct"|in_array:$auth_method}>
<a href="index.php?login&op=ttct" class="btn btn-default btn-lg btn-block"><img src="images/ttct.png" alt="<{$smarty.const._TTCT}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._TTCT}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "phc"|in_array:$auth_method}>
<a href="index.php?login&op=phc" class="btn btn-default btn-lg btn-block"><img src="images/phc.png" alt="<{$smarty.const._PHC}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._PHC}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "km"|in_array:$auth_method}>
<a href="index.php?login&op=km" class="btn btn-default btn-lg btn-block"><img src="images/km.png" alt="<{$smarty.const._KM}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._KM}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

<{if "mt"|in_array:$auth_method}>
<a href="index.php?login&op=mt" class="btn btn-default btn-lg btn-block"><img src="images/mt.png" alt="<{$smarty.const._MT}>"><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._MT}><{$smarty.const._MD_TADLOGIN_USE}><{$smarty.const._LOGIN}></a>
<{/if}>

