{* No matches for submitted search request. *}
<div class="messages status">
  <dl>
    <dt><img src="{$config->resourceBase}i/Inform.gif" alt="{ts}status{/ts}" /></dt>
    <dd>
        {if $qill}{ts}No matches found for:{/ts}
            <ul>
            {foreach from=$qill item=criteria}
                <li>{$criteria}</li>
            {/foreach}
            </ul>
        {else}
            {ts}No matching contributions found.{/ts}
        {/if}
        <br />
        {ts}Suggestions:{/ts}
        <ul>
        <li>{ts}if you are searching by contributor name, check your spelling{/ts}</li>
        <li>{ts}try a different spelling or use fewer letters{/ts}</li>
        <li>{ts}if you are searching within a date or amount range, try a wider range of values{/ts}</li>
        <li>{ts}make sure you have enough privileges in the access control system{/ts}</li>
        </ul>
    </dd>
  </dl>
</div>
