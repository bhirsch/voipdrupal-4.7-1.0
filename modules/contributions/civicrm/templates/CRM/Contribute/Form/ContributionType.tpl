{* this template is used for adding/editing/deleting contribution type  *}
<div class="form-item">
<fieldset><legend>{if $action eq 1}{ts}New Contribution Type{/ts}{elseif $action eq 2}{ts}Edit Contribution Type{/ts}{else}{ts}Delete Contribution Type{/ts}{/if}</legend>
  
   {if $action eq 8}
      <div class="messages status">
        <dl>
          <dt><img src="{$config->resourceBase}i/Inform.gif" alt="{ts}status{/ts}"></dt>
          <dd>    
          {ts}WARNING: Deleting this option will result in the loss of all contribution records of this type.{/ts} {ts}This may mean the loss of a substantial amount of data, and the action cannot be undone.{/ts} {ts}Do you want to continue?{/ts}
          </dd>
       </dl>
      </div>
     {else}
      <dl>
 	    <dt>{$form.name.label}</dt><dd>{$form.name.html}</dd>
    	<dt>{$form.description.label}</dt><dd>{$form.description.html}</dd>
    	<dt>{$form.accounting_code.label}</dt><dd>{$form.accounting_code.html}</dd>
        <dt>&nbsp;</dt><dd class="description">{ts}Use this field to flag contributions of this type with the corresponding code used in your accounting system. This code will be included when you export contribution data to your accounting package.{/ts}</dt>
    	<dt>{$form.is_deductible.label}</dt><dd>{$form.is_deductible.html}</dd>
        <dt>&nbsp;</dt><dd class="description">{ts}Are contributions of this type tax-deductible?{/ts}</dd>
        <dt>{$form.is_active.label}</dt><dd>{$form.is_active.html}</dd>
      </dl> 
     {/if}
    <dl>   
      <dt></dt><dd>{$form.buttons.html}</dd>
    </dl>
</fieldset>
</div>
