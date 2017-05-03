<?php include mymps_tpl('inc_head');?>
    <style type="text/css">
        #address select{
            margin-right: 5px;
        }
    </style>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a href="?part=list">房号信息</a></li>
                <li><a href="?part=add" class="current">增加房号</a></li>
            </ul>
        </div>
    </div>
</div>
<form method=post onSubmit="return chkform()" name="form1" action="?part=add">
<div id="<?=MPS_SOFTNAME?>">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
<td colspan="2">
    <div class="left"><a href="javascript:collapse_change('1')">房号基本信息</a></div>
    <div class="right"><a href="javascript:collapse_change('1')"><img id="menuimg_1" src="template/images/menu_reduce.gif"/></a></div>
</td>
</tr>
<tbody id="menu_1">
<tr bgcolor="white">
  <td width="15%" bgcolor="#F1F5F8">房号： </td>
  <td><input type="text" id="room_name" name="name" maxlength="32" /><br />
</tr>
<tr bgcolor="white">
  <td bgcolor="#F1F5F8">地址： </td>
  <td>
      <div id="address">
          <select name="province_id" id="province_id">
              <option value="0">请选择</option>
              <?php foreach ($province_list as $item) : ?>
                  <option value="<?=$item['provinceid']?>"><?=$item['provincename']?></option>
              <?php endforeach;?>
          </select>
      </div>
  </td>
</tr>
</tbody>
</table>
</div>
<center>
<input type="submit" value="确认提交" name="<?=CURSCRIPT?>_submit" class="mymps mini" />　
<input type="button" onClick=history.back() value="返 回" class="mymps mini">
</center>
</form>

    <script type="text/javascript" src="./js/jquery.3.1.1.min.js"></script>
    <script type="application/javascript">
        $(function () {
            $('#province_id').change(function () {
                var that = $(this);
                var data = {"do" : "city", "province_id" : $('#province_id').val()};
                $.post('/address.php', data, function (rsp) {
                    var str = select_tpl('city', rsp);
                    that.nextAll().remove();
                    $('#address').append(str);
                }, 'json')
            });

            $(document).on('change', '#city_id', function () {
                var that = $(this);
                var data = {"do" : "area", "city_id" : $(this).val()};
                $.post('/address.php', data, function (rsp) {
                    var str = select_tpl('area', rsp);
                    that.nextAll().remove();
                    $('#address').append(str);
                }, 'json')
            });

            $(document).on('change', '#area_id', function () {
                var that = $(this);
                var data = {"do": "building", "area_id": $(this).val()};
                $.post('/address.php', data, function (rsp) {
                    var str = select_tpl('building', rsp);
                    that.nextAll().remove();
                    $('#address').append(str);
                }, 'json')
            });
            
            function select_tpl(type, data) {
                var tpl = '<select name="'+type+'_id" id="'+type+'_id">';
                tpl += '<option value="">请选择</option>';
                $.each(data, function (i,v) {
                    tpl += '<option value="'+ v.id+'">'+ v.name+'</option>';
                });
                tpl += '</select>';
                return tpl;
            }
        })
    </script>
<?php mymps_admin_tpl_global_foot();?>