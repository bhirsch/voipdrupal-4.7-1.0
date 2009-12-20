{* Check for Status message for the page (stored in session->getStatus). Status is cleared on retrieval. *}
{if $session->getStatus(false)}
    {assign var="status" value=$session->getStatus(true)}
    <div class="messages status">
      <dl>
      <dt><img src="{$config->resourceBase}i/Inform.gif" alt="{ts}status{/ts}"></dt>
      <dd>
        {if is_array($status)}
            {foreach name=statLoop item=statItem from=$status}
                {if $smarty.foreach.statLoop.first}
                    <h3>{$statItem}</h3>
                    <ul>
                {else}
                    <li>{$statItem}</li>
                {/if}
                </ul>
            {/foreach}
        {else}
            {$status}
        {/if}
      </dd>
      </dl>
    </div>
{/if}
