<?php 

defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
	{_p('Questions')}
</div>
{if count($aQuestions)}
<form method="post" action="{url link='admincp.gradeservice.questions'}">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th style="width:10px;"><input type="checkbox" name="delete[]" value="" id="js_check_box_all" class="main_checkbox" /></th>
			<th style="width:20px;">&nbsp;</th>
			<th class="t_center" style="width:60px;">{_p('Question')}</th>
			<th>{_p('Controller')}</th>
			<th>{_p('Max rate')}</th>
			<th class="t_center" style="width:60px;">{_p('Active')}</th>
		</tr>
		{foreach from=$aQuestions key=iKey item=aItem}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}" data-sort-id="{$aItem.question_id}">
			<td><input type="checkbox" name="delete[]" class="checkbox" value="{$aItem.question_id}" id="js_id_row{$aItem.question_id}" /></td>
			<td class="t_center">
				<a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
				<div class="link_menu">
					<ul>
						<li><a class="popup" href="{url link='admincp.gradeservice.add-question' id=$aItem.question_id}">{_p('Edit')}</a></li>
						<li><a href="{url link='admincp.gradeservice.questions' delete[]=$aItem.question_id}" onclick="return confirm('{phrase var='core.are_you_sure'}');">{_p('Delete')}</a></li>
					</ul>
				</div>
			</td>
			<td class="t_center">
				{phrase var=$aItem.question}
			</td>
			<td>{$aItem.m_connection}</td>
			<td>{$aItem.max_rate}</td>
			<td class="t_center">
				<div class="js_item_is_active"{if !$aItem.is_active} style="display:none;"{/if}>
					<a href="#?call=gradeservice.setStatus&amp;id={$aItem.question_id}&amp;status=0" class="js_item_active_link" title="{_p var='Deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
				</div>
				<div class="js_item_is_not_active"{if $aItem.is_active} style="display:none;"{/if}>
					<a href="#?call=gradeservice.setStatus&amp;id={$aItem.question_id}&amp;status=1" class="js_item_active_link" title="{_p var='Activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
				</div>
			</td>
		</tr>
		{/foreach}
	</table>
	<div class="table_bottom">
		<input type="submit" value="{_p('Delete selected')}" class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true" />
	</div>
</form>
{/if}