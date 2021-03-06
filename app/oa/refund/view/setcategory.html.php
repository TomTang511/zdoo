<?php
/**
 * The set category view file of refund module of Ranzhi.
 *
 * @copyright   Copyright 2009-2018 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     refund
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php if(!$module):?>
<div class='with-side'>
  <div class='side'>
    <nav class='menu leftmenu affix'>
      <ul class='nav nav-primary'>
        <?php foreach($lang->refund->settings as $setting):?>
        <?php list($label, $module, $method) = explode('|', $setting);?>
        <li><?php commonModel::printLink($module, $method, '', $label);?></li>
        <?php endforeach;?>
      </ul>
    </nav>
  </div>
  <div class='main'>
<?php endif;?>
    <div class='panel'>
      <div class='panel-heading'><strong><?php echo $lang->refund->setCategory;?></strong></div>
      <div class='panel-body'>
        <form id='ajaxForm' method='post'>
          <table class='table table-form table-condensed'>
            <tr>
              <td>
                <?php if(empty($expenseList))
                { 
                    echo $lang->refund->categoryTips;
                } 
                else
                {
                    echo html::checkbox('refundCategories', $expenseList, $refundCategories, '', $type = 'block');
                }
                ?>
              </td>
            </tr>
          </table>
          <div class='page-actions'>
            <?php echo html::hidden('uid');?>
            <?php if(!empty($expenseList)):?>
            <div class='checkbox checkAll'>
              <label><input type='checkbox' name='checkAll' id='checkAll'><?php echo $lang->selectAll;?></label>
            </div>
            <?php echo html::submitButton();?>
            <?php endif;?>
            <?php commonModel::printLink('cash.tree', 'browse', 'type=out', $lang->refund->setExpense, "class='btn btn-primary setExpense'");?>
          </div>
        </form>
      </div>
    </div>
<?php if(!$module):?>
  </div>
</div>
<?php endif;?>
<?php include '../../common/view/footer.html.php';?>
