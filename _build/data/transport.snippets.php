<?php
/**
 * snippets transport file for friendlythumbof extra
 *
 * Copyright 2012 by Zaenal Muttaqin @lokamaya.com
 * Created on 12-17-2012
 *
 * @package friendlythumbof
 * @subpackage build
 */

if (! function_exists('stripPhpTags')) {
    function stripPhpTags($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<' . '?' . 'php', '', $o);
        $o = str_replace('?>', '', $o);
        $o = trim($o);
        return $o;
    }
}
/* @var $modx modX */
/* @var $sources array */
/* @var xPDOObject[] $snippets */


$snippets = array();

$snippets[1] = $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => '1',
    'description' => 'A custom output filter that output friendly thumbnails URL for phpThumbOf.',
    'name' => 'friendlyThumbOf',
), '', true, true);
$snippets[1]->setContent(file_get_contents($sources['source_core'] . '/elements/snippets/friendlythumbof.snippet.php'));
$properties = include $sources['data'].'properties/properties.friendlythumbof.php';
$snippets[1]->setProperties($properties);
unset($properties);

return $snippets;
