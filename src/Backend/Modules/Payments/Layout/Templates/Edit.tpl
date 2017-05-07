{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}
<div class="row fork-module-heading">
  <div class="col-md-12">
    <h2>
      {$lblEdit|ucfirst}
    </h2>
  </div>
</div>
<div class="row fork-module-content">
  <div class="col-md-12">
    {option:payment}
    <h3>{$lblPayment|ucfirst}</h3>
    <table class="table">
      <tr>
        <th>{$lblId|ucfirst}</th>
        <td>{$payment.id}</td>
      </tr>
      <tr>
        <th>{$lblPayerDisplayName|ucfirst}</th>
        <td>{$payment.profile.display_name}</td>
      </tr>
      <tr>
        <th>{$lblPayerEmail|ucfirst}</th>
        <td>{$payment.profile.email}</td>
      </tr>
      <tr>
        <th>{$lblStatus|ucfirst}</th>
        <td>{$payment.status.value}</td>
      </tr>
      <tr>
        <th>{$lblAmount|ucfirst}</th>
        <td>{$payment.amount}</td>
      </tr>
      <tr>
        <th>{$lblCurrency|ucfirst}</th>
        <td>{$payment.currency}</td>
      </tr>
    </table>
    {/option:payment}
  </div>
</div>
<div class="row fork-module-content">
  <div class="col-md-12">
    <h3>{$lblExtraInfo}</h3>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>{$lblTitle|ucfirst}</th>
          {option:payment.extra_fields}
          {iteration:payment.extra_fields}
          <th>
            {$var|parseextrafieldname:{$payment.extra_fields.value}}
          </th>
          {/iteration:payment.extra_fields}
          {/option:payment.extra_fields}
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <a href="{$payment.url}" title="{$payment.title}" target="_blank">
              {$payment.title}
            </a>
          </td>
          {option:payment.extra_fields}
          {iteration:payment.extra_fields}
          <th>
            {$var|parseextrafieldvalue:{$payment.extra_values}:{$payment.extra_fields.value}:'-'}
          </th>
          {/iteration:payment.extra_fields}
          {/option:payment.extra_fields}
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="row fork-module-actions">
  <div class="col-md-12">
    <div class="btn-toolbar">
      <div class="btn-group pull-left" role="group">
        <button type="button" class="btn btn-default">
          <span class="glyphicon glyphicon-chevron-left"></span>
          {$lblBack|ucfirst}
        </button>
      </div>
    </div>
  </div>
</div>
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
