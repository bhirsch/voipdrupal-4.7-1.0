<div id="crm-quick-search" class="block-crm">
   {* Simplify quick search block...
    <div class="form-item">
        <select name="contact_type" size="1" class="form-select">
            <option value="">{ts}- all contacts -{/ts}</option>
            <option value="Individual">{ts}Individuals{/ts}</option>
            <option value="Organization">{ts}Organizations{/ts}</option>
            <option value="Household">{ts}Households{/ts}</option>
        </select>
    </div> *}
    <form action="{$postURL}" method="post">
    <div class="form-item">
        <input type="hidden" name="contact_type" value="" />
        <input type="text" name="sort_name" class="form-text required" value="" autocomplete="off" />
        <br />
        <input type="submit" name="_qf_Search_refresh" value="{ts}Search{/ts}" class="form-submit" />
        <br />
        <a href="{$advancedSearchURL}" title="{ts}Go to Advanced Search{/ts}">&raquo; {ts}Advanced Search{/ts}</a>
    </div>
    </form>
</div>
