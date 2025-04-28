<?php

/**
 * @version    CVS: 1.0.0
 * @package    com_offer
 * @author     goCaution® AG <info@gocaution.ch>
 * @copyright  2023 goCaution® AG
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Factory;
use Joomla\CMS\Categories\Categories;

/**
 * Class OfferRouter
 *
 */
class OfferRouter extends RouterView
{
	private $noIDs;
	public function __construct($app = null, $menu = null)
	{
		$params = JComponentHelper::getComponent('com_offer')->params;
		$this->noIDs = (bool) $params->get('sef_ids');
		
		

		parent::__construct($app, $menu);

		$this->attachRule(new MenuRules($this));

		if ($params->get('sef_advanced', 0))
		{
			$this->attachRule(new StandardRules($this));
			$this->attachRule(new NomenuRules($this));
		}
		else
		{
			JLoader::register('OfferRulesLegacy', __DIR__ . '/helpers/legacyrouter.php');
			JLoader::register('OfferHelper', __DIR__ . '/helpers/offer.php');
			$this->attachRule(new OfferRulesLegacy($this));
		}
	}


	

	
}
