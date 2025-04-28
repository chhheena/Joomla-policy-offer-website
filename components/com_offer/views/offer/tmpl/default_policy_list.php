<?php
//no direct access
defined('_JEXEC') or die('Restricted access.');
use Joomla\CMS\Uri\Uri as JUri;
use Joomla\CMS\Language\Text as JText;
use Joomla\CMS\Factory as JFactory;
?>
<div class="policy-detail-block">
    <div class="row header-block">
        <div class="col-sm-8">
            <div class="policy-title">
            {{#isGreaterThanZero parent_policy_id}}<span><?php echo JText::_("COM_OFFER_CHILD_POLICY_NUMBER"); ?></span> {{policy_num}} <span class="pipe-separator">|</span> {{/isGreaterThanZero}}</span><span><?php echo JText::_("COM_OFFER_RENTAL_PROPERTY_LABEL"); ?></span> {{quote_appartment_adress}}, {{quote_prop_plz}} {{quote_prop_ort}}
            </div>
            <div class="deposit-amount"> <span><?php echo JText::_("COM_OFFER_DEPOSIT"); ?>:</span> CHF {{deposit_amount}} {{#ifEquals parent_policy_id 0}}<i class="fa fa-pencil edit-deposit-amount"></i>{{/ifEquals}} {{#isGreaterThanZero parent_policy_id}}<span class="pipe-separator">| </span><span><?php echo JText::_("COM_OFFER_CHILD_POLICY_START_DATE"); ?>:</span> {{invoice_startdate}}{{/isGreaterThanZero}}
            </div>
        </div>
        <div class="col-sm-4 display-flex justify-content-end align-items-center">
            <?php if(JFactory::getApplication()->getLanguage()->getTag() !='en-GB') { ?>
                    <div class="download-btn-box">
                        <span class="spinner_loader_on_offer_pdf" style="display: none;">
                            <i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;
                        </span>
                        <a id="download-pdf-button" href="javascript:void(0)">
                            <div class="icon-download">
                                <img src="images/icon-download.svg" alt="icon-download">
                            </div>
                        </a>
                    </div>
            <?php } ?>
            <div class="annual-premium-block">
                <?php echo JText::_("COM_OFFER_ANNUAL_PREMIUM"); ?> <span>CHF {{formatted_total}}</span>
            </div>
        </div>
    </div>
    <div class="policy-listing-content">
        <div class="row top-row-listing">
            {{#if organization_name}}
            <div class="col-sm-4 org_main_div">
                <?php echo JText::_("COM_OFFER_ADMINISTRATION"); ?> {{#ifEquals parent_policy_id 0}}<i class="fa fa-pencil edit-policy-organization"></i>{{/ifEquals}}<br>
                <div id="org_info_{{policy_id}}">
                    <span>
                        <b>
                            <span class="org_name_{{policy_id}}">{{organization_name}}</span><br>
                            <span class="org_address_{{policy_id}}">{{org_address}}</span><br><span class="org_plz_{{policy_id}}">{{org_zipcode}}</span> <span class="org_ort_{{policy_id}}">{{org_city}}</span>
                        </b>
                    </span>
                </div>
            </div>
            {{/if}}
            {{#if houseowner_name}}
            <div class="col-sm-4 ho_main_div">
                <?php echo JText::_("COM_OFFER_OWNER"); ?> {{#ifEquals parent_policy_id 0}}<i class="fa fa-pencil edit-policy-houseowner"></i>{{/ifEquals}}<br>
                <div id="ho_info_{{policy_id}}">
                    <span>
                        <b>
                            <span class="house_owner_name_{{policy_id}}">{{houseowner_name}}</span><br>
                            <span class="house_owner_address_{{policy_id}}">{{houseowner_address}}</span> <br>
                            <span class="house_owner_plz_{{policy_id}}">{{houseowner_zipcode}}</span> <span class="house_owner_city_{{policy_id}}">{{houseowner_city}}</span>
                        </b>
                    </span>
                </div>
            </div>
            {{/if}}

            {{#if pvt_name}}
            <div class="col-sm-4 pl_main_div">
                <?php echo JText::_("COM_OFFER_PRIVATE_LANDLORD"); ?> {{#ifEquals parent_policy_id 0}}<i class="fa fa-pencil edit-policy-privatelandlord"></i>{{/ifEquals}}<br>
                <div id="pl_info_{{policy_id}}">
                    <span>
                        <b>
                            <span class="privatelandlord_name_{{policy_id}}">{{pl_name}}</span> <span class="privatelandlord_firstname_{{policy_id}}">{{pl_first_name}}</span> <br>
                            <span class="privatelandlord_address_{{policy_id}}">{{pvt_address}}</span><br>
                            <span class="privatelandlord_plz_{{policy_id}}">{{pvt_zipcode}}</span> <span class="privatelandlord_ort_{{policy_id}}">{{pvt_city}}</span>
                        </b>
                    </span>
                </div>
            </div>
            {{/if}}

            <div class="col-sm-4 garants_main_div">
                <?php echo JText::_("COM_OFFER_TENANTS"); ?> {{#ifEquals parent_policy_id 0}}<i class="fa fa-pencil edit-policy-garants"></i>{{/ifEquals}}
                <div id="garants_list_{{policy_id}}">
                    <span><b></b></span>
                </div>
            </div>

        </div>
    </div>
</div>