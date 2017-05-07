{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}
<div class="row fork-module-heading">
  <div class="col-md-12">
    <h2>{$lblMethodsInstalled|ucfirst}</h2>
  </div>
</div>
<div class="row fork-module-content">
  <div class="col-md-12">
    {option:dgMethodsInstalled}
    {$dgMethodsInstalled}
    {/option:dgMethodsInstalled}
    {option:!dgMethodsInstalled}
    <p>{$msgNoItems}</p>
    {/option:!dgMethodsInstalled}
  </div>
</div>
<div class="row fork-module-heading">
  <div class="col-md-12">
    <h2>{$lblMethodsNotInstalled|ucfirst}</h2>
  </div>
</div>
<div class="row fork-module-content">
  <div class="col-md-12">
    {option:dgMethodsNotInstalled}
    {$dgMethodsNotInstalled}
    {/option:dgMethodsNotInstalled}
    {option:!dgMethodsNotInstalled}
    <p>{$msgNoItems}</p>
    {/option:!dgMethodsNotInstalled}
  </div>
</div>
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
