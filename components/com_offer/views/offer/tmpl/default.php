<?php
//no direct access
defined('_JEXEC') or die('Restricted access.');
use Joomla\CMS\Uri\Uri as JUri;
use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Language\Text as JText;
use Joomla\CMS\HTML\HTMLHelper as JHtml;
$termsFile = OfferHelper::getTermsFile();
$legalFile = OfferHelper::getlegalFile();
?>
<script id="policy-list-template" type="text/x-handlebars-template">
    <?php echo $this->loadTemplate('policy_list'); ?>
</script>
<div class="page-loading-mask is-fullscreen hide">
    <div class="page-loading-spinner">
        <svg viewBox="25 25 50 50" class="circular">
            <circle cx="50" cy="50" r="20" fill="none" class="path"></circle>
        </svg>
    </div>
</div>
<form action="<?php echo JRoute::_('index.php?option=com_offer&view=offer'); ?>" id="offerForm" name="offerForm" class="form-horizontal offerForm form-validate" method="post" enctype="multipart/form-data" >

<div class="offer-token-box code-box">
    <div class="top-banner">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row display-flex align-items-center">
                        <div class="col-sm-12 text-center">
                            <div class="banner-img">
                                <img src="/images/mietkautionsversicherung.png" width="320" alt="mietkautionsversicherung" />
                            </div>
                        </div>
                    </div>
                    <div class="round-shield-banner-img">
                        <img src="/images/shield-icon-green.svg" alt="shield-icon-green">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="token-box-inner">
            <div class="token-field">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="token-box-title">
                            <h2><?php echo JText::_("COM_OFFER_TOKEN_BOX_TITLE"); ?></h2>
                        </div>
                        <div class="token-box-content">
                            <?php echo JText::_("COM_OFFER_TOKEN_BOX_DESC"); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <label class="control-label" for="offer_code"><b><?php echo JText::_("COM_OFFER_CODE_TITLE"); ?></b></label>
                    </div>
                    <div class="col-xs-6 col-sm-6">
                        <div class="field">
                            <input type="text" id="offer_code_box" value="" size="20" name="offer_code_box" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="text-center button-design request-code-submit-btn">
                            <button class="btn-default">
                                <span class="spinner_loader_discount" style="display: none;">
                                    <i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;
                                </span>
                                <strong><?php echo JText::_("COM_OFFER_VALIDATE_BUTTON_TEXT"); ?></strong>
                                <i class="fa fa-chevron-right right-arrow-icon"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="code_validation_container error hide">
                <p><?php echo JText::_("COM_OFFER_VALIDATE_MSG"); ?></p>
            </div>
        </div>
    </div>
</div>
<div class="main-component-section loading-content hide">
    <div class="top-offer-section">
        <div class="container">
            <div class="row align-items-center display-flex">
                <div class="col-sm-2">
                    <div class="round-shield-img">
                        <img src="images/shield-icon.svg" alt="shield-icon">
                    </div>
                </div>
                <div class="col-sm-10">
                    <h3 class="greeting_text"></h3>
                    <div class="offer-notification-content">
                        <?php echo JText::_('COM_OFFER_NOTIFICATION_TEXT');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="policy-offer-view">
        <div class="container">
            <h2 class="policy_overview_text"><?php echo JText::_("COM_OFFER_RENTAL_DEPOSIT_POLICY_OVERVIEW"); ?></h2>
            <div class="policy-detail-section">
            </div>
        </div>
    </div>

    <div class="top-notification-sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="top-notification-container">
                        <div class="top-notify-sec">
                            <?php echo JText::_("COM_OFFER_WELCOME_TEXT"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offer-section">
        <div class="container">
            <div class="offer-section-content">
                <div class="rental-guarantee-header">
                    <div class="guarantee-header-txt"><span><?php echo JText::_('COM_OFFER_ACTIVATE_GOCAUTION_RENTAL_GUARANTEE');?></span></div>
                </div>
                <div class="offer-change-block">
                    <div class="grey-box">
                        <div class="grey-icon-box">
                            <img src="images/icon-mail.svg" alt="icon-mail">
                        </div>
                        <div class="grey-content-box">
                            <div class="contact-information-sec">
                                <div class="heading-label">
                                    <p><?php echo JText::_("COM_OFFER_CORRESPONDENCE_ADDRESS_HEADING"); ?></p>
                                </div>
                                <div class="row contact-standard-address hide">
                                    <div class="col-sm-6">
                                        <label><?php echo JText::_("COM_OFFER_STREET"); ?></label>
                                        <input type="text" name="contact_address_address" class="input-box" value="">
                                    </div>
                                    <div class="col-sm-2">
                                        <label><?php echo JText::_("COM_OFFER_ZIPCODE"); ?></label>
                                        <input type="text" name="contact_address_plz" class="input-box" value="">
                                    </div>
                                    <div class="col-sm-4">
                                        <label><?php echo JText::_("COM_OFFER_CITY"); ?></label>
                                        <input type="text" name="contact_address_ort" class="input-box" value="">
                                    </div>
                                </div>
                                <div class="row receipt-address-box">
                                    <div class="col-sm-12">
                                        <div class="receipt-address-check">
                                            <input type="checkbox" class="input-box" name="receipt-address" id="receipt-address" value="1">
                                            <label for="receipt-address">
                                                <?php echo JText::_("COM_OFFER_ADD_NEW_ADDRESS"); ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="contact-co-address hide">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><?php echo JText::_("COM_OFFER_RECIPIENT_NAME"); ?></label>
                                            <input type="text" name="contact_address_co_name" class="input-box" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label><?php echo JText::_("COM_OFFER_STREET"); ?></label>
                                            <input type="text" name="contact_address_co_address" class="input-box" value="">
                                        </div>
                                        <div class="col-sm-2">
                                            <label><?php echo JText::_("COM_OFFER_ZIPCODE"); ?></label>
                                            <input type="text" name="contact_address_co_plz" class="input-box" value="">
                                        </div>
                                        <div class="col-sm-4">
                                            <label><?php echo JText::_("COM_OFFER_CITY"); ?></label>
                                            <input type="text" name="contact_address_co_ort" class="input-box" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="grey-box">
                        <div class="grey-icon-box">
                            <img src="images/icon-contact.svg" alt="icon-contact">
                        </div>
                        <div class="grey-content-box">
                            <div class="contact-information-sec">
                                <div class="heading-label">
                                    <p><?php echo JText::_("COM_OFFER_UPDATE_OPTIMAL_SUPPORT"); ?></p>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label><?php echo JText::_("COM_OFFER_EMAIL"); ?></label>
                                        <input type="text" name="email" class="input-box validate-email" value="">
                                    </div>
                                    <div class="col-sm-4">
                                        <label><?php echo JText::_("COM_OFFER_MOBILE"); ?></label>
                                        <input type="text" name="mobile" class="input-box intlcode" value="">
                                    </div>
                                    <div class="col-sm-4">
                                        <label><?php echo JText::_("COM_OFFER_TELEPHONE"); ?></label>
                                        <input type="text" name="telefon" class="input-box intlcode" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grey-box">
                        <div class="grey-icon-box">
                            <img src="images/icon-surface1.svg" alt="icon-surface1">
                        </div>
                        <div class="grey-content-box">
                            <div class="contact-information-sec">
                                <div class="heading-label">
                                    <p><?php echo JText::_("COM_OFFER_AGREEMENT_UPLOAD"); ?></p>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">

                                        <div class="file_uploads_container">
                                            <div class="mb-0 form-group file_upload_container rental_agreement_file_upload_container error-message-padding common_agreement_file_upload_container">

                                                <div class="grp-top-title m-y-3">
                                                <!--drag and drop-->
                                                    <div class="row">
                                                        <div class="col-xs-12 col-md-12 optional_uploader">
                                                                <div id="cf_1" class="convertforms cf cf-img-left cf-form-bottom cf-success-hideform cf-hasLabels main-cff">
                                                                    <div class="cf-form-wrap cf-col-16 ">
                                                                        <div class="cf-fields">
                                                                            <div class="cf-control-group " data-key="2">
                                                                                <div class="cf-control-label">
                                                                                </div>
                                                                                <div class="cf-control-input">
                                                                                    <input type="hidden" id="uploaded_f" />
                                                                                    <div style="visibility: hidden;" id="file_busin_files_3"></div>
                                                                                        <div class="cfup-tmpl" style="display:none;">
                                                                                            <div class="cfup-file">
                                                                                                <div class="cfup-status"></div>
                                                                                                <div class="cfup-thumb">
                                                                                                <!-- <img data-dz-thumbnail /> -->
                                                                                                </div>
                                                                                                <div class="cfup-details">
                                                                                                    <div class="cfup-name" data-dz-name></div>
                                                                                                    <div class="cfup-error"><div data-dz-errormessage></div></div>
                                                                                                    <div class="cfup-progress">
                                                                                                        <span class="dz-upload" data-dz-uploadprogress></span>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="cfup-right">
                                                                                                    <span class="cfup-size" data-dz-size></span>
                                                                                                    <a href="#" class="cfup-remove jboxtooltip" data-jbox-title="" data-jbox-content="<?php echo JText::_('COM_OFFER_UPLOADED_FILE_REMOVE'); ?>" onclick="removeRentContract(this, 'abc', 'file_rental_agreement', 'cfup-file')"  data-dz-remove>×</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <div id="form1_fileupload_1_929815903" data-name="cf[fileupload_1]" data-key="2" data-maxfilesize="10" data-maxfiles="0" data-acceptedfiles=".jpg, .jpeg, .png, .pdf, .doc, .docx" class="cfupload_3 uploadbox">
                                                                                        <div class="dz-message cfuploadsub_3">
                                                                                            <span><?php echo JText::_('COM_OFFER_DRAG_DROP_OR_CHOOSE_FILES_TEXT'); ?></span>
                                                                                            <span class="cfupload-browse"><?php echo JText::_('COM_OFFER_BROWSE_FILE'); ?></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <input type="hidden" name="cf[form_id]" value="file_busin-file_busin_files_3">
                                                                </div>
                                                            <div class="cf-control-input-desc desc"><?php echo JText::_('COM_OFFER_FILEUPLOAD_SIZE_AND_TYPE_MESSAGE'); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!--End of drag and drop-->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grey-box">
                        <div class="grey-icon-box">
                            <img src="images/icon-calendar.svg" alt="icon-calendar">
                        </div>
                        <div class="grey-content-box">
                            <div class="contact-information-sec insurance-calendar-view">
                                <div class="heading-label">
                                    <p><?php echo JText::_("COM_OFFER_START_DATE_HEADING"); ?></p>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="calendar-view-content">
                                            <?php echo JText::_("COM_OFFER_START_DATE_CONTENT"); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label><?php echo JText::_("COM_OFFER_START_DATE_LABEL"); ?></label>
                                        <div class="input-group date" id="start_datepicker">
                                            <input type="text" class="form-control" name="policy_start_date" placeholder="<?php echo JText::_('COM_OFFER_START_DATE_FORMAT_PLACEHOLDER');?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                        </div>
                                        <small class="help-block date_format_error" data-fv-validator="date" data-fv-result="INVALID" style="display: none;"><?php echo JText::_("COM_OFFER_START_DATE_FORMAT_ERROR"); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grey-box">
                        <div class="grey-icon-box">
                            <img src="images/icon-refund.svg" alt="icon-refund">
                        </div>
                        <div class="grey-content-box">
                            <div class="contact-information-sec iban-refund-view">
                                <div class="heading-label">
                                    <p><?php echo JText::_("COM_OFFER_IBAN_REFUND_HEADING"); ?></p>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="iban-view-content">
                                            <?php echo JText::_("COM_OFFER_IBAN_REFUND_CONTENT"); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label><?php echo JText::_("COM_OFFER_IBAN_REFUND_LABEL"); ?></label>
                                        <input type="text" name="iban_number" class="input-box" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grey-box">
                        <div class="grey-icon-box">
                            <img src="images/icon-comment.svg" alt="icon-comment">
                        </div>
                        <div class="grey-content-box">
                            <div class="contact-information-sec">
                                <div class="heading-label">
                                    <p><b><?php echo JText::_("COM_OFFER_MESSAGE_TITLE"); ?></b><br><?php echo JText::_("COM_OFFER_MESSAGE_DESC"); ?></p>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="message-box">
                                            <textarea name="policy_admin_message" id="policy_admin_message" placeholder="<?php echo JText::_("COM_OFFER_MESSAGE_LABEL"); ?>" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="finalize-box-top-content">
                        <div class="checkbox-label">
                            <input name="term_check" type="checkbox" id="yes_check">
                            <label for="yes_check"><?php echo JTEXT::_("COM_OFFER_CHECKBOX_TEXT");?></label>
                        </div>
                        <div class="box-content-inner">
                            <?php echo JText::_("COM_OFFER_AGREEMENT_CONTENT"); ?>
                        </div>
                    </div>
                    <div class="row general-error-message" style="display: none;">
                        <div class="col-xs-12 col-sm-12">
                            <div class="display-flex">
                                <div class="error-icon"><i class="fa fa-warning"></i></div>
                                <div class="error-text"><span class="error-message-inner"><?php echo JText::_("COM_OFFER_GENERAL_ERROR_MESSAGE"); ?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="policy-offer-submit-box">
                        <button class="btn submit-btn form-submit-button">
                            <span href="#">
                                <span class="spinner_loader_on_submit" style="display: none;">
                                    <i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;
                                </span>
                                <img src="images/icon-reply.svg" alt="reply"><?php echo JText::_("COM_OFFER_SUBMIT_BUTTON_TEXT"); ?></a>
                        </button>
                        <div class="notes"><img src="images/icon-message.svg" alt="message"><span id="email-post-text"></span>
                        <input type="hidden" name="customer_old_email" id="customer_old_email_exist">
                        </div>
                    </div>
                </div>

                <!-- Thanks Message Section -->
                <div class="thanks-message-box hide">
                    <div class="thanks-top-block">
                        <img src="images/icon-success.svg" alt="icon-success">
                        <div class="thanks-txt">
                            <h3><?php echo JText::_("COM_OFFER_THANKS_MSG_TITLE"); ?></h3>
                            <p><?php echo JText::_("COM_OFFER_THANKS_MSG_DESC"); ?></p>
                        </div>
                    </div>

                    <div class="next-step-box-container">
                        <div class="next-step-text-label">
                            <span><?php echo JText::_("COM_OFFER_NEXT_STEP");?></span>
                        </div>
                    </div>
                    <div class="greybox-step-list">
                        <ul role="list" class="step-list-view">
                            <li>
                                <div class="step-content">
                                    <span class="v-border" aria-hidden="true"></span>
                                    <div class="step-content-area">
                                        <div class="step-icon-block">
                                            1
                                        </div>
                                        <div class="step-content-block">
                                            <h4><?php echo JText::_("COM_OFFER_HEADING_TEXT_STEP_1"); ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="active">
                                <div class="step-content">
                                    <span class="v-border" aria-hidden="true"></span>
                                    <div class="step-content-area">
                                        <div class="step-icon-block">
                                            2
                                        </div>
                                        <div class="step-content-block">
                                            <h4><?php echo JText::_("COM_OFFER_HEADING_TEXT_STEP_2_1"); ?></h4>
                                            <p><?php echo JText::_("COM_OFFER_DESC_TEXT_STEP_2_1"); ?></p>
                                            <h4><?php echo JText::_("COM_OFFER_HEADING_TEXT_STEP_2_2"); ?></h4>
                                            <p><?php echo JText::_("COM_OFFER_DESC_TEXT_STEP_2_2"); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pending">
                                <div class="step-content">
                                    <span class="v-border" aria-hidden="true"></span>
                                    <div class="step-content-area">
                                        <div class="step-icon-block">
                                            3
                                        </div>
                                        <div class="step-content-block">
                                            <h4><?php echo JText::_("COM_OFFER_HEADING_TEXT_STEP_3"); ?></h4>
                                            <p><?php echo JText::_("COM_OFFER_DESC_TEXT_STEP_3"); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pending">
                                <div class="step-content">
                                    <span class="v-border" aria-hidden="true"></span>
                                    <div class="step-content-area">
                                        <div class="step-icon-block">
                                            4
                                        </div>
                                        <div class="step-content-block">
                                            <h4><?php echo JText::_("COM_OFFER_HEADING_TEXT_STEP_4"); ?></h4>
                                            <p><?php echo JText::_("COM_OFFER_DESC_TEXT_STEP_4"); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pending last-step">
                                <div class="step-content">
                                    <span class="v-border" aria-hidden="true"></span>
                                    <div class="step-content-area">
                                        <div class="step-icon-block">
                                            <i class="fa fa-heart"></i>
                                        </div>
                                        <div class="step-content-block">
                                            <h4><?php echo JText::_("COM_OFFER_HEADING_TEXT_STEP_5"); ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="invoice-details-box">
                        <div class="invoice-details-head">
                            <?php echo JText::_("COM_OFFER_BILLING_DETAIL");?>
                        </div>
                        <div class="row invoice-table">
                            <div class="col-sm-6"><?php echo JText::_("COM_OFFER_INSURANCE_PERIOD"); ?></div>
                            <div class="col-sm-6 text-end"><span class="policy_start_date"></span> - <span class="policy_end_date"></span></div>
                            <div class="col-sm-6"><?php echo JText::_("COM_OFFER_INSURANCE_PREMIUM"); ?></div>
                            <div class="col-sm-6 text-end">CHF <span class="policy_premium"></span></div>
                        </div>

                        <div class="invoices-buttons">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="btn-box green-btn">
                                        <button class="btn" id="download-qr-invoice-pdf">
                                            <span class="spinner_loader_on_qr_button" style="display: none;">
                                                <i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;
                                            </span>
                                            <img src="images/icon-download-white.svg" alt="icon-download">
                                            <span><?php echo JText::_("COM_OFFER_QR_INVOICE_DOWNLOAD"); ?></span>
                                            <input type="hidden" name="qr_invoice_id" id="qr_invoice_id" />
                                            <input type="hidden" name="qr_policy_id" id="qr_policy_id" />
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="btn-box">
                                        <a target="_blank" id="payment_link" href="#">
                                            <img src="images/icon-credit-card.svg" alt="icon-download">
                                            <span><?php echo JText::_("COM_OFFER_START_ONLINE_PAYMENT"); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Thanks Message Section -->
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="calculated_policy_deposit_amount" id="calculated_policy_deposit_amount">
<input type="hidden" name="calculated_policy_computed_total" id="calculated_policy_computed_total">
<input type="hidden" name="selectedLessorType" id="selectedLessorType">
<input type="hidden" name="isGarants" id="isGarants">
<input type="hidden" name="selectedGarantCount" id="selectedGarantCount">
<input type="hidden" name="policy_deposit_amount" id="policy_deposit_amount">
<input type="hidden" name="premium_percentage" id="premium_percentage">
<input type="hidden" name="policy_computed_total" id="policy_computed_total">
<input type="hidden" name="policy_contact_type" id="policy_contact_type">
<input type="hidden" name="contactEmailEdit" id="contactEmailEdit" value="0">
</form>
<?php echo $this->loadTemplate('policy_drawer'); ?>
<?php echo $this->loadTemplate('faq'); ?>
