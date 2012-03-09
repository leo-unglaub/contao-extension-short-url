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
 * Class ShortUrlAbstract
 * The abstract class with every short url provider should extend from.
 */
abstract class ShortUrlAbstract extends Controller
{
	/**
	 * Define how long the url should be cached. The value must be
	 * in secounds. If you set this property to 0, the cache is disabled.
	 * 
	 * Examples:
	 * 1 Day:	86400
	 * 1 Month:	2592000
	 * 1 Year:	30758400
	 * 
	 * @var int
	 */
	protected $intExpires = 0;


	/**
	 * Return the short url of the given long url
	 * 
	 * @param	string	$strLongUrl		The long url whitch should be shorter
	 * @return	string					The new short url
	 */
	public function getShortUrl($strLongUrl);


	/**
	 * Return the long url for the given short url
	 * 
	 * @param	string	$strShortUrl	The short url
	 * @return	string					The long url
	 */
	public function getLongUrl($strShortUrl);
}

?>