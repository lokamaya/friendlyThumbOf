<?php
/**
 * en default topic lexicon file for friendlyThumbOf extra
 *
 * Copyright 2012 by Zaenal Muttaqin @lokamaya.com
 * Created on 12-17-2012
 *
 * friendlythumbof is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * friendlythumbof is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * friendlythumbof; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package friendlyThumbOf
**/

$_lang['setting_friendlythumbof.allow_friendly'] = 'Friendly Thumbnail (mod_rewrite)';
$_lang['setting_friendlythumbof.allow_friendly_desc'] = 'Enable/disable friendly url. Please note that this extra require mod_rewrite.';
$_lang['setting_friendlythumbof.base_request'] = 'Base Request (mod_rewrite)';
$_lang['setting_friendlythumbof.base_request_desc'] = 'Base request will be appended to the begining of URL. This setting required by mod_rewrite. Default <b>image</b>';
$_lang['setting_friendlythumbof.enable_mgr_context'] = 'Allow mgr Context';
$_lang['setting_friendlythumbof.enable_mgr_context_desc'] = 'Display images in mgr context (useful for CMP). Otherwise, will used "web" context instead.';
$_lang['setting_friendlythumbof.context_request'] = 'Context Request (mod_rewrite)';
$_lang['setting_friendlythumbof.context_request_desc'] = 'Append context_key to the url (default false)';
$_lang['setting_friendlythumbof.force_cache_context'] = 'Cache Context (mod_rewrite)';
$_lang['setting_friendlythumbof.force_cache_context_desc'] = 'Force cache to a specific context.';
$_lang['setting_friendlythumbof.force_passthru'] = 'Force Passthru';
$_lang['setting_friendlythumbof.force_passthru_desc'] = 'Default true. Set it to false will redirect request on generating thumbnail.';
$_lang['setting_friendlythumbof.mode_separator'] = 'Mode Separator (mod_rewrite)';
$_lang['setting_friendlythumbof.mode_separator_desc'] = 'Append a "text" to the url before imagemode. Changes to this key must conform with mod_rewrite.';
$_lang['setting_friendlythumbof.imagemode_default'] = 'default (do not delete)';
$_lang['setting_friendlythumbof.imagemode_default_desc'] = 'Default image mode. Feel free to modify, but do not delete.';
$_lang['setting_friendlythumbof.imagemode_thumb'] = 'Mode: thumb';
$_lang['setting_friendlythumbof.imagemode_thumb_desc'] = 'Image mode "thumb". Feel free to modify or delete it. <br />Key: friendlythumbof.imagemode_thumb';
$_lang['setting_friendlythumbof.imagemode_medium'] = 'Mode: medium';
$_lang['setting_friendlythumbof.imagemode_medium_desc'] = 'Image mode "medium". Feel free to modify or delete it. <br />Key: friendlythumbof.imagemode_medium';
$_lang['setting_friendlythumbof.imagemode_large'] = 'Mode: large';
$_lang['setting_friendlythumbof.imagemode_large_desc'] = 'Image mode "large". Feel free to modify or delete it. <br />Key: friendlythumbof.imagemode_large';

$_lang['prof_friendlythumbof.mode'] = 'Thumbnail Mode';
$_lang['prof_friendlythumbof.mode_desc'] = 'Mode for thumbnail.';
?>
