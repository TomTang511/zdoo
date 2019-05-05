<?php 
/**
 * The receive payments file of contract module of RanZhi.
 *
 * @copyright   Copyright 2009-2018 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     contract 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.modal.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<?php include '../../../sys/common/view/chosen.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php js::set('mainCurrency', $config->setting->mainCurrency);?>
<form method='post' id='receiveForm' class='form-table' action='<?php echo $this->createLink('contract', 'receive', "contractID={$contract->id}")?>'>
  <table class='table table-form table-condensed'>
    <tr>
      <th class='w-100px'><?php echo $lang->contract->all;?></th>
      <td class='w-p50'><?php echo zget($currencySign, $contract->currency, $contract->currency) . $contract->amount;?></td>
      <td></td>
    </tr>
    <tr>
      <th><?php echo $lang->contract->thisAmount;?></th>
      <td>
        <div class='input-group'>
          <?php echo html::input('amount', '', "class='form-control'");?>
          <div class='input-group-addon'>
            <label class='checkbox-inline'><input type='checkbox' id='finish' name='finish' value='1'> <?php echo $lang->contract->completeReturn;?></label>
          </div>
          <div class='input-group-addon'>
            <label class='checkbox-inline'><input type='checkbox' id='createTrade' name='createTrade' value='1' checked='checked'> <?php echo $lang->trade->create;?></label>
          </div>
        </div>
      </td>
      <td></td>
    </tr>
    <tr class='tradeTR'>
      <th><?php echo $lang->trade->depositor;?></th>
      <td><?php echo html::select('depositor', $depositorList, '', "class='form-control'");?></td>
      <td>
        <?php unset($depositorList[0]);?>
        <?php unset($depositorList['']);?>
        <?php if(!$depositorList) commonModel::printLink('cash.depositor', 'browse', '', $lang->depositor->create, "class='btn createDepositor'");?>
      </td>
    </tr>
    <tr class='tradeTR currencyTR'>
      <th><?php echo $lang->trade->currency;?></th>
      <td>
        <div class='input-group'>
          <?php echo html::select('currencyLabel', $lang->currencyList, $config->setting->mainCurrency, "class='form-control' readonly");?>
          <?php echo html::hidden('currency');?>
          <span class='input-group-addon fix-border exchangeRate'><?php echo $lang->trade->exchangeRate;?></span>
          <?php echo html::input('exchangeRate', '', "class='form-control exchangeRate'");?> 
        </div>
      </td>
      <td></td>
    </tr>
    <tr class='tradeTR'>
      <th><?php echo $lang->trade->category;?></th>
      <td><?php echo html::select('category', array('') + (array) $categories, '', "class='form-control'");?></td>
      <td></td>
    </tr>
    <tr class='tradeTR'>
      <th><?php echo $lang->trade->dept;?></th>
      <td><?php echo html::select('dept', array('') + (array) $deptList, isset($dept->id) ? $dept->id : '', "class='form-control'");?></td>
      <td></td>
    </tr>
    <tr class='tradeTR'>
      <th><?php echo $lang->trade->product;?></th>
      <td><?php echo html::select('product', $productList, $product, "class='form-control chosen'");?></td>
      <td></td>
    </tr>
    <tr>
      <th><?php echo $lang->contract->returnedBy;?></th>
      <td><?php echo html::select('returnedBy', $users, $this->app->user->account, "class='form-control chosen'");?></td>
      <td></td>
    </tr>
    <tr>
      <th><?php echo $lang->contract->returnedDate;?></th>
      <td><?php echo html::input('returnedDate', '', "class='form-control form-date'");?></td>
      <td></td>
    </tr>
    <tr>
      <th><?php echo $lang->contract->handlers;?></th>
      <td colspan='2'><?php echo html::select('handlers[]', $users, $contract->handlers . ',' . $this->app->user->account, "class='form-control chosen' multiple");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->comment;?></th>
      <td colspan='2'><?php echo html::textarea('comment', '', "rows='2'");?></td>
    </tr>
    <tr>
      <th></th>
      <td colspan='2'>
        <?php echo html::submitButton();?>
        <div id='duplicateError' class='hide'></div>
      </td>
    </tr>
  </table>
</form>
<?php if(!empty($contract->returnList)):?>
<div class='panel'>
  <div class='panel-heading'><strong><?php echo $lang->contract->returnRecords;?></strong></div>
  <div class='panel-body'>
    <?php foreach($contract->returnList as $return):?>
    <?php printf($lang->contract->returnInfo, formatTime($return->returnedDate, DT_DATE1), zget($users, $return->returnedBy, $return->returnedBy), zget($currencySign, $contract->currency, '') . $return->amount);?>
    <?php endforeach;?>
  </div>
</div>
<?php endif;?>
<div class='errorMessage hide'>
  <div class='alert alert-danger alert-dismissable'>
    <button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
    <button type='submit' class='btn btn-default' id='continueSubmit'><?php echo $lang->continueSave;?></button>
  </div>
</div>
<?php include '../../../sys/common/view/footer.modal.html.php';?>
