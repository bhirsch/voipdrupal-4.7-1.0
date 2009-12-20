{if $action eq 1 or $action eq 2 or $action eq 8} {* add, update or view *}              
    {include file="CRM/Contribute/Form/Contribution.tpl"}
{elseif $action eq 4}
    {include file="CRM/Contribute/Form/ContributionView.tpl"}
{else}
{capture assign=newContribURL}{crmURL p="civicrm/contact/view/contribution" q="reset=1&action=add&cid=`$contactId`&context=contribution"}{/capture}
<div id="help">
<p>{ts 1=$newContribURL}This page lists all contributions received from {$display_name} since inception.
Click <a href="%1">New Contribution</a> to record a new offline contribution for this contact.{/ts}.
</div>

{if $rows}
    {include file="CRM/Contribute/Page/ContributionTotals.tpl"}
    <p> </p>
    {include file="CRM/Contribute/Form/Selector.tpl"}
    
    {if $action eq 16}
    <div class="action-link">
    <a href="{$newContribURL}">&raquo; {ts}New Contribution{/ts}</a>
    </div>
    {/if}

{else}
   <div class="messages status">
       <dl>
       <dt><img src="{$config->resourceBase}i/Inform.gif" alt="{ts}status{/ts}"></dt>
       <dd>
            {if $permission EQ 'edit'}
                {ts 1=$newContribURL}There are no contributions recorded for this contact. You can <a href="%1">enter one now</a>.{/ts}
            {else}
                {ts}There are no contributions recorded for this contact.{/ts}
            {/if}
       </dd>
       </dl>
  </div>
{/if}

{/if}
