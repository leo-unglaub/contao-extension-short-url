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
 * Class ShortUrlInsertTags
 * Contain methods to handle custom insert tags
 * 
 * Short url's are available via the insert tags {{short_url::provider::the long url}} or {{long_url::provider::the short url}}.
 * The protocol (http or https) is addet automaticly.
 * 
 * Examples:
 * ########
 * 
 * {{short_url::tinyurl::http://www.leo-unglaub.net}}
 * {{short_url::googl::www.leo-unglaub.net}}
 * 
 * {{long_url::tinyurl::http://tinyurl.com/7gnjh4s}}
 * {{long_url::tinyurl::tinyurl.com/7gnjh4s}}
 */
class ShortUrlInsertTags extends Controller
{
	/**
	 * Return a short url for a long url
	 * 
	 * @param string $strTag
	 * @return string|bool
	 */
	public function getInsertTagShortUrl($strTag)
	{
		$arrChunks = explode('::', $strTag);

		if ($arrChunks[0] == 'short_url')
		{
			$objShortUrl = new ShortUrl();
			return $objShortUrl->getShortUrl($arrChunks[2], $arrChunks[1]);
		}

		return false;
	}


	/**
	 * Return a long url for a short url
	 * 
	 * @param string $strTag
	 * @return string|bool
	 */
	public function getInsertTagLongUrl($strTag)
	{
		$arrChunks = explode('::', $strTag);

		if ($arrChunks[0] == 'long_url')
		{
			$objShortUrl = new ShortUrl();
			return $objShortUrl->getLongUrl($arrChunks[2], $arrChunks[1]);
		}

		return false;
	}
}

?>