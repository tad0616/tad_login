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
include_once "../../../../mainfile.php";

global $apiConfig;

$modhandler      = xoops_gethandler('module');
$tad_loginModule = $modhandler->getByDirname("tad_login");
$config_handler  = xoops_gethandler('config');
$tad_loginConfig = $config_handler->getConfigsByCat(0, $tad_loginModule->getVar('mid'));

$apiConfig = array(
    // True if objects should be returned by the service classes.
    // False if associative arrays should be returned (default behavior).
    'use_objects'           => false,

    // The application_name is included in the User-Agent HTTP header.
    'application_name'      => $xoopsConfig['sitename'],

    // OAuth2 Settings, you can get these keys at https://code.google.com/apis/console
    'oauth2_client_id'      => trim($tad_loginConfig['google_appId']),
    'oauth2_client_secret'  => trim($tad_loginConfig['google_secret']),
    'oauth2_redirect_uri'   => XOOPS_URL . "/modules/tad_login/index.php",

    // The developer key, you get this at https://code.google.com/apis/console
    'developer_key'         => trim($tad_loginConfig['google_api_key']),

    // Site name to show in the Google's OAuth 1 authentication screen.
    'site_name'             => $_SERVER["HTTP_HOST"],

    // Which Authentication, Storage and HTTP IO classes to use.
    'authClass'             => 'Google_OAuth2',
    'ioClass'               => 'Google_CurlIO',
    'cacheClass'            => 'Google_FileCache',

    // Don't change these unless you're working against a special development or testing environment.
    'basePath'              => 'https://www.googleapis.com',

    // IO Class dependent configuration, you only have to configure the values
    // for the class that was configured as the ioClass above
    'ioFileCache_directory' =>
    (function_exists('sys_get_temp_dir') ?
        sys_get_temp_dir() . '/Google_Client' :
        '/tmp/Google_Client'),

    // Definition of service specific values like scopes, oauth token URLs, etc
    'services'              => array(
        'analytics'        => array('scope' => 'https://www.googleapis.com/auth/analytics.readonly'),
        'calendar'         => array(
            'scope' => array(
                "https://www.googleapis.com/auth/calendar",
                "https://www.googleapis.com/auth/calendar.readonly",
            ),
        ),
        'books'            => array('scope' => 'https://www.googleapis.com/auth/books'),
        'latitude'         => array(
            'scope' => array(
                'https://www.googleapis.com/auth/latitude.all.best',
                'https://www.googleapis.com/auth/latitude.all.city',
            ),
        ),
        'moderator'        => array('scope' => 'https://www.googleapis.com/auth/moderator'),
        'oauth2'           => array(
            'scope' => array(
                'https://www.googleapis.com/auth/userinfo.profile',
                'https://www.googleapis.com/auth/userinfo.email',
            ),
        ),
        'plus'             => array('scope' => 'https://www.googleapis.com/auth/plus.login'),
        'siteVerification' => array('scope' => 'https://www.googleapis.com/auth/siteverification'),
        'tasks'            => array('scope' => 'https://www.googleapis.com/auth/tasks'),
        'urlshortener'     => array('scope' => 'https://www.googleapis.com/auth/urlshortener'),
    ),
);
