<?php
/**
 * The control file of tree module of RanZhi.
 *
 * @copyright   Copyright 2009-2018 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id: control.php 4145 2016-10-14 05:31:16Z liugang $
 * @link        http://www.ranzhi.org
 */
class tree extends control
{
    const NEW_CHILD_COUNT = 5;

    /**
     * Browse the categories and print manage links.
     * 
     * @param  string $type 
     * @param  int    $startModule 
     * @param  int    $root 
     * @param  string $from
     * @access public
     * @return void
     */
    public function browse($type = 'article', $startModule = 0, $root = 0, $from = '')
    {
        if(strpos($this->config->tree->menuGroup->category, ',' . $type . ',') !== false and isset($this->lang->$type->menu))
        {
            $this->lang->tree->menu = $this->lang->$type->menu;
            $this->lang->menuGroups->tree = $type;
        }
        elseif(strpos($this->config->tree->menuGroup->setting, ',' . $type . ',') !== false)
        {
            if($type != 'blog')  $this->lang->category = $this->lang->$type;
            if($type == 'forum') $this->lang->category = $this->lang->board;

            $this->lang->tree->menu = isset($this->lang->setting->menu) ? $this->lang->setting->menu : '';
            $this->lang->menuGroups->tree = 'setting';

            if($type == 'dept' and !isset($this->lang->setting->menu))
            {
                unset($this->lang->tree->menu);
                $this->lang->menuGroups->tree = 'user';
            }
        }
        elseif(strpos($type, 'doc') !== false)
        {
            if($this->session->docFrom == 'doc') $this->loadModel('doc', 'doc')->setMainMenu();
            $this->lang->menuGroups->tree = 'doc';
            $this->view->lib = $this->loadModel('doc', 'doc')->getLibById($root);
            $this->view->projects = $this->loadModel('project', 'proj')->getPairs();
        }
        elseif(strpos($this->config->tree->menuGroup->product, ',' . $type . ',') !== false && isset($this->lang->$from->menu))
        {
            $this->lang->tree->menu = $this->lang->$from->menu;
            $this->lang->menuGroups->tree = $from;
        }
        $this->view->title    = $this->lang->category->common;
        $this->view->type     = $type;
        $this->view->root     = $root;
        $this->view->moduleID = $startModule;
        $this->view->treeMenu = $this->tree->getTreeMenu($type, 0, array('treeModel', 'createManageLink'), $root);
        $this->view->children = $this->tree->getChildren($startModule, $type, $root);

        $this->display();
    }

    /**
     * Edit a category.
     * 
     * @param  int      $categoryID 
     * @access public
     * @return void
     */
    public function edit($categoryID)
    {
        /* Get current category. */
        $category = $this->tree->getById($categoryID);

        if($category->type == 'out') $this->tree->checkRight($category->id);

        /* If type is forum, assign board to category. */
        if($category->type != 'blog' and strpos($this->config->tree->menuGroup->setting, ',' . $category->type . ',') !== false) $this->lang->category = $this->lang->{$category->type};
        if($category->type == 'forum') $this->lang->category = $this->lang->board;
        if($category->type == 'dept')
        {
            $this->app->loadLang('user');
            $this->lang->category = $this->lang->dept;
        }

        if(!empty($_POST))
        {
            $result = $this->tree->update($categoryID);
            if($result === true) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));

            $this->send(array('result' => 'fail', 'message' => dao::isError() ? dao::getError() : $result));
        }

        /* Get option menu and remove the families of current category from it. */
        $optionMenu = $this->tree->getOptionMenu($category->type, 0, false, $category->root);
        $families   = $this->tree->getFamily($categoryID, $category->type, $category->root);
        foreach($families as $member) unset($optionMenu[$member]);

        /* Assign. */
        $this->view->category   = $category;
        $this->view->optionMenu = $optionMenu;
        $this->view->aliasAddon = trim("http://" . $this->server->http_host . $this->config->webRoot, '/' ). '/';

        if(strpos('forum,blog', $category->type) !== false) $this->view->aliasAddon .=  $category->type . '/';

        if($category->type == 'dept' or $category->type == 'forum' or $category->type == 'blog') $this->view->users = $this->loadModel('user')->getPairs('nodeleted,nodeleted,noclosed');

        $groups = $this->loadModel('group')->getPairs();
        $this->view->groups = $groups;

        /* remove left menu. */
        unset($this->lang->tree->menu);

        $this->display();
    }

    /**
     * Merge category for trade.
     * 
     * @param  string  $type 
     * @access public
     * @return void
     */
    public function merge($type = 'in')
    {
        if($_POST)
        {
            $result = $this->tree->merge($type);
            if(is_array($result)) $this->send($result);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'reload'));
        }

        $this->view->title      = $this->lang->tree->merge;
        $this->view->type       = $type;
        $this->view->categories = $this->tree->getOptionMenu($type, 0, $removeRoot = true);
        $this->display();
    }

    /**
     * Manage children.
     *
     * @param  string    $type 
     * @param  int       $category    the current category id.
     * @param  int       $root
     * @access public
     * @return void
     */
    public function children($type, $category = 0, $root = 0)
    {
        /* If type is forum, assign board to category. */
        if($type != 'blog' and strpos($this->config->tree->menuGroup->setting, ',' . $type . ',') !== false) $this->lang->category = $this->lang->$type;
        if($type == 'forum')
        {
            $this->lang->category = $this->lang->board;
            $this->view->boardChildrenCount = $this->dao->select('count(*) as count')->from(TABLE_CATEGORY)->where('grade')->eq(2)->andWhere('type')->eq('forum')->fetch('count');
        }
        if($type == 'dept')
        {
            $this->app->loadLang('user');
            $this->lang->category = $this->lang->dept;
        }

        if($type == 'out' and $category) $this->tree->checkRight($category);

        if(!empty($_POST))
        { 
            $result = $this->tree->manageChildren($type, $this->post->parent, $this->post->children, $root);
            $locate = $this->inLink('browse', "type=$type&category={$this->post->parent}&root=$root");
            if($result === true) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $locate));
            $this->send(array('result' => 'fail', 'message' => dao::isError() ? dao::getError() : $result));
        }

        $this->view->title    = $this->lang->tree->manage;
        $this->view->type     = $type;
        $this->view->root     = $root;
        $this->view->children = $this->tree->getChildren($category, $type, $root);
        $this->view->origins  = $this->tree->getOrigin($category);
        $this->view->parent   = $category;

        $this->display();
    }

    /**
     * Delete a category.
     * 
     * @param  int    $categoryID 
     * @access public
     * @return void
     */
    public function delete($categoryID)
    {
        /* If type is 'forum' and has children, warning. */
        $category = $this->tree->getByID($categoryID);
        if($category->major) return false;

        if($category->type == 'out') $this->tree->checkRight($categoryID);

        $children = $this->tree->getChildren($categoryID, $category->type); 
        if($children) $this->send(array('result' => 'fail', 'message' => $this->lang->tree->hasChildren));

        if($category->type == 'forum') 
        {
            $threads = $this->loadModel('thread')->getList($category->id);
            if($threads) $this->send(array('result' => 'fail', 'message' => $this->lang->tree->hasThreads));
        }

        if($category->type == 'product')
        {
            $products = $this->loadModel('product')->getPairs($status = '', $category->id);
            if($products) $this->send(array('result' => 'fail', 'message' => $this->lang->tree->hasProducts));
        }
 
        if($this->tree->delete($categoryID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Redirect to tree browse when no categories
     * 
     * @param  string $message 
     * @access public
     * @return void
     */
    public function redirect($type = 'article')
    {
        unset($this->lang->tree->menu);
        if($type == 'forum') $message = $this->lang->tree->noBoards;
        $this->view->message = !empty($message) ? $message : $this->lang->tree->noCategories;
        $this->view->type    = $type;

        $this->display();
    }
}
