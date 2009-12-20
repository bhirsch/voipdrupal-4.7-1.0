{* this template is used for adding/editing/deleting premium  *}
<fieldset><legend>{if $action eq 1}{ts}New Premium{/ts}{elseif $action eq 2}{ts}Edit Premium{/ts}{elseif $action eq 1024}{ts}Preview a Premium{/ts}{else}{ts}Delete Premium Product{/ts}{/if}</legend>
<div class="form-item">
  
   {if $action eq 8}
      <div class="messages status">
        <dl>
          <dt><img src="{$config->resourceBase}i/Inform.gif" alt="{ts}status{/ts}"></dt>
          <dd>    
          {ts}Are you sure you want to delete this premium? This action cannot be undone. This will also remove the premium from any contribution pages that currently include it.{/ts}
          </dd>
       </dl>
      </div>
  {elseif $action eq 1024}
     {include file="CRM/Contribute/Form/Contribution/PremiumBlock.tpl" context="previewPremium"}
  {else}  
    <dl>
 	<dt>{$form.name.label}</dt><dd>{$form.name.html}</dd>
	<dt>&nbsp;</dt><dd class="description">{ts}Name of the product as it will be displayed to contributors.{/ts}</dt>
    <dt>{$form.description.label}</dt><dd>{$form.description.html}</dd>
	<dt>{$form.sku.label}</dt><dd>{$form.sku.html}</dd>
	<dt>&nbsp;</dt><dd class="description">{ts}Optional product SKU or code. If used, this value will be included in contributor receipts.{/ts}</dt>
	
    <dt>{$form.imageOption.label}</dt>
    <dd>
    <fieldset>
    <div class="description">
        <p>{ts}A thumbnail picture of this premium will be displayed on the contribution page if you provide one. When a contributor clicks on the thumbnail, a full-size image is displayed in a pop-up window. Images must be in GIF, JPEG, or PNG format, and the full-size image may be no larger than 500 pixels wide x 500 pixels high. Thumbnails should be approximately 100 x 100 pixels.{/ts}</p>
        <p>{ts}You can upload an image from your computer OR enter a URL for an image already on the Web. If you chose to upload an image file, a 'thumbnail' version will be automatically created for you. If you don't have an image available at this time, you may also choose to display a 'No Image Available' icon - by selecting the 'default image'.{/ts}</p>
    </div>

    <table class="form-layout-compressed">
    {if $thumbnailUrl}<tr class="odd-row"><td class="describe-image" colspan="2"><strong>Current Image Thumbnail</strong><br /><img src="{$thumbnailUrl}"</td></tr>{/if} 
    <tr><td>{$form.imageOption.image.html}</td><td>{$form.uploadFile.html}</td></tr>
	<tr><td colspan="2">{$form.imageOption.thumbnail.html}</td></tr>
    <tr id="imageURL"{if $action eq 2}class="show-row" {else} class="hide-row" {/if}>
        <td class="label">{$form.imageUrl.label}</td><td>{$form.imageUrl.html|crmReplace:class:huge}</td>
    </tr>
    <tr id="thumbnailURL"{if $action eq 2}class="show-row" {else} class="hide-row" {/if}>
        <td class="label">{$form.thumbnailUrl.label}</td><td>{$form.thumbnailUrl.html|crmReplace:class:huge}</td>
    </tr>
	<tr><td colspan="2">{$form.imageOption.default_image.html}</td></tr>
	<tr><td colspan="2">{$form.imageOption.noImage.html}</td></tr>
	</table>
    </fieldset>
    </dd>

	<dt>{$form.min_contribution.label}</dt><dd>{$form.min_contribution.html}</dd>
	<dt>&nbsp;</dt><dd class="description">{ts}The minimum contribution amount required to be eligible to select this premium. If you want to offer it to all contributors regardless of contribution amount, enter '0'. If display of minimum contribution amounts is enabled then this text is displayed:{/ts} <em>{ts}(Contribute at least X to be eligible for this gift.){/ts}</em></dt>

	<dt>{$form.price.label}</dt><dd>{$form.price.html}</dd>
	<dt>&nbsp;</dt><dd class="description">{ts}The market value of this premium (e.g. retail price). For tax-deductible contributions, this amount will be used to set the non-deductible amount in the contribution record and receipt.{/ts}</dt>
	<dt>{$form.cost.label}</dt><dd>{$form.cost.html}</dd>
	<dt>&nbsp;</dt><dd class="description">{ts}You may optionally record the actual cost of this product to your organization. This may be useful when evaluating net return for this incentive.{/ts}</dt>
	<dt>{$form.options.label}</dt><dd>{$form.options.html}</dd>
	<dt>&nbsp;</dt><dd class="description">{ts}Enter a comma-delimited list of color, size, etc. options for the product if applicable. Contributors will be presented a drop-down menu of these options when they select this product.{/ts}</dt>
    <dt>{$form.is_active.label}</dt><dd>{$form.is_active.html}</dd>
    </dl>

	<div id="time-delimited[show]" class="data-group-first">
        <a href="#" onclick="hide('time-delimited[show]'); show('time-delimited'); return false;"><img src="{$config->resourceBase}i/TreePlus.gif" class="action-icon" alt="{ts}open section{/ts}"/></a><label>{ts}Subscription, Membership or Service Settings{/ts}</label><br />
	</div>	

	<div id="time-delimited">
    <fieldset><legend><a href="#" onclick="hide('time-delimited'); show('time-delimited[show]'); return false;"><img src="{$config->resourceBase}i/TreeMinus.gif" class="action-icon" alt="{ts}close section{/ts}"/></a>{ts}Subscription, Membership or Service Settings{/ts}</legend>
    <dl>
	<dt>{$form.period_type.label}</dt><dd>{$form.period_type.html}</dd>
	<dt>&nbsp;</dt><dd class="description">{ts}Select 'Rolling' if the subscription or membership starts on the current day. Select 'Fixed' if the start date is a fixed month and day within the current year (set this value in the next field).{/ts}</dt>
 
	<dt>{$form.fixed_period_start_day.label}</dt><dd>{$form.fixed_period_start_day.html}</dd>
        <dt>&nbsp;</dt><dd class="description">{ts}Month and day (MMDD) on which a fixed period subscription or membership will start. EXAMPLE: A fixed period membership with Start Day set to 0101 means that the membership period would be 1/1/06 - 12/31/06 for anyone signing up during 2006.{/ts}</dt>

	<dt>{$form.duration_interval.label}</dt><dd>{$form.duration_interval.html} &nbsp; {$form.duration_unit.html}</dd>
        <dt>&nbsp;</dt><dd class="description">{ts}Duration of subscription, membership or service (e.g. 12-month subscription).{/ts}</dt>

	<dt>{$form.frequency_interval.label}</dt><dd>{$form.frequency_interval.html} &nbsp; {$form.frequency_unit.html}</dd>
        <dt>&nbsp;</dt><dd class="description">{ts}Frequency of subscription, membership, or service (e.g. journal delivered every two months).{/ts}</dt>
    </dl>
    </fieldset>
	</div>
 {/if}
</div>
</fieldset>
<div id="crm-submit-buttons">
    {$form.buttons.html}
</div>

{if $action eq 1 or $action eq 2 }		 

<script type="text/javascript">
var myElement1 = document.getElementById('time-delimited');
var myElement2 = document.getElementById('time-delimited[show]');

{if $showSubscriptions }
  myElement1.style.display = 'block';
  myElement2.style.display = 'none';    
{else}
  myElement1.style.display = 'none';
  myElement2.style.display = 'block';  
{/if}
{literal}

function add_upload_file_block(parms) {
	if (parms =='thumbnail') {
	      
          document.getElementById("imageURL").style.display="table-row";                    
	      document.getElementById("thumbnailURL").style.display="table-row";
	   
	} else {

	      document.getElementById("imageURL").style.display="none";    
	      document.getElementById("thumbnailURL").style.display="none";
	   	
	}	
}

function select_option() {
    
}

function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=640,height=420,left = 202,top = 184');");
}

{/literal}
</script>

{/if}
