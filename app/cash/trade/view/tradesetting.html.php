<?php
/**
 * The manage privilege view of group module of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     group
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<form class='form' id='ajaxForm' method='post'>
  <div class='panel'>
    <div class='panel-heading'>
      <strong><?php echo $this->lang->trade->cashSetting?></strong>
    </div>
    <div class='panel-body'>
    <?php foreach($cashSetting as $code => $value):?>
      <div class='group-item'><?php echo html::checkbox('cashSetting', array($code => $value['name']), isset($value['setting']) ? $code : '');?></div>
    <?php endforeach?>
    </div>
    <div class='panel-footer'><?php echo html::submitButton() . html::hidden('foo'); // Just a var, to make sure $_POST is not empty.?></div>
  </div>
</form>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>