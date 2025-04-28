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

use \Joomla\CMS\MVC\Controller\BaseController;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_offer'))
{
	throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Offer', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('OfferHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'offer.php');

$controller = BaseController::getInstance('Offer');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
