<?php
/**
 * systemSettings transport file for friendlythumbof extra
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
/* @var xPDOObject[] $systemSettings */


$systemSettings = array();

$systemSettings[1] = $modx->newObject('modSystemSetting');
$systemSettings[1]->fromArray(array(
    'key' => 'friendlythumbof.allow_friendly',
    'value' => true,
    'xtype' => 'combo-boolean',
    'namespace' => 'friendlythumbof',
    'area' => 'setting',
), '', true, true);
$systemSettings[2] = $modx->newObject('modSystemSetting');
$systemSettings[2]->fromArray(array(
    'key' => 'friendlythumbof.base_request',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'friendlythumbof',
    'area' => 'setting',
), '', true, true);
$systemSettings[3] = $modx->newObject('modSystemSetting');
$systemSettings[3]->fromArray(array(
    'key' => 'friendlythumbof.enable_mgr_context',
    'value' => false,
    'xtype' => 'combo-boolean',
    'namespace' => 'friendlythumbof',
    'area' => 'setting',
), '', true, true);
$systemSettings[4] = $modx->newObject('modSystemSetting');
$systemSettings[4]->fromArray(array(
    'key' => 'friendlythumbof.context_request',
    'value' => false,
    'xtype' => 'combo-boolean',
    'namespace' => 'friendlythumbof',
    'area' => 'setting',
), '', true, true);
$systemSettings[5] = $modx->newObject('modSystemSetting');
$systemSettings[5]->fromArray(array(
    'key' => 'friendlythumbof.force_cache_context',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'friendlythumbof',
    'area' => 'setting',
), '', true, true);
$systemSettings[6] = $modx->newObject('modSystemSetting');
$systemSettings[6]->fromArray(array(
    'key' => 'friendlythumbof.force_passthru',
    'value' => true,
    'xtype' => 'combo-boolean',
    'namespace' => 'friendlythumbof',
    'area' => 'setting',
), '', true, true);
$systemSettings[7] = $modx->newObject('modSystemSetting');
$systemSettings[7]->fromArray(array(
    'key' => 'friendlythumbof.mode_separator',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'friendlythumbof',
    'area' => 'setting',
), '', true, true);
$systemSettings[8] = $modx->newObject('modSystemSetting');
$systemSettings[8]->fromArray(array(
    'key' => 'friendlythumbof.imagemode_default',
    'value' => 'mw=950',
    'xtype' => 'textfield',
    'namespace' => 'friendlythumbof',
    'area' => 'imagemode',
), '', true, true);
$systemSettings[9] = $modx->newObject('modSystemSetting');
$systemSettings[9]->fromArray(array(
    'key' => 'friendlythumbof.imagemode_thumb',
    'value' => 'w=90&h=120',
    'xtype' => 'textfield',
    'namespace' => 'friendlythumbof',
    'area' => 'imagemode',
), '', true, true);
$systemSettings[10] = $modx->newObject('modSystemSetting');
$systemSettings[10]->fromArray(array(
    'key' => 'friendlythumbof.imagemode_medium',
    'value' => 'w=300&h=400',
    'xtype' => 'textfield',
    'namespace' => 'friendlythumbof',
    'area' => 'imagemode',
), '', true, true);
$systemSettings[11] = $modx->newObject('modSystemSetting');
$systemSettings[11]->fromArray(array(
    'key' => 'friendlythumbof.imagemode_large',
    'value' => 'w=900&h=1200',
    'xtype' => 'textfield',
    'namespace' => 'friendlythumbof',
    'area' => 'imagemode',
), '', true, true);
return $systemSettings;
