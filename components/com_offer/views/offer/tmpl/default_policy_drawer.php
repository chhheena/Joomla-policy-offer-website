<?php
//no direct access
defined('_JEXEC') or die('Restricted access.');
$garants_birthday_warning_translation =  'COM_OFFER_BIRTHDAY_MESSAGE_FOR_ADDITIONAL_TENANTS';
?>
<!-- Drawer Code -->
<div class="edit-policy-drawer">
    <div class="header-drawer">
        <div class="row">
            <div class="col-sm-7 col-xs-8">
                <div class="header-left-section">
                    <div class="icon-sec">
                        <img src="images/icon-edit-round.svg" alt="">
                    </div>
                    <div class="head-content-sec">
                        <h4 class="policy-number drawer-head-policy_num"><?php echo JText::_('COM_OFFER_NOT_AVAILABLE_TEXT'); ?></h4>
                        <span class="policy-address  drawer-head-policy-address"><?php echo JText::_('COM_OFFER_NOT_AVAILABLE_TEXT'); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-5  col-xs-4 text-right">
                <div class="button-section">
                    <div class="close-drawer">
                        <a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Schliessen"><i class="glyphicon glyphicon-remove"></i></a>
                    </div>
                    <div class="save-button">
                        <button type="button" class="btn btn-primary" value="" id="saveButton_modal"><?php echo JText::_('COM_OFFER_SAVE_TEXT'); ?><span class="save-icon"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="has-error row drawer-error-message drawer_required_pl_org_error align-center hide">
        <div class="col-xs-12 col-sm-12">
            <div class="display-flex">
                <div class="error-icon"><i class="fa fa-warning"></i></div>
                <div class="error-text"><span class="error-message-inner"><?php echo JText::_("COM_OFFER_DRAWER_REQUIRED_FIELDS_ERROR_TEXT"); ?></span></div>
            </div>
        </div>
    </div>
    </div>

    <div class="drawer-content">
        <form name="form_policy_org_pl" id="form_policy_org_pl">
            <div class="row">
                <fieldset>
                    <div class="row sub-rent-owner-lessor-hide">
                        <div class="col-xs-12">
                            <div class="d-block-mob display-flex align-center mb-30">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label class="control-label mb-0" for="Mitevertrag mit formtitle-label">
                                        <?php echo JText::_('COM_OFFER_LANDLORD_TYPE'); ?> *
                                    </label>
                                </div>
                                <div class="text-right col-xs-12 col-sm-8 col-md-8 col-lg-8 text-left-vsmall">
                                    <div class="btn-group btn-radio-select" id="lessor_group" data-toggle="buttons">
                                        <label class="btn btn-default " for="Verwaltung">
                                            <input class="radio_toggle required" type="radio" value="organization" name="lessor_type" id="lessor_type_org">
                                            <?php echo JText::_('COM_OFFER_MANAGEMENT'); ?>
                                        </label>
                                        <label class="btn btn-default" for="Eigentümer">
                                            <input class="radio_toggle required" type="radio" value="private_landlord" name="lessor_type" id="lessor_type_private">
                                            <?php echo JText::_('COM_OFFER_OWNER'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lessor_type_organization_block hide">
                        <div style="display:none;" id="not-accepted-organization" class="mb-30">
                            <div class="content-box">
                                <div class="info-logo">
                                    <i class="fa fa-times-circle "></i>
                                </div>
                                <div class="info-text">
                                    <div class="info-title">
                                        <span><?php echo JText::_('COM_OFFER_NOTACCEPTEDORG_INFO_TITLE'); ?></span>
                                    </div>
                                    <div>
                                        <?php echo JText::_('COM_OFFER_NOTACCEPTEDORG_INFO_MESSAGE'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback mb-30">
                            <div class="form-group org_search_title">
                                <div class="grp-top-title m-y-3">
                                    <legend class="a-legend a-legend-main">
                                        <span class="hidden-xs"><?php echo JText::_('COM_OFFER_ORG_SEARCH'); ?></span>
                                        <span class="visible-xs"><?php echo JText::_('COM_OFFER_ORG_SEARCH_MOBILE'); ?></span>
                                    </legend>
                                    <hr class="seprator fullhr-seprator">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 org_typehead ">
                                <div class="input-group">
                                    <input type="text" id="google_org_search" class="form-control" placeholder="<?php echo JText::_('COM_OFFER_ORG_SEARCH_PLACEHOLDER'); ?>">
                                    <span class="input-group-btn jboxtooltip-org-clear" data-jbox-title="" data-jbox-content="<?php echo JText::_('COM_OFFER_REMOVE_SELECTION'); ?>">
                                        <button class="btn btn-default" onclick="clearOrgSelection()" type="button"><i class="fa fa-search"></i> </button>
                                    </span>
                                </div>
                                <!-- /input-group -->
                            </div>
                        </div>
                        <div class="form-group org_manual_section">
                            <div class="grp-top-title m-y-3 bs-margin-top">
                                <legend class="a-legend a-legend-main"><?php echo JText::_('COM_OFFER_ADD_ORG_MANUALY'); ?></legend>
                                <hr class="seprator fullhr-seprator">
                            </div>
                        </div>
                        <div class="form-group org_exist_confirm_section" style="display:none;">
                        </div>
                        <div class="form-group org_manual_section mb-0">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="field form-group">
                                    <label for="vermieter_firma">
                                        <?php echo JText::_('COM_OFFER_ORGANISATION_NAME'); ?>
                                    </label>
                                    <input type="text" id="org_name" class="form-control required" name="org_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group org_manual_section mb-0">
                            <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                                <div class="field form-group">
                                    <label for="org_address">
                                        <?php echo JText::_('COM_OFFER_ADDRESS'); ?> *
                                    </label>
                                    <input type="text" id="prop_address" class="form-control required" name="org_address">
                                </div>
                            </div>
                            <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                                <div class="row">
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 collapse-right">
                                        <div class="field form-group">
                                            <label for="regiprop_plz">
                                                <?php echo JText::_('COM_OFFER_ZIPCODE'); ?> *
                                            </label>
                                            <input type="tel" id="org_plz" minlength="4" name="org_plz" class="required form-control">
                                        </div>
                                    </div>
                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 myregiprop collapse-left">
                                        <div class="field form-group">
                                            <label for="regiprop_plz">
                                                <?php echo JText::_('COM_OFFER_CITY'); ?> *
                                            </label>
                                            <input type="text" id="org_ort" size="20" name="org_ort" class="required form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                                        <div class="field">
                                            <label for="org_phone">
                                                <?php echo JText::_('COM_OFFER_TELEPHONE'); ?>
                                            </label>
                                            <input type="tel" class="form-control intlcode" name="org_phone" id="org_phone">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 pull-right">
                                        <div class="field form-group org_email_input">
                                            <label for="org_email">
                                                <?php echo JText::_('COM_OFFER_EMAIL'); ?>
                                            </label>
                                            <input type="text" class="form-control" name="org_email" id="org_email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="organization_id" name="organization_id">
                    </div>
                </fieldset>
            </div>

            <div class="organization_houseowner_block hide">
                <div class="row">
                    <div class="form-group information-about-employee-heading">
                        <div class="grp-top-title m-y-3">
                            <legend class="a-legend a-legend-main"><?php echo JText::_('COM_OFFER_HOUSE_OWNER_TITLE'); ?></legend>
                            <hr class="seprator">
                        </div>
                    </div>
                </div>
                <p class=""><?php echo JText::_('COM_OFFER_ADD_HO_INFO'); ?></p>
                <!--houseowner count and tooltip-->
                <div class="row" id="show-houseowner" style="display: none;">
                        <p class="text-left houseowner_count">
                            <?php echo JText::sprintf('COM_OFFER_HOUSEOWNER_COUNT_AVAILABLE', '<span id="count_houseowner"></span>'); ?>
                            <!-- <span class="jboxtooltip" data-jbox-title="" data-jbox-content="<?php //echo JText::_('COM_OFFER_HOUSEOWNER_COUNT_AVAILABLE_TOOLTIP'); ?>">
                                <i class="fa fa-info-circle">&nbsp;</i>
                            </span> -->
                        </p>
                </div>

                <br />
                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 house_owner_data">
                            <div class="input-group">
                                <input type="text" id="google_houseowner_search" class="form-control" placeholder="<?php echo JText::_('COM_OFFER_HOUSEOWNER_SEARCH_PLACEHOLDER'); ?>">
                                <span class="input-group-btn jboxtooltip-ho-clear" data-jbox-title="" data-jbox-content="<?php echo JText::_('COM_OFFER_REMOVE_SELECTION'); ?>">
                                    <button class="btn btn-default" onclick="clearHOSelection()" type="button"><i class="fa fa-search"></i> </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </div>
                    </div>
                </div>
                <div class="form-group information-about-houseowner-heading mb-30 HO_manual_section" id="show-houseowner-enter" style="display: none;">
                    <div class="grp-top-title m-y-3">
                        <legend class="a-legend a-legend-main"><?php echo JText::_('COM_OFFER_ENTER_HOUSEOWNER_DATA_YOURSELF'); ?></legend>
                        <hr class="seprator fullhr-seprator">
                    </div>
                </div>
                <div class="row HO_manual_section">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 house_owner_name">
                        <div class="field form-group">
                            <label for="house_owner_name">
                                <?php echo JText::_('COM_OFFER_HOUSE_OWNER_NAME'); ?>
                            </label>
                            <input type="text" id="house_owner_name" class="form-control" name="house_owner_name">
                        </div>
                    </div>
                </div>
                <div class="row HO_manual_section">
                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                        <div class="field">
                            <label for="house_owner_address" class="house_owner_address">
                                <?php echo JText::_('COM_OFFER_ADDRESS'); ?>
                            </label>
                            <input type="text" id="house_owner_address" class="form-control house_owner_address" name="house_owner_address">
                        </div>
                    </div>
                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 myregiprop house_owner_plz collapse-right">
                                <div class="field form-group">
                                    <label for="house_owner_plz" class="house_owner_plz">
                                        <?php echo JText::_('COM_OFFER_ZIPCODE'); ?>
                                    </label>
                                    <input type="tel" class="form-control" id="house_owner_plz" minlength="4" name="house_owner_plz">
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 myregiprop house_owner_city collapse-left">
                                <div class="field form-group">
                                    <label for="house_owner_city" class="house_owner_city">
                                        <?php echo JText::_('COM_OFFER_CITY'); ?>
                                    </label>
                                    <input type="text" class="form-control" id="house_owner_city" value="" size="20" name="house_owner_city">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="houseowner_id" name="houseowner_id">
            </div>

            <div class="lessor_type_private_block hide">
                <div class="row">
                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="form-group d-block-mob display-flex align-center mb-30">
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                    <label for="anrede" class="control-label">
                                        <?php echo JText::_('COM_OFFER_SALUTATION'); ?>
                                    </label>
                                </div>
                                <div class="text-right col-xs-12 col-sm-10 col-md-10 col-lg-10 text-left-vsmall">
                                    <div class="btn-group" id="anrede_group" data-toggle="buttons">
                                        <label class="btn btn-default active" for="anrede" id="label_user"><?php echo JText::_('COM_OFFER_MR'); ?>
                                            <input class="radio_toggle anrede_private_cls required" type="radio" value="mr" name="anrede_private" id="anrede_mr" checked="checked" />
                                        </label>
                                        <label class="btn btn-default " for="anrede"><?php echo JText::_('COM_OFFER_MRS'); ?>
                                            <input class="radio_toggle anrede_private_cls required" type="radio" value="mrs" name="anrede_private" id="anrede_mrs" /> </label>
                                        <label class="btn btn-default" for="anrede"><?php echo JText::_('COM_OFFER_FAMILY'); ?>
                                            <input class="radio_toggle anrede_private_cls required" type="radio" value="family" name="anrede_private" id="anrede_family" /> </label>
                                        <label class="btn btn-default " for="anrede" id="anrede_company_label"><?php echo JText::_('COM_OFFER_PL_COMPANY'); ?>
                                            <input class="radio_toggle anrede_private_cls required" type="radio" value="company" name="anrede_private" id="anrede_company" /> </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="form-group d-block-mob display-flex align-center mb-30">
                                <div class="col-xs-12 col-sm-5 col-md-6 no-padding-right">
                                    <label class="control-label" for="privatelandlord_language"><?php echo JText::_('JFIELD_LANGUAGE_LABEL'); ?> *</label>
                                </div>
                                <div class="text-right col-xs-12 col-sm-7 col-md-6 text-left-vsmall collapse-left mob_left_collapse">
                                    <div class="btn-group btn-radio-select lang-radio-select salutation_btn_group" data-toggle="buttons">
                                        <label class="btn btn-default" for="privatelandlord_language" id="label_user">
                                            DE
                                            <input class="radio_toggle required" type="radio" value="de-DE" name="privatelandlord_language" id="pl_de" />
                                        </label>
                                        <label class="btn btn-default " for="privatelandlord_language">
                                            FR
                                            <input class="radio_toggle required" type="radio" value="fr-FR" name="privatelandlord_language" id="pl_fr" />
                                        </label>
                                        <label class="btn btn-default " for="privatelandlord_language">
                                            IT
                                            <input class="radio_toggle required" type="radio" value="it-IT" name="privatelandlord_language" id="pl_it" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group pvt_org_exist_confirm_section" style="display:none;">
                <?php
                    //echo RegistrationFrontendHelper::landLordMessageBoxRender('COM_OFFER_ORG_EXIST_IN_PL_TITLE ','pvt_org');
                        /*foreach($this->landlordExistsData as $landlordData)
                        {
                        ?>
                            <div class="pl_exist_info" id="<?php echo 'pvt_org_'.$landlordData ?>"></div>
                        <?php
                        }*/
                    ?>
                </div> -->
                <div class="row">
                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                        <div class="field form-group">
                            <label for="privatelandlord_vermieter_firma" id="privatelandlord_vermieter_firma_label">
                                <?php echo JText::_('COM_OFFER_NAME'); ?> *
                            </label>
                            <input type="text" id="privatelandlord_vermieter_firma" class="form-control required" name="privatelandlord_name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 pull-right">
                        <div class="field form-group privatelandlord_vermieter_firma_firstname_label_input">
                            <label for="privatelandlord_vermieter_firma_firstname" id="privatelandlord_vermieter_firma_firstname_label">
                                <?php echo JText::_('COM_OFFER_FIRST_NAME'); ?> *
                            </label>
                            <input type="text" id="privatelandlord_vermieter_firma_firstname" class="form-control required" name="privatelandlord_firstname">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                        <div class="field form-group">
                            <label for="prop_adress_private">
                                <?php echo JText::_('COM_OFFER_ADDRESS'); ?> *
                            </label>
                            <input type="text" id="privatelandlord_prop_adress" class="form-control required" name="privatelandlord_address">
                        </div>
                    </div>
                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 collapse-right">
                                <div class="field form-group">
                                    <label for="regiprop_plz">
                                        <?php echo JText::_('COM_OFFER_ZIPCODE'); ?> *
                                    </label>
                                    <input type="tel" id="privatelandlord_regiprop_plz" minlength="4" name="privatelandlord_plz" class="required form-control">
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 collapse-left">
                                <div class="field form-group">
                                    <label for="regiprop_plz">
                                        <?php echo JText::_('COM_OFFER_CITY'); ?> *
                                    </label>
                                    <input type="text" id="privatelandlord_regiprop_ort" value="" size="20" name="privatelandlord_ort" class="required form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                        <div class="field">
                            <label for="vermieter_kontakt">
                                <?php echo JText::_('COM_OFFER_TELEPHONE'); ?>
                            </label>
                            <input type="tel" class="form-control intlcode" name="privatelandlord_phone" id="privatelandlord_vermieter_kontakt">
                        </div>
                    </div>
                    <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 pull-right">
                        <div class="field form-group privatelandlord_email_input">
                            <label for="vermieter_kontakt">
                                <?php echo JText::_('COM_OFFER_EMAIL'); ?>
                            </label>
                            <input type="text" class="form-control" name="privatelandlord_email" id="privatelandlord_email">
                        </div>
                    </div>
                </div>
                <input type="hidden" id="privatelandlord_id" name="privatelandlord_id" value="">
            </div>
        </form>

        <hr class="mt-10 section-hr-seprator">
        <div class="garant_block">
            <form name="form_policy_garant" id="form_policy_garant">
                <div class="row">
                <div class="form-group mb-30 garants-contact-heading">
                    <fieldset>
                        <div class="text-left grp-top-title section-title m-y-3 garants-non-sub-rent-owner">
                            <legend class="a-legend a-legend-main">
                                <span class="hidden-xs"><?php echo JText::_('COM_OFFER_EXTRAFIELDS'); ?></span>
                                <span class="visible-xs"><?php echo JText::_('COM_OFFER_EXTRAFIELDS_MOBILE'); ?></span>
                            </legend>
                        </div>
                        <div class="text-left grp-top-title section-title m-y-3 garants-sub-rent-owner hide">
                            <legend class="a-legend a-legend-main">
                                <span><?php echo JText::_('COM_OFFER_ADDITIONAL_TENANTS_SUBRENT'); ?></span>
                            </legend>
                            <div tabindex="-1" class="a-button a-button-icon-help help-btn"
                                data-header="<?php echo JText::_('COM_OFFER_ADDITIONAL_TENANTS_TITLE'); ?>"
                                data-content="<?php echo JText::_('COM_OFFER_HELP_ADDITIONAL_TENANTS_SUBRENT_DESC'); ?>">
                                <span class="slide-div"><?php echo JText::_('COM_OFFER_HELP_BUTTON'); ?></span>
                                <i class="fa fa-question-circle slide-div" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="text-left grp-top-title section-title m-y-3 company-garants hide">
                            <legend class="a-legend a-legend-main">
                                <span class="hidden-xs"><?php echo JText::_('COM_OFFER_EXTRAFIELDS'); ?></span>
                                <span class="visible-xs"><?php echo JText::_('COM_OFFER_EXTRAFIELDS_MOBILE'); ?></span>
                            </legend>
                            <div tabindex="-1" class="a-button a-button-icon-help help-btn"
                                data-header="<?php echo JText::_('COM_OFFER_ADDITIONAL_TENANTS_TITLE'); ?>"
                                data-content="<?php echo JText::_('COM_OFFER_HELP_COMPANY_ADDITIONAL_TENANTS_DESC'); ?>">
                                <span class="slide-div"><?php echo JText::_('COM_OFFER_HELP_BUTTON'); ?></span>
                                <i class="fa fa-question-circle slide-div" aria-hidden="true"></i>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="form-group garants-contact-sub-heading display-flex align-center">
                    <label for="garant_total" class="col-xs-7 col-xs-50 col-sm-9 col-md-9 col-lg-9 control-label garant_yes_no_label">
                    <?php echo JText::_('COM_OFFER_ADDITIONAL_TENANTS_TOTAL'); ?>
                    </label>
                    <div class="text-right col-xs-5 col-xs-50 col-sm-3 col-md-3 col-lg-3" >
                        <div class="btn-group btn-radio-select" id="garant_total_main" data-toggle="buttons">
                            <label class="btn btn-default" for="garant_total_main">
                                <input type="radio" value="1" name="garant_total_main" class="radio_toggle">
                            <?php echo JText::_('JYES'); ?>
                            </label>
                            <label class="btn btn-default" for="garant_total_main">
                                <input type="radio" value="0" name="garant_total_main"
                                class="radio_toggle">
                            <?php echo JText::_('JNO'); ?>
                            </label>
                        </div>
                        <input type="radio" style="display: none;" value="0"  id="garant_total_no"
                            name="garant_total"/>
                    </div>
                </div>
                <div class="form-group align-center mt-30 mb-30" id="garant_total_sub" style="display: none;">
                    <label for="" class="col-xs-5 col-sm-4 col-md-8 col-lg-7 control-label">
                    <?php echo JText::_('COM_OFFER_ADDITIONAL_TENANTS_YES'); ?>
                    </label>
                    <div class="text-right col-xs-7 col-sm-8 col-md-8 col-lg-5">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default active grant_one grant_one_radio" style="display: none;">
                            <input type="radio" value="1" checked="checked" name="garant_total" class="">
                            1
                            </label>
                            <label class="btn btn-default grant_two grant_two_radio" style="display: none;">
                            <input type="radio" value="2" name="garant_total" class="">
                            2
                            </label>
                            <label class="btn btn-default grant_three grant_three_radio" style="display: none;">
                            <input type="radio" value="3" name="garant_total" class="">
                            3
                            </label>
                            <label class="btn btn-default grant_four grant_four_radio" style="display: none;">
                            <input type="radio" value="4" name="garant_total" class="">
                            4
                            </label>
                            <label class="btn btn-default grant_five grant_five_radio" style="display: none;">
                            <input type="radio" value="5" name="garant_total" class="">
                            5
                            </label>
                        </div>
                    </div>
                </div>
                </div>
                <div class="tenant_info_message mb-30" style="display:none;" >
                    <div class="content-box" >
                        <div class="info-logo">
                            <i class="fa fa-warning"></i>
                        </div>
                        <div class="info-text">
                            <div>
                                <?php echo JText::_('COM_OFFER_TENANT_INFO_MESSAGE'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="garant_one_div" class="garant-individaul first" style="display:none;">
                    <div class="row">
                        <div class="form-group mb-30">
                            <div class="text-left grp-top-title section-title m-y-3">
                                <legend class="a-legend a-legend-main sub-title"> <?php echo JText::_('COM_OFFER_ADDITIONAL_TENANTS_COMMON_TITLE'); ?>1</legend>
                            </div>
                        </div>
                        <div class="form-group btngroup-container">
                            <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6">
                                <div class="row display-flex align-center">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 no-padding-right">
                                        <label class="control-label" for="garant_one_salutation"><?php echo JText::_('COM_OFFER_SALUTATION'); ?> *</label>
                                    </div>
                                    <div class="text-right col-xs-9 col-sm-9 col-md-9 col-lg-9 collapse-left salutation-radio">
                                        <div class=" btn-group btn-radio-select salutation_btn_group" data-toggle="buttons">
                                            <label class="btn btn-default" for="garant_one_salutation">
                                            <?php echo JText::_('COM_OFFER_MR'); ?>
                                            <input class="radio_toggle required" type="radio" value="mr" name="garant_one_salutation"/>
                                            </label>
                                            <label class="btn btn-default " for="garant_one_salutation">
                                            <?php echo JText::_('COM_OFFER_MRS'); ?>
                                            <input class="radio_toggle required" type="radio" value="mrs" name="garant_one_salutation"/>
                                            </label>
                                            <label class="btn btn-default " for="garant_one_salutation">
                                            <?php echo JText::_('COM_OFFER_COMPANY'); ?>
                                            <input class="radio_toggle required" type="radio" value="company" name="garant_one_salutation"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="field form-group">
                                <label class="garant_one_name" for="garant_one_name">
                                <?php echo JText::_('COM_OFFER_NAME'); ?> *
                                </label>
                                <input type="text" id="garant_one_name" class="form-control required" name="garant_one_name">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_one_salutation_dependant non_company_field_div">
                            <div class="field form-group">
                                <label for="garant_one_vorname">
                                    <?php echo JText::_('COM_OFFER_FIRST_NAME'); ?> *
                                </label>
                                <input type="text" id="garant_one_vorname" class="form-control required" name="garant_one_vorname">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="field form-group">
                                <label for="garant_one_adresseinfo">
                                    <?php echo JText::_('COM_OFFER_ADDRESS'); ?> *
                                </label>
                                <input type="text" id="garant_one_adresseinfo" class="form-control required" name="garant_one_adresseinfo">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 collapse-right">
                                    <div class="field form-group">
                                        <label>
                                            <?php echo JText::_('COM_OFFER_ZIPCODE'); ?> *
                                        </label>
                                        <input type="tel" id="garant_one_plz" minlength="4" name="garant_one_plz" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 collapse-left">
                                    <div class="field form-group">
                                        <label>
                                            <?php echo JText::_('COM_OFFER_CITY'); ?> *
                                        </label>
                                        <input type="text" id="garant_one_ort" value="" size="20" name="garant_one_ort" class="form-control required">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Start of New garants fields-->
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garants_birthday_container garant_one_salutation_dependant non_company_field_div">
                            <div class="field form-group">
                                <label for="garant_one_geburtsdatum">
                                    <?php echo JText::_('COM_OFFER_DATE_OF_BIRTH'); ?> *
                                </label>
                                <input type="text" id="garant_one_geburtsdatum" class="birthdate-validate-18 form-control required" name="garant_one_geburtsdatum" placeholder="<?php echo JText::_('COM_OFFER_START_DATE_FORMAT_PLACEHOLDER'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group field nation-field-container float-label-select">
                                <label for="garant_one_nation">
                                    <?php echo JText::_('COM_OFFER_COUNTRY'); ?> *
                                </label>
                                <select name='garant_one_nation' class='godrop form-control required' id='garant_one_nation'></select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 birthday-error-msg garant_one_salutation_dependant non_company_field_div">
                        <?php
                            echo OfferHelper::birthDateRender($garants_birthday_warning_translation,'garant_one_geburtsdatum_message');
                            ?>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_one_nation_residant_permit hide">
                                <div class="form-group residence_card_questions field float-label-select garant_one_residence_card_questions">
                                    <label for="garant_one_residence_card_questions"><?php echo JText::_('COM_OFFER_RESIDENCE_OPTION_QUESTION'); ?> *</label>
                                </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_one_salutation_dependant non_company_field_div">
                            <div class="field form-group mobilefield">
                                <label for="garant_one_phone">
                                    <?php echo JText::_('COM_OFFER_MOBILE'); ?> *
                                </label>
                                <input type="tel" id="garant_one_phone" class="col-xs-10 col-sm-10 col-md-12 col-lg-12 form-control intlcode required" data-alt-class="garant-phone" name="garant_one_phone">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="garant_one_no_email-container">
                                <div class="field form-group mb-15 garant_one_email_field">
                                    <label for="garant_one_email">
                                        <?php echo JText::_('COM_OFFER_EMAIL'); ?> <span class="star_disable">*</span>
                                    </label>
                                    <div class="garant-email-field">
                                        <input type="text" id="garant_one_email" class="form-control garant_email required" name="garant_one_email">
                                        <span class="input-group-addon hide">
                                            <div class="control control--checkbox">
                                                <input type="checkbox" data-no-email-element="garant_one_" class="garant_one_no_emails no-email-checkbox" name="duplicate_garant_one_no_emails" value="1">
                                                <div class="control__indicator"></div><?php echo JText::_('COM_OFFER_NONE'); ?>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="checkbox-with-border garant_one_no-email-field garant_one_no_email_main mb-30">
                                <label class="mb-0 control control--checkbox">
                                <?php echo JText::_('COM_OFFER_NO_EMAIL'); ?>
                                <input type="checkbox" data-no-email-element="garant_one_" class="garant_one_no_emails no-email-checkbox" name="garant_one_no_emails" value="1"/>
                                <div class="control__indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-0 form-group btngroup-container display-flex align-center">
                            <label for="garant_one_open_debt" class="col-xs-7 col-xs-50 col-sm-12 col-md-8 col-lg-9 control-label btn-grp-label">
                            <?php echo JText::_('COM_OFFER_OPEN_DEBT'); ?> *
                            </label>
                            <div class="text-right col-xs-5 col-xs-50 col-sm-12 col-md-4 col-lg-3 debt-radio-btns" >
                                <div class="btn-group btn-radio-select" id="garant_one_open_debt" data-toggle="buttons">
                                    <label class="btn btn-default" for="garant_one_open_debt">
                                    <input type="radio" value="1" name="garant_one_open_debt" class="radio_toggle required">
                                    <?php echo JText::_('JYES'); ?>
                                    </label> <label class="btn btn-default" for="garant_one_open_debt">
                                    <input type="radio" value="0" name="garant_one_open_debt"
                                        class="radio_toggle required">
                                    <?php echo JText::_('JNO'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of New garants fields-->
                </div>
                <div id="garant_two_div" class="garant-individaul" style="display:none;">
                    <div class="row">
                        <div class="form-group mb-30">
                            <div class="text-left grp-top-title section-title m-y-3">
                                <legend class="a-legend a-legend-main sub-title"> <?php echo JText::_('COM_OFFER_ADDITIONAL_TENANTS_COMMON_TITLE'); ?>2</legend>
                            </div>
                        </div>
                        <div class="form-group btngroup-container">
                            <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6">
                                <div class="row display-flex align-center">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 no-padding-right">
                                        <label class="control-label" for="garant_two_salutation"><?php echo JText::_('COM_OFFER_SALUTATION'); ?> *</label>
                                    </div>
                                    <div class="text-right col-xs-9 col-sm-9 col-md-9 col-lg-9 collapse-left salutation-radio">
                                        <div class=" btn-group btn-radio-select salutation_btn_group" data-toggle="buttons">
                                            <label class="btn btn-default" for="garant_two_salutation">
                                            <?php echo JText::_('COM_OFFER_MR'); ?>
                                            <input class="radio_toggle required" type="radio" value="mr" name="garant_two_salutation"/>
                                            </label>
                                            <label class="btn btn-default " for="garant_two_salutation">
                                            <?php echo JText::_('COM_OFFER_MRS'); ?>
                                            <input class="radio_toggle required" type="radio" value="mrs" name="garant_two_salutation"/>
                                            </label>
                                            <label class="btn btn-default " for="garant_two_salutation">
                                            <?php echo JText::_('COM_OFFER_COMPANY'); ?>
                                            <input class="radio_toggle required" type="radio" value="company" name="garant_two_salutation"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="field form-group">
                                <label class="garant_two_name" for="garant_two_name">
                                    <?php echo JText::_('COM_OFFER_NAME'); ?> *
                                </label>
                                <input type="text" id="garant_two_name" class="form-control required" name="garant_two_name">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_two_salutation_dependant non_company_field_div">
                            <div class="field form-group">
                                <label for="garant_two_vorname">
                                    <?php echo JText::_('COM_OFFER_FIRST_NAME'); ?> *
                                </label>
                                <input type="text" id="garant_two_vorname" class="form-control required" name="garant_two_vorname">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="field form-group">
                                 <label for="garant_two_adresseinfo">
                                    <?php echo JText::_('COM_OFFER_ADDRESS'); ?> *
                                </label>
                                <input type="text" id="garant_two_adresseinfo" class="form-control required" name="garant_two_adresseinfo">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 collapse-right">
                                    <div class="field form-group">
                                        <label for="garant_two_plz">
                                            <?php echo JText::_('COM_OFFER_ZIPCODE'); ?> *
                                        </label>
                                        <input type="tel" id="garant_two_plz" minlength="4" name="garant_two_plz" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 collapse-left">
                                    <div class="field form-group">
                                        <label for="garant_two_plz">
                                            <?php echo JText::_('COM_OFFER_CITY'); ?> *
                                        </label>
                                        <input type="text" id="garant_two_ort" value="" size="20" name="garant_two_ort" class="form-control required">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Start of New garants fields-->
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garants_birthday_container garant_two_salutation_dependant non_company_field_div">
                            <div class="field form-group">
                                <label for="garant_two_geburtsdatum">
                                    <?php echo JText::_('COM_OFFER_DATE_OF_BIRTH'); ?> *
                                </label>
                                <input type="text" id="garant_two_geburtsdatum" class="birthdate-validate-18 form-control required" name="garant_two_geburtsdatum" placeholder="<?php echo JText::_('COM_OFFER_START_DATE_FORMAT_PLACEHOLDER'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group field nation-field-container float-label-select">
                                <label for="garant_two_nation">
                                <?php echo JText::_('COM_OFFER_COUNTRY'); ?> *
                                </label>
                                <select name='garant_two_nation' class='godrop form-control required' id='garant_two_nation'></select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 birthday-error-msg garant_two_salutation_dependant non_company_field_div">
                        <?php
                            echo OfferHelper::birthDateRender($garants_birthday_warning_translation,'garant_two_geburtsdatum_message');
                            ?>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_two_nation_residant_permit hide">
                            <div class="form-group residence_card_questions field float-label-select garant_two_residence_card_questions">
                                <label for="garant_two_residence_card_questions"><?php echo JText::_('COM_OFFER_RESIDENCE_OPTION_QUESTION'); ?> *</label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_two_salutation_dependant non_company_field_div">
                            <div class="field form-group mobilefield">
                                <label for="garant_two_phone">
                                    <?php echo JText::_('COM_OFFER_MOBILE'); ?> *
                                </label>
                                <input type="tel" id="garant_two_phone" class="col-xs-10 col-sm-10 col-md-12 col-lg-12 form-control intlcode required" data-alt-class="garant-phone" name="garant_two_phone">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="garant_two_no_email-container">
                                <div class="field form-group mb-15 garant_two_email_field">
                                    <label for="garant_two_email">
                                        <?php echo JText::_('COM_OFFER_EMAIL'); ?> <span class="star_disable">*</span>
                                    </label>
                                    <div class="garant-email-field">
                                        <input type="text" id="garant_two_email" class="form-control required garant_email" name="garant_two_email">
                                        <span class="input-group-addon hide">
                                            <div class="control control--checkbox">
                                                <input type="checkbox" data-no-email-element="garant_two_" class="garant_two_no_emails no-email-checkbox" name="duplicate_garant_two_no_emails" value="1">
                                                <div class="control__indicator"></div><?php echo JText::_('COM_OFFER_NONE'); ?>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="checkbox-with-border garant_two_no-email-field garant_two_no_email_main mb-30">
                                <label class="mb-0 control control--checkbox">
                                <?php echo JText::_('COM_OFFER_NO_EMAIL'); ?>
                                <input type="checkbox" data-no-email-element="garant_two_" class="garant_two_no_emails no-email-checkbox" name="garant_two_no_emails" value="1"/>
                                <div class="control__indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-0 form-group btngroup-container display-flex align-center">
                            <label for="garant_two_open_debt" class="col-xs-7 col-xs-50 col-sm-12 col-md-8 col-lg-9 control-label btn-grp-label">
                            <?php echo JText::_('COM_OFFER_OPEN_DEBT'); ?> *
                            </label>
                            <div class="text-right col-xs-5 col-xs-50 col-sm-12 col-md-4 col-lg-3 debt-radio-btns" >
                                <div class="btn-group btn-radio-select" id="garant_two_open_debt" data-toggle="buttons">
                                    <label class="btn btn-default" for="garant_two_open_debt">
                                    <input type="radio" value="1" name="garant_two_open_debt" class="radio_toggle required">
                                    <?php echo JText::_('JYES'); ?>
                                    </label> <label class="btn btn-default" for="garant_two_open_debt">
                                    <input type="radio" value="0" name="garant_two_open_debt"
                                        class="radio_toggle required">
                                    <?php echo JText::_('JNO'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of New garants fields-->
                </div>
                <div id="garant_three_div" class="garant-individaul" style="display:none;">
                    <div class="row">
                        <div class="form-group mb-30">
                            <div class="text-left grp-top-title section-title m-y-3">
                                <legend class="a-legend a-legend-main sub-title"> <?php echo JText::_('COM_OFFER_ADDITIONAL_TENANTS_COMMON_TITLE'); ?>3</legend>
                            </div>
                        </div>
                        <div class="form-group btngroup-container">
                            <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6">
                                <div class="row display-flex align-center">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 no-padding-right">
                                        <label class="control-label" for="garant_three_salutation"><?php echo JText::_('COM_OFFER_SALUTATION'); ?> *</label>
                                    </div>
                                    <div class="text-right col-xs-9 col-sm-9 col-md-9 col-lg-9 collapse-left salutation-radio">
                                        <div class=" btn-group btn-radio-select salutation_btn_group" data-toggle="buttons">
                                            <label class="btn btn-default" for="garant_three_salutation">
                                            <?php echo JText::_('COM_OFFER_MR'); ?>
                                            <input class="radio_toggle required" type="radio" value="mr" name="garant_three_salutation"/>
                                            </label>
                                            <label class="btn btn-default " for="garant_three_salutation">
                                            <?php echo JText::_('COM_OFFER_MRS'); ?>
                                            <input class="radio_toggle required" type="radio" value="mrs" name="garant_three_salutation"/>
                                            </label>
                                            <label class="btn btn-default " for="garant_three_salutation">
                                            <?php echo JText::_('COM_OFFER_COMPANY'); ?>
                                            <input class="radio_toggle required" type="radio" value="company" name="garant_three_salutation"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="field form-group">
                                <label class="garant_three_name" for="garant_three_name">
                                    <?php echo JText::_('COM_OFFER_NAME'); ?> *
                                </label>
                                <input type="text" id="garant_three_name" class="form-control required" name="garant_three_name">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_three_salutation_dependant non_company_field_div">
                            <div class="field form-group">
                                <label for="garant_three_vorname">
                                    <?php echo JText::_('COM_OFFER_FIRST_NAME'); ?> *
                                </label>
                                <input type="text" id="garant_three_vorname" class="form-control required" name="garant_three_vorname">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="field form-group">
                                <label for="garant_three_adresseinfo">
                                    <?php echo JText::_('COM_OFFER_ADDRESS'); ?> *
                                </label>
                                <input type="text" id="garant_three_adresseinfo" class="form-control required" name="garant_three_adresseinfo">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 collapse-right">
                                    <div class="field form-group">
                                        <label>
                                            <?php echo JText::_('COM_OFFER_ZIPCODE'); ?> *
                                        </label>
                                        <input type="tel" id="garant_three_plz" minlength="4" name="garant_three_plz" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 collapse-left">
                                    <div class="field form-group">
                                        <label>
                                            <?php echo JText::_('COM_OFFER_CITY'); ?> *
                                        </label>
                                        <input type="text" id="garant_three_ort" value="" size="20" name="garant_three_ort" class="form-control required">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Start of New garants fields-->
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 myregitabort1 garants_birthday_container garant_three_salutation_dependant non_company_field_div">
                            <div class="field form-group">
                                <label for="garant_three_geburtsdatum">
                                    <?php echo JText::_('COM_OFFER_DATE_OF_BIRTH'); ?> *
                                </label>
                                <input type="text" id="garant_three_geburtsdatum" class="birthdate-validate-18 form-control required" name="garant_three_geburtsdatum" placeholder="<?php echo JText::_('COM_OFFER_START_DATE_FORMAT_PLACEHOLDER'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group field nation-field-container float-label-select">
                                <label for="garant_two_nation">
                                    <?php echo JText::_('COM_OFFER_COUNTRY'); ?> *
                                </label>
                                <select name='garant_three_nation' class='godrop form-control required' id='garant_three_nation'></select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 birthday-error-msg garant_three_salutation_dependant non_company_field_div">
                            <?php
                                echo OfferHelper::birthDateRender($garants_birthday_warning_translation,'garant_three_geburtsdatum_message');
                                ?>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_three_nation_residant_permit hide">
                            <div class="form-group residence_card_questions field float-label-select garant_three_residence_card_questions">
                                <label for="garant_three_residence_card_questions"><?php echo JText::_('COM_OFFER_RESIDENCE_OPTION_QUESTION'); ?> *</label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_three_salutation_dependant non_company_field_div">
                            <div class="field form-group mobilefield">
                                <label for="garant_three_phone">
                                    <?php echo JText::_('COM_OFFER_MOBILE'); ?> *
                                </label>
                                <input type="tel" id="garant_three_phone" class="col-xs-10 col-sm-10 col-md-12 col-lg-12 form-control intlcode required" data-alt-class="garant-phone" name="garant_three_phone">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="garant_three_no_email-container">
                                <div class="field form-group mb-15 garant_three_email_field">
                                    <label for="garant_three_email">
                                        <?php echo JText::_('COM_OFFER_EMAIL'); ?> <span class="star_disable">*</span>
                                    </label>
                                    <div class="garant-email-field">
                                        <input type="text" id="garant_three_email" class="form-control required garant_email" name="garant_three_email">
                                        <span class="input-group-addon hide">
                                            <div class="control control--checkbox">
                                                <input type="checkbox" data-no-email-element="garant_three_" class="garant_three_no_emails no-email-checkbox" name="duplicate_garant_three_no_emails" value="1">
                                                <div class="control__indicator"></div><?php echo JText::_('COM_OFFER_NONE'); ?>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="checkbox-with-border garant_three_no-email-field garant_three_no_email_main mb-30">
                                <label class="mb-0 control control--checkbox">
                                <?php echo JText::_('COM_OFFER_NO_EMAIL'); ?>
                                <input type="checkbox" data-no-email-element="garant_three_" class="garant_three_no_emails no-email-checkbox" name="garant_three_no_emails" value="1"/>
                                <div class="control__indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-0 form-group btngroup-container display-flex align-center">
                            <label for="garant_three_open_debt" class="col-xs-7 col-xs-50 col-sm-12 col-md-8 col-lg-9 control-label btn-grp-label">
                            <?php echo JText::_('COM_OFFER_OPEN_DEBT'); ?> *
                            </label>
                            <div class="text-right col-xs-5 col-xs-50 col-sm-12 col-md-4 col-lg-3 debt-radio-btns" >
                                <div class="btn-group btn-radio-select" id="garant_three_open_debt" data-toggle="buttons">
                                    <label class="btn btn-default" for="garant_three_open_debt">
                                    <input type="radio" value="1" name="garant_three_open_debt" class="radio_toggle required">
                                    <?php echo JText::_('JYES'); ?>
                                    </label> 
                                    <label class="btn btn-default" for="garant_three_open_debt">
                                    <input type="radio" value="0" name="garant_three_open_debt"
                                        class="radio_toggle required">
                                    <?php echo JText::_('JNO'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of New garants fields-->
                </div>
                <!-- fourth garant-->
                <div id="garant_four_div" class="garant-individaul" style="display:none;">
                    <div class="row">
                        <div class="form-group mb-30">
                            <div class="text-left grp-top-title section-title m-y-3">
                                <legend class="a-legend a-legend-main sub-title"> <?php echo JText::_('COM_OFFER_ADDITIONAL_TENANTS_COMMON_TITLE'); ?>4</legend>
                            </div>
                        </div>
                        <div class="form-group btngroup-container">
                            <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6">
                                <div class="row display-flex align-center">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 no-padding-right">
                                        <label class="control-label" for="garant_four_salutation"><?php echo JText::_('COM_OFFER_SALUTATION'); ?> *</label>
                                    </div>
                                    <div class="text-right col-xs-9 col-sm-9 col-md-9 col-lg-9 collapse-left salutation-radio">
                                        <div class=" btn-group btn-radio-select salutation_btn_group" data-toggle="buttons">
                                            <label class="btn btn-default" for="garant_four_salutation">
                                            <?php echo JText::_('COM_OFFER_MR'); ?>
                                            <input class="radio_toggle required" type="radio" value="mr" name="garant_four_salutation"/>
                                            </label>
                                            <label class="btn btn-default " for="garant_four_salutation">
                                            <?php echo JText::_('COM_OFFER_MRS'); ?>
                                            <input class="radio_toggle required" type="radio" value="mrs" name="garant_four_salutation"/>
                                            </label>
                                            <label class="btn btn-default " for="garant_four_salutation">
                                            <?php echo JText::_('COM_OFFER_COMPANY'); ?>
                                            <input class="radio_toggle required" type="radio" value="company" name="garant_four_salutation"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="field form-group">
                                <label class="garant_four_name" for="garant_four_name">
                                    <?php echo JText::_('COM_OFFER_NAME'); ?> *
                                </label>
                                <input type="text" id="garant_four_name" class="form-control required" name="garant_four_name">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_four_salutation_dependant non_company_field_div">
                            <div class="field form-group">
                                <label for="garant_four_vorname">
                                    <?php echo JText::_('COM_OFFER_FIRST_NAME'); ?> *
                                </label>
                                <input type="text" id="garant_four_vorname" class="form-control required" name="garant_four_vorname">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="field form-group">
                                <label for="garant_four_adresseinfo">
                                    <?php echo JText::_('COM_OFFER_ADDRESS'); ?> *
                                </label>
                                <input type="text" id="garant_four_adresseinfo" class="form-control required" name="garant_four_adresseinfo">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 collapse-right">
                                    <div class="field form-group">
                                        <label>
                                            <?php echo JText::_('COM_OFFER_ZIPCODE'); ?> *
                                        </label>
                                        <input type="tel" id="garant_four_plz" minlength="4" name="garant_four_plz" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 collapse-left">
                                    <div class="field form-group">
                                        <label>
                                            <?php echo JText::_('COM_OFFER_CITY'); ?> *
                                        </label>
                                        <input type="text" id="garant_four_ort" value="" size="20" name="garant_four_ort" class="form-control required">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Start of New garants fields-->
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 myregitabort1 garants_birthday_container garant_four_salutation_dependant non_company_field_div">
                            <div class="field form-group">
                                <label for="garant_four_geburtsdatum">
                                    <?php echo JText::_('COM_OFFER_DATE_OF_BIRTH'); ?> *
                                </label>
                                <input type="text" id="garant_four_geburtsdatum" class="birthdate-validate-18 form-control required" name="garant_four_geburtsdatum" placeholder="<?php echo JText::_('COM_OFFER_START_DATE_FORMAT_PLACEHOLDER'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group field nation-field-container float-label-select">
                                <label for="garant_four_nation">
                                    <?php echo JText::_('COM_OFFER_COUNTRY'); ?> *
                                </label>
                                <select name='garant_four_nation' class='godrop form-control required' id='garant_four_nation'></select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 birthday-error-msg garant_four_salutation_dependant non_company_field_div">
                            <?php
                                echo OfferHelper::birthDateRender($garants_birthday_warning_translation,'garant_four_geburtsdatum_message');
                            ?>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_four_nation_residant_permit hide">
                            <div class="form-group field residence_card_questions float-label-select garant_four_residence_card_questions">
                                <label for="garant_four_residence_card_questions"><?php echo JText::_('COM_OFFER_RESIDENCE_OPTION_QUESTION'); ?> *</label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_four_salutation_dependant non_company_field_div">
                            <div class="field form-group mobilefield">
                                <label for="garant_four_phone">
                                    <?php echo JText::_('COM_OFFER_MOBILE'); ?> *
                                </label>
                                <input type="tel" id="garant_four_phone" class="col-xs-10 col-sm-10 col-md-12 col-lg-12 form-control intlcode required" data-alt-class="garant-phone" name="garant_four_phone">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="garant_four_no_email-container">
                                <div class="field form-group mb-15 garant_four_email_field">
                                    <label for="garant_four_email">
                                        <?php echo JText::_('COM_OFFER_EMAIL'); ?> <span class="star_disable">*</span>
                                    </label>
                                    <div class="garant-email-field">
                                        <input type="text" id="garant_four_email" class="form-control required garant_email" name="garant_four_email">
                                        <span class="input-group-addon hide">
                                            <div class="control control--checkbox">
                                                <input type="checkbox" data-no-email-element="garant_four_" class="garant_four_no_emails no-email-checkbox" name="duplicate_garant_four_no_emails" value="1">
                                                <div class="control__indicator"></div><?php echo JText::_('COM_OFFER_NONE'); ?>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="checkbox-with-border garant_four_no-email-field garant_four_no_email_main mb-30">
                                <label class="mb-0 control control--checkbox">
                                <?php echo JText::_('COM_OFFER_NO_EMAIL'); ?>
                                <input type="checkbox" data-no-email-element="garant_four_" class="garant_four_no_emails no-email-checkbox" name="garant_four_no_emails" value="1"/>
                                <div class="control__indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-0 form-group btngroup-container display-flex align-center">
                            <label for="garant_four_open_debt" class="col-xs-7 col-xs-50 col-sm-12 col-md-8 col-lg-9 control-label btn-grp-label">
                            <?php echo JText::_('COM_OFFER_OPEN_DEBT'); ?> *
                            </label>
                            <div class="text-right col-xs-5 col-xs-50 col-sm-12 col-md-4 col-lg-3 debt-radio-btns" >
                                <div class="btn-group btn-radio-select" id="garant_four_open_debt" data-toggle="buttons">
                                    <label class="btn btn-default" for="garant_four_open_debt">
                                    <input type="radio" value="1" name="garant_four_open_debt" class="radio_toggle required">
                                    <?php echo JText::_('JYES'); ?>
                                    </label> <label class="btn btn-default" for="garant_four_open_debt">
                                    <input type="radio" value="0" name="garant_four_open_debt"
                                        class="radio_toggle required">
                                    <?php echo JText::_('JNO'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of New garants fields-->
                </div>
                <!-- fifth garant-->
                <div id="garant_five_div" class="garant-individaul" style="display:none;">
                    <div class="row">
                        <div class="form-group mb-30">
                            <div class="text-left grp-top-title section-title m-y-3">
                                <legend class="a-legend a-legend-main sub-title"> <?php echo JText::_('COM_OFFER_ADDITIONAL_TENANTS_COMMON_TITLE'); ?>5</legend>
                            </div>
                        </div>
                        <div class="form-group btngroup-container">
                            <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6">
                                <div class="row display-flex align-center">
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 no-padding-right">
                                        <label class="control-label" for="garant_five_salutation"><?php echo JText::_('COM_OFFER_SALUTATION'); ?> *</label>
                                    </div>
                                    <div class="text-right col-xs-9 col-sm-9 col-md-9 col-lg-9 collapse-left salutation-radio">
                                        <div class=" btn-group btn-radio-select salutation_btn_group" data-toggle="buttons">
                                            <label class="btn btn-default" for="garant_five_salutation">
                                            <?php echo JText::_('COM_OFFER_MR'); ?>
                                            <input class="radio_toggle required" type="radio" value="mr" name="garant_five_salutation"/>
                                            </label>
                                            <label class="btn btn-default " for="garant_five_salutation">
                                            <?php echo JText::_('COM_OFFER_MRS'); ?>
                                            <input class="radio_toggle required" type="radio" value="mrs" name="garant_five_salutation"/>
                                            </label>
                                            <label class="btn btn-default " for="garant_five_salutation">
                                            <?php echo JText::_('COM_OFFER_COMPANY'); ?>
                                            <input class="radio_toggle required" type="radio" value="company" name="garant_five_salutation"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="field form-group">
                                <label class="garant_five_name" for="garant_five_name">
                                    <?php echo JText::_('COM_OFFER_NAME'); ?> *
                                </label>
                                <input type="text" id="garant_five_name" class="form-control required" name="garant_five_name">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_five_salutation_dependant non_company_field_div">
                            <div class="field form-group">
                                <label for="garant_five_vorname">
                                    <?php echo JText::_('COM_OFFER_FIRST_NAME'); ?> *
                                </label>
                                <input type="text" id="garant_five_vorname" class="form-control required" name="garant_five_vorname">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="field form-group">
                                <label for="garant_five_adresseinfo">
                                    <?php echo JText::_('COM_OFFER_ADDRESS'); ?> *
                                </label>
                                <input type="text" id="garant_five_adresseinfo" class="form-control required" name="garant_five_adresseinfo">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 collapse-right">
                                    <div class="field form-group">
                                        <label>
                                            <?php echo JText::_('COM_OFFER_ZIPCODE'); ?> *
                                        </label>
                                        <input type="tel" id="garant_five_plz" minlength="4" name="garant_five_plz" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 collapse-left">
                                    <div class="field form-group">
                                        <label>
                                            <?php echo JText::_('COM_OFFER_CITY'); ?> *
                                        </label>
                                        <input type="text" id="garant_five_ort" value="" size="20" name="garant_five_ort" class="form-control required">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Start of New garants fields-->
                    <div class="row">
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 myregitabort1 garants_birthday_container garant_five_salutation_dependant non_company_field_div">
                            <div class="field form-group">
                                <label for="garant_five_geburtsdatum">
                                    <?php echo JText::_('COM_OFFER_DATE_OF_BIRTH'); ?> *
                                </label>
                                <input type="text" id="garant_five_geburtsdatum" class="birthdate-validate-18 form-control required" name="garant_five_geburtsdatum" placeholder="<?php echo JText::_('COM_OFFER_START_DATE_FORMAT_PLACEHOLDER'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group field nation-field-container float-label-select">
                                <label for="garant_five_nation">
                                    <?php echo JText::_('COM_OFFER_COUNTRY'); ?> *
                                </label>
                                <select name='garant_five_nation' class='godrop form-control required' id='garant_five_nation'></select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 birthday-error-msg garant_five_salutation_dependant non_company_field_div">
                            <?php
                                echo OfferHelper::birthDateRender($garants_birthday_warning_translation,'garant_five_geburtsdatum_message');
                            ?>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_five_nation_residant_permit hide">
                            <div class="form-group field residence_card_questions float-label-select garant_five_residence_card_questions">
                                <label for="garant_five_residence_card_questions"><?php echo JText::_('COM_OFFER_RESIDENCE_OPTION_QUESTION'); ?> *</label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6 garant_five_salutation_dependant non_company_field_div">
                            <div class="field form-group mobilefield">
                                <label for="garant_five_phone">
                                    <?php echo JText::_('COM_OFFER_MOBILE'); ?> *
                                </label>
                                <input type="tel" id="garant_five_phone" class="col-xs-10 col-sm-10 col-md-12 col-lg-12 form-control intlcode required" data-alt-class="garant-phone" name="garant_five_phone">
                            </div>
                        </div>
                        <div class="col-xs-12 col-xs-50 col-sm-6 col-md-6 col-lg-6">
                            <div class="garant_five_no_email-container">
                                <div class="field form-group mb-15 garant_five_email_field">
                                    <label for="garant_five_email">
                                        <?php echo JText::_('COM_OFFER_EMAIL'); ?> <span class="star_disable">*</span>
                                    </label>
                                    <div class="garant-email-field">
                                        <input type="text" id="garant_five_email" class="form-control required garant_email" name="garant_five_email">
                                        <span class="input-group-addon hide">
                                            <div class="control control--checkbox">
                                                <input type="checkbox" data-no-email-element="garant_five_" class="garant_five_no_emails no-email-checkbox" name="duplicate_garant_five_no_emails" value="1">
                                                <div class="control__indicator"></div><?php echo JText::_('COM_OFFER_NONE'); ?>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="checkbox-with-border garant_five_no-email-field garant_five_no_email_main mb-30">
                                <label class="mb-0 control control--checkbox">
                                <?php echo JText::_('COM_OFFER_NO_EMAIL'); ?>
                                <input type="checkbox" data-no-email-element="garant_five_" class="garant_five_no_emails no-email-checkbox" name="garant_five_no_emails" value="1"/>
                                <div class="control__indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-0 form-group btngroup-container display-flex align-center">
                            <label for="garant_five_open_debt" class="col-xs-7 col-xs-50 col-sm-12 col-md-8 col-lg-9 control-label btn-grp-label">
                            <?php echo JText::_('COM_OFFER_OPEN_DEBT'); ?> *
                            </label>
                            <div class="text-right col-xs-5 col-xs-50 col-sm-12 col-md-4 col-lg-3 debt-radio-btns" >
                                <div class="btn-group btn-radio-select" id="garant_five_open_debt" data-toggle="buttons">
                                    <label class="btn btn-default" for="garant_five_open_debt">
                                    <input type="radio" value="1" name="garant_five_open_debt" class="radio_toggle required">
                                    <?php echo JText::_('JYES'); ?>
                                    </label> <label class="btn btn-default" for="garant_five_open_debt">
                                    <input type="radio" value="0" name="garant_five_open_debt"
                                        class="radio_toggle required">
                                    <?php echo JText::_('JNO'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of New garants fields-->
                </div>
            </form>
        </div>

        <hr class="mt-10 section-hr-seprator">
        <div class="deposite_amount_block hide">
            <form name="form_deposite_amount" id="form_deposite_amount">
                <div class="private-calculator" id="calcmodule">
                    <div id="contentdiv">
                        <div id="contentmainfield">
                            <div class="form-group calc_content" id="input_field">
                                <span class="label-text"><?php echo JText::_('COM_OFFER_DEPOSIT_AMOUNT_LABEL'); ?></span>
                                <div id="text-field">
                                    <p class="calc-chf">CHF</p>
                                    <input type="tel" name="searchstring" value="" class="required form-control validate-numeric" maxlength="10" id="searchstring" />
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <?php //if($this->base_id){ ?>
                        <!-- <input type="hidden" name="offer_per" data-offer-per="" value="<?php //echo $this->base_id;?>" /> -->
                        <?php //}?>

                        <div style="clear: both;"></div>
                        <div class="amnt-results hide">
                            <div class="for-private-contact">
                                <span><?php echo JText::_('COM_OFFER_PREMIUM'); ?></span>
                                <span id="results"></span>
                                <?php echo JText::_('COM_OFFER_CALCULATOR_PER_YEAR_LABEL') ?>
                            </div>
                        </div>
                        <div class="error-display" style="display: none;"></div>
                    </div>
                    <!--rightdiv-->
                    <div style="clear: both;"></div>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="overlay-drawer">&nbsp;</div>
<!-- Drawer Code -->