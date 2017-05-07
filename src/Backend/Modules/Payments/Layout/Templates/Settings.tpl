{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}
<div class="row fork-module-heading">
  <div class="col-md-12">
    <h2>{$lblSettings|ucfirst}</h2>
  </div>
</div>
{form:settings}
<div class="row">
  <div class="col-md-12">
    NO SETTINGS YET
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="btn-toolbar">
      <div class="btn-group pull-right" role="group">
        <button id="save" type="submit" name="save" class="btn btn-primary">{$lblSave|ucfirst}</button>
      </div>
    </div>
  </div>
</div>
{/form:settings}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
