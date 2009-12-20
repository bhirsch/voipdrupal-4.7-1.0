{* Export Wizard - Step 3 (map export data fields) *}

 {* WizardHeader.tpl provides visual display of steps thru the wizard as well as title for current step *}
 {include file="CRM/WizardHeader.tpl"}

<div id="help">
<p>{ts}Select the fields to be exported using the table below. For each field, first select the contact type that the field belongs to (e.g. select <strong>Individuals</strong> if you are exporting <strong>Last Name</strong>). Then select the actual field to be exported from the drop-down menu which will appear next to the contact type. Your export can include multiple types of contact records, and non-applicable fields will be empty (e.g. <strong>Last Name</strong> will not be populated for an Organization record).{/ts}</p>
<p>{ts}Click <strong>Select more fields...</strong> if you want to export more fields than are initially displayed in the table.{/ts}</p>

{if $savedMapping}
<p>{ts}Click 'Load Saved Field Mapping' to retrieve an export setup that you have previously saved.{/ts}</p>
{/if}

<p>{ts}If you want to use the same export setup in the future, check 'Save this field mapping' at the bottom of the page before continuing. You will then be able to reload this setup with a single click.{/ts}</p>
</div>

{* Table for mapping data to CRM fields *}
{include file="CRM/Contact/Form/Task/Export/table.tpl"}
<br />

<div id="crm-submit-buttons">
    {$form.buttons.html}
</div>
{$initHideBoxes}
