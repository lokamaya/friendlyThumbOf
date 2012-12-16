<?php
/**
 * friendlyThumbOf
 * File: assets/components/friendlythumbof/connector.php
 * This extra depend on phpThumbOf
 *
 * Copyright 2012 by Zaenal <Twitter @lokamaya>
 *
 * Distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * @package friendlyThumbOf
**/
/**
 *
 * Example 1: Output URL
 * ----------- 
 * url format http(s)://mydomain.com/{friendlythumbof_base_uri}/{context_key}/{friendlythumbof_mode}/path_to_file/myimage.(jpg|jpeg|png|gif)
 *
 * thumb  -> http://www.mydomain.com/image/web/thumb/my-photo.jpg
 * medium -> http://www.mydomain.com/image/web/medium/my-photo.jpg
 * large  -> http://www.mydomain.com/image/web/large/my-photo.jpg
 * advanced (if enabled):
 &        -> http://www.mydomain.com/image/web/advanced/my-photo.{hash}.jpg
 *
**/
include_once("./friendlythumbof.function.php");

define('MODX_API_MODE', true);
define('FRIENDLYTHUMBOF_BASE', friendlythumbof_fancy_path(dirname(__FILE__))) . '/'; // absolute path to directory of this file
define('FRIENDLYTHUMBOF_MODX_BASE', dirname(dirname(dirname(FRIENDLYTHUMBOF_BASE))) . '/'); // absolute path to MODx installation directory

include_once(FRIENDLYTHUMBOF_MODX_BASE . "config.core.php");
if (!defined('MODX_CORE_PATH')) define('MODX_CORE_PATH', FRIENDLYTHUMBOF_MODX_BASE . '/core/');

/* get request and cleanup */
$context = (string)isset($_GET['context_image']) ? trim($_GET['context_image']) : '';
$context = preg_replace("@\W+@",'',$context);

/* include the modX class */
if (!@include_once (MODX_CORE_PATH . "model/modx/modx.class.php")) {
    $errorMessage = 'Image temporarily unavailable';
    @include(MODX_CORE_PATH . 'error/unavailable.include.php');
    header('HTTP/1.1 503 Service Unavailable');
    echo "<html><title>Error 503: Site temporarily unavailable</title><body><h1>Error 503</h1><p>{$errorMessage}</p></body></html>";
    exit();
}

/* Create an instance of the modX class */
$modx= new modX();
if (!is_object($modx) || !($modx instanceof modX)) {
    $errorMessage = '<a href="setup/">MODX not installed. Install now?</a>';
    @include(MODX_CORE_PATH . 'error/unavailable.include.php');
    header('HTTP/1.1 503 Service Unavailable');
    echo "<html><title>Error 503: Site temporarily unavailable</title><body><h1>Error 503</h1><p>{$errorMessage}</p></body></html>";
    exit();
}

/* start output buffering */
ob_start();

/** 
 * Initialize context
 * - Context must be initialized, or $modx->getOption will not works (empty result)
 * - Pass "session_enable=0" to disable session (http://develop.modx.com/blog/2012/04/05/new-for-2.2.1-session-less-contexts/) 
**/

if (empty($context)) {
    $modx->initialize('web', array('session_enabled'=>0));
} else if ($context == 'mgr') {
    if (!(boolean)$modx->getOption('friendlythumbof.allow_mgr_context', null, false)) {
        friendlythumbof_not_found("[E-0] Not allowed to access mgr context");
    } else {
        $modx->initialize('mgr', array('session_enabled'=>1));
        if (!$modx->user->hasSessionContext('mgr')) {
            friendlythumbof_not_found("[E-0] Can not access mgr context. Login required.");
        }
    }
} else {
    $modx->initialize($context, array('session_enabled'=>0));
}

/* check direct access if friendly url enabled */
$allow_friendly = (boolean)$modx->getOption('friendlythumb.allow_friendly', null, true);
$direct_access  = false;
if (basename($_SERVER['REQUEST_URI']) == basename(__FILE__)) {
    if ($allow_friendly && $context != 'mgr') {
        friendlythumbof_not_found("[E-2a] Direct access detected");
    }
    $direct_access = true;
}

/* Temporarily disable phpthumbof.postfix_property_hash and phpthumbof.hash_thumbnail_names, but don't save it */
$modx->setOption('phpthumbof.hash_thumbnail_names', 0);
$modx->setOption('phpthumbof.postfix_property_hash', 0);
//$modx->setOption('phpthumbof.cache_path', $cachePath);
//$modx->setOption('phpthumbof.cache_path_url', $cachePathUrl);

/* friendlythumbof_options */
$fto_options = friendlythumbof_get_options($modx);

$mode    = (string)isset($_GET['mode']) ? (trim($_GET['mode'])) : '';
$mode    = preg_replace("@\W+@",'',$mode);
$input   = (string)isset($_GET['input']) ? (string)(trim($_GET['input'])) : '';
$input   = strip_tags($input);

$imageProperties = $fto_options;
$imageProperties['friendlythumbof.allow_friendly'] = $allow_friendly;
$imageProperties['direct']    = $direct_access;
$imageProperties['base_url']  = $modx->context->getOption('base_url',null,'');
$imageProperties['input']     = $input;
$imageProperties['context']   = $context;
$imageProperties['mode']      = $mode;
$imageProperties['imagemode'] = $modx->getOption('friendlythumbof.imagemode_'.$mode,null,null);

$cacheinfo = friendlythumbof_generate_url($imageProperties);

/* parse request */
friendlythumbof_validate_request($imageProperties);

if ($direct_access && file_exists($cacheinfo['cache'])) {
    friendlythumbof_output_image($cacheinfo['cache'], $context);
}

/* scriptProperties */
$scriptProperties = array(
    'input'        => $input,
    'options'      => $imageProperties['imagemode'],
    'cachePath'    => dirname($cacheinfo['cache']).'/',
    'cachePathUrl' => dirname($cacheinfo['url']).'/',
    'phpthumbof.cache_path' => dirname($cacheinfo['cache']).'/',
    'phpthumbof.cache_path_url' => dirname($cacheinfo['url']).'/',
    'phpthumbof.hash_thumbnail_names' => 0,
    'phpthumbof.postfix_property_hash'=> 0,
    'output' => true
);

$imglink = $modx->runSnippet('phpthumbof',$scriptProperties);

if (!empty($imglink)) {
    if ($fto_options['friendlythumbof.force_passthru'] || $direct_access) {
        friendlythumbof_output_image($cacheinfo['cache'], $context);
    } else {
        $imglink .= (strpos($imglink,'?') ? '&' : '?') . 'redirect=1';
        header($imglink);
    }
}


