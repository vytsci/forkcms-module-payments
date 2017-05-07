<div class="text-center">
  <form action="{$var|geturlforblock:'Payments':'Method'}/test/simulate" method="post">
    <input type="hidden" name="id" value="{$payment.id}" />
    <button type="submit" class="btn btn-primary">Simulate payment</button>
  </form>
</div>
