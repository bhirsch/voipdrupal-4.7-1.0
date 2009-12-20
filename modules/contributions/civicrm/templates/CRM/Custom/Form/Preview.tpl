{if $preview_type eq 'group'}
    {capture assign=infoMessage}{ts}Preview of the custom data group (fieldset) as it will be displayed within an edit form.{/ts}{/capture}
    {capture name=legend}
        {foreach from=$groupTree item=name}
        {$name.title}
        {/foreach}
    {/capture}
{else}
    {capture assign=infoMessage}{ts}Preview of this field as it will be displayed in an edit form.{/ts}{/capture}
{/if}
{include file="CRM/common/info.tpl"}
<div class="form-item">
{strip}

{foreach from=$groupTree item=cd_edit key=group_id}
    <p></p>
    <fieldset>{if $preview_type eq 'group'}<legend>{$smarty.capture.legend}</legend>{/if}
    {if $cd_edit.help_pre}<div class="messages help">{$cd_edit.help_pre}</div><br />{/if}
    <dl>
    {foreach from=$cd_edit.fields item=element key=field_id}
	{if $element.options_per_line}
        {assign var="element_name" value=$group_id|cat:_|cat:$field_id|cat:_|cat:$element.name}
        <dt>{$form.$element_name.label} </dt>
        <dd>
            {assign var="count" value="1"}
                <table class="form-layout-compressed">
                   {* sort by fails for option per line. Added a variable to iterate through the element array*}
                   {assign var="index" value="1"}
                   {foreach name=outer key=key item=item from=$form.$element_name}
                        {if $index < 10}
                            {assign var="index" value=`$index+1`}
                        {else}
                            <td class="labels font-light">{$form.$element_name.$key.html}</td>
                            {if $count == $element.options_per_line}
                                 </tr>
                                 <tr>
                                 {assign var="count" value="1"}
                            {else}
                                 {assign var="count" value=`$count+1`}
                            {/if}
                         {/if}
                    {/foreach}
                    </tr>
            </table>
        </dd>
        {if $element.help_post}
            <dt>&nbsp;</dt><dd class="description">{$element.help_post}</dd>
        {/if}
	{else}
        {assign var="name" value=`$element.name`} 
        {assign var="element_name" value=$group_id|cat:_|cat:$field_id|cat:_|cat:$element.name}
        <dt>{$form.$element_name.label}</dt><dd>&nbsp;{$form.$element_name.html}
	       {if $element.data_type eq 'Date'}
	        {if $element.skip_calendar NEQ true } 
                <span>
                   
		    {include file="CRM/common/calendar/desc.tpl"}
		    {include file="CRM/common/calendar/body.tpl" dateVar=$element_name startDate=1905 endDate=2010 }
		</span>
	
	        {/if}
              {/if}
        </dd>		
        {if $element.help_post}
            <dt>&nbsp;</dt><dd class="description">{$element.help_post}</dd>
        {/if}
	{/if}
    {/foreach}
    </dl>
    {if $cd_edit.help_post}<br /><div class="messages help">{$cd_edit.help_post}</div>{/if}
    </fieldset>
{/foreach}
{/strip}

<dl>
  <dt></dt><dd>{$form.buttons.html}</dd>
</dl>
</div>
