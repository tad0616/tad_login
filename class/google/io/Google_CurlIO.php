<?php
/*
 * Copyright 2010 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Curl based implementation of apiIO.
 *
 * @author Chris Chabot <chabotc@google.com>
 * @author Chirag Shah <chirags@google.com>
 */
require_once 'Google_CacheParser.php';

class Google_CurlIO extends Google_IO
{
    private static $ENTITY_HTTP_METHODS = ['POST' => null, 'PUT' => null];
    private static $HOP_BY_HOP = [
      'connection', 'keep-alive', 'proxy-authenticate', 'proxy-authorization',
      'te', 'trailers', 'transfer-encoding', 'upgrade',
  ];

    private $curlParams = [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => 0,
      CURLOPT_FAILONERROR => false,
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_HEADER => true,
      CURLOPT_VERBOSE => false,
  ];

    /**
     * Check for cURL availability.
     */
    public function __construct()
    {
        if (!function_exists('curl_init')) {
            throw new Exception(
                'Google CurlIO client requires the CURL PHP extension'
      );
        }
    }

    /**
     * Perform an authenticated / signed apiHttpRequest.
     * This function takes the apiHttpRequest, calls apiAuth->sign on it
     * (which can modify the request in what ever way fits the auth mechanism)
     * and then calls apiCurlIO::makeRequest on the signed request
     *
     * @return Google_HttpRequest The resulting HTTP response including the
     * responseHttpCode, responseHeaders and responseBody.
     */
    public function authenticatedRequest(Google_HttpRequest $request)
    {
        $request = Google_Client::$auth->sign($request);

        return $this->makeRequest($request);
    }

    /**
     * Execute a apiHttpRequest
     *
     * @param Google_HttpRequest $request the http request to be executed
     * @throws Google_IOException on curl or IO error
     * @return Google_HttpRequest http request with the response http code, response
     * headers and response body filled in
     */
    public function makeRequest(Google_HttpRequest $request)
    {
        // First, check to see if we have a valid cached version.
        $cached = $this->getCachedRequest($request);
        if (false !== $cached) {
            if (!$this->checkMustRevaliadateCachedRequest($cached, $request)) {
                return $cached;
            }
        }

        if (array_key_exists(
            $request->getRequestMethod(),
            self::$ENTITY_HTTP_METHODS
    )) {
            $request = $this->processEntityRequest($request);
        }

        $ch = curl_init();
        curl_setopt_array($ch, $this->curlParams);
        curl_setopt($ch, CURLOPT_URL, $request->getUrl());
        if ($request->getPostBody()) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getPostBody());
        }

        $requestHeaders = $request->getRequestHeaders();
        if ($requestHeaders && is_array($requestHeaders)) {
            $parsed = [];
            foreach ($requestHeaders as $k => $v) {
                $parsed[] = "$k: $v";
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $parsed);
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request->getRequestMethod());
        curl_setopt($ch, CURLOPT_USERAGENT, $request->getUserAgent());
        $respData = curl_exec($ch);

        // Retry if certificates are missing.
        if (CURLE_SSL_CACERT == curl_errno($ch)) {
            error_log('SSL certificate problem, verify that the CA cert is OK.'
        . ' Retrying with the CA cert bundle from google-api-php-client.');
            curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacerts.pem');
            $respData = curl_exec($ch);
        }

        $respHeaderSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $respHttpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrorNum = curl_errno($ch);
        $curlError = curl_error($ch);
        curl_close($ch);
        if (CURLE_OK != $curlErrorNum) {
            throw new Google_IOException("HTTP Error: ($respHttpCode) $curlError");
        }

        // Parse out the raw response into usable bits
        list($responseHeaders, $responseBody) =
          self::parseHttpResponse($respData, $respHeaderSize);

        if (304 == $respHttpCode && $cached) {
            // If the server responded NOT_MODIFIED, return the cached request.
            $this->updateCachedRequest($cached, $responseHeaders);

            return $cached;
        }

        // Fill in the apiHttpRequest with the response values
        $request->setResponseHttpCode($respHttpCode);
        $request->setResponseHeaders($responseHeaders);
        $request->setResponseBody($responseBody);
        // Store the request in cache (the function checks to see if the request
        // can actually be cached)
        $this->setCachedRequest($request);
        // And finally return it
        return $request;
    }

    /**
     * Set options that update cURL's default behavior.
     * The list of accepted options are:
     * {@link http://php.net/manual/en/function.curl-setopt.php]
     *
     * @param array $optCurlParams Multiple options used by a cURL session.
     */
    public function setOptions($optCurlParams)
    {
        foreach ($optCurlParams as $key => $val) {
            $this->curlParams[$key] = $val;
        }
    }

    /**
     * @param $respData
     * @param $headerSize
     * @return array
     */
    private static function parseHttpResponse($respData, $headerSize)
    {
        if (false !== mb_stripos($respData, parent::CONNECTION_ESTABLISHED)) {
            $respData = str_ireplace(parent::CONNECTION_ESTABLISHED, '', $respData);
        }

        if ($headerSize) {
            $responseBody = mb_substr($respData, $headerSize);
            $responseHeaders = mb_substr($respData, 0, $headerSize);
        } else {
            list($responseHeaders, $responseBody) = explode("\r\n\r\n", $respData, 2);
        }

        $responseHeaders = self::parseResponseHeaders($responseHeaders);

        return [$responseHeaders, $responseBody];
    }

    private static function parseResponseHeaders($rawHeaders)
    {
        $responseHeaders = [];

        $responseHeaderLines = explode("\r\n", $rawHeaders);
        foreach ($responseHeaderLines as $headerLine) {
            if ($headerLine && false !== mb_strpos($headerLine, ':')) {
                list($header, $value) = explode(': ', $headerLine, 2);
                $header = mb_strtolower($header);
                if (isset($responseHeaders[$header])) {
                    $responseHeaders[$header] .= "\n" . $value;
                } else {
                    $responseHeaders[$header] = $value;
                }
            }
        }

        return $responseHeaders;
    }
}
