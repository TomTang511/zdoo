<?php 
/**
 * The edit view file of sales module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      chujilu <chujilu@cnezsoft.com>
 * @package     sales 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->sales->edit;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-condensed'>
      <table class='table table-form'>
        <tr>
          <th class='w-80px'><?php echo $lang->sales->name;?></th>
          <td class='w-p40'>
            <?php echo html::hidden('id', $group->id);?>
            <?php echo html::input('name', $group->name, "class='form-control'");?>
          </td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->sales->desc;?></th>
          <td colspan='2'><?php echo html::textarea('desc', $group->desc, "rows='2' class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->sales->users;?></th>
          <td colspan='2'><div class='checkbox-users'><?php echo html::checkbox('users', $users, $group->users);?></div></td>
        </tr>
        <tr>
          <th><?php echo $lang->sales->priv;?></th>
          <td colspan='2'>
            <ul id='privTab' class='nav nav-tabs'>
              <?php foreach($users as $account => $realname):?>
              <li><?php echo html::a("#privs_$account", $realname, "data-toggle='tab'")?></li>
              <?php endforeach;?>
            </ul>
            <div id='privContent' class='tab-content'>
              <?php foreach($users as $account => $realname):?>
              <div class='tab-pane' id='privs_<?php echo $account?>'>
                <?php foreach($groups as $g):?>
                <div class='priv-item'> 
                  <?php 
                  $value   = "{$account}_{$g->id}";
                  $label   = sprintf($lang->sales->viewTip, $realname, $g->id == $group->id ? $lang->sales->currentGroup : $g->name);
                  $checked = isset($privs[$account][$g->id]['view']) ? $value : '';
                  echo html::checkbox('privs_view', array($value => $label), $checked);
                  ?>
                </div>
                <div class='priv-item'> 
                  <?php 
                  $value   = "{$account}_{$g->id}";
                  $label   = sprintf($lang->sales->editTip, $realname, $g->id == $group->id ? $lang->sales->currentGroup : $g->name);
                  $checked = isset($privs[$account][$g->id]['edit']) ? $value : '';
                  echo html::checkbox('privs_edit', array($value => $label), $checked);
                  ?> 
                </div>
                <?php endforeach;?>
              </div>
              <?php endforeach;?>
            </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan='2'><?php echo html::submitButton() . '&nbsp;&nbsp;' . html::backButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
