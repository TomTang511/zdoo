<?php
/**
 * The tree module zh-tw file of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->tree->common      = "類目";
$lang->tree->add         = "添加";
$lang->tree->edit        = "編輯";
$lang->tree->children    = "添加子類目";
$lang->tree->delete      = "刪除類目";
$lang->tree->browse      = "類目維護";
$lang->tree->manage      = "維護類目";
$lang->tree->fix         = "修復數據";

$lang->tree->noCategories  = '您還沒有添加類目，請添加類目。';
$lang->tree->noBoards      = '您還沒有設置版塊，請設置版塊。';
$lang->tree->timeCountDown = "<strong id='countDown'>3</strong> 秒後轉向%s管理頁面。";
$lang->tree->redirect      = '立即轉向';
$lang->tree->aliasRepeat   = '別名: %s 已經存在,不能重複添加。';
$lang->tree->aliasConflict = '別名: %s 與系統模組衝突，不能添加。';
$lang->tree->hasChildren   = '該版塊存在子版塊，不能刪除。';
$lang->tree->hasThreads    = '該版塊存在帖子，不能刪除。';
$lang->tree->confirmDelete = "您確定刪除該類目嗎？";
$lang->tree->successFixed  = "成功修復";

/* Lang items for article, products. */
$lang->category = new stdclass();
$lang->category->common   = '類目';
$lang->category->name     = '類目名稱';
$lang->category->alias    = '別名';
$lang->category->parent   = '上級類目';
$lang->category->desc     = '描述';
$lang->category->keywords = '關鍵詞';
$lang->category->children = "子類目";

/* Lang items for area. */
$lang->area = new stdclass();
$lang->area->common   = '區域';
$lang->area->name     = '名稱';
$lang->area->alias    = '別名';
$lang->area->parent   = '上級區域';
$lang->area->desc     = '描述';
$lang->area->keywords = '關鍵詞';
$lang->area->children = "子區域";

/* Lang items for industry. */
$lang->industry = new stdclass();
$lang->industry->common   = '行業';
$lang->industry->name     = '名稱';
$lang->industry->alias    = '別名';
$lang->industry->parent   = '上級行業';
$lang->industry->desc     = '描述';
$lang->industry->keywords = '關鍵詞';
$lang->industry->children = "子行業";

/* Lang items for income. */
$lang->in = new stdclass();
$lang->in->common   = '收入科目';
$lang->in->name     = '名稱';
$lang->in->alias    = '別名';
$lang->in->parent   = '上級科目';
$lang->in->desc     = '描述';
$lang->in->keywords = '關鍵詞';
$lang->in->children = '子科目';

/* Lang items for expend. */
$lang->out = new stdclass();
$lang->out->common   = '支出科目';
$lang->out->name     = '名稱';
$lang->out->alias    = '別名';
$lang->out->parent   = '上級科目';
$lang->out->desc     = '描述';
$lang->out->keywords = '關鍵詞';
$lang->out->children = '子科目';

/* Lang items for forum. */
$lang->board = new stdclass();
$lang->board->common     = '版塊';
$lang->board->name       = '版塊';
$lang->board->alias      = '別名';
$lang->board->parent     = '上級版塊';
$lang->board->desc       = '描述';
$lang->board->keywords   = '關鍵詞';
$lang->board->children   = "子版塊";
$lang->board->readonly   = '訪問權限';
$lang->board->moderators = '版主';

$lang->board->readonlyList[0] = '開放';
$lang->board->readonlyList[1] = '只讀';

$lang->board->placeholder = new stdclass();
$lang->board->placeholder->moderators  = '會員用戶名, 多個用戶名之間用逗號隔開';
$lang->board->placeholder->setChildren = '論壇功能需要設置二級版塊。';
