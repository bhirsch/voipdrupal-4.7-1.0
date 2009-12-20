{* this template is used for adding/editing tags  *}

<fieldset><legend>{ts}Tags{/ts}</legend>
    <p>
    {if $action eq 16}
        {if $permission EQ 'edit'}
            {capture assign=crmURL}{crmURL p='civicrm/contact/view/tag' q='action=update'}{/capture}
            {ts 1=$displayName 2=$crmURL}Current tags for <strong>%1</strong> are highlighted. You can add or remove tags from <a href="%2">Edit Tags</a>.{/ts}
        {else}
            {ts}Current tags are highlighted.{/ts}
        {/if}
    {else}
        {ts}Mark or unmark the checkboxes, and click 'Update Tags' to modify tags.{/ts}
    {/if}
    </p>
    
      {foreach from=$tag item="row" key = "id"}

        <div class="form-item" id ="rowid{$id}">

         {$form.tagList[$id].html} &nbsp;{$row}

        </div>

      {/foreach}

    {* Show Edit Tags link if in View mode *}
    {if $permission EQ 'edit' AND $action eq 16}
        </fieldset>
        <div class="action-link">
          <a href="{crmURL p='civicrm/contact/view/tag' q='action=update'}">&raquo; {ts}Edit Tags{/ts}</a>
        </div>
    {else}
       <div class="form-item">{$form.buttons.html}</div>
       </fieldset>
    {/if}

 <script type="text/javascript">
 {* this function is called to change the color of selected row(s) *}
    var fname = "{$form.formName}";	
    on_load_init_check(fname);
 </script>
