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

use Joomla\CMS\Uri\Uri as JUri;
use Joomla\CMS\Factory as JFactory;
jimport('joomla.application.component.view');

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session as JSession;

/**
 * View class for an Offer.
 *
 * @since  1.6
 */
class OfferViewOffer extends \Joomla\CMS\MVC\View\HtmlView
{
	protected $items;

	protected $pagination;

	protected $state;

	protected $params;

	public $fixed_amount;
	public $firstPercentageAmount;
	public $secondPercentageAmount;
	public $tax_percent;
	public $tooltipText;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$app = Factory::getApplication();

		$this->state = $this->get('State');
		$this->params = $this->state->get('params');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		$this->_prepareDocument();

		OfferHelper::injectMiscJTextsInHead();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function _prepareDocument()
	{

        $offerCssPath = JUri::base() . 'components/com_offer/assets/css';
		$offerJsPath = JUri::base() . 'components/com_offer/assets/js';
		$offerAssetsPath = JUri::base() . 'components/com_offer/assets';
		$document = JFactory::getDocument();
		$document->addStyleSheet($offerCssPath.'/dropzone.css');
		$document->addStyleSheet($offerCssPath.'/nice-select.css');
		$document->addStyleSheet($offerCssPath.'/intlTelInput.css');
		$document->addStyleSheet($offerCssPath.'/jBox.css');
		$document->addStyleSheet($offerCssPath."/bootstrap-datepicker.min.css");
		$document->addStyleSheet($offerCssPath.'/offer.css?v='.time());

		$document->addScript($offerJsPath.'/handlebars-v1.3.0.js');
		$document->addScript($offerJsPath.'/handlebars.js');
		$document->addScript($offerJsPath.'/jquery.min.js');
		$document->addScript($offerJsPath.'/jBox.min.js');
		$document->addScript($offerJsPath.'/bootstrap.js');
		$document->addScript($offerJsPath.'/intlTelInput.js');
		$document->addScript($offerJsPath.'/fileupload/polyfills.js');
		$document->addScript($offerJsPath.'/fileupload/dropzone.min.js');
		$document->addScript($offerJsPath.'/fileupload/fileupload.js');
		$document->addScript($offerJsPath.'/fileupload/caption.js');
		$document->addScript($offerJsPath.'/jquery.nice-select.js');
		$document->addScript($offerJsPath.'/offer.js?v='.time());
		$document->addScript($offerJsPath."/bootstrap-datepicker/bootstrap-datepicker.min.js");
		$document->addScript($offerJsPath."/bootstrap-datepicker/bootstrap-datepicker.en-GB.min.js");
		$document->addScript($offerJsPath."/bootstrap-datepicker/bootstrap-datepicker.de.min.js");
		$document->addScript($offerJsPath."/bootstrap-datepicker/bootstrap-datepicker.fr.min.js");
		$document->addScript($offerJsPath."/bootstrap-datepicker/bootstrap-datepicker.it.min.js");
		$document->addScript($offerAssetsPath.'/typeahead/typeahead.bundle.js');

		$document->addScriptDeclaration('var offerToken = "'.JFactory::getApplication()->input->get('t').'";');
		$document->addScriptDeclaration('var policyID = "'.JFactory::getSession()->get('policy_id', 0).'";');
		$document->addScriptDeclaration('
			var ConvertFormsConfig = {
			"baseurl" : " index.php?option=com_offer&task=offer.uploadFileToTmp",
			"token"   : "' . JSession::getFormToken() . '",
			"debug"   : "false",
			};
		');

		$this->fixed_amount = 236.25;
		$this->firstPercentageAmount  = 4.5;
		$this->secondPercentageAmount  = 6;
		$this->tax_percent  = 5;

		$scriptDeclaration = 'var fixedAmountBusiness = '.$this->fixed_amount.';
								var firstRateBusiness = '. $this->firstPercentageAmount.';
								var secondRateBusiness = '. $this->secondPercentageAmount.';
								var taxPercentageBusiness = '. $this->tax_percent.'';
		$document->addScriptDeclaration($scriptDeclaration);

		$lang = JFactory::getLanguage();
		$locale = explode("-",$lang->getTag())[0];
		$document->addScriptDeclaration('
			var WEBSITE_LANGUAGE = "'.$locale.'"
			var WEBSITE_URL = "'.JUri::root().'";
		');

		$app   = Factory::getApplication();
		$menus = $app->getMenu();
		$title = null;
		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', Text::_('COM_OFFER_DEFAULT_PAGE_TITLE'));
		}

		$title = $this->params->get('page_title', '');

		if (empty($title))
		{
			$title = $app->get('sitename');
		}
		elseif ($app->get('sitename_pagetitles', 0) == 1)
		{
			$title = Text::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		}
		elseif ($app->get('sitename_pagetitles', 0) == 2)
		{
			$title = Text::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}

	}

	/**
	 * Check if state is set
	 *
	 * @param   mixed  $state  State
	 *
	 * @return bool
	 */
	public function getState($state)
	{
		return isset($this->state->{$state}) ? $this->state->{$state} : false;
	}
}
