{* This file provides the HTML for the big add contact form *}
{* It provides the templating for Name, Demographics and Contact notes *}
{* The templating for Location and Communication preferences block has been plugged by including the Location.tpl file *}    

{* @var $form Contains the array for the form elements and other form associated information assigned to the template by the controller *}

 {* Including the javascript source code from the Individual.js *}
 <script type="text/javascript" src="{$config->resourceBase}js/Individual.js"></script>
 
 <div class="crm-submit-buttons">
    {$form.buttons.html}
 </div>

{if $contact_type eq 'Individual'}
 <div id="name">
 <fieldset><legend>{ts}Name and Greeting{/ts}</legend>
	<table class="form-layout">
    <tr>
		<td>{$form.prefix_id.label}</td>
		<td>{$form.first_name.label}</td>
		<td>{$form.middle_name.label}</td>
		<td>{$form.last_name.label}</td>
		<td>{$form.suffix_id.label}</td>
	</tr>
	<tr>
		<td>{$form.prefix_id.html}</td>
		<td>{$form.first_name.html}</td>
		<td>{$form.middle_name.html|crmReplace:class:eight}</td>
		<td>{$form.last_name.html}</td>
		<td>{$form.suffix_id.html}</td>
	</tr>
    <tr>
        <td>&nbsp;</td>
        <td>{$form.job_title.label}</td>
        <td>{$form.greeting_type.label}</td>
        <td colspan="2">{$form.nick_name.label} &nbsp; </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>{$form.job_title.html}</td>
        <td>{$form.greeting_type.html}</td>
        <td colspan="2">{$form.nick_name.html|crmReplace:class:big}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="3">{$form.home_URL.label}</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="3">{$form.home_URL.html}</td>
        <td>&nbsp;</td>
    </tr>
    </table>

    {$form._qf_Edit_refresh_dedupe.html}
    {if $isDuplicate}&nbsp;&nbsp;{$form._qf_Edit_next_duplicate.html}{/if}
    <div class="spacer"></div>
 </fieldset>
 </div>
{elseif $contact_type eq 'Household'}
<div id="name">
 <fieldset><legend>{ts}Household{/ts}</legend>
    <div class="form-item">
        <span class="labels">{$form.household_name.label}</span>
        <span class="fields">
            {$form.household_name.html|crmReplace:class:big}
        </span>
    </div>

    <div class="form-item">
        <span class="labels">{$form.nick_name.label}</span>
        <span class="fields">
            {$form.nick_name.html|crmReplace:class:big}
        </span>
    </div>

    <!-- Spacer div forces fieldset to contain floated elements -->
    <div class="spacer"></div>
 </fieldset>
 </div>
{elseif $contact_type eq 'Organization'}
<div id="name">
 <fieldset><legend>{ts}Organization{/ts}</legend>
	<table class="form-layout">
    <tr>
		<td>{$form.organization_name.label}</td>
		<td>{$form.legal_name.label}</td>
		<td>{$form.sic_code.label}</td>
    </tr>
    <tr>
        <td>{$form.organization_name.html|crmReplace:class:big}</td>
        <td>{$form.legal_name.html|crmReplace:class:big}</td>
        <td>{$form.sic_code.html}</td>
    </tr>
    <tr>
        <td>{$form.home_URL.label}</td>
		<td colspan="2">{$form.nick_name.label}</td>
	</tr>
    <tr>
        <td>{$form.home_URL.html|crmReplace:class:big}</td>
        <td colspan="2">{$form.nick_name.html|crmReplace:class:big}</td>
    </tr>
    </table>
</fieldset>
</div>
{/if}

{* Plugging the Communication preferences block *} 
 {include file="CRM/Contact/Form/CommPrefs.tpl"}
 
{* Conditionally insert any inline custom data groups *} 
{include file="CRM/Contact/Page/View/CustomData.tpl" mainEditForm=1}

{* Plugging the Location block *}
 {include file="CRM/Contact/Form/Location.tpl"}

{if $contact_type eq 'Individual'}
 <div id = "demographics[show]" class="data-group label">
    {$demographics.show}{ts}Demographics{/ts}
 </div>

 <div id="demographics">
 <fieldset><legend>{$demographics.hide}{ts}Demographics{/ts}</legend>
    <div class="form-item">
        <span class="labels">
        {$form.gender_id.label}
        </span>
        <span class="fields">
        {$form.gender_id.html}
        </span>
    </div>
	<div class="form-item">
        <span class="labels">
        {$form.birth_date.label}
        </span>
        <span class="fields">
		{$form.birth_date.html}
                <div class="description"> 
                   {include file="CRM/common/calendar/desc.tpl"}
                </div>
        </span>
        {include file="CRM/common/calendar/body.tpl" dateVar=birth_date startDate=1905 endDate=currentYear}
    </div>
	<div class="form-item">
        {$form.is_deceased.html}
        {$form.is_deceased.label}
    </div>
  </fieldset>
 </div>
{/if}  

 {******************************** ENDING THE DEMOGRAPHICS SECTION **************************************}

 {* Notes block only included for Add Contact (since it navigates from Edit form...) *}
 {if $action eq 1}
     <div id = "notes[show]" class="data-group">
        {$notes.show}<label>{ts}Notes{/ts}</label>
     </div>

     <div id = "notes">
         <fieldset><legend>{$notes.hide}{ts}Contact Notes{/ts}</legend>
            <div class="form-item">
                {$form.note.html}
            </div>
         </fieldset>
     </div>
{/if}
 <!-- End of "notes" div -->

 {* Groups and Tags block *} 
<div id="group[show]" class="data-group">
    <a href="#" onclick="hide('group[show]'); show('group'); return false;"><img src="{$config->resourceBase}i/TreePlus.gif" class="action-icon" alt="{ts}open section{/ts}"/></a><label>{ts}Tags and Groups{/ts}</label><br />
</div>

<div id="group">
    <fieldset><legend><a href="#" onclick="hide('group'); show('group[show]'); return false;"><img src="{$config->resourceBase}i/TreeMinus.gif" class="action-icon" alt="{ts}close section{/ts}"/></a>{ts}Tags and Groups{/ts}</legend>
    {strip}
    <div class="form-item">
	<table class="form-layout">
    <tr>
        <td>
        <div class="label">{ts}Group(s){/ts}</div>
        <div class="listing-box">
	{$form.group.html}
        </div>
        </td>
        <td>
        <div class="label">{ts}Tag(s){/ts}</div>
        <div class="listing-box">
	{$form.tag.html}
        </div>
        </td>
    </tr>
    </table>
    </div>
    {/strip}
    <div class="spacer"> </div>
    </fieldset>
</div>

 <div class="crm-submit-buttons">
    {$form.buttons.html}
 </div>

 <script type="text/javascript">
    var showBlocks = new Array({$showBlocks});
    var hideBlocks = new Array({$hideBlocks});

{* hide and display the appropriate blocks as directed by the php code *}
    on_load_init_blocks( showBlocks, hideBlocks );
 </script>
