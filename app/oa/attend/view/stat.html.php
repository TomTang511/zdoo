<?php
/**
 * The stat view file of attend module of Ranzhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     attend
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../../sys/common/view/treeview.html.php';?>
<?php js::set('mode', $mode);?>
<div id='menuActions'>
  <?php commonModel::printLink('attend', 'exportstat', "data=$currentYear$currentMonth", "{$lang->attend->export}", "class='iframe btn btn-primary'")?>
</div>
<div class='with-side'>
  <div class='side'>
    <div class='panel panel-sm'>
      <div class='panel-body'>
        <ul class='tree' data-collapsed='true'>
          <?php foreach($yearList as $year):?>
          <li class='<?php echo $year == $currentYear ? 'active' : ''?>'>
            <?php commonModel::printLink('attend', 'stat', "currentDate=$year", $year);?>
            <ul>
              <?php foreach($monthList[$year] as $m):?>
              <li class='<?php echo ($year == $currentYear and $m == $currentMonth) ? 'active' : ''?>'>
                <?php commonModel::printLink('attend', 'stat', "currentDate=$year$m", $year . $m);?>
              </li>
              <?php endforeach;?>
            </ul>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
    </div>
  </div>
  <div class='main'>
    <?php if($waitReviews):?>
    <table class='table table-borderless'>
      <?php foreach($waitReviews as $module):?>
      <?php $reviewedBy = $module == 'attend' ? $config->attend->reviewedBy : $this->loadModel($module, 'oa')->getReviewedBy();?>
      <tr>
        <td>
          <?php printf($lang->attend->waitReviews, $lang->$module->common);?>
          <?php if(($this->app->user->admin == 'super') or ($reviewedBy == $this->app->user->account && commonModel::hasPriv($module, 'browseReview'))) echo html::a(helper::createLink($module, 'browseReview'), $lang->leave->review, "class='btn btn-primary'");?>
        </td>
      </tr>
      <?php endforeach;?>
    </table>
    <?php else:?>
    <div class='panel'>
      <div class='panel-heading text-center'>
        <strong><?php echo $currentYear . $lang->year . ($currentMonth ? $currentMonth . $lang->month : '') . $lang->attend->report;?></strong>
      </div>
      <form id='ajaxForm' method='post' action='<?php echo $this->createLink('attend', 'saveStat', "month=$month")?>'>
        <table class='table table-data table-condensed table-striped table-hover table-bordered text-center' id='attendStat'>
          <thead>
            <tr class='text-center'>
              <th class='text-middle'><?php echo $lang->user->realname;?></th>
              <th class='w-70px'><?php echo $lang->attend->statusList['normal']?></th>
              <th class='w-60px'><?php echo $lang->attend->statusList['late'];?></th>
              <th class='w-60px'><?php echo $lang->attend->statusList['early'];?></th>
              <th class='w-60px'><?php echo $lang->attend->statusList['absent'];?></th>
              <th class='w-60px'><?php echo $lang->attend->statusList['trip'];?></th>
              <th class='w-60px'><?php echo $lang->attend->statusList['egress'];?></th>
              <th class='w-60px'><?php echo $lang->leave->paid;?></th>
              <th class='w-70px'><?php echo $lang->leave->unpaid;?></th>
              <th class='w-80px'><?php echo $lang->overtime->typeList['time'];?></th>
              <th class='w-80px'><?php echo $lang->overtime->typeList['rest'];?></th>
              <th class='w-80px'><?php echo $lang->overtime->typeList['holiday'];?></th>
              <th class='w-70px'><?php echo $lang->attend->statusList['lieu'];?></th>
              <th class='w-90px'><?php echo $lang->attend->deserveDays;?></th>
              <th class='w-100px'><?php echo $lang->attend->actualDays;?></th>
              <?php if($mode == 'view' && $currentMonth):?>
              <th><?php echo $lang->actions;?></th>
              <?php endif;?>
            </tr>
          </thead>
          <?php foreach($stat as $account => $accountStat):?>
          <?php if(!isset($users[$account])) continue;?>
          <tr class='view'>
            <td class='text-middle'><?php echo $users[$account];?></td>
            <td><?php echo $accountStat->normal;?></td>
            <td><?php echo $accountStat->late;?></td>
            <td><?php echo $accountStat->early;?></td>
            <td><?php echo $accountStat->absent;?></td>
            <td><?php echo $accountStat->trip;?></td>
            <td><?php echo $accountStat->egress;?></td>
            <td><?php echo $accountStat->paidLeave;?></td>
            <td><?php echo $accountStat->unpaidLeave;?></td>
            <td><?php echo $accountStat->timeOvertime;?></td>
            <td><?php echo $accountStat->restOvertime;?></td>
            <td><?php echo $accountStat->holidayOvertime;?></td>
            <td><?php echo $accountStat->lieu;?></td>
            <td><?php echo $accountStat->deserve;?></td>
            <td><?php echo $accountStat->actual;?></td>
            <?php if($currentMonth):?>
            <td><?php echo html::a('javascript:;', $lang->edit, "class='singleEdit'")?></td>
            <?php endif;?>
          </tr>
          <tr class='edit hide'>
            <td class='text-middle'><?php echo $users[$account];?></td>
            <td><?php echo html::input("normal[$account]", $accountStat->normal, "class='form-control'");?></td>
            <td><?php echo html::input("late[$account]", $accountStat->late, "class='form-control'");?></td>
            <td><?php echo html::input("early[$account]", $accountStat->early, "class='form-control'");?></td>
            <td><?php echo html::input("absent[$account]", $accountStat->absent, "class='form-control'");?></td>
            <td><?php echo html::input("trip[$account]", $accountStat->trip, "class='form-control'");?></td>
            <td><?php echo html::input("egress[$account]", $accountStat->egress, "class='form-control'");?></td>
            <td><?php echo html::input("paidLeave[$account]", $accountStat->paidLeave, "class='form-control'");?></td>
            <td><?php echo html::input("unpaidLeave[$account]", $accountStat->unpaidLeave, "class='form-control'");?></td>
            <td><?php echo html::input("timeOvertime[$account]", $accountStat->timeOvertime, "class='form-control'");?></td>
            <td><?php echo html::input("restOvertime[$account]", $accountStat->restOvertime, "class='form-control'");?></td>
            <td><?php echo html::input("holidayOvertime[$account]", $accountStat->holidayOvertime, "class='form-control'");?></td>
            <td><?php echo html::input("lieu[$account]", $accountStat->lieu, "class='form-control'");?></td>
            <td><?php echo html::input("deserve[$account]", $accountStat->deserve, "class='form-control'");?></td>
            <td><?php echo html::input("actual[$account]", $accountStat->actual, "class='form-control'");?></td>
            <td class='singleSave hide'><?php echo html::submitButton();?></td>
          </tr>
          <?php endforeach;?>
        </table>
        <?php if($currentMonth):?>
        <div class='page-actions'>
          <?php echo html::a($this->createLink('attend', 'stat', "month=$month&mode=edit"), $lang->edit, "class='btn'");?>
          <?php if($mode == 'edit') echo html::submitButton();?>
        </div>
        <?php endif;?>
      </form>
    </div>
    <?php endif;?>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
