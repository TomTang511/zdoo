<?php
/**
 * The browse view file of holiday module of Ranzhi.
 *
 * @copyright   Copyright 2009-2018 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     holiday
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<div id='menuActions'>
  <?php commonModel::printLink('holiday', 'create', "", "<i class='icon icon-plus'> </i>" . $lang->create, "data-toggle='modal' class='btn btn-primary'")?>
</div>
<div class='with-side'>
  <div class='side'>
    <div class='panel panel-sm'>
      <div class='panel-body'>
        <ul class='tree' data-collapsed='true'>
          <?php foreach($yearList as $year):?>
          <li class='<?php echo $year == $currentYear ? 'active' : ''?>'>
            <?php commonModel::printLink('holiday', 'browse', "year=$year", $year);?>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
    </div>
  </div>
  <div class='main'>
    <div class='panel'>
      <table class='table table-data table-hover text-center table-fixed'>
        <thead>
          <tr class='text-center'>
            <th class='w-150px'><?php echo $lang->holiday->name;?></th>
            <th class='w-200px'><?php echo $lang->holiday->holiday;?></th>
            <th class='w-80px'><?php echo $lang->holiday->type;?></th>
            <th><?php echo $lang->holiday->desc;?></th>
            <th class='w-100px'><?php echo $lang->actions;?></th>
          </tr>
        </thead>
        <?php foreach($holidays as $holiday):?>
        <tr>
          <td><?php echo $holiday->name;?></td>
          <td><?php echo formatTime($holiday->begin, DT_DATE1) . ' ~ ' . formatTime($holiday->end, DT_DATE1);?></td>
          <td><?php echo zget($lang->holiday->typeList, $holiday->type);?></td>
          <td><?php echo $holiday->desc;?></td>
          <td>
            <?php commonModel::printLink('oa.holiday', 'edit', "id=$holiday->id", $lang->edit, "data-toggle='modal'");?>
            <?php commonModel::printLink('oa.holiday', 'delete', "id=$holiday->id", $lang->delete, "class='deleter'");?>
          </td>
        </tr>
        <?php endforeach;?>
      </table>
      <?php if(!$holidays):?>
      <div class='table-footer'>
        <div class='pager' style='float: right; clear: none'><?php echo $lang->pager->noRecord;?></div>
      </div>
      <?php endif;?>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
