<?php

// RP申請獲得
define('CLIENT_ID', '3b0d2d618fab231818e08ca605e1a74a');
define('CLIENT_SECRET', 'cfc3d40dee3657ed32c68174d3458061cde01e551d7aad31f1723c4a0804ca0e');
//
define('AUTH_SECRET', 'dWhvby50d0BnbWFpbC5jb20=');
//define('REDIR_URI0', 'http://openid.zipko.info/callback.php');
define('WELL_KNOWN_URL', 'https://oidc.tanet.edu.tw/.well-known/openid-configuration');
// 預設0由設定檔的URL決定；設定為1則每次皆由WELL_KNOWN取回END POINT URL
define('DYNAMICAL_ENDPOINT', 0);
// DYNAMICAL_ENDPOINT設為0下方三項需填寫
define('AUTH_ENDPOINT', 'https://oidc.tanet.edu.tw/oidc/v1/azp');
define('TOKEN_ENDPOINT', 'https://oidc.tanet.edu.tw/oidc/v1/token');
define('USERINFO_ENDPOINT', 'https://oidc.tanet.edu.tw/oidc/v1/userinfo');
define('JWKS_URI', 'https://oidc.tanet.edu.tw/oidc/v1/jwksets');
// PROFILE URL
define('PROFILE_ENDPOINT', 'https://oidc.tanet.edu.tw/moeresource/api/v1/oidc/profile');
