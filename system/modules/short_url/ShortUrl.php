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
 * Class ShortUrl
 * Contains methods to manipulate urls
 */
class ShortUrl extends Controller
{
	/**
	 * Import some needet libraries
	 * 
	 * @param void
	 * @return void
	 */
	public function __construct()
	{
		$this->import('Database');
		parent::__construct();
	}


	/**
	 * Return a short url
	 * 
	 * @param string $strLongUrl
	 * @param string $strProvider
	 * @return string
	 */
	public function getShortUrl($strLongUrl, $strProvider)
	{
		// check if the provider exists
		$this->checkProviderExists($strProvider);
		$strLongUrl = $this->prepareUrl($strLongUrl);

		// try loading from the cache table
		$strShortUrl = $this->getShortUrlFromCache($strLongUrl);

		if ($strShortUrl != false)
		{
			return $strShortUrl;
		}


		// nothing in the cache tables, so we have to get the real one
		$strProvider = 'ShortUrlProvider' . $GLOBALS['TL_SHORT_URL_PROVIDER'][$strProvider];
		$objProvider = new $strProvider();

		$strShortUrl = $objProvider->getShortUrl($strLongUrl);
		$this->addToCache($strShortUrl, $strLongUrl, $objProvider->intExpires);

		return $strShortUrl;
	}


	/**
	 * Return a long url
	 * 
	 * @param string $strShortUrl
	 * @param string $strProvider
	 * @return string
	 */
	public function getLongUrl($strShortUrl, $strProvider)
	{
		// check if the provider exists
		$this->checkProviderExists($strProvider);
		$strShortUrl = $this->prepareUrl($strShortUrl);

		// try loading from the cache table
		$strLongUrl = $this->getLongUrlFromCache($strShortUrl);

		if ($strLongUrl != false)
		{
			return $strLongUrl;
		}


		// nothing in the cache tables, so we have to get the real one
		$strProvider = 'ShortUrlProvider' . $GLOBALS['TL_SHORT_URL_PROVIDER'][$strProvider];
		$objProvider = new $strProvider();

		$strLongUrl = $objProvider->getLongUrl($strShortUrl);
		$this->addToCache($strShortUrl, $strLongUrl, $objProvider->intExpires);

		return $strLongUrl;
	}


	/**
	 * Add a url to the cache table
	 * 
	 * @param string $strShortUrl
	 * @param string $strLongUrl
	 * @param int $intExpires
	 * @return bool
	 */
	protected function addToCache($strShortUrl, $strLongUrl, $intExpires)
	{
		// check if the url is cacheable
		if ($intExpires < 1)
		{
			return false;
		}


		// build the set array
		$arrSet = array
		(
			'shortUrl'	=> $this->prepareUrl($strShortUrl),
			'longUrl'	=> $this->prepareUrl($strLongUrl),
			'expires'	=> time() + $intExpires,
			'tstamp'	=> time()
		);

		// save the tripple in the database
		$objDb = $this->Database->prepare('INSERT INTO tl_short_url_cache %s')
								->set($arrSet)
								->execute();

		return true;
	}


	/**
	 * Get a short url from the cache table
	 * 
	 * @param string $strLongUrl
	 * @return bool|string
	 */
	protected function getShortUrlFromCache($strLongUrl)
	{
		$objCache = $this->Database->prepare('SELECT shortUrl FROM tl_short_url_cache WHERE longUrl=?')
								   ->limit(1)
								   ->execute($this->prepareUrl($strLongUrl));

		// if we have a match, we return the short url
		if ($objCache->numRows == 1)
		{
			return $objCache->shortUrl;
		}

		// damn, not cache entry here.
		return false;
	}


	/**
	 * Get a long url from the cache table
	 * 
	 * @param string $strShortUrl
	 * @return bool|string
	 */
	protected function getLongUrlFromCache($strShortUrl)
	{
		$objCache = $this->Database->prepare('SELECT longUrl FROM tl_short_url_cache WHERE shortUrl=?')
								   ->limit(1)
								   ->execute($this->prepareUrl($strShortUrl));

		// if we have a match, we return the long url
		if ($objCache->numRows == 1)
		{
			return $objCache->longUrl;
		}

		// damn, nothing here. Again ... :(
		return false;
	}


	/**
	 * Prepare a given url and repair it
	 * 
	 * @param string $strUrl
	 * @return string
	 */
	protected function prepareUrl($strUrl)
	{
		$strUrl = trim($strUrl);
		$arrUrl = parse_url($strUrl);

		// add the scheme if empty
		if ($arrUrl['scheme'] == '')
		{
			$strUrl = 'http://' . $strUrl;
		}

		return $strUrl;
	}


	/**
	 * Check if the given provider exists
	 * 
	 * @param string $strProvider
	 * @return bool
	 */
	protected function checkProviderExists($strProvider)
	{
		if (array_key_exists($strProvider, $GLOBALS['TL_SHORT_URL_PROVIDER']))
		{
			return true;
		}

		throw new Exception('The provider "' . $strProvider . '" is not registered in this installation.');
	}
}

?>