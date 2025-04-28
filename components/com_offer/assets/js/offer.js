jQuery(document).ready(function () {
  const startDateInput = jQuery("input[name='policy_start_date']");
  const dateError = jQuery(".date_format_error");
  let noResultFound = Joomla.JText._("JGLOBAL_SELECT_NO_RESULTS_MATCH");
  const noData = Joomla.JText._("COM_OFFER_NO_DATA");
  let organizationLabel = Joomla.JText._("COM_OFFER_ADMINISTRATION");
  let houseOwnerLabel = Joomla.JText._("COM_OFFER_OWNER");
  let privatelandlordLabel = Joomla.JText._("COM_OFFER_PRIVATE_LANDLORD");
  let validBirthdayMsg = Joomla.JText._("COM_OFFER_VLD_BIRTHDAY_FORMAT_MESSAGE");
  let validEmailMsg = Joomla.JText._("COM_OFFER_VLD_EMAIL_FORMAT_MESSAGE");
  let name = Joomla.JText._("COM_OFFER_NAME");
  let firstName = Joomla.JText._("COM_OFFER_FIRST_NAME");
  let companyName = Joomla.JText._("COM_OFFER_COMPANY_NAME");
  let plCompanyName = Joomla.JText._("COM_OFFER_PRIVATELANDLORD_PL_COMPANY_CPNAME");
  let plFamilyName = Joomla.JText._("COM_OFFER_PRIVATELANDLORD_FAMILY_NAME");
  let plFamilyFirstName = Joomla.JText._("COM_OFFER_PRIVATELANDLORD_FAMILY_FIRSTNAME");

  let datePickerToday = new Date();
  let lowestStartDate = new Date();
  lowestStartDate.setDate(datePickerToday.getDate() + 10); // Set start date today + 10 days

  jQuery("#start_datepicker")
    .datepicker({
      format: "dd.mm.yyyy",
      autoclose: true,
      language: WEBSITE_LANGUAGE,
      startDate: lowestStartDate,
    })
    .on("changeDate", function (e) {
      let value = e.format();
      if (value) {
        dateError.hide();
        startDateInput.parent().removeClass("has_error");
      }
    })
    .on("clearDate", function (e) {
      dateError.show();
      startDateInput.parent().addClass("has_error");
    });

  Handlebars.registerHelper("ifEquals", function (arg1, arg2, options) {
    return arg1 == arg2 ? options.fn(this) : options.inverse(this);
  });
  Handlebars.registerHelper("isGreaterThanZero", function (value, options) {
    return parseInt(value) > 0 ? options.fn(this) : options.inverse(this);
  });

  // Intelligent country dropdown for mobile and telefon
  jQuery(".intlcode").intlTelInput({
    allowExtensions: false,
    autoFormat: true,
    autoHideDialCode: true,
    autoPlaceholder: true,
    nationalMode: false,
    preferredCountries: ["ch"],
    separateDialCode: false,
    initialCountry: "ch",
  });

  jQuery(".intlcode").bind("input", function () {
    jQuery(this).val(function (_, v) {
      //return v.replace(/\s+/g, '');
      return v.replace(/[^0-9\+]/g, "");
    });
  });

  function removeQueryStringParameter() {
    if (window.location.search !== "") {
      var urlWithoutQueryString = window.location.href.split("?")[0];
      window.history.replaceState({}, document.title, urlWithoutQueryString);
    }
  }

  if (offerToken) {
    pageLoaderHead(1);
    jQuery(".code-box").addClass("hide");
    jQuery.ajax({
      url: getURL('offer.checkCodeTokenValidation'),
      data: {
        code: offerToken,
        validation_type: "token",
      },
      type: "POST",
      success: function (result) {
        result = JSON.parse(result);
        if (result) {
          getCustomerInfo();
          removeQueryStringParameter();
        } else {
          window.location.href = WEBSITE_URL;
        }
      },
    });
  }

  jQuery(document).on("click", 'input[name="receipt-address"]', function (e) {
    jQuery(".contact-co-address").toggleClass("hide");
  });
  function commonPolicyData() {
    let co_address_option_checked = jQuery("#receipt-address").is(":checked");
    var policyData = {
      email: jQuery("input[name=email]").val(),
      mobile: jQuery("input[name='mobile']").val(),
      telephone: jQuery('input[name="telefon"]').val(),
      contact_address_address: jQuery('input[name="contact_address_address"]').val(),
      policy_start_date: jQuery('input[name="policy_start_date"]').val(),
      contact_address_plz: jQuery('input[name="contact_address_plz"]').val(),
      contact_address_ort: jQuery('input[name="contact_address_ort"]').val(),
    };
    if (co_address_option_checked) {
      policyData.contact_address_co_name = jQuery('input[name="contact_address_co_name"]').val();
      policyData.contact_address_co_address = jQuery('input[name="contact_address_co_address"]').val();
      policyData.contact_address_co_plz = jQuery('input[name="contact_address_co_plz"]').val();
      policyData.contact_address_co_ort = jQuery('input[name="contact_address_co_ort"]').val();
    }
    return policyData;
  }

  jQuery(document).on("click", "#download-pdf-button", function (e) {
    let spinnerLoader = jQuery(".spinner_loader_on_offer_pdf");
    let downloadPdfButton = jQuery("#download-pdf-button");
    spinnerLoader.css("display", "initial");
    downloadPdfButton.hide();
    var policyData = commonPolicyData();
    jQuery.ajax({
      url: getURL('offer.getPolicyOfferPdf'),
      data: policyData,
      type: "POST",
      success: function (result) {
        if (result) {
          spinnerLoader.hide();
          downloadPdfButton.show();
          window.location.href = getURL('offer.downloadOfferParterPdf');
        }
      },
    });
  });

  jQuery(document).on("click", "#download-qr-invoice-pdf", function (e) {
    e.preventDefault();
    let downloadQrInvoicePdf = jQuery("#download-qr-invoice-pdf");
    let spinnerLoader = downloadQrInvoicePdf.find(".spinner_loader_on_qr_button");
    let downloadImage = downloadQrInvoicePdf.find("img");

    spinnerLoader.css("display", "initial");
    downloadImage.hide();
    downloadQrInvoicePdf.attr("disabled", "disabled");

    let qrData = {
      qr_invoice_id: jQuery("input[name='qr_invoice_id']").val(),
      qr_policy_id: jQuery('input[name="qr_policy_id"]').val(),
    };
    jQuery.ajax({
      url: getURL('offer.getPolicyOfferQrInvoicePdf'),
      data: qrData,
      type: "POST",
      success: function (result) {
        if (result) {
          spinnerLoader.hide();
          downloadImage.show();
          downloadQrInvoicePdf.removeAttr("disabled");
          window.location.href = getURL('offer.downloadQrInvoicePdf');
        }
      },
    });
  });
  if (!offerToken) {
    getCustomerInfo();
  }

  let termCheckInput = jQuery('input[name="term_check"]');
  termCheckInput.on("change", function () {
    if (termCheckInput.is(":checked")) {
      termCheckInput.parent().removeClass("has_error");
    }
  });

  // get drawer data to sent in save policy
  function drawerPolicyData() {
    var drawerPolicyData = {};
    var formPolicyOrgPlData = jQuery("#form_policy_org_pl").serialize();
    if (formPolicyOrgPlData) {
      drawerPolicyData.formPolicyOrgPlData = formPolicyOrgPlData;
    }

    var formData = jQuery("#form_policy_garant").serialize();
    if (formData) {
      drawerPolicyData.garantsData = formData;
    }
    return drawerPolicyData;
  }

  function checkValidationOnSubmit() {

    var contactEmailEdit = jQuery('input[name="contactEmailEdit"]').val();
    if (contactEmailEdit > 0) {
      var contactEmail = jQuery('input[name="email"]').val();
      if (!validateEmail(contactEmail)) {
        jQuery(".general-error-message").show();
        return false;
      }
    }
    return true;
  }

  //Save policy offer data
  jQuery(".form-submit-button").click(function (e) {
    e.preventDefault();
    let termCheckInput = jQuery('input[name="term_check"]');
    let generalErrorDiv = jQuery(".general-error-message");
    let dateRegex = /^\d{2}\.\d{2}\.\d{4}$/;
    let startDateValue = startDateInput.val();
    if (!startDateValue || !dateRegex.test(startDateValue) || !termCheckInput.is(":checked")) {
      generalErrorDiv.show();
      if (!startDateValue) {
        startDateInput.parent().addClass("has_error");
      }
      if (!termCheckInput.is(":checked")) {
        termCheckInput.parent().addClass("has_error");
      }
      return;
    }

    var selectedLessorType = jQuery('input[name="selectedLessorType"]').val();
    if (!checkValidationOnSubmit()) {
      return;
    }

    generalErrorDiv.hide();

    jQuery(".date_format_error").hide();
    jQuery(".form-submit-button .spinner_loader_on_submit").css("display", "initial");
    jQuery(".form-submit-button span img").hide();
    jQuery(".form-submit-button").attr("disabled", "disabled");
    var depositAmount = jQuery('input[name="policy_deposit_amount"]').val();
    var cleanDepositAmount = cleanDigit(depositAmount);
    var computedTotal = jQuery('input[name="policy_computed_total"]').val();
    var cleanComputedTotal = cleanDigit(computedTotal);
    var files = [];
    jQuery('input[name="file_rental_agreement[]"]').each(function () {
      files.push($(this).val());
    });
    var policyData = commonPolicyData();
    var drawerData = drawerPolicyData();
    if (Object.keys(drawerData).length !== 0) {
      policyData.drawerData = JSON.stringify(drawerData);
    }
    if (files.length) {
      policyData.files = JSON.stringify(files);
    }
    policyData.policy_admin_message = jQuery("#policy_admin_message").val();
    policyData.contact_iban = jQuery('input[name="iban_number"]').val();
    policyData.policy_deposit_amount = cleanDepositAmount.toFixed(2);
    policyData.policy_computed_total = cleanComputedTotal.toFixed(2);
    policyData.policy_contact_type = jQuery('input[name="policy_contact_type"]').val();
    policyData.selected_lessor_type = selectedLessorType;
    policyData.premium_percentage = jQuery('input[name="premium_percentage"]').val();;
    jQuery.ajax({
      url: getURL('offer.savePolicyOfferData'),
      data: policyData,
      type: "POST",
      success: function (result) {
        result = JSON.parse(result);
        if (result.payment && result.payment.policy_id > 0 && result.payment.invoice_id > 0) {
          populatePaymentSection(result.payment);
          jQuery(".thanks-message-box").removeClass("hide");
          jQuery(".rental-guarantee-header, .policy_overview_text, .policy-detail-section, .top-notification-container, .offer-change-block").remove();

          jQuery("html, body").animate(
            {
              scrollTop: 300,
            },
            "slow"
          );
          return false;
        }
      },
    });
  });
  jQuery("input[name=offer_code_box]").on("input", function () {
    if (jQuery(this).val().trim()) {
      jQuery(this).parent().removeClass("has_error");
    }
  });
  jQuery(".request-code-submit-btn").click(function (e) {
    e.preventDefault();
    let codeInvalidText = jQuery(".code_validation_container");
    let offerCodeBoxHead = jQuery("input[name=offer_code_box]");
    codeInvalidText.addClass("hide");
    if (offerCodeBoxHead.val().trim() === "") {
      offerCodeBoxHead.parent().addClass("has_error");
      return;
    }
    offerCodeBoxHead.parent().removeClass("has_error");
    let code = jQuery("#offer_code_box").val();
    let spinnerLoaderHead = jQuery(".spinner_loader_discount");
    let rightArrowIconHead = jQuery(".right-arrow-icon");
    let codeInputSubmitBtnHead = jQuery(".request-code-submit-btn button, input[name=offer_code_box]");
    rightArrowIconHead.hide();
    spinnerLoaderHead.show();
    codeInputSubmitBtnHead.prop("disabled", true);
    if (code) {
      jQuery.ajax({
        url: getURL('offer.checkCodeTokenValidation'),
        data: {
          code: code,
          validation_type: "code",
        },
        type: "POST",
        success: function (result) {
          codeInputSubmitBtnHead.prop("disabled", false);

          result = JSON.parse(result);
          if (result) {
            getCustomerInfo();
          } else {
            codeInvalidText.removeClass("hide");
            spinnerLoaderHead.hide();
            rightArrowIconHead.show();
          }
        },
      });
    }
  });

  jQuery("input[name='email']").on("change input", function () {
    var oldCustomerEmail = jQuery("#customer_old_email_exist").val();
    var emailVal = jQuery(this).val();
    setEmailPostText(emailVal || oldCustomerEmail);
   });
  jQuery("footer").addClass("policy-footer");
  loadFooterLogo("white");

  //Close drawer
  jQuery('.close-drawer a, .overlay-drawer, .close-btn').on('click', function () {
    jQuery('.edit-policy-drawer').removeClass('open');
    jQuery('.overlay-drawer').removeClass('open');
    jQuery('body').removeClass('modal-open');
  });

  var garantTotalNumbers = ["one", "two", "three", "four", "five"];

  //SET drawer hidden value and changes reflect in policy information
  jQuery(document).on('click', '#saveButton_modal', function() {
    let drawerBtnValue = jQuery(this).val();
    if (policyID) {
      pageLoaderHead(1);
      var garantTotal = jQuery("[name='garant_total']:checked").val();
      var garantTotalMain = "";
      var garantString = "";
      var organization_name = "";
      var org_address = "";
      var org_zipcode = "";
      var org_city = "";
      var houseowner_name = "";
      var houseowner_address = "";
      var houseowner_zipcode = "";
      var houseowner_city = "";
      var lessorType = "";
      var pl_name = "";
      var pl_first_name = "";
      var pvt_address = "";
      var pvt_zipcode = "";
      var pvt_city = "";

      jQuery('.edit-policy-drawer :input').each(function(){
        var currentElementName = jQuery(this).attr('name');
        var currentElementValue = jQuery(this).val();

        if (currentElementName == "lessor_type") {
          lessorType = jQuery('input[name="'+currentElementName+'"]:checked').val();
        }

          if (currentElementName && currentElementName.indexOf('org_') === 0) {
            if (currentElementName == "org_name") {

              organization_name = currentElementValue;
            } else if (currentElementName == "org_address") {

              org_address = currentElementValue;
            } else if (currentElementName == "org_plz") {

              org_zipcode = currentElementValue;
            } else if (currentElementName == "org_ort") {

              org_city = currentElementValue;
            }
          }

        if (currentElementName && currentElementName.indexOf('house_owner_') === 0) {
          if (currentElementName == "house_owner_name") {

            houseowner_name = currentElementValue;
          } else if (currentElementName == "house_owner_address") {

            houseowner_address = currentElementValue;
          } else if (currentElementName == "house_owner_plz") {

            houseowner_zipcode = currentElementValue;
          } else if (currentElementName == "house_owner_city") {

            houseowner_city = currentElementValue;
          }
        }

        if (currentElementName && currentElementName.indexOf('privatelandlord_') === 0) {
          if (currentElementName == "privatelandlord_name") {

            pl_name = currentElementValue;
          } else if (currentElementName == "privatelandlord_firstname") {

            pl_first_name = currentElementValue;
          } else if (currentElementName == "privatelandlord_address") {

            pvt_address = currentElementValue;
          } else if (currentElementName == "privatelandlord_plz") {

            pvt_zipcode = currentElementValue;
          } else if (currentElementName == "privatelandlord_ort") {

            pvt_city = currentElementValue;
          }
        }

        if (currentElementName == "garant_total_main") {
          garantTotalMain = jQuery('input[name="'+currentElementName+'"]:checked').val();
        }
        if (currentElementName == "garant_total") {
          garantTotal = jQuery('input[name="'+currentElementName+'"]:checked').val();
        }
        if (currentElementName && currentElementName.indexOf('garant_') === 0 && garantTotal) {
            for (var i = 0; i < garantTotal; i++) {
              var garantName = "";
              var garantVorname = "";
              var garantBirthdate = "";
              if (currentElementName.indexOf("garant_" + garantTotalNumbers[i] + "_") === 0 && !jQuery(this).is(":disabled")) {
                if (currentElementName.indexOf("garant_" + garantTotalNumbers[i] + "_name") === 0 && currentElementValue) {

                  garantName = "<span class=" + currentElementName + "_" + policyID + ">" + currentElementValue + "</span>";
                } else if (currentElementName.indexOf("garant_" + garantTotalNumbers[i] + "_vorname") === 0 && currentElementValue) {

                  var isBirthday =jQuery("#garant_" + garantTotalNumbers[i] + "_geburtsdatum").val();
                  var commaSeparator = isBirthday ? ", " : "";
                  var brTag = isBirthday ? "" : "<br>";
                  garantVorname = "<span class=" + currentElementName + "_" + policyID + ">" + currentElementValue + commaSeparator + "</span>" + brTag;
                } else if (currentElementName.indexOf("garant_" + garantTotalNumbers[i] + "_geburtsdatum") === 0 && currentElementValue) {

                  garantBirthdate = currentElementValue ? "<span class=" + currentElementName + "_" + policyID + ">" + currentElementValue + "</span><br>" : "";
                }

                garantString += garantName + " " + garantVorname + garantBirthdate;
              }
            }
        }

      });

      if (drawerBtnValue == 'garants') {
        if (garantTotalMain > 0 && garantTotal > 0) {
          var garantsFieldValid = checkGarantRequiredFields(garantTotal, garantTotalNumbers);
          if (!garantsFieldValid) {
            pageLoaderHead(0);
            return;
          }
        } else {
          showHideDrawerErrroMsg(true);
        }
      }

      if (drawerBtnValue == 'deposit') {
        if(!jQuery('input[name="searchstring"]').val().trim()){
          showHideDrawerErrroMsg(false);
          pageLoaderHead(0);
          return;
        } else {
          var calculatedPolicy_depositAmount = jQuery('input[name="calculated_policy_deposit_amount"]').val();
          var calculatedPolicy_computedTotal = jQuery('input[name="calculated_policy_computed_total"]').val();
          jQuery('input[name="policy_deposit_amount"]').val(calculatedPolicy_depositAmount);
          jQuery('input[name="policy_computed_total"]').val(calculatedPolicy_computedTotal);
          showHideDrawerErrroMsg(true);
        }
      }

      if (garantString.trim().length) {
        jQuery("#garants_list_" + policyID).prev('div.no_garant_data').remove();
        jQuery("#garants_list_" + policyID + " span b").empty().append(garantString);
      } else {
        jQuery("#garants_list_" + policyID + " span b").empty();
        jQuery("#garants_list_" + policyID).prev('div.no_garant_data').remove();
        jQuery("#garants_list_" + policyID).before("<div class='no_garant_data'><b>" + noData + "</b></div>");
      }

      var commonTemplate = Handlebars.compile('<div class="col-sm-4 {{main_div_class}}">{{label}} <i class="fa fa-pencil edit-policy-{{edit_class}}"></i><br><div id="{{info_id_prefix}}{{policy_id}}"><span><b><span class="{{name_class}}">{{name}}</span>{{#if first_name}} <span class="{{first_name_class}}">{{first_name}}</span>{{/if}}<br><span class="{{address_class}}">{{address}}</span><br><span class="{{zipcode_class}}">{{zipcode}}</span> <span class="{{city_class}}">{{city}}</span></b></span></div></div>');

      if (lessorType == "organization" && drawerBtnValue == 'organization') {
        var isRequiredFilled = checkRequiredFields(".lessor_type_organization_block");
        if (!isRequiredFilled) {
          pageLoaderHead(0);
          return;
        } else {
          var context = {
            parent_policy_id: 0,
            policy_id: policyID,
            name: organization_name,
            address: org_address,
            zipcode: org_zipcode,
            city: org_city,
            main_div_class: 'org_main_div',
            label: organizationLabel,
            edit_class: 'organization',
            info_id_prefix: 'org_info_',
            name_class: 'org_name',
            address_class: 'org_address',
            zipcode_class: 'org_plz',
            city_class: 'org_ort'
          };
          var html = commonTemplate(context);
          jQuery(".policy-listing-content .org_main_div").remove();
          jQuery(".policy-listing-content .garants_main_div").before(html);
          jQuery(".policy-listing-content .pl_main_div").addClass("hide");
          jQuery('input[name="selectedLessorType"]').val('organization');
        }

        var context = {
          parent_policy_id: 0,
          policy_id: policyID,
          name: houseowner_name,
          address: houseowner_address,
          zipcode: houseowner_zipcode,
          city: houseowner_city,
          main_div_class: 'ho_main_div',
          label: houseOwnerLabel,
          edit_class: 'houseowner',
          info_id_prefix: 'ho_info_',
          name_class: 'house_owner_name',
          address_class: 'house_owner_address',
          zipcode_class: 'house_owner_plz',
          city_class: 'house_owner_city'
        };
        var html = commonTemplate(context);
        jQuery(".policy-listing-content .ho_main_div").remove();
        jQuery(".policy-listing-content .garants_main_div").before(html);

        if (houseowner_name.trim().length) {
          jQuery("#ho_info_" + policyID).prev('div.no_ho_data').remove();
        } else {
          jQuery("#ho_info_" + policyID + " span b").empty();
          jQuery("#ho_info_" + policyID).before("<div class='no_ho_data'><b>" + noData + "</b></div>");
        }
      }

      if (lessorType == "private_landlord" && drawerBtnValue == 'privatelandlord') {
        var isRequiredFilled = checkRequiredFields(".lessor_type_private_block");
        if (!isRequiredFilled) {
          pageLoaderHead(0);
          return;
        } else {
          var context = {
            parent_policy_id: 0,
            policy_id: policyID,
            name: pl_name,
            first_name: pl_first_name,
            address: pvt_address,
            zipcode: pvt_zipcode,
            city: pvt_city,
            main_div_class: 'pl_main_div',
            label: privatelandlordLabel,
            edit_class: 'privatelandlord',
            info_id_prefix: 'pl_info_',
            name_class: 'privatelandlord_name',
            first_name_class: 'privatelandlord_firstname',
            address_class: 'privatelandlord_address',
            zipcode_class: 'privatelandlord_plz',
            city_class: 'privatelandlord_ort'
          };
          var html = commonTemplate(context);
          jQuery(".policy-listing-content .pl_main_div").remove();
          jQuery(".policy-listing-content .garants_main_div").before(html);
          jQuery(".policy-listing-content .org_main_div, .policy-listing-content .ho_main_div").addClass("hide");
          jQuery('input[name="selectedLessorType"]').val('privatelandlord');
        }
      }

      var policy_depositAmount = jQuery('input[name="policy_deposit_amount"]').val();
      var policy_computedTotal = jQuery('input[name="policy_computed_total"]').val();
      var formattedDepositAmount = formatAmountWithSeparator(policy_depositAmount);
      var formattedComputedTotal = formatAmountWithSeparator(policy_computedTotal);
      jQuery(".deposit-amount").contents().filter(function() {
        return this.nodeType === 3;
      }).get(1).replaceWith(" CHF " + formattedDepositAmount +  " ");
      jQuery(".annual-premium-block span").text("CHF " + formattedComputedTotal);
      pageLoaderHead(0);
    }
  });

  //Garants js
  function garant_total_one_changes(){
    jQuery("#garant_one_div").find(":input").removeAttr('disabled');
    jQuery("#garant_two_div, #garant_three_div, #garant_four_div, #garant_five_div").find(":input").attr('disabled','disabled');
  }

  jQuery(document).on('change', '.com_offer input[name="garant_total_main"]', function (event) {
    var val = jQuery(this).val();

    if (val == 1) {
        jQuery('input[type=radio][name=garant_total][value=1]').prop('checked', true).trigger('change');
        jQuery('#garant_one_div').show();
        jQuery('.grant_one_radio').trigger("change");
        jQuery('.grant_one').addClass("btn-success active");
        jQuery('#garant_total_sub, .tenant_info_message, .grant_one, .grant_two, .grant_three, .grant_four, .grant_five').show();
        jQuery(".grant_two,.grant_three, .grant_four, .grant_five").removeClass("btn-success active");
        garant_total_one_changes();
        jQuery('input[name="isGarants"]').val(1);
        jQuery('.no-email-checkbox').trigger('change');
    } else {
      jQuery(".garant-individaul input,.garant-individaul select").attr('disabled','disabled');
      jQuery("#garant_total_sub, .tenant_info_message, .grant_one, .grant_two, .grant_three, .grant_four, .grant_five, #garant_one_div, #garant_two_div, #garant_three_div, #garant_four_div, #garant_five_div").hide();
      jQuery('input[name="isGarants"]').val(0);
    }
  });

  jQuery(document).on('change', '.com_offer input[name="garant_total"]', function (event) {

    var selected_value = jQuery(this).val();
    jQuery('input[name="selectedGarantCount"]').val(selected_value);
    if (selected_value == 1) {
        jQuery('#garant_one_div').show();
        jQuery('#garant_two_div, #garant_three_div, #garant_four_div, #garant_five_div').hide();
        garant_total_one_changes();
    }
    else if (selected_value == 2) {
        jQuery('#garant_one_div, #garant_two_div').show();
        jQuery('#garant_three_div, #garant_four_div, #garant_five_div').hide();

        jQuery("#garant_one_div, #garant_two_div").find(":input").removeAttr('disabled');
        jQuery("#garant_three_div, #garant_four_div, #garant_five_div").find(":input").attr('disabled','disabled');
    }
    else if (selected_value == 3) {
        jQuery('#garant_one_div, #garant_two_div, #garant_three_div').show();
        jQuery('#garant_four_div,  #garant_five_div').hide();

        jQuery("#garant_one_div, #garant_two_div, #garant_three_div").find(":input").removeAttr('disabled');
        jQuery("#garant_four_div, #garant_five_div").find(":input").attr('disabled','disabled');
    }
    else if (selected_value == 4) {
        jQuery('#garant_one_div, #garant_two_div, #garant_three_div, #garant_four_div').show();
        jQuery('#garant_five_div').hide();

        jQuery("#garant_one_div, #garant_two_div, #garant_three_div, #garant_four_div").find(":input").removeAttr('disabled');
        jQuery("#garant_five_div").find(":input").attr('disabled','disabled');
    }
    else if(selected_value == 5){
        jQuery('#garant_one_div, #garant_two_div, #garant_three_div, #garant_four_div, #garant_five_div').show();
        jQuery(".garant-individaul").find(":input").removeAttr('disabled');
    }
    jQuery(".garant-individaul .non_company_field_div.hide").find(":input").attr('disabled','disabled');
    jQuery(".garant-individaul .email_with_checkbox .garant_email").attr('disabled','disabled');

  });

  jQuery('.no-email-checkbox').change(function () {
    triggerDisabledEmailCheck(jQuery(this).is(":checked"),jQuery(this).data('no-email-element'));
  });
  function triggerDisabledEmailCheck(state,prefix){
    let input_name = prefix+'email';
    let input_name_header = jQuery('input[name="'+input_name+'"]');
    jQuery("."+prefix+"no-email-field, ."+prefix+"email_field .star_disable").toggleClass("hide",state);
    jQuery("."+prefix+"email_field").toggleClass("email_with_checkbox",state).find(".input-group-addon").toggleClass("hide",!state);
    input_name_header.attr("disabled", state);
    let parant_class = state ? ".input-group-addon ": '';
    jQuery(parant_class+"."+prefix+"no_emails").prop("checked", state);
    if(state){
      input_name_header.closest('.form-group').removeClass('has-error');
      input_name_header.val("");
    } else {
      input_name_header.removeAttr('disabled');
      jQuery(parant_class+"."+prefix+"no_emails").prop("checked", state);
    }
  }
  /* Edit separately ORG-HO/PL/Garants/Deposit Amount */
  jQuery(document).on("click", ".edit-policy-organization", function () {
    showHideDrawerErrroMsg(true, false);
    onChangeOrganization();
    scrollPageTop(".com_offer .edit-policy-drawer", 0);
    openDrawer('organization');
  });

  jQuery(document).on("click", ".edit-policy-houseowner", function () {
    showHideDrawerErrroMsg(true, false);
    onChangeOrganization();
    scrollPageTop(".com_offer .edit-policy-drawer", 720);
    openDrawer('organization');
  });

  jQuery(document).on("click", ".edit-policy-privatelandlord", function () {
    showHideDrawerErrroMsg(true, false);
    onChangePrivateLandlord();
    scrollPageTop(".com_offer .edit-policy-drawer", 0);
    openDrawer('privatelandlord');
  });

  jQuery(document).on("click", ".edit-policy-garants", function () {
    showHideDrawerErrroMsg(true, false);
    jQuery(".lessor_type_private_block, .lessor_type_organization_block, .organization_houseowner_block, .deposite_amount_block, .sub-rent-owner-lessor-hide, .section-hr-seprator").addClass("hide");
    jQuery(".garant_block").removeClass("hide");
    scrollPageTop(".com_offer .edit-policy-drawer", 0);
    openDrawer('garants');
  });
  jQuery(document).on("click", ".edit-deposit-amount", function () {
    showHideDrawerErrroMsg(true, false);
    jQuery(".organization_houseowner_block, .lessor_type_private_block, .lessor_type_organization_block, .sub-rent-owner-lessor-hide, .section-hr-seprator, .garant_block").addClass("hide");
    jQuery(".deposite_amount_block").removeClass("hide").find(":input").prop("disabled", false);
    var policyDepositAmount = jQuery('input[name="calculated_policy_deposit_amount"]').val();
    cleanDepositAmount = cleanDigit(policyDepositAmount);
    var searchDeposit = jQuery('input[name="searchstring"]');
    searchDeposit.val(cleanDepositAmount);
    var calculateDeposit = searchDeposit.val();
    if (calculateDeposit.trim() !== "") {
      searchDeposit.trigger("keyup");
      searchDeposit.closest(".form-group").removeClass("has-error");
    }
    openDrawer('deposit');
  });

  /* Deposit amount drawer js code */
  var typingTimer;
  var $searchStringInput = jQuery('#searchstring');

  //on keyup, start the countdown
  $searchStringInput.on('keyup', function () {
    clearTimeout(typingTimer);
    calculation();
  });

  $searchStringInput.on('keydown', function () {
    clearTimeout(typingTimer);
  });

  jQuery(document).on("change", 'input[type="radio"][name="lessor_type"]', function () {
    var lessor_type = jQuery(this).val();
    if (lessor_type == "organization") {
      jQuery("#saveButton_modal").attr("value", 'organization');
      onChangeOrganization();
    } else {
      jQuery("#saveButton_modal").attr("value", 'privatelandlord');
      onChangePrivateLandlord();
    }
  });

  jQuery(document).on("keyup blur", ".birthdate-validate-18", function () {
    checkBirthdateValidation(this);
  });

  var spinner_loader_html = '<div class="amount-spinner"><div class="bounce-1"></div><div class="bounce-2"></div><div class="bounce-3"></div></div>';

  jQuery('select[name="garant_one_nation"],select[name="garant_two_nation"],select[name="garant_three_nation"],select[name="garant_four_nation"],select[name="garant_five_nation"]').on('change', function () {
    let nation_id = jQuery(this).attr('id');
    let sub_nation = nation_id.replace('nation','');
    let CHECountry = (jQuery(this).val() == 'CHE' || jQuery(this).val() == '');
    jQuery('.'+nation_id+'_residant_permit').toggleClass('hide', CHECountry);
    var targetDropdown = jQuery('select[name="' + sub_nation + 'residence_card_questions"]');
    targetDropdown.val('').prop('disabled', CHECountry);
    targetDropdown.niceSelect('update');
  });

  //for org auto search
  var minLengthSearch  = 4;
  var organizationsBloodhound = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: getURL('offer.searchOrganization') + "&searchword=%QUERY",
      wildcard: '%QUERY'
    },
  });
  organizationsBloodhound.initialize();
  jQuery('#google_org_search').typeahead({minLength: minLengthSearch}, {
    name: 'organizations',
    limit: 20,
    displayKey: 'org_name',
    source: organizationsBloodhound.ttAdapter(),
    templates: {
      suggestion: Handlebars.compile('<div><div class="name-div"><span><strong> {{org_name}} – {{org_ort}}</strong></span></div><div class="date-div text-muted"><span> {{org_address}},</span><span> {{org_plz}}</span><span> {{org_ort}}</span></div></div>'),
      empty: function(context){
        jQuery(".org_typehead .tt-dataset").text(noResultFound);
      }
    }
  }).on('typeahead:selected', function (ev, suggestion) {
    jQuery('#house_owner_name, #house_owner_address, #house_owner_plz, #house_owner_city').val('').trigger("blur");
    for (var property in suggestion) {
      if (suggestion.hasOwnProperty(property)) {

        if (property == "org_name") {

          disableORGFields(1);
          jQuery('#google_org_search').val(suggestion[property]);
          jQuery('input[name="org_name"]').val(suggestion[property]);
          jQuery('input[name="org_name"]').closest('.form-group').removeClass('has-error');
        }  else if (property == "org_address") {

          jQuery('input[name="org_address"]').val(suggestion[property]);
          jQuery('input[name="org_address"]').closest('.form-group').removeClass('has-error');
        }  else if (property == "org_plz") {

          jQuery('input[name="org_plz"]').val(suggestion[property]);
          jQuery('input[name="org_plz"]').closest('.form-group').removeClass('has-error');
        }  else if (property == "org_ort") {

          jQuery('input[name="org_ort"]').val(suggestion[property]);
          jQuery('input[name="org_ort"]').closest('.form-group').removeClass('has-error');
        }  else if (property == "org_phone") {

          jQuery('input[name="org_phone"]').val(suggestion[property]);
        }  else if (property == "org_email") {

          jQuery('input[name="org_email"]').val(suggestion[property]);
        }
        if (property == "organization_id") {

          jQuery("#organization_id").val(suggestion[property]);
          getHouseowner(suggestion[property]);
        }
        if (property == "status") {
          if (suggestion['status'] == "icon-unpublish") {
              jQuery('#not-accepted-organization').slideDown();
          } else {
              jQuery('#not-accepted-organization').slideUp();
          }
        }
      }
    }
  });

  //houseowner auto search
  var houseownersBloodhound = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: getURL('offer.searchHouseOwner'),
      prepare: function(query, settings) {
          settings.url += "&searchword=" + encodeURIComponent(query) + "&org_id=" + jQuery("#organization_id").val();
          return settings;
      },
      wildcard: '%QUERY'
    },
  });
  houseownersBloodhound.initialize();
  jQuery('#google_houseowner_search').typeahead({minLength: minLengthSearch}, {
    name: 'houseowners',
    limit: 20,
    displayKey: 'house_owner_name',
    source: houseownersBloodhound.ttAdapter(),
    templates: {
      suggestion: Handlebars.compile('<div><div class="name-div"><span><strong> {{house_owner_name}} </span> <span class="{{house_owner_plz}}"></span> <span class="text-muted">{{#if house_owner_city}} – {{house_owner_city}}{{/if}}</span></strong></div><div class="date-div text-muted"><span>{{house_owner_address}}</span></div></div>'),
      empty: function(context){
        jQuery(".house_owner_data .tt-dataset").text(noResultFound);
      }
    }
  }).on('typeahead:selected', function (ev, suggestion) {
    for (var property in suggestion) {
      if (suggestion.hasOwnProperty(property)) {
        if (property == "house_owner_name") {

          disableHOFields(1);
          jQuery('#google_houseowner_search').val(suggestion[property]);
          jQuery('input[name="house_owner_name"]').val(suggestion[property]);
        }
        if (property == "house_owner_address") {
          jQuery('input[name="house_owner_address"]').val(suggestion[property]);


        }
        if (property == "house_owner_plz") {
          jQuery('input[name="house_owner_plz"]').val(suggestion[property]);
        }
        if (property == "house_owner_city") {
          jQuery('input[name="house_owner_city"]').val(suggestion[property]);
        }
        if (property == "houseowner_id") {
              jQuery("#houseowner_id").val(suggestion[property]);
        }
      }
    }
  });

  function getCustomerInfo() {
    pageLoaderHead(1);
    jQuery.ajax({
      url: getURL('offer.getCustomerInfo'),
      type: "POST",
      success: function (result) {
        result = JSON.parse(result);
        pageLoaderHead(0);
        if (!result.policy) {
          return;
        }
        policyID = result.policy.policy_id;
        if (result.policy.customer_answer_received == 1) {
          jQuery(".offer-change-block, .top-notification-sec").remove();
          let policy_overview_text = Joomla.JText._("COM_OFFER_RENTAL_DEPOSIT_CHILD_POLICY_OVERVIEW");
          jQuery(".policy_overview_text").html(policy_overview_text);
          let offer_accepted_text = Joomla.JText._("COM_OFFER_ACCEPTED_OFFER_TEXT");
          offer_accepted_text = offer_accepted_text.replace("{accepted_date}", result.policy.customer_answer_received_date_formatted);
          jQuery(".guarantee-header-txt span").html(offer_accepted_text);
          jQuery(".rental-guarantee-header").addClass("mb-0 offer-submitted");
          if (result.payment && result.policy.policy_id> 0 && result.payment.invoice_id> 0) {
            let invoice_details_box = jQuery(".invoice-details-box").detach();
            jQuery(".offer-section-content").append(invoice_details_box);
            result.payment.policy_id = result.policy.policy_id;
            populatePaymentSection(result.payment);
          }

        } else {
          var policy_deposit_amount = cleanDigit(result.policy.deposit_amount);
          var policy_computed_total = cleanDigit(result.policy.formatted_total);

          jQuery('input[name="policy_deposit_amount"]').val(policy_deposit_amount);
          jQuery('input[name="calculated_policy_deposit_amount"]').val(policy_deposit_amount);
          jQuery('input[name="premium_percentage"]').val(result.policy.premium_percentage);
          jQuery('input[name="policy_computed_total"]').val(policy_computed_total);
          jQuery('input[name="calculated_policy_computed_total"]').val(policy_computed_total);
          jQuery('input[name="policy_contact_type"]').val(result.contact.contact_type);
          var quoteAddress = result.policy.quote_appartment_adress + ', ' + result.policy.quote_prop_plz + " " + result.policy.quote_prop_ort;

          jQuery(".policy-number.drawer-head-policy_num").text(result.policy.policy_num);
          jQuery(".policy-address.drawer-head-policy-address").text(quoteAddress);

          if (result.policy.org_id) {
            jQuery(".lessor_type_private_block").addClass('hide');
            jQuery(".lessor_type_organization_block").removeClass('hide').find(':input').prop('disabled', false);
            jQuery('input[type="radio"][name="lessor_type"][value="organization"]').trigger('click');
            jQuery("#organization_id").val(result.policy.org_id);
            jQuery('input[name="org_name"]').val(result.policy.organization_name);
            jQuery('input[name="org_address"]').val(result.policy.org_address);
            jQuery('input[name="org_plz"]').val(result.policy.org_zipcode);
            jQuery('input[name="org_ort"]').val(result.policy.org_city);
            jQuery('input[name="org_phone"]').val(result.policy.org_phone);
            jQuery('input[name="org_email"]').val(result.policy.org_email);
            jQuery('input[name="selectedLessorType"]').val('organization');

            if (result.policy.ho_id) {
              jQuery(".organization_houseowner_block").removeClass('hide').find(':input').prop('disabled', false);
              jQuery("#houseowner_id").val(result.policy.ho_id);
              jQuery('input[name="house_owner_name"]').val(result.policy.houseowner_name);
              jQuery('input[name="house_owner_address"]').val(result.policy.houseowner_address);
              jQuery('input[name="house_owner_plz"]').val(result.policy.houseowner_zipcode);
              jQuery('input[name="house_owner_city"]').val(result.policy.houseowner_city);
            } else {
              jQuery(".organization_houseowner_block").addClass('hide');
            }
          }
          if (result.policy.pl_id) {
            jQuery(".lessor_type_organization_block").addClass('hide');
            jQuery(".lessor_type_private_block").removeClass('hide').find(':input').prop('disabled', false);
            jQuery('input[type="radio"][name="lessor_type"][value="private_landlord"]').trigger('click');
            jQuery('input[type="radio"][name="anrede_private"][value="' + result.policy.pl_anrede + '"]').trigger('click');
            jQuery('input[type="radio"][name="privatelandlord_language"][value="' + result.policy.pl_language + '"]').trigger('click');
            jQuery("#privatelandlord_id").val(result.policy.pl_id);
            jQuery('input[name="privatelandlord_name"]').val(result.policy.pl_name);
            jQuery('input[name="privatelandlord_firstname"]').val(result.policy.pl_first_name);
            jQuery('input[name="privatelandlord_address"]').val(result.policy.pvt_address);
            jQuery('input[name="privatelandlord_plz"]').val(result.policy.pvt_zipcode);
            jQuery('input[name="privatelandlord_ort"]').val(result.policy.pvt_city);
            jQuery('input[name="privatelandlord_phone"]').val(result.policy.pl_phone);
            jQuery('input[name="privatelandlord_email"]').val(result.policy.pl_email);
            jQuery('input[name="selectedLessorType"]').val('privatelandlord');
          }

          if (policy_deposit_amount) {
            jQuery(".deposite_amount_block").removeClass("hide").find(':input').prop('disabled', false);
            jQuery('input[name="searchstring"]').val(policy_deposit_amount);
            jQuery("#results").html("CHF " + result.policy.formatted_total);
            jQuery(".amnt-results").removeClass("hide");

          }
        }
        if (!result.policy) {
          jQuery(".main-component-section").addClass("hide");
          jQuery(".offer-token-box").removeClass("hide");
          jQuery(".body").addClass("offer-token-page");
          return;
        }

        jQuery(".code-box").addClass("hide");
        jQuery(".main-component-section").removeClass("hide");
        jQuery(".main-component-section").removeClass("loading-content");
        jQuery(".body").removeClass("offer-token-page");
        loadFooterLogo();
        jQuery("footer").removeClass("policy-footer");
        let customer_salutation = result.contact.customer_salutation;
        jQuery("input[name='mobile']").val(result.contact.mobile);
        jQuery("input[name='telefon']").val(result.contact.telefon);
        jQuery("input[name='email']").val(result.contact.email);
        jQuery('input[name="iban_number"]').val(result.contact.iban);
        setEmailPostText(result.contact.email);
        if (result.contact.email) {
          jQuery("#customer_old_email_exist").val(result.contact.email);
        }
        if (customer_salutation) {
          jQuery(".greeting_text").html(customer_salutation);
        }
        result.policy.contact_type = result.contact.contact_type;
        if (result.policy) {
          render_item(result.policy);
          if (result.policy.customer_answer_received == 1) {
            jQuery(".download-btn-box").remove();
          }
        }

        if (result.policy.contact_address_type == 2) {
          jQuery("#receipt-address").prop("checked", true);
          jQuery(".receipt-address-box").hide();
          jQuery(".contact-co-address").removeClass("hide");
          jQuery('input[name="contact_address_co_name"]').val(result.policy.contact_address_co_name);
          jQuery('input[name="contact_address_co_address"]').val(result.policy.contact_address_co_address);
          jQuery('input[name="contact_address_co_plz"]').val(result.policy.contact_address_co_plz);
          jQuery('input[name="contact_address_co_ort"]').val(result.policy.contact_address_co_ort);
        } else {
          jQuery(".contact-standard-address").removeClass("hide");
          jQuery('input[name="contact_address_address"]').val(result.policy.contact_address_co_address);
          jQuery('input[name="contact_address_plz"]').val(result.policy.contact_address_co_plz);
          jQuery('input[name="contact_address_ort"]').val(result.policy.contact_address_co_ort);
        }
      },
    });
  }

  function render_item(data) {
    var source = jQuery("#policy-list-template").html();
    var template = Handlebars.compile(source);
    var context = data;
    var html = template(context);
    jQuery(".policy-detail-section").append(html);

    if (!data.ho_id && data.parent_policy_id == "0" && data.org_id) {
      jQuery(".policy-listing-content .garants_main_div").before('<div class="col-sm-4 ho_main_div">' + houseOwnerLabel + ' <i class="fa fa-pencil edit-policy-houseowner"></i><br>' + '<div class="no_ho_data"><b>' + noData + '</b></div>' + '<div id="ho_info_' + policyID + '"><span><b></b></span></div></div>');
    }

    renderGarantsDropdowns(data.countryLists , data.residenceQuestionLists);
    var garant_total_main = jQuery("[name='garant_total_main']");
    if (data.garantData.length) {
      var garantString = "";

      garant_total_main.filter("[value='1']").trigger("click");
      var numbers = ["one", "two", "three", "four", "five"];
      jQuery.each(data.garantData, function (index, value) {
        if (index > 0) {
          garantString += " <br> ";
        }
        jQuery("[name='garant_total']").filter("[value='" + (index+1) + "']").trigger("click");
        jQuery.each(value, function (key, val) {

          var inputFieldName = "garant_" + numbers[index] + "_" + key.replace("garant_", "");

          var garantName = "";
          var garantVorname = "";
          var garantBirthdate = "";
          var commaSeparator = "";

          if (key == "garant_name") {
            garantName = "<span class=" + inputFieldName + "_" + data.policy_id + ">" + val + "</span>";
          }
          if (key == "garant_vorname") {
            commaSeparator = value.garant_geburtsdatum ? ", " : "";
            garantVorname = "<span class=" + inputFieldName + "_" + data.policy_id + ">" + val + commaSeparator + "</span>";
          }
          if (key == "garant_geburtsdatum") {
            garantBirthdate = val ? "<span class=" + inputFieldName + "_" + data.policy_id + ">" + val + "</span>" : "";
          }
          garantString += garantName + " " + garantVorname + garantBirthdate;

          var inputField = jQuery("[name='" + inputFieldName + "']");

          if (key == "garant_email") {
            if (!validateEmail(val)) {
              let delimiter = "_email";
              let index = inputFieldName.indexOf(delimiter);
              let part1 = inputFieldName.substring(0, index);
              let part2 = inputFieldName.substring(index);
              let checkBoxClass = part1 + "_no" + part2 +"s";
              jQuery("." + checkBoxClass).prop('checked', true).trigger('change');
            }
          }

          if (inputField.length > 0) {

            if (inputField.is(":radio")) {
              inputField.filter("[value='" + val + "']").trigger("click");
            } else if (inputField.is("select")) {
              inputField.val(val).niceSelect('update');
              if (key == 'garant_residence_card_questions' && val != "") {
                jQuery(".garant_"+ numbers[index] +"_nation_residant_permit").removeClass("hide");
              }
            } else {
                inputField.val(val);
            }
          }
        });
      });

      jQuery("#garants_list_" + data.policy_id + " span b").append(garantString);
    } else {
      garant_total_main.filter("[value='0']").trigger("click");
      jQuery("#garants_list_" + data.policy_id).before("<div class='no_garant_data'><b>" + noData + "</b></div>");
    }
  }

  jQuery(document).on("mouseenter mouseleave", ".edit-deposit-amount, .edit-policy-organization, .edit-policy-houseowner, .edit-policy-privatelandlord, .edit-policy-garants", function (event) {
    jQuery(this).parent().toggleClass('edit-overlay', event.type === "mouseenter");
  });

  jQuery(".required").on("input change", function() {
    const parent = jQuery(this).closest(".form-group");
    if (jQuery(this).is(":radio")) {
      const groupName = jQuery(this).attr("name");
      const isAnyChecked = jQuery("input[name='" + groupName + "']").is(":checked");
      if (isAnyChecked) {
        parent.removeClass("has-error");
      } else {
        parent.addClass("has-error");
      }
    } else {
      if (jQuery(this).val().trim() !== "") {
        parent.removeClass("has-error");
      } else {
        parent.addClass("has-error");
      }
    }

    if (jQuery(".has-error").length === 0) {
      jQuery(".drawer_required_pl_org_error").addClass("hide");
    }
  });

  function checkBirthdateValidation(element){
    var dateValue = jQuery(element).val();
    var datePattern = /^(0[1-9]|[12][0-9]|3[01])\.(0[1-9]|1[0-2])\.(19|20)\d\d$/;

    if (datePattern.test(dateValue)) {
      jQuery(element).closest('.form-group').removeClass('has-error');
      jQuery(element).next('label').remove();
    } else {
      jQuery(element).next('label').remove();
      jQuery(element).after('<label>'+ validBirthdayMsg +'</label>');
      jQuery(element).closest('.form-group').addClass('has-error');
    }
    let validatemessage = birthagelimit(dateValue);
    let header_message = jQuery("."+jQuery(element).attr("name")+"_message");
    (validatemessage) ? header_message.slideUp() : header_message.slideDown();
  }

  function birthagelimit(birthdate){
    let birthDateValid;
    let birthdate_array = birthdate.split(".");
    let day = birthdate_array[0];
    let month = birthdate_array[1];
    let year = birthdate_array[2];
    let age = 18;
    let mydate = new Date();
    mydate.setFullYear(year, month-1, day);
    let currdate = new Date();
    let setDate = new Date();
    setDate.setFullYear(mydate.getFullYear() + age, month-1, day);

    birthDateValid = !((currdate - setDate) < 0);
    return birthDateValid;
  }

  jQuery(".garant_email, .validate-email").on("blur keyup", function() {
    const email = jQuery(this).val();
    var contactEmail = jQuery(this).hasClass('validate-email');
    if (contactEmail) {
      jQuery('input[name="contactEmailEdit"]').val(1);
    }
    if (!validateEmail(email)) {
      jQuery(this).next('label').remove();
      jQuery(this).after('<label>'+ validEmailMsg +'</label>');
      jQuery(this).closest('.form-group').addClass('has-error');
    } else {
      jQuery(this).closest('.form-group').removeClass('has-error');
      jQuery(this).next('label').remove();
    }
  });

  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  jQuery("input[name='anrede_private']").on('change', function () {
    var firmLabel = jQuery("#privatelandlord_vermieter_firma_label");
    var firmInput = jQuery("#privatelandlord_vermieter_firma");
    var firstNameLabel = jQuery("#privatelandlord_vermieter_firma_firstname_label");
    var firstNameInput = jQuery("#privatelandlord_vermieter_firma_firstname");

    function setLabel(labelText, firstNameText = '', requiredClass = '') {
      firmLabel.text(labelText + ' *');
      firstNameLabel.text(firstNameText + ' *');
      firstNameInput.removeClass('required').addClass(requiredClass);
    }

    var selectedValue = jQuery("input[name='anrede_private']:checked").val();
    switch(selectedValue) {
      case "company":
        setLabel(companyName, plCompanyName);
        firstNameLabel.text(plCompanyName);
        break;
      case "mr":
      case "mrs":
        setLabel(name, firstName, 'required');
        break;
      case "family":
        setLabel(plFamilyName, plFamilyFirstName, 'required');
        break;
      default:
        break;
    }
  });

  jQuery('input[name="garant_one_salutation"],input[name="garant_two_salutation"],input[name="garant_three_salutation"],input[name="garant_four_salutation"],input[name="garant_five_salutation"]').change(function () {

    let current_attributename = jQuery(this).attr('name');
    let dependant_header = jQuery('.'+current_attributename+'_dependant');
    let garant_name_text = current_attributename.replace('salutation','name');
    let person_name_label = name;

    if(jQuery(this).val() == "company"){
        person_name_label = companyName;
        dependant_header.addClass("hide");
        dependant_header.find(":input").attr("disabled", "disabled").closest(".form-group").removeClass("has-error");
    }else{
        dependant_header.removeClass("hide");
        dependant_header.find(":input").removeAttr("disabled");
    }
    jQuery("."+garant_name_text).html(person_name_label+" *");
  });

  jQuery('div.garant_block input[type="radio"]').on('change click', function() {
      jQuery(this).closest('div.btn-group').find('label').removeClass('btn-primary');
  });

  function pageLoaderHead(show) {
    if (show) {
        jQuery(".page-loading-mask").removeClass("hide");
    } else {
        jQuery(".page-loading-mask").addClass("hide");
    }
  }

  /*deposite amount calculation*/
  function calculation() {
    let onready = setDefaultParameter(arguments,arguments[0], 0);
    var Cost = jQuery("#searchstring").val();
    var amount = Cost.replace("'", "");
    var amount = amount.replace(/[^0-9.]/g, "");
    checkSectionHideOrShow(amount.length);
    jQuery("#searchstring").val(amount);
    if (isValidDepositAmount(amount)) {
      if(!onready) {
          jQuery(".amnt-results").addClass("hide");
      }
    } else if (amount.length > 2) {
      var premium = calculatePremium(amount);
      var formatPremium = formatAmountWithSeparator(premium);
      jQuery("#results").html(spinner_loader_html);
      typingTimer = setTimeout(function () {
        populateResultAmount(jQuery("#results"), formatPremium);
      }, 2000);
      jQuery(".amnt-results").css({"padding": "5px"});
    }
  }

});

function onChangePrivateLandlord() {
  jQuery(".organization_houseowner_block, .lessor_type_organization_block, .deposite_amount_block, .section-hr-seprator, .garant_block").addClass("hide");
  jQuery('input[type="radio"][name="lessor_type"][value="private_landlord"]').trigger("click");
  jQuery(".lessor_type_private_block, .sub-rent-owner-lessor-hide").removeClass("hide").find(":input").prop("disabled", false);
}

function onChangeOrganization() {
  jQuery(".lessor_type_private_block, .deposite_amount_block, .section-hr-seprator, .garant_block").addClass("hide");
  jQuery('input[type="radio"][name="lessor_type"][value="organization"]').trigger("click");
  jQuery(".lessor_type_organization_block, .sub-rent-owner-lessor-hide, .organization_houseowner_block").removeClass("hide").find(":input").prop("disabled", false);
}

function setDefaultParameter(arguments, passvalue, defaultvalue) {
  return arguments.length > 0 && passvalue !== undefined ? passvalue : defaultvalue;
}
///Default parameter attachClass = '.jboxtooltip', returnFunc = false
function triggerTooltip() {
  let attachClass = setDefaultParameter(arguments, arguments[0], ".jboxtooltip");
  let returnFunc = setDefaultParameter(arguments, arguments[1], false);

  let jboxTooltipMergedOptions = {
    getContent: "data-jbox-content",
    attach: attachClass,
    adjustPosition: true,
    maxWidth: 300,
    closeOnEsc: true,
    closeOnClick: true,
    closeOnMouseleave: true,
  };
  let jBoxObject = new jBox("Tooltip", jboxTooltipMergedOptions);
  if (returnFunc) {
    return jBoxObject;
  }
}
function removeRentContract(id, ind, inputname, cfname) {
  var obj1 = jQuery(id).parent(".cfup-right").parent(".cfup-file").find(".cfup-details .cfup-name").text();
  jQuery('input[name="' + inputname + '[]"]').each(function () {
    if (jQuery(this).val() == obj1) {
      jQuery(this).remove();
      if (ind != "abc") {
        jQuery("." + cfname + ind).remove();
      }
      jQuery.ajax({
        url: getURL('offer.clearTmp'),
        method: "POST",
        dataType: "json",
        data: {
          img: jQuery(this).val(),
        },
        success: function (data) {
          window.jboxtooltipobject.close();
        },
      });
    }
  });
}
function loadFooterLogo(type) {
  let policy_footer_img = jQuery(".policy-footer img").attr("src");
  let find = "_white.png";
  let replace = ".svg";
  if (type == "white") {
    find = ".svg";
    replace = "_white.png";
  }
  policy_footer_img = policy_footer_img.replace(find, replace);
  jQuery(".policy-footer img").attr("src", policy_footer_img);
}

function getHouseowner(id) {
  disableHOFields(0);
  jQuery.ajax({
    url: getURL('offer.check_houseowner'),
    //dataType: 'json',
    data: { org_id : id },
    method: 'POST',
    success: function (result) {
      result = JSON.parse(result);
      if (result > 0) {
        jQuery("#show-houseowner").show();
        jQuery('#count_houseowner').html(result);
        jQuery('#show-houseowner .tt-menu').remove();
        if(!id){
          jQuery("#show-houseowner").hide();
        }
      } else{
        jQuery("#show-houseowner, #show-houseowner-enter").hide();

      }
    }
  });
}

function getURL(task){
  return WEBSITE_URL + "index.php?option=com_offer&task="+task+"&tmpl=component";
}

function cleanDigit(digit) {
  return parseFloat(digit.replace(/[^0-9.]/g, ''));
}

function checkSectionHideOrShow(length) {
  let common_header = jQuery(".amnt-results");
  common_header.toggleClass("hide", length <= 2);
}

function calculatePremium(amount){
  var changeDepositAmount = amount;
  if (!changeDepositAmount) {
    return;
  }
  var depositAmount = cleanDigit(changeDepositAmount);
  var calculatedPremium;
  var contactType = jQuery('input[name="policy_contact_type"]').val();
  if(contactType == 1){
    var discount = 0;
    var amount = 0.045;
    var tax = 5;
    calculatedPremium = getSubTotalPrivate(discount, depositAmount, amount, tax);
  } else {
    calculatedPremium = getSubTotalBusiness(depositAmount);
  }
  jQuery('input[name="calculated_policy_deposit_amount"]').val(changeDepositAmount);
  jQuery('input[name="calculated_policy_computed_total"]').val(calculatedPremium);
  jQuery('input[name="searchstring"]').val(depositAmount);

  return calculatedPremium;
}

function openDrawer(value) {
  jQuery(".edit-policy-drawer").toggleClass("open");
  jQuery(".overlay-drawer").toggleClass("open");
  jQuery("body").toggleClass("modal-open");
  jQuery("#saveButton_modal").attr("value", value);
}

function isValidDepositAmount(amount){
  return (amount == 0 || amount == "" || amount.length <= 2);
}

function formatAmountWithSeparator(amount){
  return parseFloat(amount).toLocaleString('de-CH',   { minimumFractionDigits: 2 });
}

function populateResultAmount(result_header, new_amount) {
  result_header.empty().html('CHF '+new_amount);
}

function getSubTotalPrivate(discount, depositAmount, amount, tax) {
  depositAmount = (depositAmount <= 2000) ? 2000 : depositAmount;
  var deposit_amount = ((depositAmount * amount - discount) * (1 + tax / 100));
  var formattedNumber = getFormattedCentBasedValue(deposit_amount).toFixed(2);
  jQuery('input[name="premium_percentage"]').val(amount);
  return formattedNumber;
}

function getSubTotalBusiness(amount) {
  var formattedNumber;
  var bussinessRate = jQuery('input[name="premium_percentage"]').val();
  bussinessRate = bussinessRate * 100;
  t = (amount * (bussinessRate / 100) - 0) * (1 + taxPercentageBusiness / 100);
  formattedNumber = getFormattedCentBasedValue(t).toFixed(2);;
  return formattedNumber;
}

function getFormattedCentBasedValue(t){
  return (Math.round((t * 2)*10)/10)/2;
}

function scrollPageTop(selectorOfElement, valOfScroll) {
  jQuery(selectorOfElement).animate({
    scrollTop: valOfScroll,
  }, "fast");
}

var jboxtooltip_org_clear = unselect_tooltip('.jboxtooltip-org-clear');
jboxtooltip_org_clear.disable();

var jboxtooltip_ho_clear = unselect_tooltip('.jboxtooltip-ho-clear');
jboxtooltip_ho_clear.disable();

function disableORGFields(org_search){
  let icon_header = jQuery('.org_typehead .input-group-btn i');
  let search_class = 'fa-search';
  let remove_class = 'fa-remove';
  if(org_search > 0){
    icon_header.removeClass(search_class).addClass(remove_class);
    jboxtooltip_org_clear = unselect_tooltip('.jboxtooltip-org-clear');
    jboxtooltip_org_clear.enable();
  }else{
    jboxtooltip_org_clear.destroy();
    jQuery("#organization_id, #google_org_search, #houseowner_id, #google_houseowner_search").val('');
    icon_header.removeClass(remove_class).addClass(search_class);
    disableHOFields(0);

  }
}

function disableHOFields(ho_search){
  let icon_header = jQuery('.house_owner_data .input-group-btn i');
  let search_class = 'fa-search';
  let remove_class = 'fa-remove';
  if(ho_search > 0){
      icon_header.removeClass(search_class).addClass(remove_class);
      jboxtooltip_ho_clear = unselect_tooltip('.jboxtooltip-ho-clear');
      jboxtooltip_ho_clear.enable();
  }else{
      jboxtooltip_ho_clear.destroy();
      jQuery("#google_houseowner_search, #houseowner_id").val('');
      icon_header.removeClass(remove_class).addClass(search_class);
      jQuery("#show-houseowner").hide();
  }
}

function unselect_tooltip(attachClass){
  return triggerTooltip(attachClass, true);
}

function clearOrgSelection(){
  if(jQuery('.org_typehead .input-group-btn i').hasClass("fa-search")){
      return true;
  }
  disableORGFields(0);
}

function clearHOSelection(){
  if(jQuery('.house_owner_data .input-group-btn i').hasClass("fa-search")){
      return true;
  }
  disableHOFields(0);
}

function renderGarantsDropdowns(countryList , residenceQuestionLists){
  var numbers = ["one", "two", "three", "four", "five"];
  jQuery.each(numbers, function(index, value) {
    jQuery("#garant_"+value+"_nation").append(countryList);
    triggerNiceSelectDropdown("#garant_"+value+"_nation");
    jQuery(".garant_"+value+"_residence_card_questions").append(residenceQuestionLists.replace(/garant_/g, "garant_"+value+"_"));
    triggerNiceSelectDropdown("#garant_"+value+"_residence_card_questions");
  });
}

function checkGarantRequiredFields(garantTotal, garantTotalNumbers) {
  var valid = true;
  if (garantTotal) {
    for (var i = 0; i < garantTotal; i++) {
      var value = garantTotalNumbers[i];
      jQuery("#garant_" + value + "_div :input").each(function(){
        var input = jQuery(this);
        valid = toggleHasErrorClass(this, input, value) && valid;
      });
    }
  }
  showHideDrawerErrroMsg(valid);
  return valid;
}

function checkRequiredFields(elementsRequired) {
  let isValid = true;
  jQuery(elementsRequired + " .required").each(function() {
    var input = jQuery(this);
    isValid = toggleHasErrorClass(this, input) && isValid;
  });
  showHideDrawerErrroMsg(isValid);
  return isValid;
}

function showHideDrawerErrroMsg(checkValid, forDrawer = true) {
  var drawerRequiredPlOrgError= jQuery(".drawer_required_pl_org_error");
  if (!checkValid) {
    drawerRequiredPlOrgError.toggleClass("hide",false);
    return;
  } else {
    drawerRequiredPlOrgError.toggleClass("hide",true);
    if (forDrawer) {
      jQuery(".close-drawer a").trigger("click");
    }
  }
}

function toggleHasErrorClass(currentObj, input, value = "") {
  var inputType = input.attr('type');
  var inputName = input.attr('name');
  var parentFormGroup = input.closest('.form-group');
  var valid = true;
  var isDisabled = input.is(":disabled");
  if (!isDisabled) {
    if (inputType === 'radio') {
      var allRadioButtons = jQuery("input[name='" + inputName + "']");
      var isAnyChecked = allRadioButtons.is(':checked');
      if (isAnyChecked) {
        parentFormGroup.removeClass('has-error');
      } else {
        parentFormGroup.addClass('has-error');
        valid = false;
      }
    } else if (currentObj.tagName.toLowerCase() === 'select') {
      var selectedOption = input.find('option:selected').val().trim().length > 0;
      if (inputName === 'garant_' + value + '_residence_card_questions') {
        var hideResidenceQues = jQuery(".garant_" + value + "_nation_residant_permit").hasClass("hide");
        if (hideResidenceQues) {
          parentFormGroup.removeClass('has-error');
        } else if (selectedOption) {
          parentFormGroup.removeClass('has-error');
        } else {
          parentFormGroup.addClass('has-error');
          valid = false;
        }
      } else {
        if (selectedOption) {
          parentFormGroup.removeClass('has-error');
        } else {
          parentFormGroup.addClass('has-error');
          valid = false;
        }
      }
    } else if(inputType === 'text' || inputType === 'tel') {
      var inputVal = input.val().trim().length;
      if (inputVal) {
        parentFormGroup.removeClass('has-error');
      } else {
        parentFormGroup.addClass('has-error');
        valid = false;
      }
    }
  }
  return valid;
}

function setEmailPostText(email) {
  let emailPostText = Joomla.JText._("COM_OFFER_CONFIRMATION_POST_TEXT");
  if (email) {
    emailPostText = Joomla.JText._("COM_OFFER_CONFIRMATION_EMAIL_TEXT");
  }
  jQuery("#email-post-text").html(emailPostText);
}

function triggerNiceSelectDropdown(element){
  jQuery(element).niceSelect();
}

function populatePaymentSection(payment){
  jQuery("#qr_invoice_id").val(payment.invoice_id);
  jQuery("#qr_policy_id").val(payment.policy_id);
  jQuery(".invoices-buttons #payment_link").attr("href", payment.link);
  jQuery(".invoice-details-box .policy_start_date").html(payment.invoice_startdate);
  jQuery(".invoice-details-box .policy_end_date").html(payment.invoice_enddate);
  jQuery(".invoice-details-box .policy_premium").html(payment.premium);
}
