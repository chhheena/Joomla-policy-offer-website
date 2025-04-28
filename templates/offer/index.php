<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.offer
 *
 * @copyright   (C) 2012 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app  = JFactory::getApplication();
$user = JFactory::getUser();

// Output as HTML5
$this->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');

// Add JavaScript Frameworks
//JHtml::_('bootstrap.framework');

// Add template js
JHtml::_('script', 'template.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'bootstrap.js', array('version' => 'auto', 'relative' => true));

// Add html5 shiv
JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

// Add Stylesheets
JHtml::_('stylesheet', 'bootstrap.css', array('version' => 'auto', 'relative' => true));

// Check for a custom CSS file
JHtml::_('stylesheet', 'font-awesome.min.css', array('version' => 'auto', 'relative' => true));

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Adjusting content width
$position7ModuleCount = $this->countModules('position-7');
$position8ModuleCount = $this->countModules('position-8');

if ($position7ModuleCount && $position8ModuleCount)
{
	$span = 'span6';
}
elseif ($position7ModuleCount && !$position8ModuleCount)
{
	$span = 'span9';
}
elseif (!$position7ModuleCount && $position8ModuleCount)
{
	$span = 'span9';
}
else
{
	$span = 'span12';
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . htmlspecialchars(JUri::root() . $this->params->get('logoFile'), ENT_QUOTES) . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<jdoc:include type="head" />
</head>
<body class="site landing-page <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '')
	. ($this->direction === 'rtl' ? ' rtl' : '');
?>">
	<!-- Body -->
	<div class="body offer-token-page" id="top">
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">

			<header>
				<div class="header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-7 col-xs-5">
								<jdoc:include type="modules" name="header" />
							</div>
							<div class="col-md-5 col-xs-7">
								<?php if ($this->countModules('header-right')) : ?>
									<div class="top-right-sec">
										<jdoc:include type="modules" name="header-right" />
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div class="for-mobile-only">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<div class="top-slogan">
								<h2><?php echo JText::_('COM_OFFER_TOP_LOGO_SLOGAN_TITLE',); ?></h2>
								<p><?php echo JText::_('COM_OFFER_TOP_LOGO_SLOGAN_SUBTITLE',); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Begin Content -->
			<jdoc:include type="message" />
			<jdoc:include type="component" />
			<!-- End Content -->
		</div>
	</div>
	<!-- Footer -->
	<jdoc:include type="modules" name="Footer" />

	<jdoc:include type="modules" name="google-badge-design-popup" />

	<jdoc:include type="modules" name="contact-modal-block" />

	<jdoc:include type="modules" name="debug" style="none" />

	<div id="contactModal" class="modal fade contactpopup" tabindex="-1" role="dialog" aria-labelledby="faqModalTitle" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button class="close" type="button" data-dismiss="modal">×</button>
					<div class="contact-top-content">
						<h3 class="contact-title">
							<?php echo JTEXT::_('GLOBAL_CONTACT_MODAL_TITLE'); ?>
						</h3>
						<img src="images/contact_us.svg" alt="">
						<div class="contact-content"><?php echo JTEXT::_('GLOBAL_CONTACT_MODAL_CONTENT'); ?></div>
					</div>
					<div class="contact-buttons-block">
						<!-- <button type="button" data-dismiss="modal"></button> -->
						<a href="mailto:info@gocaution.ch?Subject=<?php echo JTEXT::_('GLOBAL_CONTACT_MODAL_EMAIL_SUBJECT'); ?>" class="email-btn"><?php echo JTEXT::_('GLOBAL_CONTACT_MODAL_EMAIL_BTN'); ?></a>
						<a href="tel:0584262222" class="call-btn"><?php echo JTEXT::_('GLOBAL_CONTACT_MODAL_CALL_BTN'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
