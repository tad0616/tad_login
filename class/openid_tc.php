<?php

/**
 * This class provides a simple interface for OpenID (1.1 and 2.0) authentication.
 * Supports Yadis discovery.
 * The authentication process is stateless/dumb.
 *
 * Usage:
 * Sign-on with OpenID is a two step process:
 * Step one is authentication with the provider:
 * <code>
 * $openid = new LightOpenID('my-host.example.org');
 * $openid->identity = 'ID supplied by user';
 * header('Location: ' . $openid->authUrl());
 * </code>
 * The provider then sends various parameters via GET, one of them is openid_mode.
 * Step two is verification:
 * <code>
 * $openid = new LightOpenID('my-host.example.org');
 * if ($openid->mode) {
 *     echo $openid->validate() ? 'Logged in.' : 'Failed';
 * }
 * </code>
 *
 * Change the 'my-host.example.org' to your domain name. Do NOT use $_SERVER['HTTP_HOST']
 * for that, unless you know what you are doing.
 *
 * Optionally, you can set $returnUrl and $realm (or $trustRoot, which is an alias).
 * The default values for those are:
 * $openid->realm     = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
 * $openid->returnUrl = $openid->realm . $_SERVER['REQUEST_URI'];
 * If you don't know their meaning, refer to any openid tutorial, or specification. Or just guess.
 *
 * AX and SREG extensions are supported.
 * To use them, specify $openid->required and/or $openid->optional before calling $openid->authUrl().
 * These are arrays, with values being AX schema paths (the 'path' part of the URL).
 * For example:
 *   $openid->required = array('namePerson/friendly', 'contact/email');
 *   $openid->optional = array('namePerson/first');
 * If the server supports only SREG or OpenID 1.1, these are automaticaly
 * mapped to SREG names, so that user doesn't have to know anything about the server.
 *
 * To get the values, use $openid->getAttributes().
 *
 *
 * The library requires PHP >= 5.1.2 with curl or http/https stream wrappers enabled.
 * @author    Mewp
 * @copyright Copyright (c) 2010, Mewp
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class LightOpenID
{
    public $returnUrl;
    public $required = [];
    public $optional = [];
    public $verify_peer = null;
    public $capath = null;
    public $cainfo = null;
    public $data;
    private $identity;
    private $claimed_id;
    protected $server;
    protected $version;
    protected $trustRoot;
    protected $aliases;
    protected $identifier_select = false;
    protected $ax = false;
    protected $sreg = false;
    protected $setup_url = null;
    protected $headers = [];
    protected static $ax_to_sreg = [
        'namePerson/friendly' => 'nickname',
        'contact/email' => 'email',
        'namePerson' => 'fullname',
        'birthDate' => 'dob',
        'person/gender' => 'gender',
        'contact/postalCode/home' => 'postcode',
        'contact/country/home' => 'country',
        'pref/language' => 'language',
        'pref/timezone' => 'timezone',
    ];

    public function __construct($host)
    {
        $this->trustRoot = (mb_strpos($host, '://') ? $host : 'http://' . $host);
        if ((!empty($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS'])
            || (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])
                && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            $this->trustRoot = (mb_strpos($host, '://') ? $host : 'https://' . $host);
        }

        if (false !== ($host_end = mb_strpos($this->trustRoot, '/', 8))) {
            $this->trustRoot = mb_substr($this->trustRoot, 0, $host_end);
        }

        $uri = rtrim(preg_replace('#((?<=\?)|&)openid\.[^&]+#', '', $_SERVER['REQUEST_URI']), '?');
        $this->returnUrl = $this->trustRoot . $uri;

        $this->data = ('POST' === $_SERVER['REQUEST_METHOD']) ? $_POST : $_GET;

        if (!function_exists('curl_init') && !in_array('https', stream_get_wrappers(), true)) {
            throw new ErrorException('You must have either https wrappers or curl enabled.');
        }
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'identity':
                if (mb_strlen($value = trim((string)$value))) {
                    if (preg_match('#^xri:/*#i', $value, $m)) {
                        $value = mb_substr($value, mb_strlen($m[0]));
                    } elseif (!preg_match('/^(?:[=@+\$!\(]|https?:)/i', $value)) {
                        $value = "http://$value";
                    }
                    if (preg_match('#^https?://[^/]+$#i', $value, $m)) {
                        $value .= '/';
                    }
                }
                $this->$name = $this->claimed_id = $value;
                break;
            case 'trustRoot':
            case 'realm':
                $this->trustRoot = trim($value);
        }
    }

    public function __get($name)
    {
        switch ($name) {
            case 'identity':
                # We return claimed_id instead of identity,
                # because the developer should see the claimed identifier,
                # i.e. what he set as identity, not the op-local identifier (which is what we verify)
                return $this->claimed_id;
            case 'trustRoot':
            case 'realm':
                return $this->trustRoot;
            case 'mode':
                return empty($this->data['openid_mode']) ? null : $this->data['openid_mode'];
        }
    }

    /**
     * Checks if the server specified in the url exists.
     *
     * @param $url url to check
     * @return true, if the server exists; false otherwise
     */
    public function hostExists($url)
    {
        if (false === mb_strpos($url, '/')) {
            $server = $url;
        } else {
            $server = @parse_url($url, PHP_URL_HOST);
        }

        if (!$server) {
            return false;
        }

        return !!gethostbynamel($server);
    }

    protected function request_curl($url, $method, $params, $update_claimed_id)
    {
        $params = http_build_query($params, '', '&');
        $curl = curl_init($url . ('GET' === $method && $params ? '?' . $params : ''));
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: application/xrds+xml, */*']);

        if (null !== $this->verify_peer) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->verify_peer);
            if ($this->capath) {
                curl_setopt($curl, CURLOPT_CAPATH, $this->capath);
            }

            if ($this->cainfo) {
                curl_setopt($curl, CURLOPT_CAINFO, $this->cainfo);
            }
        }

        if ('POST' === $method) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        } elseif ('HEAD' === $method) {
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_NOBODY, true);
        } else {
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_HTTPGET, true);
        }
        $response = curl_exec($curl);

        if ('HEAD' === $method && 405 == curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
            curl_setopt($curl, CURLOPT_HTTPGET, true);
            $response = curl_exec($curl);
            $response = mb_substr($response, 0, mb_strpos($response, "\r\n\r\n"));
        }

        if ('HEAD' === $method || 'GET' === $method) {
            $header_response = $response;

            # If it's a GET request, we want to only parse the header part.
            if ('GET' === $method) {
                $header_response = mb_substr($response, 0, mb_strpos($response, "\r\n\r\n"));
            }

            $headers = [];
            foreach (explode("\n", $header_response) as $header) {
                $pos = mb_strpos($header, ':');
                if (false !== $pos) {
                    $name = mb_strtolower(trim(mb_substr($header, 0, $pos)));
                    $headers[$name] = trim(mb_substr($header, $pos + 1));
                }
            }

            if ($update_claimed_id) {
                # Updating claimed_id in case of redirections.
                $effective_url = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
                if ($effective_url != $url) {
                    $this->identity = $this->claimed_id = $effective_url;
                }
            }

            if ('HEAD' === $method) {
                return $headers;
            }
            $this->headers = $headers;
        }

        if (curl_errno($curl)) {
            throw new ErrorException(curl_error($curl), curl_errno($curl));
        }

        return $response;
    }

    protected function parse_header_array($array, $update_claimed_id)
    {
        $headers = [];
        foreach ($array as $header) {
            $pos = mb_strpos($header, ':');
            if (false !== $pos) {
                $name = mb_strtolower(trim(mb_substr($header, 0, $pos)));
                $headers[$name] = trim(mb_substr($header, $pos + 1));

                # Following possible redirections. The point is just to have
                # claimed_id change with them, because the redirections
                # are followed automatically.
                # We ignore redirections with relative paths.
                # If any known provider uses them, file a bug report.
                if ('location' === $name && $update_claimed_id) {
                    if (0 === mb_strpos($headers[$name], 'http')) {
                        $this->identity = $this->claimed_id = $headers[$name];
                    } elseif ('/' === $headers[$name][0]) {
                        $parsed_url = parse_url($this->claimed_id);
                        $this->identity = $this->claimed_id = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $headers[$name];
                    }
                }
            }
        }

        return $headers;
    }

    protected function request_streams($url, $method, $params, $update_claimed_id)
    {
        if (!$this->hostExists($url)) {
            throw new ErrorException("Could not connect to $url.", 404);
        }

        $params = http_build_query($params, '', '&');
        switch ($method) {
            case 'GET':
                $opts = [
                    'http' => [
                        'method' => 'GET',
                        'header' => 'Accept: application/xrds+xml, */*',
                        'ignore_errors' => true,
                    ],
                    'ssl' => [
                        'CN_match' => parse_url($url, PHP_URL_HOST),
                    ],
                ];
                $url = $url . ($params ? '?' . $params : '');
                break;
            case 'POST':
                $opts = [
                    'http' => [
                        'method' => 'POST',
                        'header' => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $params,
                        'ignore_errors' => true,
                    ],
                    'ssl' => [
                        'CN_match' => parse_url($url, PHP_URL_HOST),
                    ],
                ];
                break;
            case 'HEAD':
                # We want to send a HEAD request,
                # but since get_headers doesn't accept $context parameter,
                # we have to change the defaults.
                $default = stream_context_get_options(stream_context_get_default());
                stream_context_get_default([
                                               'http' => [
                                                   'method' => 'HEAD',
                                                   'header' => 'Accept: application/xrds+xml, */*',
                                                   'ignore_errors' => true,
                                               ],
                                               'ssl' => [
                                                   'CN_match' => parse_url($url, PHP_URL_HOST),
                                               ],
                                           ]);

                $url = $url . ($params ? '?' . $params : '');
                $headers = get_headers($url);
                if (!$headers) {
                    return [];
                }

                if (405 == (int)mb_substr($headers[0], mb_strlen('HTTP/1.1 '))) {
                    # The server doesn't support HEAD, so let's emulate it with
                    # a GET.
                    $args = func_get_args();
                    $args[1] = 'GET';
                    call_user_func_array([$this, 'request_streams'], $args);

                    return $this->headers;
                }

                $headers = $this->parse_header_array($headers, $update_claimed_id);

                # And restore them.
                stream_context_get_default($default);

                return $headers;
        }

        if ($this->verify_peer) {
            $opts['ssl'] += [
                'verify_peer' => true,
                'capath' => $this->capath,
                'cafile' => $this->cainfo,
            ];
        }

        $context = stream_context_create($opts);
        $data = file_get_contents($url, false, $context);
        # This is a hack for providers who don't support HEAD requests.
        # It just creates the headers array for the last request in $this->headers.
        if (isset($http_response_header)) {
            $this->headers = $this->parse_header_array($http_response_header, $update_claimed_id);
        }

        return file_get_contents($url, false, $context);
    }

    protected function request($url, $method = 'GET', $params = [], $update_claimed_id = false)
    {
        if (function_exists('curl_init')
            && (!in_array('https', stream_get_wrappers(), true) || !ini_get('safe_mode') && !ini_get('open_basedir'))) {
            return $this->request_curl($url, $method, $params, $update_claimed_id);
        }

        return $this->request_streams($url, $method, $params, $update_claimed_id);
    }

    protected function build_url($url, $parts)
    {
        if (isset($url['query'], $parts['query'])) {
            $parts['query'] = $url['query'] . '&' . $parts['query'];
        }

        $url = $parts + $url;
        $url = $url['scheme']
               . '://'
               . (empty($url['username']) ? '' : (empty($url['password']) ? "{$url['username']}@" : "{$url['username']}:{$url['password']}@"))
               . $url['host']
               . (empty($url['port']) ? '' : ":{$url['port']}")
               . (empty($url['path']) ? '' : $url['path'])
               . (empty($url['query']) ? '' : "?{$url['query']}")
               . (empty($url['fragment']) ? '' : "#{$url['fragment']}");

        return $url;
    }

    /**
     * Helper function used to scan for <meta>/<link> tags and extract information
     * from them
     * @param mixed $content
     * @param mixed $tag
     * @param mixed $attrName
     * @param mixed $attrValue
     * @param mixed $valueName
     */
    protected function htmlTag($content, $tag, $attrName, $attrValue, $valueName)
    {
        preg_match_all("#<{$tag}[^>]*$attrName=['\"].*?$attrValue.*?['\"][^>]*$valueName=['\"](.+?)['\"][^>]*/?>#i", $content, $matches1);
        preg_match_all("#<{$tag}[^>]*$valueName=['\"](.+?)['\"][^>]*$attrName=['\"].*?$attrValue.*?['\"][^>]*/?>#i", $content, $matches2);

        $result = array_merge($matches1[1], $matches2[1]);

        return empty($result) ? false : $result[0];
    }

    /**
     * Performs Yadis and HTML discovery. Normally not used.
     * @param $url Identity URL.
     * @throws ErrorException
     * @return string OP Endpoint (i.e. OpenID provider address).
     */
    public function discover($url)
    {
        if (!$url) {
            throw new ErrorException('No identity supplied.');
        }

        # Use xri.net proxy to resolve i-name identities
        if (!preg_match('#^https?:#', $url)) {
            $url = "https://xri.net/$url";
        }

        # We save the original url in case of Yadis discovery failure.
        # It can happen when we'll be lead to an XRDS document
        # which does not have any OpenID2 services.
        $originalUrl = $url;

        # A flag to disable yadis discovery in case of failure in headers.
        $yadis = true;

        # We'll jump a maximum of 5 times, to avoid endless redirections.
        for ($i = 0; $i < 5; $i++) {
            if ($yadis) {
                $headers = $this->request($url, 'HEAD', [], true);

                $next = false;
                if (isset($headers['x-xrds-location'])) {
                    $url = $this->build_url(parse_url($url), parse_url(trim($headers['x-xrds-location'])));
                    $next = true;
                }

                if (isset($headers['content-type'])
                    && (false !== mb_strpos($headers['content-type'], 'application/xrds+xml')
                        || false !== mb_strpos($headers['content-type'], 'text/xml'))) {
                    # Apparently, some providers return XRDS documents as text/html.
                    # While it is against the spec, allowing this here shouldn't break
                    # compatibility with anything.
                    # ---
                    # Found an XRDS document, now let's find the server, and optionally delegate.
                    $content = $this->request($url, 'GET');

                    preg_match_all('#<Service.*?>(.*?)</Service>#s', $content, $m);
                    foreach ($m[1] as $content) {
                        $content = ' ' . $content; # The space is added, so that strpos doesn't return 0.

                        # OpenID 2
                        $ns = preg_quote('http://specs.openid.net/auth/2.0/', '#');
                        if (preg_match('#<Type>\s*' . $ns . '(server|signon)\s*</Type>#s', $content, $type)) {
                            if ('server' === $type[1]) {
                                $this->identifier_select = true;
                            }

                            preg_match('#<URI.*?>(.*)</URI>#', $content, $server);
                            preg_match('#<(Local|Canonical)ID>(.*)</\1ID>#', $content, $delegate);
                            if (empty($server)) {
                                return false;
                            }
                            # Does the server advertise support for either AX or SREG?
                            $this->ax = (bool)mb_strpos($content, '<Type>http://openid.net/srv/ax/1.0</Type>');
                            $this->sreg = mb_strpos($content, '<Type>http://openid.net/sreg/1.0</Type>')
                                          || mb_strpos($content, '<Type>http://openid.net/extensions/sreg/1.1</Type>');

                            $server = $server[1];
                            if (isset($delegate[2])) {
                                $this->identity = trim($delegate[2]);
                            }

                            $this->version = 2;

                            $this->server = $server;

                            return $server;
                        }

                        # OpenID 1.1
                        $ns = preg_quote('http://openid.net/signon/1.1', '#');
                        if (preg_match('#<Type>\s*' . $ns . '\s*</Type>#s', $content)) {
                            preg_match('#<URI.*?>(.*)</URI>#', $content, $server);
                            preg_match('#<.*?Delegate>(.*)</.*?Delegate>#', $content, $delegate);
                            if (empty($server)) {
                                return false;
                            }
                            # AX can be used only with OpenID 2.0, so checking only SREG
                            $this->sreg = mb_strpos($content, '<Type>http://openid.net/sreg/1.0</Type>')
                                          || mb_strpos($content, '<Type>http://openid.net/extensions/sreg/1.1</Type>');

                            $server = $server[1];
                            if (isset($delegate[1])) {
                                $this->identity = $delegate[1];
                            }

                            $this->version = 1;

                            $this->server = $server;

                            return $server;
                        }
                    }

                    $next = true;
                    $yadis = false;
                    $url = $originalUrl;
                    $content = null;
                    break;
                }
                if ($next) {
                    continue;
                }

                # There are no relevant information in headers, so we search the body.
                $content = $this->request($url, 'GET', [], true);

                if (isset($this->headers['x-xrds-location'])) {
                    $url = $this->build_url(parse_url($url), parse_url(trim($this->headers['x-xrds-location'])));
                    continue;
                }

                $location = $this->htmlTag($content, 'meta', 'http-equiv', 'X-XRDS-Location', 'content');
                if ($location) {
                    $url = $this->build_url(parse_url($url), parse_url($location));
                    continue;
                }
            }

            if (!$content) {
                $content = $this->request($url, 'GET');
            }

            # At this point, the YADIS Discovery has failed, so we'll switch
            # to openid2 HTML discovery, then fallback to openid 1.1 discovery.
            $server = $this->htmlTag($content, 'link', 'rel', 'openid2.provider', 'href');
            $delegate = $this->htmlTag($content, 'link', 'rel', 'openid2.local_id', 'href');
            $this->version = 2;

            if (!$server) {
                # The same with openid 1.1
                $server = $this->htmlTag($content, 'link', 'rel', 'openid.server', 'href');
                $delegate = $this->htmlTag($content, 'link', 'rel', 'openid.delegate', 'href');
                $this->version = 1;
            }

            if ($server) {
                # We found an OpenID2 OP Endpoint
                if ($delegate) {
                    # We have also found an OP-Local ID.
                    $this->identity = $delegate;
                }
                $this->server = $server;

                return $server;
            }

            throw new ErrorException("No OpenID Server found at $url", 404);
        }
        throw new ErrorException('Endless redirection!', 500);
    }

    protected function sregParams()
    {
        $params = [];
        # We always use SREG 1.1, even if the server is advertising only support for 1.0.
        # That's because it's fully backwards compatibile with 1.0, and some providers
        # advertise 1.0 even if they accept only 1.1. One such provider is myopenid.com
        $params['openid.ns.sreg'] = 'http://openid.net/extensions/sreg/1.1';
        if ($this->required) {
            $params['openid.sreg.required'] = [];
            foreach ($this->required as $required) {
                if (!isset(self::$ax_to_sreg[$required])) {
                    continue;
                }

                $params['openid.sreg.required'][] = self::$ax_to_sreg[$required];
            }
            $params['openid.sreg.required'] = implode(',', $params['openid.sreg.required']);
        }

        if ($this->optional) {
            $params['openid.sreg.optional'] = [];
            foreach ($this->optional as $optional) {
                if (!isset(self::$ax_to_sreg[$optional])) {
                    continue;
                }

                $params['openid.sreg.optional'][] = self::$ax_to_sreg[$optional];
            }
            $params['openid.sreg.optional'] = implode(',', $params['openid.sreg.optional']);
        }

        return $params;
    }

    protected function axParams()
    {
        $params = [];
        if ($this->required || $this->optional) {
            $params['openid.ns.ax'] = 'http://openid.net/srv/ax/1.0';
            $params['openid.ax.mode'] = 'fetch_request';
            $this->aliases = [];
            $counts = [];
            $required = [];
            $optional = [];
            foreach (['required', 'optional'] as $type) {
                foreach ($this->$type as $alias => $field) {
                    if (is_int($alias)) {
                        $alias = strtr($field, '/', '_');
                    }

                    $this->aliases[$alias] = 'http://openid.edu.tw/' . $field;
                    if (empty($counts[$alias])) {
                        $counts[$alias] = 0;
                    }

                    $counts[$alias] += 1;
                    ${$type}[] = $alias;
                }
            }
            foreach ($this->aliases as $alias => $ns) {
                $params['openid.ax.type.' . $alias] = $ns;
            }
            foreach ($counts as $alias => $count) {
                if (1 == $count) {
                    continue;
                }

                $params['openid.ax.count.' . $alias] = $count;
            }

            # Don't send empty ax.requied and ax.if_available.
            # Google and possibly other providers refuse to support ax when one of these is empty.
            if ($required) {
                $params['openid.ax.required'] = implode(',', $required);
            }
            if ($optional) {
                $params['openid.ax.if_available'] = implode(',', $optional);
            }
        }

        return $params;
    }

    protected function authUrl_v1($immediate)
    {
        $returnUrl = $this->returnUrl;
        # If we have an openid.delegate that is different from our claimed id,
        # we need to somehow preserve the claimed id between requests.
        # The simplest way is to just send it along with the return_to url.
        if ($this->identity != $this->claimed_id) {
            $returnUrl .= (mb_strpos($returnUrl, '?') ? '&' : '?') . 'openid.claimed_id=' . $this->claimed_id;
        }

        $params = [
                      'openid.return_to' => $returnUrl,
                      'openid.mode' => $immediate ? 'checkid_immediate' : 'checkid_setup',
                      'openid.identity' => $this->identity,
                      'openid.trust_root' => $this->trustRoot,
                  ] + $this->sregParams();

        return $this->build_url(parse_url($this->server), ['query' => http_build_query($params, '', '&')]);
    }

    protected function authUrl_v2($immediate)
    {
        $params = [
            'openid.ns' => 'http://specs.openid.net/auth/2.0',
            'openid.mode' => $immediate ? 'checkid_immediate' : 'checkid_setup',
            'openid.return_to' => $this->returnUrl,
            'openid.realm' => $this->trustRoot,
        ];
        if ($this->ax) {
            $params += $this->axParams();
        }
        if ($this->sreg) {
            $params += $this->sregParams();
        }
        if (!$this->ax && !$this->sreg) {
            # If OP doesn't advertise either SREG, nor AX, let's send them both
            # in worst case we don't get anything in return.
            $params += $this->axParams() + $this->sregParams();
        }

        if ($this->identifier_select) {
            $params['openid.identity'] = $params['openid.claimed_id'] = 'http://specs.openid.net/auth/2.0/identifier_select';
        } else {
            $params['openid.identity'] = $this->identity;
            $params['openid.claimed_id'] = $this->claimed_id;
        }

        return $this->build_url(parse_url($this->server), ['query' => http_build_query($params, '', '&')]);
    }

    /**
     * Returns authentication url. Usually, you want to redirect your user to it.
     * @param mixed $immediate
     * @throws ErrorException
     * @return string The authentication url.
     */
    public function authUrl($immediate = false)
    {
        if ($this->setup_url && !$immediate) {
            return $this->setup_url;
        }

        if (!$this->server) {
            $this->discover($this->identity);
        }

        if (2 == $this->version) {
            return $this->authUrl_v2($immediate);
        }

        return $this->authUrl_v1($immediate);
    }

    /**
     * Performs OpenID verification with the OP.
     * @throws ErrorException
     * @return bool Whether the verification was successful.
     */
    public function validate()
    {
        # If the request was using immediate mode, a failure may be reported
        # by presenting user_setup_url (for 1.1) or reporting
        # mode 'setup_needed' (for 2.0). Also catching all modes other than
        # id_res, in order to avoid throwing errors.
        if (isset($this->data['openid_user_setup_url'])) {
            $this->setup_url = $this->data['openid_user_setup_url'];

            return false;
        }
        if ('id_res' !== $this->mode) {
            return false;
        }

        $this->claimed_id = isset($this->data['openid_claimed_id']) ? $this->data['openid_claimed_id'] : $this->data['openid_identity'];
        $params = [
            'openid.assoc_handle' => $this->data['openid_assoc_handle'],
            'openid.signed' => $this->data['openid_signed'],
            'openid.sig' => $this->data['openid_sig'],
        ];

        if (isset($this->data['openid_ns'])) {
            # We're dealing with an OpenID 2.0 server, so let's set an ns
            # Even though we should know location of the endpoint,
            # we still need to verify it by discovery, so $server is not set here
            $params['openid.ns'] = 'http://specs.openid.net/auth/2.0';
        } elseif (isset($this->data['openid_claimed_id'])
                  && $this->data['openid_claimed_id'] != $this->data['openid_identity']) {
            # If it's an OpenID 1 provider, and we've got claimed_id,
            # we have to append it to the returnUrl, like authUrl_v1 does.
            $this->returnUrl .= (mb_strpos($this->returnUrl, '?') ? '&' : '?') . 'openid.claimed_id=' . $this->claimed_id;
        }

        if ($this->data['openid_return_to'] != $this->returnUrl) {
            # The return_to url must match the url of current request.
            # I'm assuing that noone will set the returnUrl to something that doesn't make sense.
            return false;
        }

        $server = $this->discover($this->claimed_id);

        foreach (explode(',', $this->data['openid_signed']) as $item) {
            # Checking whether magic_quotes_gpc is turned on, because
            # the function may fail if it is. For example, when fetching
            # AX namePerson, it might containg an apostrophe, which will be escaped.
            # In such case, validation would fail, since we'd send different data than OP
            # wants to verify. stripslashes() should solve that problem, but we can't
            # use it when magic_quotes is off.
            $value = $this->data['openid_' . str_replace('.', '_', $item)];
            $params['openid.' . $item] = function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() ? stripslashes($value) : $value;
        }

        $params['openid.mode'] = 'check_authentication';

        $response = $this->request($server, 'POST', $params);

        return preg_match('/is_valid\s*:\s*true/i', $response);
    }

    protected function getAxAttributes()
    {
        $alias = null;
        if (isset($this->data['openid_ns_ax'])
            && 'http://openid.net/srv/ax/1.0' !== $this->data['openid_ns_ax']) {
            # It's the most likely case, so we'll check it before
            $alias = 'ax';
        } else {
            # 'ax' prefix is either undefined, or points to another extension,
            # so we search for another prefix
            //die(var_dump($this->data));
            foreach ($this->data as $key => $val) {
                if ('openid_ns_' === mb_substr($key, 0, mb_strlen('openid_ns_'))
                    && 'http://openid.net/srv/ax/1.0' === $val) {
                    $alias = mb_substr($key, mb_strlen('openid_ns_'));
                    break;
                }
            }
        }
        if (!$alias) {
            # An alias for AX schema has not been found,
            # so there is no AX data in the OP's response
            return [];
        }

        $attributes = [];
        foreach (explode(',', $this->data['openid_signed']) as $key) {
            $keyMatch = $alias . '.value.';
            if (mb_substr($key, 0, mb_strlen($keyMatch)) != $keyMatch) {
                continue;
            }
            $key = mb_substr($key, mb_strlen($keyMatch));
            if (!isset($this->data['openid_' . $alias . '_type_' . $key])) {
                # OP is breaking the spec by returning a field without
                # associated ns. This shouldn't happen, but it's better
                # to check, than cause an E_NOTICE.
                continue;
            }
            $value = $this->data['openid_' . $alias . '_value_' . $key];
            $key = mb_substr($this->data['openid_' . $alias . '_type_' . $key], mb_strlen('http://openid.edu.tw/'));

            $attributes[$key] = $value;
        }

        return $attributes;
    }

    protected function getSregAttributes()
    {
        $attributes = [];
        $sreg_to_ax = array_flip(self::$ax_to_sreg);
        foreach (explode(',', $this->data['openid_signed']) as $key) {
            $keyMatch = 'ext1.';
            if (mb_substr($key, 0, mb_strlen($keyMatch)) != $keyMatch) {
                continue;
            }
            $key = mb_substr($key, mb_strlen($keyMatch));
            if (!isset($sreg_to_ax[$key])) {
                # The field name isn't part of the SREG spec, so we ignore it.
                continue;
            }
            $attributes[$sreg_to_ax[$key]] = $this->data['openid_ext1_' . $key];
        }

        return $attributes;
    }

    /**
     * Gets AX/SREG attributes provided by OP. should be used only after successful validaton.
     * Note that it does not guarantee that any of the required/optional parameters will be present,
     * or that there will be no other attributes besides those specified.
     * In other words. OP may provide whatever information it wants to.
     *     * SREG names will be mapped to AX names.
     *     * @return Array Array of attributes with keys being the AX schema names, e.g. 'contact/email'
     * @see http://www.axschema.org/types/
     */
    public function getAttributes()
    {
        if (isset($this->data['openid_ns'])
            && 'http://specs.openid.net/auth/2.0' === $this->data['openid_ns']) {
            # OpenID 2.0
            # We search for both AX and SREG attributes, with AX taking precedence.
            //die(var_dump($this->getAxAttributes()).var_dump($this->getSregAttributes()));
            return $this->getAxAttributes() + $this->getSregAttributes();
        }

        return $this->getSregAttributes();
    }
}
