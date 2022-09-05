<form class="form-horizontal" action="" method="post">
   <div class="panel">
      <h3>
         <i class="icon-picture"></i>
         {l s='Regenerate thumbnails' d='Admin.Design.Feature'}
      </h3>
      <div class="alert alert-warning">
         {l s='Be careful! Depending on the options selected, former manually uploaded thumbnails might be erased and replaced by automatically generated thumbnails.' d='Admin.Design.Notification'}<br />
         {l s='Also, regenerating thumbnails for all existing images can take several minutes, please be patient.' d='Admin.Design.Notification'}
      </div>
      <div class="form-group">
         <label class="control-label col-lg-3">{l s='Select an image' d='Admin.Design.Feature'}</label>
         <div class="col-lg-9">
            <select name="type" onchange="changeFormat(this)">
               <option value="all">{l s='All' d='Admin.Global'}</option>
               {foreach $types AS $k => $type}
               <option value="{$k}">{$type}</option>
               {/foreach}
            </select>
         </div>
      </div>
      {foreach $types AS $k => $type}
      <div class="form-group second-select format_{$k}" style="display:none;" multiple>
         <label class="control-label col-lg-3">{l s='Select a format' d='Admin.Design.Feature'}</label>
         <div class="col-lg-9 margin-form">
            <select name="format_{$k}">
               <option value="all">{l s='All' d='Admin.Global'}</option>
               {foreach $formats[$k] AS $format}
               <option value="{$format['id_image_type']}">{$format['name']}</option>
               {/foreach}
            </select>
         </div>
      </div>
      {/foreach}
      <script>
         function changeFormat(elt)
         {ldelim}
         	$('.second-select').hide();
         	$('.format_' + $(elt).val()).show();
         {rdelim}
      </script>
      <div class="form-group">
         <label class="control-label col-lg-3">
         {l s='Erase previous images' d='Admin.Design.Feature'}
         </label>
         <div class="col-lg-9">
            <span class="switch prestashop-switch fixed-width-lg">
            <input type="radio" name="erase" id="erase_on" value="1">
            <label for="erase_on" class="radioCheck">
            {l s='Yes' d='Admin.Global'}
            </label>
            <input type="radio" name="erase" id="erase_off" value="0" checked="checked">
            <label for="erase_off" class="radioCheck">
            {l s='No' d='Admin.Global'}
            </label>
            <a class="slide-button btn"></a>
            </span>
            <p class="help-block">
               {l s='Select "No" only if your server timed out and you need to resume the regeneration.' html=1 d='Admin.Design.Help'}
            </p>
         </div>
      </div>
      <div class="panel-footer">
         <button type="submit" name="submitPs_thumbnailgenbycronModule" class="btn btn-default pull-right">
         <i class="process-icon-cogs"></i> {l s='Regenerate thumbnails' d='Admin.Design.Feature'}
         </button>
      </div>
   </div>
   <div id="overlay"><div class="cv-spinner"><span class="spinner"></span></div></div>
</form>

<div class="panel">
	<h3>
        <i class="icon-calendar"></i>
        {l s='Crons' d='Admin.Design.Feature'}
    </h3>

	{foreach from=$cronUrls item=url key=type}
		<ul>
			<li><strong>{$type}</strong><br>{$url}</li>
		</ul>
    {/foreach}
</div>

