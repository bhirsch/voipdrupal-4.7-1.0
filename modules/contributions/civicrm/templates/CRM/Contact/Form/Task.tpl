{ts 1=$totalSelectedContacts}Number of selected contacts: %1{/ts}

{if $rows } 
<div class="form-item">
<table width="30%">
  <tr class="columnheader">
    <th>{ts}Name{/ts}</th>
  </tr>
{foreach from=$rows item=row}
<tr class="{cycle values="odd-row,even-row"}">
<td>{$row.displayName}</td>
</tr>
{/foreach}
</table>
</div>
{/if}
