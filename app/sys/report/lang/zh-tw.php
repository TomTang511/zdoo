<?php
/**
 * The report module zh-tw file of RanZhi.
 *
 * @copyright   Copyright 2009-2018 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     report
 * @version     $Id: zh-tw.php 5080 2013-07-10 00:46:59Z wyd621@gmail.com $
 * @link        http://www.ranzhi.org
 */
if(!isset($lang->report)) $lang->report = new stdclass();
$lang->report->common     = '報表';
$lang->report->browse     = '訂單報表、客戶報表、合同報表';
$lang->report->list       = '統計報表';
$lang->report->item       = '條目';
$lang->report->value      = '值';
$lang->report->percent    = '百分比';
$lang->report->undefined  = '未設定';
$lang->report->time       = '時間';
$lang->report->select     = '請選擇報表類型';
$lang->report->create     = '生成報表';
$lang->report->tip        = '註：統計報表的數據，來源於列表頁面的檢索結果，生成統計報表前請先在列表頁面進行檢索。';

$lang->report->options = new stdclass();
$lang->report->options->type   = 'pie';
$lang->report->options->width  = 500;
$lang->report->options->height = 140;

$lang->report->options->graph = new stdclass();
$lang->report->options->graph->xAxisName = 'DEFAULT';
$lang->report->options->graph->caption   = 'DEFAULT';   // 是否顯示柱狀圖陰影。

$lang->report->customer = new stdclass();
$lang->report->customer->common = '客戶報表';
$lang->report->customer->chartList['assignedTo'] = '按指派給統計';
$lang->report->customer->chartList['status']     = '按狀態統計';
$lang->report->customer->chartList['level']      = '按級別統計';
$lang->report->customer->chartList['type']       = '按類型統計';
$lang->report->customer->chartList['size']       = '按規模統計';
$lang->report->customer->chartList['area']       = '按地區統計';
$lang->report->customer->chartList['industry']   = '按行業統計';

$lang->report->customer->item['assignedTo'] = '用戶';
$lang->report->customer->item['status']     = '狀態';
$lang->report->customer->item['level']      = '級別';
$lang->report->customer->item['type']       = '類型';
$lang->report->customer->item['size']       = '規模';
$lang->report->customer->item['area']       = '地區';
$lang->report->customer->item['industry']   = '行業';

$lang->report->customer->value['assignedTo'] = '客戶數';
$lang->report->customer->value['status']     = '客戶數';
$lang->report->customer->value['level']      = '客戶數';
$lang->report->customer->value['type']       = '客戶數';
$lang->report->customer->value['size']       = '客戶數';
$lang->report->customer->value['area']       = '客戶數';
$lang->report->customer->value['industry']   = '客戶數';

/* order setting. */
$lang->report->order = new stdclass();
$lang->report->order->common = '訂單報表';
$lang->report->order->chartList['product']      = '按產品統計（數量）';
$lang->report->order->chartList['productLine']  = '按產品綫統計（數量）';
$lang->report->order->chartList['status']       = '按狀態統計（數量）';
$lang->report->order->chartList['assignedTo']   = '按指派給統計（數量）';
$lang->report->order->chartList['createdBy']    = '按創建者統計（數量）';
$lang->report->order->chartList['year']         = '按年統計（數量）';
$lang->report->order->chartList['month']        = '按月統計（數量）';
$lang->report->order->chartList['productA']     = '按產品統計（金額）';
$lang->report->order->chartList['productLineA'] = '按產品綫統計（金額）';
$lang->report->order->chartList['statusA']      = '按狀態統計（金額）';
$lang->report->order->chartList['assignedToA']  = '按指派給統計（金額）';
$lang->report->order->chartList['createdByA']   = '按創建者統計（金額）';
$lang->report->order->chartList['yearA']        = '按年統計（金額）';
$lang->report->order->chartList['monthA']       = '按月統計（金額）';

$lang->report->order->item['product']      = '產品';
$lang->report->order->item['productLine']  = '產品綫';
$lang->report->order->item['status']       = '狀態';
$lang->report->order->item['assignedTo']   = '指派給';
$lang->report->order->item['createdBy']    = '創建者';
$lang->report->order->item['year']         = '年';
$lang->report->order->item['month']        = '月';
$lang->report->order->item['productA']     = '產品';
$lang->report->order->item['productLineA'] = '產品';
$lang->report->order->item['statusA']      = '狀態';
$lang->report->order->item['assignedToA']  = '指派給';
$lang->report->order->item['createdByA']   = '創建者';
$lang->report->order->item['yearA']         = '年';
$lang->report->order->item['monthA']        = '月';

$lang->report->order->value['product']      = '訂單數';
$lang->report->order->value['productLine']  = '訂單數';
$lang->report->order->value['status']       = '訂單數';
$lang->report->order->value['assignedTo']   = '訂單數';
$lang->report->order->value['createdBy']    = '訂單數';
$lang->report->order->value['year']         = '訂單數';
$lang->report->order->value['month']        = '訂單數';
$lang->report->order->value['productA']     = '成交金額';
$lang->report->order->value['productLineA'] = '成交金額';
$lang->report->order->value['statusA']      = '成交金額';
$lang->report->order->value['assignedToA']  = '成交金額';
$lang->report->order->value['createdByA']   = '成交金額';
$lang->report->order->value['yearA']        = '成交金額';
$lang->report->order->value['monthA']       = '成交金額';

$lang->report->order->options = new stdclass();
$lang->report->order->options->typeList['year']    = 'bar';
$lang->report->order->options->typeList['month']   = 'bar';
$lang->report->order->options->typeList['yearA']   = 'bar';
$lang->report->order->options->typeList['monthA']  = 'bar';

$lang->report->contract = new stdclass();
$lang->report->contract->common = '合同報表';
$lang->report->contract->chartList['status']       = '按合同狀態統計（數量）';
$lang->report->contract->chartList['delivery']     = '按交付狀態統計（數量）';
$lang->report->contract->chartList['return']       = '按回款狀態統計（數量）';
$lang->report->contract->chartList['createdBy']    = '按創建人統計（數量）';
$lang->report->contract->chartList['signedBy']     = '按指派給統計（數量）';
$lang->report->contract->chartList['deliveredBy']  = '按交付人統計（數量）';
//$lang->report->contract->chartList['handlers']     = '按經手人統計（數量）';
$lang->report->contract->chartList['contactedBy']  = '按聯繫人統計（數量）';
$lang->report->contract->chartList['year']         = '按年統計（數量）';
$lang->report->contract->chartList['month']        = '按月統計（數量）';
$lang->report->contract->chartList['statusA']      = '按合同狀態統計（金額）';
$lang->report->contract->chartList['deliveryA']    = '按交付狀態統計（金額）';
$lang->report->contract->chartList['returnA']      = '按回款狀態統計（金額）';
$lang->report->contract->chartList['createdByA']   = '按創建人統計（金額）';
$lang->report->contract->chartList['signedByA']    = '按指派給統計（金額）';
$lang->report->contract->chartList['deliveredByA'] = '按交付人統計（金額）';
//$lang->report->contract->chartList['handlersA']    = '按經手人統計（金額）';
$lang->report->contract->chartList['contactedByA'] = '按聯繫人統計（金額）';
$lang->report->contract->chartList['yearA']        = '按年統計（金額）';
$lang->report->contract->chartList['monthA']       = '按月統計（金額）';

$lang->report->contract->item['status']       = '合同狀態';
$lang->report->contract->item['delivery']     = '交付狀態';
$lang->report->contract->item['return']       = '回款狀態';
$lang->report->contract->item['createdBy']    = '創建人';
$lang->report->contract->item['signedBy']     = '用戶';
$lang->report->contract->item['deliveredBy']  = '交付人';
$lang->report->contract->item['handlers']     = '經手人';
$lang->report->contract->item['contactedBy']  = '聯繫人';
$lang->report->contract->item['year']         = '年';
$lang->report->contract->item['month']        = '月';
$lang->report->contract->item['statusA']      = '訂單狀態';
$lang->report->contract->item['deliveryA']    = '交付狀態';
$lang->report->contract->item['returnA']      = '回款狀態';
$lang->report->contract->item['createdByA']   = '創建人';
$lang->report->contract->item['signedByA']    = '用戶';
$lang->report->contract->item['deliveredByA'] = '交付人';
$lang->report->contract->item['handlersA']    = '經手人';
$lang->report->contract->item['contactedByA'] = '聯繫人';
$lang->report->contract->item['yearA']        = '年';
$lang->report->contract->item['monthA']       = '月';

$lang->report->contract->value['status']       = '合同數';
$lang->report->contract->value['delivery']     = '合同數';
$lang->report->contract->value['return']       = '合同數';
$lang->report->contract->value['createdBy']    = '合同數';
$lang->report->contract->value['signedBy']     = '合同數';
$lang->report->contract->value['deliveredBy']  = '合同數';
$lang->report->contract->value['handlers']     = '合同數';
$lang->report->contract->value['contactedBy']  = '合同數';
$lang->report->contract->value['year']         = '合同數';
$lang->report->contract->value['month']        = '合同數';
$lang->report->contract->value['statusA']      = '合同金額';
$lang->report->contract->value['deliveryA']    = '合同金額';
$lang->report->contract->value['returnA']      = '合同金額';
$lang->report->contract->value['createdByA']   = '合同金額';
$lang->report->contract->value['signedByA']    = '合同金額';
$lang->report->contract->value['deliveredByA'] = '合同金額';
$lang->report->contract->value['handlersA']    = '合同金額';
$lang->report->contract->value['contactedByA'] = '合同金額';
$lang->report->contract->value['yearA']        = '合同金額';
$lang->report->contract->value['monthA']       = '合同金額';

$lang->report->contract->options = new stdclass();
$lang->report->contract->options->typeList['year']    = 'bar';
$lang->report->contract->options->typeList['month']   = 'bar';
$lang->report->contract->options->typeList['yearA']   = 'bar';
$lang->report->contract->options->typeList['monthA']  = 'bar';

/* daily reminder. */
$lang->report->idAB         = 'ID';
$lang->report->orderTitle   = '訂單標題';
$lang->report->taskName     = '任務名稱';
$lang->report->todoName     = '待辦名稱';
$lang->report->customerName = '客戶名稱';

$lang->report->mailTitle                = new stdclass();
$lang->report->mailTitle->begin         = '提醒：您有';
$lang->report->mailTitle->order         = " 亟需聯繫訂單(%s),";
$lang->report->mailTitle->task          = " 任務(%s),";
$lang->report->mailTitle->todo          = " 待辦(%s),";
$lang->report->mailTitle->customer      = " 亟需聯繫客戶(%s),";
$lang->report->mailTitle->contractCount = " 跟蹤的合同數(%s),";
