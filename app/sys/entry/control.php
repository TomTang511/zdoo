<?php
/**
 * The control file of entry module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entry 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class entry extends control
{
    /**
     * Manage all entries.
     * 
     * @access public
     * @return void
     */
    public function admin()
    {
        $entries = $this->entry->getEntries();
        /* add web root if logo not start with /  */
        foreach($entries as $entry) if(!empty($entry->logo) && substr($entry->logo, 0, 1) != '/') $entry->logo = $this->config->webRoot . $entry->logo;
        
        $this->view->title       = $this->lang->entry->common . $this->lang->colon . $this->lang->entry->admin;
        $this->view->position[]  = $this->lang->entry->common;
        $this->view->position[]  = $this->lang->entry->admin;
        $this->view->entries     = $entries;
        $this->display();
    }

    /**
     * Create auth.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if(!empty($_POST))
        {
            if(!$this->post->buildin and !preg_match('/https?\:\/\//Ui', $this->post->login)) $this->send(array('result' => 'fail', 'message' => $this->lang->entry->error->url));

            $entryID = $this->entry->create();
            $this->entry->updateLogo($entryID);
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate'=>inlink('admin'), 'entries' => $this->entry->getJSONEntries()));
        }
        $this->view->title      = $this->lang->entry->common . $this->lang->colon . $this->lang->entry->create;
        $this->view->key        = $this->entry->createKey();
        $this->view->groups     = $this->loadModel('group')->getPairs();
        $this->view->position[] = $this->lang->entry->common;
        $this->view->position[] = $this->lang->entry->create;
        $this->display();
    }

    /**
     * Visit entry.
     * 
     * @param  int    $entryID 
     * @param  string $referer 
     * @access public
     * @return void
     */
    public function visit($entryID, $referer = '')
    {
        $referer = !empty($_GET['referer']) ? $this->get->referer : $referer;
        $entry   = $this->entry->getById($entryID);

        /* deny if no this app rights. */
        if(!commonModel::hasAppPriv($entry->code)) $this->loadModel('common', 'sys')->deny($this->app->getModuleName(), $this->app->getMethodName());

        $location = $entry->login;
        $pathinfo = parse_url($location);
        if($entry->integration)
        {
            $token = $this->loadModel('sso')->createToken(session_id(), $entryID);
            if(!empty($pathinfo['query']))
            {
                $location = rtrim($location, '&') . "&token=$token";
            }
            else
            {
                $location = rtrim($location, '?') . "?token=$token";
            }
            if(!empty($referer)) $location .= '&referer=' . $referer;
        }

        $this->locate($location);
    }

    /**
     * Logout 
     * 
     * @param  int    $entryID 
     * @access public
     * @return void
     */
    public function logout($entryID)
    {
        $entry  = $this->entry->getById($entryID);
        $logout = $entry->logout;
        $token  = $this->loadModel('sso')->createToken(session_id(), $entryID);

        if(strpos('&', $logout) !== false)
        {
            $location = rtrim($logout, '&') . "&token=$token";
        }
        else
        {
            $location = rtrim($logout, '?') . "?token=$token";
        }

        $this->locate($location);
    }

    /**
     * Edit auth.
     * 
     * @param  string $code 
     * @access public
     * @return void
     */
    public function edit($code)
    {
        if(!empty($_POST))
        {
            if(!$this->post->buildin and !preg_match('/https?\:\/\//Ui', $this->post->login)) $this->send(array('result' => 'fail', 'message' => $this->lang->entry->error->url));

            $entryID = $this->entry->update($code);
            $this->entry->updateLogo($entryID);
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror()));
            $this->send(array('result' => 'success', 'locate' => inlink('admin'), 'entries' => $this->entry->getJSONEntries()));
        }

        $entry = $this->entry->getByCode($code);
        if($entry->size != 'max')
        {
            $size = json_decode($entry->size);
            $entry->size   = 'custom';
            $entry->width  = $size->width;
            $entry->height = $size->height;
        }

        $this->view->title      = $this->lang->entry->common . $this->lang->colon . $this->lang->entry->edit;
        $this->view->position[] = $this->lang->entry->common;
        $this->view->position[] = $this->lang->entry->edit;

        $this->view->entry = $entry;
        $this->view->code  = $code;
        $this->display();
    }

    /**
     * Order entry. 
     * 
     * @access public
     * @return void
     */
    public function order()
    {
        if($_POST)
        {
            /* Sort entries by order and id. */
            $entries = array();
            foreach($this->post->order as $id => $order)
            {
                $entry        = new stdclass();
                $entry->id    = $id;
                $entry->order = $order;
                $entries[]    = $entry;
            }
            usort($entries, 'commonModel::sortEntryByOrder');

            /* Update order. */
            $order = 10;
            foreach($entries as $entry)
            {
                $this->dao->update(TABLE_ENTRY)->set('`order`')->eq($order)->where('id')->eq($entry->id)->exec();
                $order += 10;
            }
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            /* delete custome sort data. */
            $allEntries = isset($this->config->personal->common->customApp) ? json_decode($this->config->personal->common->customApp->value) : new stdclass();
            foreach($allEntries as $entry)
            {
                unset($entry->order);
            }
            $this->loadModel('setting')->setItem("{$this->app->user->account}.sys.common.customApp", json_encode($allEntries));

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin'), 'entries' => $this->entry->getJSONEntries()));
        }
    }

    /**
     * Sort entries.
     * 
     * @access public
     * @return void
     */
    public function sort()
    {
        if(!empty($_POST))
        {
            if(!$this->post->name)  die(js::alert($this->lang->entry->error->name));
            if(!$this->post->ip)    die(js::alert($this->lang->entry->error->ip));

            $this->entry->updateEntry($code);
            if(dao::isError()) die(js::error(dao::getError()));
            $this->send(array('result' => 'success', 'locate'=>inlink('admin')));
        }

        $this->view->title      = $this->lang->entry->common . $this->lang->colon . $this->lang->entry->sort;
        $this->view->position[] = $this->lang->entry->common;
        $this->view->position[] = $this->lang->entry->sort;

        $this->view->entries = $this->entry->getEntries();
        $this->display();
    }

    /**
     * Delete entry.
     * 
     * @param  string $code 
     * @param  string $confirm 
     * @access public
     * @return void
     */
    public function delete($code)
    {
        if($this->entry->delete($code)) $this->send(array('result' => 'success', 'entries' => $this->entry->getJSONEntries()));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Get all departments.
     * 
     * @param  string $entry 
     * @access public
     * @return void
     */
    public function depts($entry)
    {
        if($this->post->key) $key = $this->post->key;
        if($this->get->key)  $key = $this->get->key;
        if($this->entry->checkIP($entry) and $this->entry->getAppKey($entry) == $key)
        {
            $depts = $this->entry->getAllDepts();
            $response['status'] = 'success';
            $response['data']   = json_encode($depts);
            $this->send($response);
        }

        $response['status'] = 'fail';
        $response['data']   = 'key error';
        $this->send($response);
    }

    /**
     * Get all users. 
     * 
     * @param  string $entry 
     * @access public
     * @return void
     */
    public function users($entry)
    {
        if($this->post->key) $key = $this->post->key;
        if($this->get->key)  $key = $this->get->key;
        if($this->entry->checkIP($entry) and $this->entry->getAppKey($entry) == $key)
        {
            $depts = $this->entry->getAllUsers();
            $response['status'] = 'success';
            $response['data']   = json_encode($depts);
            $this->send($response);
        }

        $response['status'] = 'fail';
        $response['data']   = 'key error';
        $this->send($response);
    }

    /**
     * Get entry blocks.
     * 
     * @param  int    $entryID 
     * @param  int    $index 
     * @access public
     * @return void
     */
    public function blocks($entryID, $index = 0)
    {
        $entry  = $this->entry->getByCode($entryID);
        if($entry->buildin)
        {
            $this->get->set('mode', 'getblocklist');
            $this->get->set('hash', $entry->key);
            $this->get->set('lang', $this->app->getClientLang());
            $blocks = $this->fetch('block', 'index', array(), $entry->code);
            $blocks = json_decode($blocks, true);
        }
        else
        {
            $blocks = $this->entry->getBlocksByAPI($entry);
        }

        if(empty($blocks)) return false;

        $blockPairs = array('' => '') + $blocks;

        $block = $this->loadModel('block')->getBlock($index);

        echo "<th>{$this->lang->entry->lblBlock}</th>";
        echo '<td>' . html::select('entryBlock', $blockPairs, ($block and $block->source != '') ? $block->block : '', "class='form-control' onchange='getBlockParams(this.value, \"$entryID\")'") . '</td>';
        if(isset($block->source)) echo "<script>$(function(){getBlockParams($('#entryBlock').val(), '{$block->source}')})</script>";
    }

    /**
     * Set block that is from entry.
     * 
     * @param  int    $index 
     * @param  int    $entryID 
     * @param  int    $blockID 
     * @access public
     * @return void
     */
    public function setBlock($index, $entryID, $blockID)
    {
        $block = $this->loadModel('block')->getBlock($index);

        $entry  = $this->entry->getByCode($entryID);
        if($entry->buildin)
        {
            $this->get->set('mode', 'getblockform');
            $this->get->set('blockid', $blockID);
            $this->get->set('hash', $entry->key);
            $this->get->set('lang', $this->app->getClientLang());
            $params = $this->fetch('block', 'index', array(), $entry->code);
            $params = json_decode($params, true);
        }
        else
        {
            $params = $this->entry->getBlockParams($entry, $blockID);
        }

        $this->view->params  = $params;
        $this->view->block   = $block ? $block : array();
        $this->view->index   = $index;
        $this->view->blockID = $blockID;
        $this->view->entryID = $entryID;
        $this->display();
    }

    /**
     * Print buildin entry block.
     * 
     * @param  int    $index 
     * @access public
     * @return void
     */
    public function printBlock($index)
    {
        $block = $this->loadModel('block')->getBlock($index);
        if(empty($block)) return false;
        if($block->source == '') $this->locate($this->createLink('block', 'printBlock', "index=$index"));

        $entry = $this->loadModel('entry')->getByCode($block->source);
        if(!$entry->buildin) $this->locate($this->createLink('block', 'printBlock', "index=$index"));

        $html = '';
        $block->params->account = $this->app->user->account;
        $block->params->uid     = $this->app->user->id;
        $params = base64_encode(json_encode($block->params));

        $this->get->set('mode', 'getblockdata');
        $this->get->set('blockid', $block->block);
        $this->get->set('hash', $entry->key);
        $this->get->set('entry', $entry->id);
        $this->get->set('app', 'sys');
        $this->get->set('lang', $this->app->getClientLang());
        $this->get->set('sso', base64_encode(commonModel::getSysURL() . helper::createLink('entry', 'visit', "entry=$entry->id")));
        $this->get->set('param', $params);
        $html = $this->fetch('block', 'index', array(), $entry->code);

        die($html);
    }

    /**
     * custom sort apps. 
     * 
     * @access public
     * @return void
     */
    public function customSort()
    {
        if($_POST)
        {
            $orders = $_POST;
            $allEntries = isset($this->config->personal->common->customApp) ? json_decode($this->config->personal->common->customApp->value) : new stdclass();
            /* Merge entries settings. */
            foreach($orders as $id => $order)
            {
                if(!isset($allEntries->$id))
                {
                    $allEntries->$id = new stdclass();
                    $allEntries->{$id}->id = $id;
                }
                $allEntries->{$id}->order = $order * 10;
            }
            $this->loadModel('setting')->setItem("{$this->app->user->account}.sys.common.customApp", json_encode($allEntries));
            if(dao::isError()) $this->send(array('result' => 'fael', 'message' => dao::getError()));
        }
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
    }

    /**
     * update entry menu. 
     * 
     * @access public
     * @return void
     */
    public function updateEntryMenu()
    {
        if($_POST)
        {
            $id      = $this->post->id;
            $visible = $this->post->menu == 'all' ? 1 : 0;
            $allEntries = isset($this->config->personal->common->customApp) ? json_decode($this->config->personal->common->customApp->value) : new stdclass();
            if(!isset($allEntries->$id))
            {
                $allEntries->$id = new stdclass();
                $allEntries->{$id}->id = $id;
            }
            $allEntries->{$id}->visible = $visible;
            $this->loadModel('setting')->setItem("{$this->app->user->account}.sys.common.customApp", json_encode($allEntries));
            if(dao::isError()) $this->send(array('result' => 'fael', 'message' => dao::getError()));
        }
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
    }
}
