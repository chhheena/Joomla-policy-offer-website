<?php

/**
 * @version    CVS: 1.0.0
 * @package    com_offer
 * @author     goCaution® AG <info@gocaution.ch>
 * @copyright  2023 goCaution® AG
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JLoader::register('OfferHelper', JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_offer' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'offer.php');

use \Joomla\CMS\Factory;
use \Joomla\CMS\MVC\Model\BaseDatabaseModel;
require_once JPATH_LIBRARIES . '/device-detector/vendor/autoload.php';
use DeviceDetector\DeviceDetector;

/**
 * Class OfferFrontendHelper
 *
 * @since  1.6
 */
class OfferHelper
{
	/**
	 * Get an instance of the named model
	 *
	 * @param   string  $name  Model name
	 *
	 * @return null|object
	 */
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_offer/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_offer/models/' . strtolower($name) . '.php';
			$model = BaseDatabaseModel::getInstance($name, 'OfferModel');
		}

		return $model;
	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int     $pk     The item's id
	 *
	 * @param   string  $table  The table's name
	 *
	 * @param   string  $field  The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int) $pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function canUserEdit($item)
    {
        $permission = false;
        $user       = Factory::getUser();

        if ($user->authorise('core.edit', 'com_offer') || (isset($item->created_by) && $user->authorise('core.edit.own', 'com_offer') && $item->created_by == $user->id))
        {
            $permission = true;
        }

        return $permission;
    }
	static function getenv_path()
    {
        if (file_exists(JPATH_ROOT.'/libraries/env/vendor/' . 'autoload.php')) {
            require_once(JPATH_ROOT.'/libraries/env/vendor/' . 'autoload.php');
        }
        $dotenv = Dotenv\Dotenv::create(dirname(dirname(dirname(__DIR__))));
        $dotenv->load();
    }
	/**
     * This returns Array of terms file path and Name from docs.gocaution.ch
     */
    static public function getTermsFile()
    {
        self::getenv_path();
		$langTag = JFactory::getApplication()->getLanguage()->getTag();
        $langShortTag = explode("-", $langTag);
        switch ($langTag) {
            case 'fr-FR':
                $name = 'conditions-generales-cga.pdf';
                break;
            case 'it-IT':
                $name = 'condizioni-generali-assicurazione-cga.pdf';
                break;
            default:
                $name = 'allgemeine-versicherungsbedingungen-avb.pdf';
                break;
        }

        $filename = getenv('DOCS_WEBSITE_URL').$langShortTag[0].'/terms/offer/'.$name;
        return $filename;
    }

    static public function getlegalFile()
    {
        self::getenv_path();
		$langTag = JFactory::getApplication()->getLanguage()->getTag();
        $langShortTag = explode("-", $langTag);
        switch ($langTag) {
            case 'fr-FR':
                $name = 'lsa-45.pdf';
                break;
            case 'it-IT':
                $name = 'lca-45.pdf';
                break;
            default:
                $name = 'vag-45.pdf';
                break;
        }

        $filename = getenv('DOCS_WEBSITE_URL').$langShortTag[0].'/legal/'.$name;
        return $filename;
    }
	static function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
	static function getDevice(){
        $dd = new DeviceDetector($_SERVER['HTTP_USER_AGENT']);
        $dd->parse();
        return $dd->getDeviceName();
    }

    static function forceDownloadDocument($file_path, $delete_file = false, $exit_on_finish = true, $file_name = ''){
        if(file_exists($file_path)) {
            if($file_name){
                $file_extension = JFile::getExt(basename($file_path));
                $file_name = $file_name.".".$file_extension;
            }else{
                $file_name =  basename($file_path);
            }
            header('Content-Description: File Transfer');
            header('Content-Type: '.mime_content_type($file_path));
            header('Content-Disposition: attachment; filename="'.$file_name.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            flush(); // Flush system output buffer
            readfile($file_path);
            if($delete_file){
                JFile::delete($file_path);
            }

            if($exit_on_finish)
            exit;
        }
    }

    static function injectMiscJTextsInHead(){
        JText::script('COM_OFFER_UPLOAD_FILETOOBIG');
        JText::script('COM_OFFER_UPLOAD_INVALID_FILE');
        JText::script('COM_OFFER_UPLOAD_FALLBACK_MESSAGE');
        JText::script('COM_OFFER_UPLOAD_CANCEL_UPLOAD');
        JText::script('COM_OFFER_UPLOAD_CANCEL_UPLOAD_CONFIRMATION');
        JText::script('COM_OFFER_UPLOAD_MAX_FILES_EXCEEDED');
        JText::script('COM_OFFER_UPLOAD_RESPONSE_ERROR');
        JText::script('COM_OFFER_UPLOAD_REMOVE_FILE');

        JText::script('COM_OFFER_PREMIUM_ORIGINAL_AMOUNT');
        JText::script('COM_OFFER_DEPOSIT_AMOUNT_LABEL');
        JText::script('COM_OFFER_DEPOSIT_REQUIRED');
        JText::script('COM_OFFER_VLD_DEPOSIT_AMOUNT_MESSAGE');
        JText::script('COM_OFFER_URL_DISCOUNT_TEXT_WITH_PERCENTAGE');
        JText::script('COM_OFFER_URL_DISCOUNT_TEXT_WITHOUT_PERCENTAGE');

        JText::script('COM_OFFER_ACCEPTED_OFFER_TEXT');
        JText::script('COM_OFFER_RENTAL_DEPOSIT_CHILD_POLICY_OVERVIEW');
        JText::script('COM_OFFER_NO_DATA');
        JText::script('JGLOBAL_SELECT_NO_RESULTS_MATCH');
        JText::script('COM_OFFER_CONFIRMATION_EMAIL_TEXT');
        JText::script('COM_OFFER_CONFIRMATION_POST_TEXT');
        JText::script('COM_OFFER_ADMINISTRATION');
        JText::script('COM_OFFER_OWNER');
        JText::script('COM_OFFER_PRIVATE_LANDLORD');
        JText::script('COM_OFFER_VLD_BIRTHDAY_FORMAT_MESSAGE');
        JText::script('COM_OFFER_VLD_EMAIL_FORMAT_MESSAGE');
        JText::script('COM_OFFER_NAME');
        JText::script('COM_OFFER_FIRST_NAME');
        JText::script('COM_OFFER_COMPANY_NAME');
        JText::script('COM_OFFER_PRIVATELANDLORD_PL_COMPANY_CPNAME');
        JText::script('COM_OFFER_PRIVATELANDLORD_FAMILY_NAME');
        JText::script('COM_OFFER_PRIVATELANDLORD_FAMILY_FIRSTNAME');
    }
    static function getUniqueID(){
	    return uniqid(rand(100000000,999999999));
    }

    static function birthDateRender($description_variable,$class_name){
        $layout = new JLayoutFile('default_age_validation', JPATH_ROOT .'/components/com_offer/layouts');
        $data = array('description_variable' => $description_variable, 'class_name' => $class_name);
        return $layout->render($data);
    }
}
