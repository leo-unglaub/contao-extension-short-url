<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Unglaub 2012
 * @author     Leo Unglaub <leo@leo-unglaub.net>
 * @package    short_url
 * @license    LGPL
 */


/**
 * Short Url provider
 * Register your short url provider in this array
 * 
 * Example: $GLOBALS['TL_SHORT_URL_PROVIDER']['tinyurl'] = 'TinyUrl'; will be called as ShortUrlProviderTinyUrl
 */
$GLOBALS['TL_SHORT_URL_PROVIDER'] = array();


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('ShortUrlInsertTags', 'getInsertTagShortUrl');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('ShortUrlInsertTags', 'getInsertTagLongUrl');


/**
 * Cron jobs
 */
$GLOBALS['TL_CRON']['daily'][] = array('ShortUrlCron', 'removeOldCacheEntrys');


/**
 * Cache tables
 */
$GLOBALS['TL_CACHE'][] = 'tl_short_url_cache';

?>