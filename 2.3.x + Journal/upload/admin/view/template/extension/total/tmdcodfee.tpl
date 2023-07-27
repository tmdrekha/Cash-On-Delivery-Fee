<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-total" onclick="$('#form-total').attr('action','<?php echo $staysave?>');$('#form-total').submit(); " data-toggle="tooltip" title="" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_savestay; ?></button>
        <button type="submit" form="form-total" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title1; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <?php echo $getkeyform; ?>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-total" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-fee" data-toggle="tab"><?php echo $tab_fee; ?></a></li>
           
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
           <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_title; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
              <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="tmdcodfee_title[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($tmdcodfee_title[$language['language_id']]) ? $tmdcodfee_title[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" class="form-control" />
              </div>
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
              <?php } ?>
              <?php } ?>
            </div>
          </div>

          

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="tmdcodfee_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $tmdcodfee_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

         <div class="form-group">
            <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
            <div class="col-sm-10">
              <select name="tmdcodfee_taxclass" id="input-tax-class" class="form-control">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $tmdcodfee_taxclass) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
                   
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-tmdcodfee_sort_order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="tmdcodfee_sort_order" value="<?php echo $tmdcodfee_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-tmdcodfee_sort_order" class="form-control" />
            </div>
          </div>
        
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-tmdcodfee_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="tmdcodfee_status" id="input-tmdcodfee_status" class="form-control">
                <?php if ($tmdcodfee_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          </div>

           <div class="tab-pane" id="tab-fee">
            
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-tmdcodfee_delivery"><span data-toggle="tooltip" title="<?php echo $help_Restrict_cod; ?>"><?php echo $text_Restrict_cod; ?></span></label>
          <div class="col-sm-7">
                  <?php foreach ($extensions as $extension) { ?>
                <div class="checkbox">
                  <label>
                     <?php if (in_array($extension['code'], $tmdcodfee_delivery)) { ?>
                    <input type="checkbox" name="tmdcodfee_delivery[]" checked="checked" value="<?php echo $extension['code']; ?>" id="input-tmdcodfee_delivery"> <?php echo $extension['name']; ?>
                     <?php } else { ?>
                    <input type="checkbox" name="tmdcodfee_delivery[]" value="<?php echo $extension['code']; ?>" id="input-tmdcodfee_delivery"> <?php echo $extension['name']; ?>
                     <?php } ?>  
                  </label>
                </div>
              <?php } ?>
                   
          </div>
        </div>
       
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-tmdcodfee_delivery_fee"><span data-toggle="tooltip" title="<?php echo $help_Restrict_codfee; ?>"><?php echo $text_Restrict_codfee; ?></span></label>
          <div class="col-sm-7">
                 <?php foreach ($extensions as $extension) { ?>
                <div class="checkbox">
                  <label>
                     <?php if (in_array($extension['code'], $tmdcodfee_delivery_fee)) { ?>
                    <input type="checkbox" name="tmdcodfee_delivery_fee[]" checked="checked" value="<?php echo $extension['code']; ?>" id="input-tmdcodfee_delivery_fee"> <?php echo $extension['name']; ?>
                     <?php } else { ?>
                    <input type="checkbox" name="tmdcodfee_delivery_fee[]" value="<?php echo $extension['code']; ?>" id="input-tmdcodfee_delivery_fee"> <?php echo $extension['name']; ?>
                     <?php } ?>  
                  </label>
                </div>
              <?php } ?>
            
          </div>
        </div>

          <div class="table-responsive">
                <table id="codfee" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_customer_group; ?></td>
                      <td class="text-center"><?php echo $entry_range; ?></td>
                      <td class="text-center"><?php echo $entry_feetype; ?></td>
                      <td class="text-center"><?php echo $entry_codfee; ?></td>
             
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $codfee_row = 0; ?>
                    <?php foreach ($tmdcodfee_priceinfos as $tmdcodfee_priceinfo) { ?>
                    <tr id="codfee-row<?php echo $codfee_row; ?>">
                      <td class="text-left"><select name="tmdcodfee_priceinfo[<?php echo $codfee_row; ?>][customer_group_id]" class="form-control">
                        <option value="0">ALL</option>
                          <?php foreach ($customer_groups as $customer_group) { ?>
                          <?php if ($customer_group['customer_group_id'] == $tmdcodfee_priceinfo['customer_group_id']) { ?>
                          <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                      <td class="text-right">
                        <div class="col-sm-6">
                          <div class="input-group"><span class="input-group-addon"><?php echo $text_min; ?></span>
                            <input type="text" name="tmdcodfee_priceinfo[<?php echo $codfee_row; ?>][min]" value="<?php echo $tmdcodfee_priceinfo['min']; ?>" placeholder="<?php echo $text_min; ?>" class="form-control" />
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="input-group"><span class="input-group-addon"><?php echo $text_max; ?></span>
                            <input type="text" name="tmdcodfee_priceinfo[<?php echo $codfee_row; ?>][max]" value="<?php echo $tmdcodfee_priceinfo['max']; ?>" placeholder="<?php echo $text_max; ?>" class="form-control" />
                          </div>
                      </div>
                      </td>

                      <td class="text-right">
                         <select name="tmdcodfee_priceinfo[<?php echo $codfee_row; ?>][fee_type]" id="input-fee_type" class="form-control">
                          <?php if ($tmdcodfee_priceinfo['fee_type']) { ?>
                          <option value="1" selected="selected"><?php echo $text_percentage; ?></option>
                          <option value="0"><?php echo $text_fixed; ?></option>
                          <?php } else { ?>
                          <option value="1"><?php echo $text_percentage; ?></option>
                          <option value="0" selected="selected"><?php echo $text_fixed; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                      <td class="text-right"><input type="text" name="tmdcodfee_priceinfo[<?php echo $codfee_row; ?>][cod_fee]" value="<?php echo $tmdcodfee_priceinfo['cod_fee']; ?>" placeholder="<?php echo $entry_codfee; ?>" class="form-control" /></td>
                      <td class="text-left"><button type="button" onclick="$('#codfee-row<?php echo $codfee_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                    </tr>
                    <?php $codfee_row++; ?>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4"></td>
                      <td class="text-left"><button type="button" onclick="addDiscount();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
 <script type="text/javascript"><!--
var codfee_row = <?php echo $codfee_row; ?>;

function addDiscount() {
  html  = '<tr id="codfee-row' + codfee_row + '">';
    html += '  <td class="text-left"><select name="tmdcodfee_priceinfo[' + codfee_row + '][customer_group_id]" class="form-control">';
     html += '      <option value="0">ALL</option>'; 
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';
    <?php } ?>
    html += '  </select></td>';
    
    html += '  <td class="text-right"><div class="col-sm-6"><div class="input-group"><span class="input-group-addon"><?php echo $text_min; ?></span><input type="text" name="tmdcodfee_priceinfo[' + codfee_row + '][min]" value="" placeholder="<?php echo $text_min; ?>" class="form-control" /></div></div><div class="col-sm-6"><div class="input-group"><span class="input-group-addon"><?php echo $text_max; ?></span><input type="text" name="tmdcodfee_priceinfo[' + codfee_row + '][max]" value="" placeholder="<?php echo $text_max; ?>" class="form-control" /></div></div></td>';
 
     html += '  <td class="left">';
  html += '    <select name="tmdcodfee_priceinfo[' + codfee_row + '][fee_type]" class="form-control">>';
  html += '      <option value="0"><?php echo $text_fixed; ?></option>';  
  html += '      <option value="1"><?php echo $text_percentage; ?></option>';
 
  html += '    <select>';
  html += '  </td>';

    html += '  <td class="text-right"><input type="text" name="tmdcodfee_priceinfo[' + codfee_row + '][cod_fee]" value="" placeholder="<?php echo $entry_codfee; ?>" class="form-control" /></td>';

 
  
  html += '  <td class="text-left"><button type="button" onclick="$(\'#codfee-row' + codfee_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';

  $('#codfee tbody').append(html);

  $('.date').datetimepicker({
    pickTime: false
  });

  codfee_row++;
}
//--></script>
<?php echo $footer; ?>