{if $action eq 1024}
    {include file="CRM/Contribute/Form/Contribution/PreviewHeader.tpl"}
{/if}
<div class="form-item">
    <div id="thankyou_text">
        <p>
        {$thankyou_text}
        </p>
    </div>
    <div id="help">
        <p>{ts}Your contribution has been processed successfully. Please print this page for your records.{/ts}</p>
        {if $is_email_receipt}
            <p>{ts 1=$email}An email receipt for this contribution has also been sent to %1{/ts}</p>
        {/if}
    </div>
    <div class="header-dark">
        {ts}Contribution Information{/ts}
    </div>
    <div class="display-block">
        {ts}Amount{/ts}: <strong>{$amount|crmMoney}</strong><br />
        {ts}Date{/ts}: <strong>{$receive_date|crmDate}</strong><br />
        {ts}Transaction #{/ts}: {$trxn_id}
    </div>

    <div class="header-dark">
        {ts}Billing Name and Address{/ts}
    </div>
    <div class="display-block">
        <strong>{$name}</strong><br />
        {$address|nl2br}
    </div>
    <div class="display-block">
        {$email}
    </div>

    {if $contributeMode eq 'direct'}
    <div class="header-dark">
        {ts}Credit or Debit Card Information{/ts}
    </div>
    <div class="display-block">
        {$credit_card_type}<br />
        {$credit_card_number}<br />
        {ts}Expires{/ts}: {$credit_card_exp_date|truncate:7:''|crmDate}
    </div>
    {/if}

    {include file="CRM/Contribute/Form/Contribution/PremiumBlock.tpl" context="thankContribution"}

    <div id="thankyou_footer">
        <p>
        {$thankyou_footer}
        </p>
    </div>
</div>
