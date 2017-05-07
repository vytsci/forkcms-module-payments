<section id="payments-index" class="module module-payments layout-payments">
  <div class="row">
    <div class="col-md-12">
      <h2>{$lblPaymentsPayment|sprintf:{$payment.id}|ucfirst}</h2>
      {option:payment.status.is_pending}
      <div class="alert alert-warning">{$msgPaymentsStatusPending}</div>
      {/option:payment.status.is_pending}
      {option:payment.status.is_success}
      <div class="alert alert-success">{$msgPaymentsStatusSuccess}</div>
      {/option:payment.status.is_success}
      {option:payment.status.is_failure}
      <div class="alert alert-danger">{$msgPaymentsStatusFailure}</div>
      {/option:payment.status.is_failure}
      <table class="table">
        <tr>
          <th>{$lblPaymentsPayerDisplayName|ucfirst}</th>
          <td>{$payment.profile.display_name}</td>
        </tr>
        <tr>
          <th>{$lblPaymentsExternal|ucfirst}</th>
          <td><a href="{$payment.url}" title="{$payment.title}">{$payment.title}</a></td>
        </tr>
        <tr>
          <th>{$lblPaymentsAmount|ucfirst}</th>
          <td>{$payment.amount|formatprice:{$payment.currency}}</td>
        </tr>
      </table>
      {option:payment.status.is_success}
      <div class="btn-toolbar">
        <div class="btn-group pull-right">
          <a href="{$payment.url}" class="btn btn-success" title="{$payment.title}">
            {$lblPaymentsOverviewExternal|ucfirst}
          </a>
        </div>
      </div>
      {/option:payment.status.is_success}
      {option:payment.status.is_pending}
      {option:methods}
      <div class="row">
        {iteration:methods}
        <div class="col-md-3">
          {$var|parsepaymentsmethodwidget:{$methods.name}:'Button':{$payment.id}}
        </div>
        {/iteration:methods}
      </div>
      {/option:methods}
      {option:!methods}
      <p class="text-warning">{$msgPaymentsNoMethods}</p>
      {/option:!methods}
      {/option:payment.status.is_pending}
    </div>
  </div>
</section>
