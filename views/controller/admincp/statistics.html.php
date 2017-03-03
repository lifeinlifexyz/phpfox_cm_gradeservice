<?php 

defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aRates)}
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>{_p('Rating')}</th>
			<th>{_p('User')}</th>
			<th>{_p('Date')}</th>
		</tr>
		{foreach from=$aRates key=iKey item=aItem}
		<tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}" data-sort-id="{$aItem.question_id}">
			<td class="t_center">
				{$aItem.rating}
			</td>
			<td>{$aItem|user:'':'':30}</td>
			<td>
				{$aItem.time_stamp|convert_time}
			</td>
		</tr>
		{/foreach}
	</table>
</form>
{/if}