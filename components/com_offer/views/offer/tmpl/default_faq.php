<?php
//no direct access
defined('_JEXEC') or die('Restricted access.');
?>
<div class="faq-modal">
    <!-- Modal -->
    <div class="modal fade modal-fullscreen" id="faqModal" tabindex="-1" role="dialog" aria-labelledby="faqModalTitle" aria-hidden="true">
                <div class="close-icon">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="images/icon-close-modal.svg" alt="icon-close-modal">
                    </button>
                </div>
                <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-container">
                    <div class="modal-top-head">
                        <img src="images/faq-tag-white.svg" alt="faq-tag-white">
                        <h2><?php echo JText::_("COM_OFFER_FAQ_MODAL_HEAD_CONTENT"); ?></h2>
                        <p><?php echo JText::_("COM_OFFER_FAQ_MODAL_HEAD_CONTENT_DESC"); ?></p>
                    </div>
                    <div class="modal-content-box">
                        <div class="accordion-custom" id="accordion">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                            <?php echo JText::_("COM_OFFER_FAQ_MODAL_QUES_ONE"); ?>
                                            <img src="images/arrow-down-large.svg" alt="arrow-down">
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    <?php echo JText::_("COM_OFFER_FAQ_MODAL_ANS_ONE"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                            <?php echo JText::_("COM_OFFER_FAQ_MODAL_QUES_TWO"); ?>
                                            <img src="images/arrow-down-large.svg" alt="arrow-down">
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php echo JText::_("COM_OFFER_FAQ_MODAL_ANS_TWO"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                            <?php echo JText::_("COM_OFFER_FAQ_MODAL_QUES_THREE"); ?>
                                            <img src="images/arrow-down-large.svg" alt="arrow-down">
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php echo JText::_("COM_OFFER_FAQ_MODAL_ANS_THREE"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                            <?php echo JText::_("COM_OFFER_FAQ_MODAL_QUES_FOUR"); ?>
                                            <img src="images/arrow-down-large.svg" alt="arrow-down">
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    <?php echo JText::_("COM_OFFER_FAQ_MODAL_ANS_FOUR"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                                            <?php echo JText::_("COM_OFFER_FAQ_MODAL_QUES_FIVE"); ?>
                                            <img src="images/arrow-down-large.svg" alt="arrow-down">
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFive" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php echo JText::_("COM_OFFER_FAQ_MODAL_ANS_FIVE"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                                            <?php echo JText::_("COM_OFFER_FAQ_MODAL_QUES_SIX"); ?>
                                            <img src="images/arrow-down-large.svg" alt="arrow-down">
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseSix" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php echo JText::_("COM_OFFER_FAQ_MODAL_ANS_SIX"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                                            <?php echo JText::_("COM_OFFER_FAQ_MODAL_QUES_SEVEN"); ?>
                                            <img src="images/arrow-down-large.svg" alt="arrow-down">
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseSeven" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php echo JText::_("COM_OFFER_FAQ_MODAL_ANS_SEVEN"); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOneOne">
                                            <?php echo JText::_("COM_OFFER_FAQ_MODAL_QUES_EIGHT"); ?>
                                            <img src="images/arrow-down-large.svg" alt="arrow-down">
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOneOne" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php echo JText::_("COM_OFFER_FAQ_MODAL_ANS_EIGHT"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseGenerali">
                                            <?php echo JText::_("COM_OFFER_FAQ_MODAL_QUES_NINE"); ?>
                                            <img src="images/arrow-down-large.svg" alt="arrow-down">
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseGenerali" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php echo JText::_("COM_OFFER_FAQ_MODAL_ANS_NINE"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseGenerali2">
                                            <?php echo JText::_("COM_OFFER_FAQ_MODAL_QUES_TEN"); ?>
                                            <img src="images/arrow-down-large.svg" alt="arrow-down">
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseGenerali2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php echo JText::_("COM_OFFER_FAQ_MODAL_ANS_TEN"); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>