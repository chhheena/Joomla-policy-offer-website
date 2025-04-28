<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_languages
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri as JUri;
use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\HTML\HTMLHelper as JHtml;

JHtml::_('stylesheet', 'mod_languages/template.css', array('version' => 'auto', 'relative' => true));

if ($params->get('dropdown', 0) && !$params->get('dropdownimage', 1))
{
	JHtml::_('formbehavior.chosen');
}

?>
<div class="mod-languages<?php echo $moduleclass_sfx; ?>">
<?php if ($headerText) : ?>
	<div class="pretext"><p><?php echo $headerText; ?></p></div>
<?php endif; ?>

<?php if ($params->get('dropdown', 0) && !$params->get('dropdownimage', 1)) : ?>
	<form name="lang" method="post" action="<?php echo htmlspecialchars_decode(htmlspecialchars(JUri::current(), ENT_COMPAT, 'UTF-8'), ENT_NOQUOTES); ?>">
	<select class="inputbox advancedSelect" onchange="document.location.replace(this.value);" >
	<?php foreach ($list as $language) : ?>
		<option dir=<?php echo $language->rtl ? '"rtl"' : '"ltr"'; ?> value="<?php echo htmlspecialchars_decode(htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'), ENT_NOQUOTES); ?>" <?php echo $language->active ? 'selected="selected"' : ''; ?>>
		<?php echo $language->title_native; ?></option>
	<?php endforeach; ?>
	</select>
	</form>
<?php elseif ($params->get('dropdown', 0) && $params->get('dropdownimage', 1)) : ?>
	<div class="btn-group">
		<?php foreach ($list as $language) : ?>
			<?php if ($language->active) : ?>
				<a href="#" data-toggle="dropdown" class="btn dropdown-toggle">
					<span class="caret"></span>
					<?php if ($language->image) : ?>
						&nbsp;<?php echo JHtml::_('image', 'mod_languages/' . $language->image . '.gif', '', null, true); ?>
					<?php endif; ?>
					<?php echo $language->title_native; ?>
				</a>
			<?php endif; ?>
		<?php endforeach; ?>
		<ul class="<?php echo $params->get('lineheight', 0) ? 'lang-block' : 'lang-inline'; ?> dropdown-menu" dir="<?php echo JFactory::getLanguage()->isRtl() ? 'rtl' : 'ltr'; ?>">
		<?php foreach ($list as $language) : ?>
			<?php if (!$language->active) : ?>
				<li>
				<a href="<?php echo htmlspecialchars_decode(htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'), ENT_NOQUOTES); ?>">
					<?php if ($language->image) : ?>
						<?php echo JHtml::_('image', 'mod_languages/' . $language->image . '.gif', '', null, true); ?>
					<?php endif; ?>
				<?php echo $language->title_native; ?>
				</a>
				</li>
			<?php elseif ($params->get('show_active', 1)) : ?>
				<?php $base = JUri::getInstance(); ?>
				<li class="lang-active">
				<a href="<?php echo htmlspecialchars_decode(htmlspecialchars($base, ENT_QUOTES, 'UTF-8'), ENT_NOQUOTES); ?>">
					<?php if ($language->image) : ?>
						<?php echo JHtml::_('image', 'mod_languages/' . $language->image . '.gif', '', null, true); ?>
					<?php endif; ?>
				<?php echo $language->title_native; ?>
				</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	</div>
	<?php else : ?>
	<ul class="mobile_menu_vs hide <?php echo $params->get('inline', 1) ? 'lang-inline' : 'lang-block';?>">
	<?php foreach ($list as $language) : ?>
		<?php if ($params->get('show_active', 0) || !$language->active):?>
			<li class="<?php echo $language->active ? 'lang-active' : '';?>" dir="<?php echo JLanguage::getInstance($language->lang_code)->isRTL() ? 'rtl' : 'ltr' ?>">
			<a href="<?php echo $language->link;?>" >
			<?php if ($params->get('image', 1)):?>
				<div class="flag-<?php echo $language->image;?>" title="<?php echo $language->title_native;?>"></div>
			<?php else : ?>
				<?php echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef);?>
			<?php endif; ?>
			</a>
			</li>
		<?php endif;?>
	<?php endforeach;?>
	</ul>
	<ul class="dropdown-menu bigger_device_menu <?php echo $params->get('lineheight', 0) ? 'lang-block' : 'lang-inline'; ?>">
		<?php
		foreach ($list as $language) : ?>
			<?php if ($language->active) : ?>
				<li class="show">
				<a href="#" data-toggle="dropdown" class="btn dropdown-toggle show_active_language lang-opt-<?php echo $language->sef;?>">
					<?php echo strtoupper($language->sef); ?>
				</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php foreach ($list as $language) : ?>
			<?php if (!$language->active) : ?>
				<li class="no_active hide">
				<a class="btn dropdown-toggle lang-opt-<?php echo $language->sef;?>" href="<?php echo htmlspecialchars_decode(htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'), ENT_NOQUOTES); ?>">
				<?php echo strtoupper($language->sef); ?>
				</a>
				</li>
			<?php elseif ($params->get('show_active', 1)) : ?>
				<?php $base = JUri::getInstance(); ?>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
<?php endif; ?>

<?php if ($footerText) : ?>
	<div class="posttext"><p><?php echo $footerText; ?></p></div>
<?php endif; ?>
</div>
<?php
$document = JFactory::getDocument();

// Add Javascript
$document->addScriptDeclaration("(function ($) {
      $(document).ready(function () {
      	$( '.mod-languages .lang-block.dropdown-menu' ).mouseover(function() {
	  $( '.no_active' ).removeClass( 'hide' );
	});

	    $( '.mod-languages .lang-block.dropdown-menu' ).mouseleave(function() {
	  $( '.no_active' ).addClass( 'hide' );
	});
      	var ua = navigator.userAgent,
	_device = (ua.match(/iPad/i)||ua.match(/iPhone/i)||ua.match(/iPod/i)) ? 'smartphone' : 'desktop';
	if(_device == 'desktop') {
		$('.mod-languages').bind('hover', function() {
			$(this).children('.dropdown-toggle').addClass(function(){
				if($(this).hasClass('open')){
					$(this).removeClass('open');
					return '';
				}
				return 'open';
			});
			$(this).children('.dropdown-menu').stop().slideToggle(350);
		}, function(){
			$(this).children('.dropdown-menu').stop().slideToggle(350);
		});
	}else{
		$('.mod-languages .dropdown-toggle').bind('touchstart', function(){
			$('.mod-languages .dropdown-menu').stop().slideToggle(350);
		});
	}
	  });
    })(jQuery);");?>
        <style type="text/css">


</style>