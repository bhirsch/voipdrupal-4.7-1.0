{if $action eq 2}
  {include file="CRM/Contact/Form/Edit.tpl"}
{else}
{* View Contact Summary *}
<div id="name" class="data-group">
   <div>
    <label>{$displayName}</label>
    {if $contact_type eq 'Individual' && $job_title}&nbsp;&nbsp;{ts}Job Title{/ts}:&nbsp;{$job_title}
    {elseif $home_URL}&nbsp; &nbsp; <a href="{$home_URL}" target="_blank">{$home_URL}</a>{/if}
    {if $permission EQ 'edit'}
        &nbsp; &nbsp; <input type="button" value="{ts}Edit{/ts}" name="edit_contact_info" onclick="window.location='{crmURL p='civicrm/contact/view' q="reset=1&action=update&cid=$contactId"}';"/>
    {/if}
    &nbsp; &nbsp; <input type="button" value="{ts}vCard{/ts}" name="vCard_export" onclick="window.location='{crmURL p='civicrm/contact/view/vcard' q="reset=1&cid=$contactId"}';"/>
    {if $permission EQ 'edit'}
        &nbsp; &nbsp; <input type="button" value="{ts}Delete{/ts}" name="contact_delete" onclick="window.location='{crmURL p='civicrm/contact/view/delete' q="reset=1&delete=1&cid=$contactId"}';"/>
    {/if}
    {if $url } &nbsp; &nbsp; <a href="{$url}">&raquo; {ts}View User Record{/ts}</a> {/if}
    {if $contactTag}<br />{ts}Tags{/ts}:&nbsp;{$contactTag}{/if}
   </div>
</div>

{* Include links to enter Activities if session has 'edit' permission *}

{if $permission EQ 'edit'}
    {include file="CRM/Contact/Page/View/ActivityLinks.tpl"}
{/if}

{* Display populated Locations. Primary location expanded by default. *}
{foreach from=$location item=loc key=locationIndex}

 <div id="location[{$locationIndex}][show]" class="data-group">
  <a href="#" onclick="hide('location[{$locationIndex}][show]'); show('location[{$locationIndex}]'); return false;"><img src="{$config->resourceBase}i/TreePlus.gif" class="action-icon" alt="{ts}open section{/ts}"/></a><label>{$loc.location_type}{if $loc.name} - {$loc.name}{/if}{if $locationIndex eq 1} {ts}(primary location){/ts}{/if}</label>
  {if $preferred_communication_method eq 'Email'}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label>{ts}Preferred Email:{/ts}</label> {$loc.email.1.email}
  {elseif $preferred_communication_method eq 'Phone'}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label>{ts}Preferred Phone:{/ts}</label> {$loc.phone.1.phone}{/if}
 </div>

 <div id="location[{$locationIndex}]">
  <fieldset>
   <legend{if $locationIndex eq 1} class="label"{/if}>
    <a href="#" onclick="hide('location[{$locationIndex}]'); show('location[{$locationIndex}][show]'); return false;"><img src="{$config->resourceBase}i/TreeMinus.gif" class="action-icon" alt="{ts}close section{/ts}"/></a>{$loc.location_type}{if $loc.name} - {$loc.name}{/if}{if $locationIndex eq 1} {ts}(primary location){/ts}{/if}
   </legend>

  <div class="col1">
   {foreach from=$loc.phone item=phone}
     {if $phone.phone}
        {if $phone.is_primary eq 1}<strong>{/if}
        {if $phone.phone_type}{$phone.phone_type_display}:{/if} {$phone.phone}
        {if $phone.is_primary eq 1}</strong>{/if}
        <br />
     {/if}
   {/foreach}

   {foreach from=$loc.email item=email}
      {if $email.email}
        {if $email.is_primary eq 1}<strong>{/if}
        {ts}Email:{/ts} {$email.email}
        {if $email.is_primary eq 1}</strong>{/if}
        <br />
      {/if}
   {/foreach}

   {foreach from=$loc.im item=im key=imKey}
     {if $im.name or $im.provider}
        {if $im.is_primary eq 1}<strong>{/if}
        {ts}Instant Messenger:{/ts} {if $im.name}{$im.name}{/if} {if $im.provider}( {$im.provider} ) {/if}
        {if $im.is_primary eq 1}</strong>{/if}
        <br />
     {/if}
   {/foreach}
   </div>

   <div class="col2">

    {*if $config->mapAPIKey AND $loc.is_primary AND $loc.address.geo_code_1 AND $loc.address.geo_code_2*}
    {if $config->mapAPIKey AND $loc.address.geo_code_1 AND $loc.address.geo_code_2}
        <a href="{crmURL p='civicrm/contact/search/map' q="reset=1&cid=$contactId&lid=`$loc.address.location_id`"}" title="{ts}Map Primary Address{/ts}">{ts}Map this Address{/ts}</a><br />
    {/if}
    {$loc.address.display|nl2br}
  </div>
  <div class="spacer"></div>
  </fieldset>
 </div>
{/foreach}

 <div id="commPrefs[show]" class="data-group">
  <a href="#" onclick="hide('commPrefs[show]'); show('commPrefs'); return false;"><img src="{$config->resourceBase}i/TreePlus.gif" class="action-icon" alt="{ts}open section{/ts}"/></a><label>{ts}Communications Preferences{/ts}</label><br />
 </div>

<div id="commPrefs">
 <fieldset>
  <legend><a href="#" onclick="hide('commPrefs'); show('commPrefs[show]'); return false;"><img src="{$config->resourceBase}i/TreeMinus.gif" class="action-icon" alt="{ts}close section{/ts}"/></a>{ts}Communications Preferences{/ts}</legend>
  <div class="col1">
    <label>{ts}Privacy:{/ts}</label>
    <span class="font-red upper">
    {foreach from=$privacy item=privacy_val key=privacy_label}
      {if $privacy_val eq 1}{$privacy_values.$privacy_label} &nbsp; {/if}
    {/foreach}
    {if $is_opt_out}
      {ts}DO NOT SEND BULK EMAIL{/ts}
    {/if}
    </span>
  </div>
  <div class="col2">
    <label>{ts}Communication Preference:{/ts}</label> {$preferred_communication_method_display}
  </div>
  <div class="col2">
    <label>{ts}Mail Format Preference:{/ts}</label> {$preferred_mail_format_display}
  </div>
  <div class="spacer"></div>
 </fieldset>
</div>

{* Display only those custom groups having style as Inline*}
 <div>
    {include file="CRM/Contact/Page/View/InlineCustomData.tpl"}
 </div>

 {if $contact_type eq 'Individual'}
 <div id="demographics[show]" class="data-group">
  <a href="#" onclick="hide('demographics[show]'); show('demographics'); return false;"><img src="{$config->resourceBase}i/TreePlus.gif" class="action-icon" alt="{ts}open section{/ts}"/></a><label>{ts}Demographics{/ts}</label><br />
 </div>

 <div id="demographics">
  <fieldset>
   <legend><a href="#" onclick="hide('demographics'); show('demographics[show]'); return false;"><img src="{$config->resourceBase}i/TreeMinus.gif" class="action-icon" alt="{ts}close section{/ts}"/></a>{ts}Demographics{/ts}</legend>
   <div class="col1">
    <label>{ts}Gender:{/ts}</label> {$gender_display}<br />
    {if $is_deceased eq 1}
        <label>{ts}Contact is Deceased{/ts}</label>
    {/if}
   </div>
   <div class="col2">
    <label>{ts}Date of Birth:{/ts}</label> {$birth_date|crmDate}
   </div>
   <div class="spacer"></div>
  </fieldset>
 </div>
 {/if}

{* Show Contributions block if CiviContribute is enabled *}
{if $accessContribution}
    {capture assign=newContribURL}{crmURL p="civicrm/contact/view/contribution" q="reset=1&action=add&cid=`$contactId`&context=contribution"}{/capture}
<div id="contributions[show]" class="data-group">
  {if $pager->_totalItems}
    <dl><dt><a href="#" onclick="hide('contributions[show]'); show('contributions'); return false;"><img src="{$config->resourceBase}i/TreePlus.gif" class="action-icon" alt="{ts}open section{/ts}"/></a><label>{ts}Contributions{/ts}</label></dt>
    <dd><strong>{ts}Total Contributed{/ts} - {if $total_amount}{$total_amount|crmMoney}{else}n/a{/if}
        &nbsp; {ts}# Contributions{/ts} - {$pager->_totalItems}</strong></dd>
    </dl>
  {else}
    <dl><dt>{ts}Contributions{/ts}</dt>
    {if $permission EQ 'edit'}
        <dd>{ts 1=$newContribURL}There are no contributions recorded for this contact. You can <a href="%1">enter one now</a>.{/ts}</dd>
    {else}
        {ts}There are no contributions recorded for this contact.{/ts}
    {/if}
    </dl>
  {/if}
</div>

    <div id="contributions">
    {if $pager->_totalItems}
        <fieldset><legend><a href="#" onclick="hide('contributions'); show('contributions[show]'); return false;"><img src="{$config->resourceBase}i/TreeMinus.gif" class="action-icon" alt="{ts}close section{/ts}"/></a>{if $pager->_totalItems GT 3}{ts 1=$pager->_totalItems}Contributions (3 of %1){/ts}{else}{ts}Contributions{/ts}{/if}</legend>
        {include file="CRM/Contribute/Page/ContributionTotals.tpl"}
        <p>
        {include file="CRM/Contribute/Form/Selector.tpl" context="Contact Summary"}       
        </p>
        
        <div class="action-link">
            <a href="{$newContribURL}">&raquo; {ts}New Contribution{/ts}</a> 
        </div>
        </fieldset>
    {/if}
    </div>
{/if}

<div id="openActivities[show]" class="data-group">
  {if $openActivity.totalCount}
    <a href="#" onclick="hide('openActivities[show]'); show('openActivities'); return false;"><img src="{$config->resourceBase}i/TreePlus.gif" class="action-icon" alt="{ts}open section{/ts}"/></a><label>{ts}Open Activities{/ts}</label> ({$openActivity.totalCount})<br />
  {else}
    <dl><dt>{ts}Open Activities{/ts}</dt>
    {if $permission EQ 'edit'}
        {capture assign=mtgURL}{crmURL p='civicrm/contact/view/activity' q="activity_id=1&action=add&reset=1&cid=$contactId"}{/capture}
        {capture assign=callURL}{crmURL p='civicrm/contact/view/activity' q="activity_id=2&action=add&reset=1&cid=$contactId"}{/capture}
        <dd>{ts 1=$mtgURL 2=$callURL}No open activities. You can schedule a <a href="%1">meeting</a> or a <a href="%2">call</a>.{/ts}</dd>
    {else}
        {ts}There are no open activities for this contact.{/ts}
    {/if}
    </dl>
  {/if}
</div>

<div id="openActivities">
 <fieldset><legend><a href="#" onclick="hide('openActivities'); show('openActivities[show]'); return false;"><img src="{$config->resourceBase}i/TreeMinus.gif" class="action-icon" alt="{ts}close section{/ts}"/></a>{if $openActivity.totalCount GT 3}{ts 1=$openActivity.totalCount}Open Activities (3 of %1){/ts}{else}{ts}Open Activities{/ts}{/if}</legend>
	{strip}
	<table>
        <tr class="columnheader">
		<th>{ts}Activity Type{/ts}</th>
		<th>{ts}Subject{/ts}</th>
        <th>{ts}Created By{/ts}</th>
        <th>{ts}With{/ts}</th>
		<th>{ts}Scheduled Date{/ts}</th><th></th>
	</tr>
    {foreach from=$openActivity.data item=row}
        <tr class="{cycle values="odd-row,even-row"}">
           <tr class="{cycle values="odd-row,even-row"}">
             <td>{$row.activity_type}</td>
             <td>
               <a href="{crmURL p='civicrm/contact/view/activity' q="activity_id=`$row.activity_type_id`&action=view&id=`$row.id`&cid=$contactId&history=0"}">{$row.subject|mb_truncate:33:"...":true}</a>
             </td>
             <td>
             {if $contactId  NEQ $row.sourceID} 
                <a href="{crmURL p='civicrm/contact/view' q="reset=1&cid=`$row.sourceID`"}">{$row.sourceName}</a>
             {else}
                {$row.sourceName}
             {/if}			
             </td>
             <td>
                {if $$contactId NEQ $row.targetID and $contactId  EQ $row.sourceID }
                    <a href="{crmURL p='civicrm/contact/view' q="reset=1&cid=`$row.targetID`"}">{$row.targetName}</a>
                {else}
                    {$row.targetName} 
                {/if}	
             </td>
             <td>{$row.date|crmDate}</td>
             <td>
                {if $permission EQ 'edit'}
                    <a href="{crmURL p='civicrm/contact/view/activity' q="activity_id=`$row.activity_type_id`&action=update&id=`$row.id`&cid=$contactId&history=0"}">{ts}Edit{/ts}</a>
                {else}
                    <a href="{crmURL p='civicrm/contact/view/activity' q="activity_id=`$row.activity_type_id`&action=view&id=`$row.id`&cid=$contactId&history=0"}">{ts}Details{/ts}</a>
                {/if}
             </td>
           </tr>
    {/foreach}
    {if $openActivity.totalCount gt 3 }
        <tr class="even-row"><td colspan="7"><a href="{crmURL p='civicrm/contact/view/activity' q="show=1&action=browse&cid=$contactId"}">&raquo; {ts}View All Open Activities...{/ts}</a></td></tr>
    {/if}
    </table>
	{/strip}
 </fieldset>
</div>

<div id="activityHx[show]" class="data-group">
  {if $activity.totalCount}
    <a href="#" onclick="hide('activityHx[show]'); show('activityHx'); return false;"><img src="{$config->resourceBase}i/TreePlus.gif" class="action-icon" alt="{ts}open section{/ts}"/></a><label>{ts}Activity History{/ts}</label> ({$activity.totalCount})<br />
  {else}
    <dl><dt>{ts}Activity History{/ts}</dt><dd>{ts}No activity history.{/ts}</dd></dl>
  {/if}
</div>

<div id="activityHx">
 <fieldset><legend><a href="#" onclick="hide('activityHx'); show('activityHx[show]'); return false;"><img src="{$config->resourceBase}i/TreeMinus.gif" class="action-icon" alt="{ts}close section{/ts}"/></a>{if $activity.totalCount GT 3}{ts 1=$activity.totalCount}Activity History (3 of %1){/ts}{else}{ts}Activity History{/ts}{/if}</legend>
	{strip}
	<table>
        <tr class="columnheader">
		<th>{ts}Activity Type{/ts}</th>
		<th>{ts}Description{/ts}</th>
		<th>{ts}Activity Date{/ts}</th>
		<th></th>
	</tr>
    {foreach from=$activity.data item=row}
        <tr class="{cycle values="odd-row,even-row"}">
        	<td>{$row.activity_type}</td>
	    	<td>{$row.activity_summary}</td>	
            <td>{$row.activity_date|crmDate}</td>
	{if $row.callback}
            <td><a href="{crmURL p='civicrm/history/activity/detail' q="id=`$row.id`&activity_id=`$row.activity_id`&cid=`$contactId`"}">{ts}Details{/ts}</a></td>
	{else} <td></td>
	{/if}
	
        </tr>
    {/foreach}
    {if $activity.totalCount gt 3 }
        <tr class="even-row"><td colspan="7"><a href="{crmURL p='civicrm/contact/view/activity' q="show=1&action=browse&history=true&cid=$contactId"}">&raquo; {ts}View All Activity History...{/ts}</a></td></tr>
    {/if}
    </table>
	{/strip}
 </fieldset>
</div>

<div id="relationships[show]" class="data-group">
  {if $relationship.totalCount}
    <a href="#" onclick="hide('relationships[show]'); show('relationships'); return false;"><img src="{$config->resourceBase}i/TreePlus.gif" class="action-icon" alt="{ts}open section{/ts}"/></a><label>{ts}Relationships{/ts}</label> ({$relationship.totalCount})<br />
  {else}
    <dl><dt>{ts}Relationships{/ts}</dt>
    <dd>
        {if $permission EQ 'edit'}
            {capture assign=crmURL}{crmURL p='civicrm/contact/view/rel' q="action=add&cid=$contactId"}{/capture}{ts 1=$crmURL}No relationships. You can <a href="%1">create a new relationship</a>.{/ts}
        {else}
            {ts}There are no Relationships entered for this contact.{/ts}
        {/if}
    </dd>
    </dl>
  {/if}
</div>

{* Relationships block display property is always hidden (non) if there are no relationships *}
<div id="relationships">
 {if $relationship.totalCount}
 <fieldset><legend><a href="#" onclick="hide('relationships'); show('relationships[show]'); return false;"><img src="{$config->resourceBase}i/TreeMinus.gif" class="action-icon" alt="{ts}close section{/ts}"/></a>{if $relationship.totalCount GT 3}{ts 1=$relationship.totalCount}Relationships (3 of %1){/ts}{else}{ts}Relationships{/ts}{/if}</legend>
    {strip}
        <table>
        <tr class="columnheader">
            <th>{ts}Relationship{/ts}</th>
            <th></th>
            <th>{ts}City{/ts}</th>
            <th>{ts}State{/ts}</th>
            <th>{ts}Email{/ts}</th>
            <th>{ts}Phone{/ts}</th>
            <th>&nbsp;</th>
        </tr>

        {foreach from=$relationship.data item=rel}
          {*assign var = "rtype" value = "" }
              {if $rel.contact_a > 0 }
            {assign var = "rtype" value = "b_a" }
          {else}	  
            {assign var = "rtype" value = "a_b" }
          {/if*}
            <tr class="{cycle values="odd-row,even-row"}">
                <td class="label"><a href="{crmURL p='civicrm/contact/view/rel' q="action=view&reset=1&cid=`$contactId`&id=`$rel.id`&rtype=`$rel.rtype`"}">{$rel.relation}</a></td>
                <td><a href="{crmURL p='civicrm/contact/view' q="reset=1&cid=`$rel.cid`"}">{$rel.name}</a></td>
                <td>{$rel.city}</td>
                <td>{$rel.state}</td>
                <td>{$rel.email}</td>
                <td>{$rel.phone}</td>
                <td>
                    {if $permission EQ 'edit'}<a href="{crmURL p='civicrm/contact/view/rel' q="rid=`$rel.id`&action=update&rtype=`$rel.rtype`&cid=$contactId"}">{ts}Edit{/ts}</a>{/if}
                </td>
            </tr>  
        {/foreach}
        {if $relationship.totalCount gt 3 }
            <tr class="even-row"><td colspan="7"><a href="{crmURL p='civicrm/contact/view/rel' q="action=browse&cid=$contactId"}">&raquo; {ts}View All Relationships...{/ts}</a></td></tr>
        {/if}
        </table>
	{/strip}
   {if $permission EQ 'edit'}
   <div class="action-link">
       <a href="{crmURL p='civicrm/contact/view/rel' q="action=add&cid=$contactId"}">&raquo; {ts}New Relationship{/ts}</a>
   </div>
   {/if}
 </fieldset>
 {/if}
</div>

<div id="groups[show]" class="data-group">
  {if $group.totalCount}
    <a href="#" onclick="hide('groups[show]'); show('groups'); return false;"><img src="{$config->resourceBase}i/TreePlus.gif" class="action-icon" alt="{ts}open section{/ts}"/></a><label>{ts}Group Memberships{/ts}</label> ({$group.totalCount})<br />
  {else}
    <dl><dt>{ts}Group Memberships{/ts}</dt>
    <dd>
        {if $permission EQ 'edit'}
            {capture assign=crmURL}{crmURL p='civicrm/contact/view/group' q="action=add&cid=$contactId"}{/capture}{ts 1=$crmURL 2=$display_name}No current group memberships. You can <a href="%1">add %2 to a group</a>.{/ts}
        {else}
            {ts}No current group memberships.{/ts}
        {/if}
    </dd>
    </dl>
  {/if}
</div>

<div id="groups">
 <fieldset><legend><a href="#" onclick="hide('groups'); show('groups[show]'); return false;"><img src="{$config->resourceBase}i/TreeMinus.gif" class="action-icon" alt="{ts}close section{/ts}"/></a>{if $group.totalCount GT 3}{ts 1=$group.totalCount}Group Memberships (3 of %1){/ts}{else}{ts}Group Memberships{/ts}{/if}</legend>
	{strip}
	<table>
        <tr class="columnheader">
		<th>{ts}Group{/ts}</th>
		<th>{ts}Status{/ts}</th>
		<th>{ts}Date Added{/ts}</th>
	</tr>
    {foreach from=$group.data item=row}
        <tr class="{cycle values="odd-row,even-row"}">
        	<td><a href="{crmURL p='civicrm/group/search' q="reset=1&force=1&context=smog&gid=`$row.group_id`"}">{$row.title}</a></td>
	    	<td>{ts 1=$row.in_method}Added (by %1){/ts}</td> 
            <td>{$row.in_date|crmDate}</td>
        </tr>
    {/foreach}
    {if $group.totalCount gt 3 }
        <tr class="even-row"><td colspan="7"><a href="{crmURL p='civicrm/contact/view/group' q="action=browse&cid=$contactId"}">&raquo; {ts}View All Group Memberships...{/ts}</a></td></tr>
    {/if}
    </table>
	{/strip}
   {if $permission EQ 'edit'}
   <div class="action-link">
       <a href="{crmURL p='civicrm/contact/view/group' q="reset=1&action=add&cid=$contactId"}">&raquo; {ts}New Group Membership{/ts}</a>
   </div>
   {/if}
 </fieldset>
</div>

<div id="notes[show]" class="data-group">
  {if $noteTotalCount}
    <a href="#" onclick="hide('notes[show]'); show('notes'); return false;"><img src="{$config->resourceBase}i/TreePlus.gif" class="action-icon" alt="{ts}open section{/ts}"/></a><label>{ts}Notes{/ts}</label> ({$noteTotalCount})<br />
  {else}
    <dl><dt>{ts}Notes{/ts}</dt>
    <dd>
        {if $permission EQ 'edit'}
            {capture assign=crmURL}{crmURL p='civicrm/contact/view/note' q="action=add&cid=$contactId"}{/capture}{ts 1=$crmURL}There are no Notes. You can <a href="%1">enter notes</a> about this contact.{/ts}
        {else}
            {ts}There are no Notes for this contact.{/ts}
        {/if}
    </dd>
    </dl>
  {/if}
</div>

<div id="notes">
{if $note}
  <fieldset><legend><a href="#" onclick="hide('notes'); show('notes[show]'); return false;"><img src="{$config->resourceBase}i/TreeMinus.gif" class="action-icon" alt="{ts}close section{/ts}"/></a>{if $noteTotalCount GT 3}{ts 1=$noteTotalCount}Notes (3 of %1){/ts}{else}{ts}Notes{/ts}{/if}</legend>
       {strip}
       <table>
       <tr class="columnheader">
    	<th>{ts}Note{/ts}</th>
	    <th>{ts}Date{/ts}</th>
	    <th></th>
       </tr>
       {foreach from=$note item=note}
       <tr class="{cycle values="odd-row,even-row"}">
            <td>
                {$note.note|mb_truncate:80:"...":true}
                {* Include '(more)' link to view entire note if it has been truncated *}
                {assign var="noteSize" value=$note.note|count_characters:true}
                {if $noteSize GT 80}
                    <a href="{crmURL p='civicrm/contact/view/note' q="id=`$note.id`&action=view&cid=$contactId"}">{ts}(more){/ts}</a>
                {/if}
            </td>
            <td>{$note.modified_date|crmDate}</td>
            <td>
                {if $permission EQ 'edit'}<a href="{crmURL p='civicrm/contact/view/note' q="id=`$note.id`&action=update&cid=$contactId"}">{ts}Edit{/ts}</a>{/if}
            </td> 
       </tr>  
       {/foreach}
       {if $noteTotalCount gt 3 }
            <tr class="even-row"><td colspan="7"><a href="{crmURL p='civicrm/contact/view/note' q="action=browse&cid=$contactId"}">&raquo; {ts}View All Notes...{/ts}</a></td></tr>
       {/if}
       </table>
       {/strip}
       {if $permission EQ 'edit'}
       <div class="action-link">
         <a href="{crmURL p='civicrm/contact/view/note' q="action=add&cid=$contactId"}">&raquo; {ts}New Note{/ts}</a>
       </div>
       {/if}
 </fieldset>
{/if}
</div> <!-- End of Notes block -->

 <script type="text/javascript">
    var showBlocks = new Array({$showBlocks});
    var hideBlocks = new Array({$hideBlocks});

{* hide and display the appropriate blocks as directed by the php code *}
    on_load_init_blocks( showBlocks, hideBlocks );
 </script>

{/if}
