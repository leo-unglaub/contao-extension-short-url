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
 * Class ShortUrlCron
 * Provide methods to handle cashed short url's
 */
class ShortUrlCron extends Controller
{
	/**
	 * Remove old entry's from the short url cache table
	 * 
	 * @param void
	 * @return void
	 */
	public function removeOldCacheEntrys()
	{
		$this->import('Database');

		// remove every expired cache entry
		$objDbCache = $this->Database->query('DELETE FROM tl_short_url_cache WHERE expires<=unix_timestamp()');


		// define the log message
		if ($objDbCache->affectedRows > 0)
		{
			$strLogMessage = $objDbCache->affectedRows . ' items would removed from the short url cache.';
		}
		else
		{
			$strLogMessage = 'Nothing to remove from the short url cache.';
		}

		$this->log($strLogMessage, 'ShortUrlCron removeOldCacheEntrys()', TL_CRON);
	}
}

?>