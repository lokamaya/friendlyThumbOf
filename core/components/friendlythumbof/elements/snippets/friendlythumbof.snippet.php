<?php
/**
 * friendlyThumbOf
 * a snippet for friendlythumbof extra
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
 * USAGE 1
 * Default mode: friendlythumbof.imagemode_thumb = 'w=90&h=120'
 * - [[friendlyThumbOf? &input=`media/logo.jpg`]]
 * - [[*mygallery:friendlyThumbOf=`mode=thumb&context=web`]]
 *
 * 
 * USAGE 2
 * Go to system setting, namespace friendlythumbof, and create another 
 * mode: friendlythumbof.imagemode_large = 'w=600&h=800&far=C&cz=0'
 * Now we can use it as below
 * - [[friendlyThumbOf? &input=`media/logo.jpg` &mode=`large`]]
 * Output http://mydomain.com/image/large/media/logo.jpg
 *
 * USAGE 3
 * Set friendlythumbof.context_request = true, and use it on enUS context.
 * - [[friendlyThumbOf? &input=`media/logo.jpg`]]
 * Output http://mydomain.com/image/enUS/default/media/logo.jpg
 *
 * USAGE 4
 * Direct access or no fancy url
 * - [[friendlyThumbOf? &input=`media/logo.jpg` &context=`mgr` &friendly=`0`]]
 * Output http://mydomain.com/assets/components/friendlythumbof/connector.php?input=media/logo.jpg&mode=default&context=`mgr`
 *
**/

//print_r(array($input,$options, $scriptProperties));
//return '';

if (empty($modx)) return '';

/* include friendlythumbof.function.php */
$assetsPath = $modx->getOption('friendlythumbof.assets_path',null,$modx->getOption('assets_path').'components/friendlythumbof/');
if (!@require_once($assetsPath.'friendlythumbof.function.php')) {
    $modx->log(modX::LOG_LEVEL_ERROR,'[friendlyThumbOf] Could not load friendlythumbof.function.php');
    return '';
}

/* Get input (image path) */
$input    = isset($input) ? $input : '';
if (empty($input)) return '';

/* Get properties */
$option = isset($option) ? $option: null;
$direct = isset($direct) ? (boolean)$direct: false;

$imageProperties = array();
if ($option) {
    $option = friendlythumbof_parse_options($option, $input);
    $imageProperties = array_merge($scriptProperties, $option);
} else {
    $imageProperties = $scriptProperties;
}    

$wctx = $modx->resource ? $modx->resource->get('context') : $modx->context->get('key');

$imageProperties['direct'] = $direct;
$imageProperties['context']  = $modx->getOption('context', $scriptProperties, $wctx, true);
$imageProperties['input']    = $input;
$imageProperties['base_url'] = $modx->context->getOption('base_url');
$imageProperties['mode']     = $modx->getOption('mode', $scriptProperties, 'default', true);
$imageProperties['imagemode'] = $modx->getOption('friendlythumbof.imagemode_'.$imageProperties,null,null);

if (!$imageProperties['imagemode']) {
    if ($imageProperties['mode'] != 'default') {
        $imageProperties['mode'] = 'default';
        $imageProperties['imagemode'] = $modx->getOption('friendlythumbof.imagemode_'.$imageProperties['imagemode'],null,'');
    } else {
        $modx->log(modX::LOG_LEVEL_ERROR,'[friendlyThumbOf] Could not load default mode');
        return '';
    }
}

$imageProperties = array_merge(friendlythumbof_get_options($modx), $imageProperties);

$cache_info = friendlythumbof_generate_url($imageProperties);

return $cache_info['url'];