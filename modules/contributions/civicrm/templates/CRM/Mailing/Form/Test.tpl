{include file="CRM/WizardHeader.tpl}

<div class="form-item">
<fieldset>
  <legend></legend>
  <dl>
    <dt class="label">{$form.test.label}</dt><dd>{$form.test.html}</dd>
    <dt class="label">{ts}The test mailing will be sent to{/ts} </dt><dd>&nbsp;&nbsp;&nbsp;&lt;{$email}&gt;</dd>
    <dt></dt><dd>{$form.buttons.html}</dd>
  </dl>
</fieldset>
</div>
