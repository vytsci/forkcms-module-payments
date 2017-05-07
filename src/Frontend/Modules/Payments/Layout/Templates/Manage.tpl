<h1>{$lblPaymentsManage|ucfirst}</h1>
<section id="payments-manage" class="module module-payments layout-payments-manage">
  {option:payments}
  <table class="table table-hover">
    <thead>
    <tr>
      <th>{$lblId|ucfirst}</th>
      <th>{$lblPaymentsExternalTitle|ucfirst}</th>
      <th>{$lblPaymentsAmount|ucfirst}</th>
      <th>{$lblPaymentsCurrency|ucfirst}</th>
      <th>{$lblPaymentsStatus|ucfirst}</th>
      <th>{$lblCreatedOn|ucfirst}</th>
      <th>{$lblActions|ucfirst}</th>
    </tr>
    </thead>
    <tbody>
    {iteration:payments}
    <tr>
      <td>
        {$payments.id}
      </td>
      <td>
        <a href="{$payments.url}" title="{$payments.title}">
          {$payments.title}
        </a>
      </td>
      <td>
        {$payments.amount}
      </td>
      <td>
        {$payments.currency}
      </td>
      <td>
        {option:payments.status.is_pending}
        <span class="text-warning">{$lblPending|ucfirst}</span>
        {/option:payments.status.is_pending}
        {option:payments.status.is_success}
        <span class="text-success">{$lblSuccess|ucfirst}</span>
        {/option:payments.status.is_success}
        {option:payments.status.is_failure}
        <span class="text-danger">{$lblFailure|ucfirst}</span>
        {/option:payments.status.is_failure}
      </td>
      <td>
        {$payments.created_on}
      </td>
      <td>
        <div class="btn-toolbar">
          <div class="btn-group">
            <a href="{$var|geturlforblock:'Payments'}/{$payments.id}" class="btn btn-link btn-xs" title="{$lblView|ucfirst}">
              {option:payments.status.is_pending}
              {$lblPaymentsMakePayment|ucfirst}
              {/option:payments.status.is_pending}
              {option:!payments.status.is_pending}
              {$lblView|ucfirst}
              {/option:!payments.status.is_pending}
            </a>
          </div>
        </div>
      </td>
    </tr>
    {/iteration:payments}
    </tbody>
  </table>
  {/option:payments}
  {option:!payments}
  <p>{$msgNoItems}</p>
  {/option:!payments}
</section>
