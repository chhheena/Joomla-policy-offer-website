<?php
/**
 * @version    CVS: 1.0.0
 * @package    com_offer
 * @author     goCaution® AG <info@gocaution.ch>
 * @copyright  2023 goCaution® AG
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
use Joomla\CMS\Factory as JFactory;
/**
 * Policy list controller class. policy
 *
 * @since  1.6
 */
class OfferControllerOffer extends OfferController
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional
	 * @param   array   $config  Configuration array for model. Optional
	 *
	 * @return object	The model
	 *
	 * @since	1.6
	 */
	public function &getModel($name = 'Offer', $prefix = 'OfferModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
    public function getCustomerInfo(){
        $session = JFactory::getSession();
        $policy_id = $session->get('policy_id', 0);
		$postData = array(
			'policy_id' => $policy_id,
			'language' => JFactory::getApplication()->getLanguage()->getTag()
		);
		$server_output = $this->crmCurl($postData,"getPolicyOfferCustomer");

        if (!empty($server_output)) {
            $decoded_output = json_decode($server_output, true);
            if(is_array($decoded_output['policy']) && count($decoded_output['policy'])){

                if ($decoded_output['policy']['parent_policy_id'] > 0) {
                    $session->set('child_policy_id', $decoded_output['policy']['policy_id']);
                }else{
                    $session->clear('child_policy_id');
                }
                //set customer name in session
                $customer_name = trim(implode(" ",array($decoded_output['contact']['nachname'], $decoded_output['contact']['vorname'])));
                $session->set('customer_name', $customer_name);
            }
        }

        echo $server_output;
        die;
	}

	public function getPolicyOfferPdf() {
		$session = JFactory::getSession();
		$policy_id = $session->get('policy_id', 0);
		$child_policy_id = $session->get('child_policy_id', 0);
        $policy_id = $child_policy_id ? $child_policy_id : $policy_id;
		$app = JFactory::getApplication();
        $postData = $app->input->input->post->getArray();

		$postData['policy_id'] = $policy_id;

        if($postData['contact_address_co_address']){
            $postData['contact_address'] = $postData['contact_address_co_address'];
            $postData['contact_plz'] = $postData['contact_address_co_plz'];
            $postData['contact_ort'] = $postData['contact_address_co_ort'];
        }else{
            $postData['contact_address'] = $postData['contact_address_address'];
            $postData['contact_plz'] = $postData['contact_address_plz'];
            $postData['contact_ort'] = $postData['contact_address_ort'];
        }

		$server_output = $this->crmCurl($postData, "getPolicyOfferPdf");
        $decoded_output = json_decode($server_output, true);

        if ($decoded_output && isset($decoded_output['file'])) {
            $filePath = json_decode($decoded_output['file']);
        }

		$session->set('offerPartnerPdfPath', $filePath);
		return true;
	}

	public function getPolicyOfferQrInvoicePdf() {
		$session = JFactory::getSession();

		$app = JFactory::getApplication();
		$postData = $app->input->input->post->getArray();

		$server_output = $this->crmCurl($postData, "getPolicyOfferQrInvoicePdf");
        $decoded_output = json_decode($server_output, true);

        if ($decoded_output && isset($decoded_output['file'])) {
            $filePath = json_decode($decoded_output['file']);
        }

		$session->set('qrInvoicePdfPath', $filePath);
		return true;
	}

	public function downloadQrInvoicePdf() {
		$session = JFactory::getSession();
		$filePath = $session->get('qrInvoicePdfPath', '');
		if ($filePath != '')
		{
			OfferHelper::forceDownloadDocument($filePath, true);
		}
	}

	public function downloadOfferParterPdf() {
		$session = JFactory::getSession();
		$filePath = $session->get('offerPartnerPdfPath', '');
        $fileName = JText::sprintf('COM_OFFER_OFFER_DOWNLOAD_NAME',$session->get('customer_name'));
		if ($filePath != '')
		{
			OfferHelper::forceDownloadDocument($filePath, true, true, $fileName);
		}
	}

    public function checkCodeTokenValidation(){
        $app = JFactory::getApplication();
        $validation_type = $app->input->get('validation_type');
        $code = $app->input->get('code');
        $postData = array();
        $postData['validation_type'] = $validation_type;
        $postData['code'] = $code;
        $server_output = $this->crmCurl($postData, "validatePolicyOfferTC");

        if (!empty($server_output)) {
            $decoded_output = json_decode($server_output, true);
            if (is_array($decoded_output) && count($decoded_output) > 0) {
                $session = JFactory::getSession();
                $session->set('policy_id', $decoded_output['policy_id']);
            }
        }

        echo $server_output;
        die;
    }
    public function savePolicyOfferData(){
        $app = JFactory::getApplication();
        $postData = $app->input->getArray();
        $ip_address = OfferHelper::get_client_ip();
        $device = OfferHelper::getDevice();
        $postData['ip_address'] = $ip_address;
        $postData['device'] = $device;
        $session = JFactory::getSession();
        $policy_id = $session->get('policy_id', 0);
        $postData['policy_id'] = $policy_id;
        $server_output = $this->crmCurl($postData, "savePolicyOffer");
        echo $server_output;
        die;
    }

	function crmCurl($postData, $taskName){
		OfferHelper::getenv_path();
		$ch = curl_init();
        $url = getenv("CRM_WEBSITE_URL");
        $authorization = "Authorization: Bearer ".getenv("BEARER_TOKEN_FOR_CURL");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data;' , $authorization ));
        curl_setopt($ch, CURLOPT_URL,$url."/api/index.php?task=".$taskName);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
		return $server_output;
	}
	public function uploadFileToTmp()
    {

		$return = array();
		$config = JFactory::getConfig();
		$tmp_path = $config->get('tmp_path');
        if (!JFolder::exists($tmp_path)) {
            JFolder::create($tmp_path);
        }
        if (!empty($_FILES)) {

            // Replace any special characters in the filename
            jimport('joomla.filesystem.file');
            jimport('joomla.filesystem.folder');
            if (is_array($_FILES)) {
                foreach ($_FILES as $file_new) {
                    if (is_array($file_new['name'])) {
                        $filename = $file_new['name'][0];
                        $filetype = $file_new['type'][0];
                        $filetmp = $file_new['tmp_name'][0];
                        $extension = JFile::getExt($file_new['name'][0]);
                        $fileError = $file_new['error'][0];
                        $filesize = $file_new['size'][0];

                    } else {

                        $filename = $file_new['name'];
                        $filetype = $file_new['type'];
                        $filetmp = $file_new['tmp_name'];
                        $extension = JFile::getExt($file_new['name']);
                        $fileError = $file_new['error'];
                        $filesize = $file_new['size'];
                    }
                        $filename = JFile::stripExt($filename) . '_' . OfferHelper::getUniqueID();
                        $filename = $filename . '.' . $extension;
                        $uploadFolder = $tmp_path."/";
                        $original_filename = JFile::stripExt($filename) . '---' . $extension;
                        $uploadPath = $uploadFolder . "" . $filename;
                        $form_id = JRequest::getVar('form_id');
                        $ex = explode("-", $form_id);
                        $form_files = $ex[1];
                        $form_id = $ex[0];
                        $return['field_name'] = $form_id;
                        $return['form_files'] = $form_files;
                        $return['original_filename'] = $original_filename;
                        $return['file_name'] = $filename;
                        $return['file_size'] = $filesize;
                        $return['file_type'] = $filetype;
                        $fileTemp = $filetmp;

                      /***start validation***/

                      if ($filetype != 'image/jpg' && $filetype != 'image/jpeg' && $filetype != 'image/png' && $filetype != 'application/pdf' && $filetype != 'application/octet-stream' && $filetype != 'application/msword' && $filetype != 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                        $return['error_msg'] = JText::_('COM_OFFER_BROWSE_FILE_TYPE');
                        echo json_encode($return);
                        exit;
                         }
                       $images = array('image/jpg','image/png','image/jpeg');
                       $ignored   = array_map('trim', explode(',', ''));
                        if (in_array($filetype, $images))
                            {
                                // If tmp_name is empty, then the file was bigger than the PHP limit
                                if (!empty($filetmp))
                                {
                                    // Get the mime type this is an image file
                                    $mime = self::getMimeType($filetmp, true);

                                    // Did we get anything useful?
                                    if ($mime != false)
                                    {
                                    }
                                    // We can't detect the mime type so it looks like an invalid image
                                    else
                                    {
                                        $return['error_msg'] = JText::_('JLIB_MEDIA_ERROR_WARNINVALID_IMG');
                                        echo json_encode($return);
                                        exit;
                                    }
                                }
                                else
                                {
                                    $return['error_msg'] = JText::_('JLIB_MEDIA_ERROR_WARNFILETOOLARGE');
                                        echo json_encode($return);
                                        exit;
                                }
                            }elseif (!in_array($filetype, $ignored))
                                {

                                // Get the mime type this is not an image file
                                $mime = self::getMimeType($filetmp, false);

                                // Did we get anything useful?
                                if ($mime != false)
                                {

                                }
                                // We can't detect the mime type so it looks like an invalid file
                                else
                                {
                                    $return['error_msg'] = JText::_('JLIB_MEDIA_ERROR_WARNINVALID_MIME');
                                    echo json_encode($return);
                                    exit;
                                }
                                }
                                $xss_check = file_get_contents($filetmp, false, null, -1, 256);
                                $html_tags = array(
                            'abbr', 'acronym', 'address', 'applet', 'area', 'audioscope', 'base', 'basefont', 'bdo', 'bgsound', 'big', 'blackface', 'blink',
                            'blockquote', 'body', 'bq', 'br', 'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'comment', 'custom', 'dd', 'del',
                            'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'fn', 'font', 'form', 'frame', 'frameset', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
                            'head', 'hr', 'html', 'iframe', 'ilayer', 'img', 'input', 'ins', 'isindex', 'keygen', 'kbd', 'label', 'layer', 'legend', 'li', 'limittext',
                            'link', 'listing', 'map', 'marquee', 'menu', 'meta', 'multicol', 'nobr', 'noembed', 'noframes', 'noscript', 'nosmartquotes', 'object',
                            'ol', 'optgroup', 'option', 'param', 'plaintext', 'pre', 'rt', 'ruby', 's', 'samp', 'script', 'select', 'server', 'shadow', 'sidebar',
                            'small', 'spacer', 'span', 'strike', 'strong', 'style', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'title',
                            'tr', 'tt', 'ul', 'var', 'wbr', 'xml', 'xmp', '!DOCTYPE', '!--',
                        );
                        foreach ($html_tags as $tag)
                        {
                            // A tag is '<tagname ', so we need to add < and a space or '<tagname>'
                            if (stripos($xss_check, '<' . $tag . ' ') !== false || stripos($xss_check, '<' . $tag . '>') !== false)
                            {
                                $return['error_msg'] = JText::_('JLIB_MEDIA_ERROR_WARNIEXSS');
                                        echo json_encode($return);
                                        exit;
                            }
                        }

                        $fileuploadsize = 1048576 * 10;
                        if ($filesize > $fileuploadsize) {
                            $return['error_msg'] = JText::_('COM_OFFER_BROWSE_SIZE_EXCEEDS');
                            echo json_encode($return);
                            exit;

                        }

                        if ($fileError > 0 && $fileError != 4) {

                            switch ($fileError) {
                                case 1:
                                    $return['error_msg'] = JText::_('COM_OFFER_BROWSE_SERVER_ERROR');
                                    break;
                                case 2:
                                    $return['error_msg'] = JText::_('COM_OFFER_BROWSE_ALLOWED_ERROR');
                                    break;
                                case 3:
                                    $return['error_msg'] = JText::_('COM_OFFER_BROWSE_UPLOAD_ERROR');
                                    break;

                            }
                            if ($return['error_msg'] != '') {
                               echo json_encode($return['error_msg']);
                                exit;
                            }
                        }
                      /**end validation***/

                        if (!JFolder::exists($uploadFolder)) {
                            JFolder::create($uploadFolder);
                        }
                         if (!JFile::upload($fileTemp, $uploadPath)) {
                            $return['error_msg'] = JText::_('JLIB_MEDIA_ERROR_WARNFILETYPE');
                            echo json_encode($return);
                            exit;
                    }else {
                        echo json_encode($return);
                        exit;
                       }
                    }
            }
            die;
        }

    }
	static function getMimeType($file, $isImage = false)
    {

        // If we can't detect anything mime is false
        $mime = false;

        try
        {
            if ($isImage && function_exists('exif_imagetype'))
            {
                $mime = image_type_to_mime_type(exif_imagetype($file));
            }
            elseif ($isImage && function_exists('getimagesize'))
            {
                $imagesize = getimagesize($file);
                $mime      = isset($imagesize['mime']) ? $imagesize['mime'] : false;
            }
            elseif (function_exists('mime_content_type'))
            {
                // We have mime magic.
                $mime = mime_content_type($file);
            }
            elseif (function_exists('finfo_open'))
            {
                // We have fileinfo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime  = finfo_file($finfo, $file);
                finfo_close($finfo);
            }
        }
        catch (\Exception $e)
        {
            // If we have any kind of error here => false;
            return false;
        }

        // If we can't detect the mime try it again
        if ($mime === 'application/octet-stream' && $isImage === true)
        {
            $mime = self::getMimeType($file, false);
        }

        // We have a mime here
        return $mime;
    }
	public function clearTmp()
    {
        $img = JRequest::getVar('img');
		$config = JFactory::getConfig();
		$tmp_path = $config->get('tmp_path');
        $uploadFolder = $tmp_path ."/". $img;
        if (unlink($uploadFolder)) {

            echo '1';
        } else {
            echo '0';
        }
        exit;
	}
    function searchOrganization(){
        $app = JFactory::getApplication();
        $keywords = $app->input->getString('searchword');
        $postData = array();
        $postData['searchword'] = $keywords;
        $server_output = $this->crmCurl($postData,"searchOrganization");
        echo $server_output;
        die;
    }
    function searchHouseOwner(){
        $app = JFactory::getApplication();
        $keywords = $app->input->getString('searchword');
        $orgID = $app->input->getString('org_id');
        $postData = array();
        $postData['searchword'] = $keywords;
        $postData['org_id'] = $orgID;
        $server_output = $this->crmCurl($postData,"searchHouseOwner");
        echo $server_output;
        die;
    }
    function check_houseowner(){
        $app = JFactory::getApplication();
        $postData = $app->input->getArray();
        $server_output = $this->crmCurl($postData,"check_houseowner");
        echo $server_output;
        die;
    }
}
