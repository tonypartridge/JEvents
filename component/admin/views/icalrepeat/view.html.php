<?php
/**
 * JEvents Component for Joomla 1.5.x
 *
 * @version     $Id: view.html.php 2749 2011-10-13 08:54:34Z geraintedwards $
 * @package     JEvents
 * @copyright   Copyright (C)  2008-2015 GWE Systems Ltd
 * @license     GNU/GPLv2, see http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.jevents.net
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
 * HTML View class for the component
 *
 * @static
 */
class AdminIcalrepeatViewIcalrepeat extends JEventsAbstractView
{

	function overview($tpl = null)
	{

		$document = JFactory::getDocument();
		$document->setTitle(JText::_('ICAL_EVENT_REPEATS'));

		// Set toolbar items for the page
		JToolBarHelper::title(JText::_('ICAL_EVENT_REPEATS'), 'jevents');

		JToolBarHelper::editList('icalrepeat.edit');
		JToolBarHelper::deleteList('Delete this repeat?', 'icalrepeat.delete');
		JToolBarHelper::cancel('icalevent.list');
				
		$params = JComponentHelper::getParams(JEV_COM_COMPONENT);
		JEventsHelper::addSubmenu();

		JHTML::_('behavior.tooltip');

		if (JevJoomlaVersion::isCompatible("3.0")){
			$this->sidebar = JHtmlSidebar::render();					
		}
	}

	function edit($tpl = null)
	{
		$document = JFactory::getDocument();
		include(JEV_ADMINLIBS . "editStrings.php");
		$document->addScriptDeclaration($editStrings);

		JEVHelper::script('editical.js', 'components/' . JEV_COM_COMPONENT . '/assets/js/');
		JEVHelper::script('view_detail.js', 'components/' . JEV_COM_COMPONENT . '/assets/js/');
                  JEVHelper::script('JevStdRequiredFields.js', 'components/' . JEV_COM_COMPONENT . '/assets/js/');

		$document->setTitle(JText::_('EDIT_ICAL_REPEAT'));

		// Set toolbar items for the page
		JToolBarHelper::title(JText::_('EDIT_ICAL_REPEAT'), 'jevents');

		JToolBarHelper::apply('icalrepeat.apply', "JEV_SAVE");
		$this->addSaveToolBarButton();
		//$this->addCancelToolBarButton();

		JToolBarHelper::cancel('icalrepeat.list');
		//JToolBarHelper::help( 'screen.icalrepeat.edit', true);

		$params = JComponentHelper::getParams(JEV_COM_COMPONENT);
		//$section = $params->get("section",0);

		JHTML::_('behavior.tooltip');
		
                if (JevJoomlaVersion::isCompatible("3.0")){
			// load Joomla javascript classes
			JHTML::_('behavior.core');
			$this->setLayout("edit");
                }
                else {
                    $this->setLayout("edit16");
                }		

		$this->setupEditForm();

	}

	function addSaveToolBarButton()
	{

		$toolbar =  JToolBar::getInstance('toolbar');

		// Add a standard button
		//$bar->appendButton( 'Standard', $icon, $alt, $task, $listSelect, $x );

		$buttontext = JText::_('JEV_SAVE_CLOSE');
		$buttonhtml = '<button onclick="javascript:return clickIcalSaveButton();" class="btn btn-small">
		<span class="icon-save" title="' . $buttontext . '"></span>' . $buttontext . '</button><div style="position:relative;clear:both;">';
		$submitbutton = "Joomla.submitbutton";

		ob_start();
		?>
		<div id="action_dialog"  style="position:absolute;right:0px;background-color:#eeeeee;border:solid 1px #000000;padding:16px;visibility:hidden">
			<div style="width:16px!important;float:right;font-size:10px;background-color:#ffffff;border:solid #000000;border-width:0 0 1px 1px;text-align:center;margin:-16px;">
				<a href="javascript:void(0)" onclick="closedialog()" style="font-weight:bold;text-decoration:none;color:#000000;border-width:0;">x</a>
			</div>

			<?php
			$buttontext = JText::_('JEV_SAVE_THIS');
			$buttontask = "icalrepeat.save";
			?>
			<div><button onclick="javascript:<?php echo $submitbutton; ?>('<?php echo $buttontask; ?>');return false;" class="btn btn-small"><span class="icon-save" style='margin:0px' title="<?php echo strip_tags($buttontext); ?>"></span><?php echo $buttontext; ?></button></div>

			<?php
			/*
			  $buttontext = JText::_( 'JEV_SAVE_FUTURE' );
			  $buttontask = "icalrepeat.savefuture";
			  <div><a href="#" onclick="javascript:return submitbutton('<?php echo $buttontask;?>')" class="toolbar"><span class="icon-32-save" style='margin:0px' title="<?php echo strip_tags($buttontext);?>"></span><?php echo $buttontext;?></a></div>
			 */
			?>

			<?php
			$buttontext = JText::_('JEV_SAVE_ALL');
			$buttontask = "icalevent.save";
			?>
			<div><button onclick="javascript:<?php echo $submitbutton; ?>('<?php echo $buttontask; ?>');return false;" class="btn btn-small"><span class="icon-save" style='margin:0px' title="<?php echo strip_tags($buttontext); ?>"></span><?php echo $buttontext; ?></button></div>

		</div>

		</div>
		<?php
		$html = $buttonhtml . ob_get_clean();
		$toolbar->appendButton('Custom', $html, "customsave");

	}

	function addCancelToolBarButton()
	{

		$toolbar =  JToolBar::getInstance('toolbar');
		$submitbutton = "Joomla.submitbutton";
		$html = '<button class="btn btn-small" onclick="javascript: '.$submitbutton.'(\'icalrepeat.detail\');return false;" ><span class="icon-cancel" title="Cancel"> </span>' . JText::_('JEV_CANCEL') . '</button>';
		$toolbar->appendButton('Custom', $html, "customcancel");

	}

}
