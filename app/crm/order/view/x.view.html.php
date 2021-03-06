<?php
/**
 * The view view file of order module of RanZhi.
 *
 * @copyright   Copyright 2009-2018 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Gang Liu <liugang@cnezsoft.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php include '../../../sys/common/view/header.lite.html.php';?>
<?php include '../../../sys/common/view/kindeditor.html.php';?>
<div class='xuanxuan-card'>
  <div class='panel'>
    <div class='panel-heading'><strong><?php echo $lang->order->view?></strong></div>
    <div class='panel-body'>
      <?php 
      $payed = $order->status == 'payed';
      $customerLink = html::a($this->createLink('customer', 'view', "customerID={$customer->id}"), $customer->name);
      $productLink = '';
      foreach($order->products as $product)
      {
          $productLink .= html::a($this->createLink('product', 'view', "productID={$product->id}"), $product->name);
      }
  
      if($contract) $contractLink = html::a($this->createLink('contract', 'view', "contractID={$contract->id}"), $contract->name);
      ?>
      <p><?php printf($lang->order->infoBuy, $customerLink, $productLink);?></p>
      <?php if($contract):?>
      <p><?php printf($lang->order->infoContract, $contractLink);?></p>
      <?php endif;?>
      <p><?php printf($lang->order->infoAmount, zget($currencySign, $order->currency, '') . formatMoney($order->plan), zget($currencySign, $order->currency, '') . formatMoney($order->real))?></p>
      <p>
        <?php if(formatTime($order->contactedDate)) printf($lang->order->infoContacted, formatTime($order->contactedDate, DT_DATETIME1))?>
        <?php if(formatTime($order->nextDate)) printf($lang->order->infoNextDate, formatTime($order->nextDate, DT_DATE1))?>
      </p>
    </div>
  </div> 
  <div class='panel'>
    <div class='panel-heading'><strong><i class='icon-file-text-alt'></i> <?php echo $lang->order->lifetime;?></strong></div>
    <div class='panel-body'>
      <?php $payed = $order->status == 'payed';?>
      <table class='table table-info'>
        <tr>
          <th class='w-80px'><?php echo $lang->lifetime->createdBy;?></th>
          <td><?php echo zget($users, $order->createdBy) . $lang->at . formatTime($order->createdDate, DT_DATETIME1);?></td>
        </tr>
        <tr>
          <th><?php echo $lang->lifetime->assignedTo;?></th>
          <td><?php if($order->assignedTo) echo zget($users, $order->assignedTo) . $lang->at . formatTime($order->assignedDate, DT_DATETIME1);?></td>
        </tr>
        <?php if($order->closedBy):?>
        <tr>
          <th><?php echo $lang->lifetime->closedBy;?></th>
          <td><?php if($order->closedBy) echo zget($users, $order->closedBy) . $lang->at . formatTime($order->closedDate, DT_DATETIME1);?></td>
        </tr>
        <?php endif;?>
        <?php if($order->closedReason):?>
        <tr>
          <th><?php echo $lang->lifetime->closedReason;?></th>
          <td><?php echo $lang->order->closedReasonList[$order->closedReason];?></td>
        </tr>
        <?php endif;?>
        <?php if($order->signedBy):?>
        <tr>
          <th><?php echo $lang->lifetime->signedBy;?></th>
          <td>
            <?php if($contract and $contract->signedBy and $contract->status != 'canceled') echo zget($users, $contract->signedBy) . $lang->at . formatTime($contract->signedDate, DT_DATE1);?>
          </td>
        </tr>
        <?php endif;?>
        <?php if($order->editedBy):?>
        <tr>
          <th><?php echo $lang->order->editedBy;?></th>
          <td><?php if($order->editedBy) echo zget($users, $order->editedBy) . $lang->at . formatTime($order->editedDate, DT_DATETIME1);?></td>
          <td>
          </td>
        </tr>
        <?php endif;?>
      </table>
    </div>
  </div>
  <?php echo $this->fetch('contact', 'block', "customer={$order->customer}");?>
  <?php echo $this->fetch('action', 'history', "objectType=order&objectID={$order->id}");?>
  <div class='page-actions'>
    <?php
    echo "<div class='btn-group'>";
    commonModel::printLink('action', 'createRecord', "objectType=order&objectID={$order->id}&customer={$order->customer}&history=", $lang->order->record, "class='btn' data-toggle='modal' data-width='800'");
    if($order->status == 'normal') commonModel::printLink('contract', 'create', "customer={$order->customer}&orderID={$order->id}", $lang->order->sign, "class='btn btn-default'");
  
    if($order->status != 'normal') echo html::a('###', $lang->order->sign, "class='btn' disabled='disabled' class='disabled'");
    if($order->status != 'closed') commonModel::printLink('order', 'assign', "orderID=$order->id", $lang->assign, "data-toggle='modal' class='btn btn-default'");
    
    if($order->status == 'closed') echo html::a('###', $lang->assign, "data-toggle='modal' class='btn btn-default disabled' disabled");
    echo '</div>';
  
    echo "<div class='btn-group'>";
    if($order->status != 'closed') commonModel::printLink('order', 'close', "orderID=$order->id", $lang->close, "class='btn btn-default' data-toggle='modal'");
    if($order->closedReason == 'payed') echo html::a('###', $lang->close, "disabled='disabled' class='disabled btn'");
    if($order->closedReason != 'payed' and $order->status == 'closed') commonModel::printLink('order', 'activate', "orderID=$order->id", $lang->activate, "class='btn' data-toggle='modal'");
    if($order->closedReason == 'payed' or  $order->status != 'closed') echo html::a('###', $lang->activate, "class='btn disabled' data-toggle='modal'");
    echo '</div>';
  
    echo "<div class='btn-group'>";
    commonModel::printLink('order', 'edit', "orderID=$order->id", $lang->edit, "class='btn btn-default'");
    if($order->status == 'normal' or $order->closedReason == 'failed') commonModel::printLink('order', 'delete', "orderID=$order->id", $lang->delete, "class='btn btn-default deleter'");
    echo html::a('#commentBox', $this->lang->comment, "class='btn btn-default' onclick=setComment()");
    echo '</div>';

    echo html::backButton();
    ?>
  </div>
  <fieldset id='commentBox' class='hide'>
    <legend><?php echo $lang->comment;?></legend>
    <form id='ajaxForm' method='post' action='<?php echo inlink('edit', "orderID={$order->id}&comment=true")?>'>
      <div class='form-group'><?php echo html::textarea('comment', '',"rows='5' class='w-p100'");?></div>
      <?php echo html::submitButton();?>
    </form>
  </fieldset>      
</div>
<?php include '../../common/view/footer.html.php';?>
