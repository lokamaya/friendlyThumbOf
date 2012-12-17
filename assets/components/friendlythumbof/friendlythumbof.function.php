<?php
/**
 * friendlyThumbOf
 * File: assets/components/friendlythumbof/friendlythumbof.function.php
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


/* SOME FUNCTION */
function friendlythumbof_get_options($modx) {
    $op = array (
        'friendlythumbof.allow_friendly'   => (boolean)$modx->getOption('friendlythumbof.allow_friendly', null, true),
        'friendlythumbof.base_request'       => (string)$modx->getOption('friendlythumbof.request_uri', null, 'image', true), /* must match with .htaccess */
        'friendlythumbof.enable_mgr_context' => (boolean)$modx->getOption('friendlythumbof.enable_mgr_context', null, false),
        'friendlythumbof.context_request'    => (boolean)$modx->getOption('friendlythumbof.context_request', null, false), 
        'friendlythumbof.force_cache_context'  => (string)$modx->getOption('friendlythumbof.force_cache_context', null, '',true),
        'friendlythumbof.force_passthru'  => (boolean)$modx->getOption('friendlythumbof.force_passthru', null, true),
        'friendlythumbof.mode_separator'     => (string)$modx->getOption('friendlythumbof.mode_separator', null, '', true), /* must match with .htaccess */
    );
    
    if (!$op['friendlythumbof.context_request']) {
        $op['friendlythumbof.enable_empty_context'] = true;
    }
    
    $op['friendlythumbof.base_request'] = preg_replace(array("@^(/)+@","@(/)+$@"),"", $op['friendlythumbof.base_request']);
    if (!empty($op['friendlythumbof.mode_separator'])) $op['friendlythumbof.mode_separator'] =  preg_replace(array("@^(/)+@","@(/)+$@"),"", $op['friendlythumbof.mode_separator']);
    if (!empty($op['friendlythumbof.force_cache_context'])) $op['friendlythumbof.force_cache_context'] =  preg_replace(array("@^(/)+@","@(/)+$@"),"", $op['friendlythumbof.force_cache_context']);
    
    $op['base_cache_path'] = (string)$modx->getOption('phpthumbof.cache_path', null, MODX_ASSETS_PATH . 'components/phpthumbof/cache/',true);
    $op['base_cache_url']  = MODX_URL_SCHEME . MODX_HTTP_HOST . MODX_BASE_URL;
    $op['connector_url']   = (string)$modx->getOption('friendlythumbof.assets_url',null, $modx->getOption('assets_url').'components/friendlythumbof/connector.php');
    
    if (preg_match("@^http@i", $op['connector_url'])) {
        $op['connector_url'] = $op['base_cache_url'] . $op['connector_url'];
    }

    return $op;
}

function friendlythumbof_parse_options($string, $input='') {
    $options = array('mode'=>'default','context'=>'','friendly'=>1, 'input'=>$input);
    if (is_array($string)) {
        return $string;
    } else {
        $string = str_replace('&amp;','&', $string);
        if (preg_match_all("@([a-z\s]+)=([^\&]+)@i",$string, $match, PREG_SET_ORDER)) {
            foreach($match as $opt) {
                $options[trim($opt[1])] = trim($opt[2]);
            }
        }
    }
    return $options;
}

function friendlythumbof_generate_url($imageProperties) {
    if (empty($imageProperties['input'])) return false;
    
    $cache_path = $imageProperties['base_cache_path'];
    $cache_url  = $imageProperties['base_cache_url'];
    $connector_query = "input=".$imageProperties['input']."&mode".$imageProperties['mode'];
    
    $separator= (!empty($imageProperties['friendlythumbof.mode_separator']) ? $imageProperties['friendlythumbof.mode_separator'] . '/' : '');
    
    if (!$imageProperties['friendlythumbof.context_request']) {
        if (empty($imageProperties['friendlythumbof.force_cache_context'])) {
            $cache_path .= $imageProperties['mode'] . '/';
            $cache_url  .=  $imageProperties['friendlythumbof.base_request'] . '/' . $separator. $imageProperties['mode'] . '/';
        } else {
            $cache_path .= $imageProperties['friendlythumbof.force_cache_context'] .'/'. $imageProperties['mode'] . '/';
            $cache_url  .= ($imageProperties['base_url'] == '/' ? '' : $imageProperties['base_url']);
            $cache_url  .= $imageProperties['friendlythumbof.base_request'] . '/' . $separator . $imageProperties['mode'] . '/';
        }
        if ($imageProperties['context'] != 'mgr') $connector_query .= '&context_image='.$imageProperties['context'];
    } else {
        if (empty($imageProperties['friendlythumbof.force_cache_context'])) {
            if (empty($imageProperties['context'])) $imageProperties['context'] = 'web';
            $cache_path .= $imageProperties['context'] .'/'. $imageProperties['mode'] . '/';
            $cache_url  .=  $imageProperties['friendlythumbof.base_request'] . '/' . $imageProperties['context'] . '/' . $separator. $imageProperties['mode'] . '/';
        } else {
            $cache_path .= $imageProperties['friendlythumbof.force_cache_context'] .'/'. $imageProperties['mode'] . '/';
            $cache_url  .=  $imageProperties['friendlythumbof.base_request'] . '/' . 'web/' . $separator. $imageProperties['mode'] . '/';
        }
        $connector_query .= '&context_image='.$imageProperties['context'];
    }
    
    $input = preg_replace("@^/+@","",$imageProperties['input']);
    $cache_path = $cache_path . $input;
    if ((isset($imageProperties['direct']) && $imageProperties['direct']) || !$imageProperties['friendlythumbof.allow_friendly']) {
        $_alt = $cache_url;
        $cache_url = $imageProperties['connector_url'].'?'.$connector_query;
    } else {
        $cache_url  = $cache_url . $input;
        $_alt = $imageProperties['connector_url'].'?'.$connector_query;
    }
    
    $cacheinfo = array(
        'input' => $input,
        'cache' => $cache_path,
        'url'  => $cache_url,
        '_alt'  => $_alt
        ); 
    return $cacheinfo;
}

function friendlythumbof_validate_request($imageProperties) {
    $context = $imageProperties['context'];
    $input = $imageProperties['input'];
    $mode  = $imageProperties['mode'];
    
    /* check context */
    if (empty($context) && $imageProperties['friendlythumbof.context_request']) {
        friendlythumbof_not_found("[E-1a] Context is empty");
    }
    
    /* Check allow_friendly_query against .htaccess rewrite */
    if (empty($mode)) {
        friendlythumbof_not_found("[E-2a] Empty mode");
    } else if ($imageProperties['imagemode']===null) {
        friendlythumbof_not_found("[E-2b] Unknown mode \"$mode\"!");
    }
        
    /* Check input (image) */
    if (empty($input)) {
        friendlythumbof_not_found("[E-3a] Empty image");
    } else if (!preg_match("@\.(gif|jpeg|jpg|png|bmp)$@i", $input)) {
        friendlythumbof_not_found("[E-3b] Invalid image format $input");
    } else if (!file_exists(MODX_BASE_PATH . $input)) {
        friendlythumbof_not_found("[E-3c] Image not exist $input");
    }
}

function friendlythumbof_stringify_options($options) {
    if (!is_array($options)) return $options;
    
    array_walk($options, '_stringifyFT','');
    //$options = implode('&', $output);
    return implode('&', $options);
}

function _stringifyFT(&$item,$key,$par) {
    if (is_array($item)) {
        $items = $item;
        array_walk($items, '_stringifyFT', $key);
        $item = implode('&', $items);
    } else {
        if (!empty($par)) {
            $item = $par.'[]='.$item;
        } else {
            $item = $key.'='.$item;
        }
    }
}


function friendlythumbof_fancy_path($path) {
    return str_replace('\\','/', trim($path));
}

function friendlythumbof_output_image($path, $context='web') {
    if ($size = @getimagesize($path)) {
        $fp = fopen($path, "rb");
        if ($fp) {
            if ($context=='mgr') {
                header("Cache-Control: private");
            } else {
                header("Cache-Control: public");
            }
            header("Content-type: {$size['mime']}");
            fpassthru($fp);
            exit;
        } else {
            friendlythumbof_not_found("Can not read file");
        }
        
    }
    friendlythumbof_not_found("Can not read filesize");
}

function friendlythumbof_not_found($msg=null) {
    header("Status: 404 Not Found");
    header("HTTP/1.0 404 Not Found");
    header("HTTP/1.1 404 Not Found");
    echo("File not found");
    if ($msg) echo ": $msg";
    exit();
}
