<?php
/**
 * The index view file of index module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     index 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
include "../../common/view/header.lite.html.php";
css::import($themeRoot . 'default/ips.css');
js::import($jsRoot . 'jquery/ips.js');
?>
  <!-- Desktop -->
  <div id='desktop' class='fullscreen-mode' unselectable="on" style="-moz-user-select:none;-webkit-user-select:none;" onselectstart="return false;">
    <div id='leftBar' class='dock-left'>
      <div id='apps-menu'>
        <ul class='bar-menu'></ul>
      </div>
      <div class='dock-bottom'>
        <div id='apps-actions'>
          <ul class='bar-menu'>
            <li><button class='fullscreen-btn' data-toggle='tooltip' data-placement='right' data-id='allapps' title='<?php echo $lang->index->allEntries?>'><i class='icon-reorder'></i></button></li>
          </ul>
        </div>
        <div id='avatar' data-toggle='tooltip' data-placement='right' title='<?php echo $lang->index->profile?>' class='app-btn' data-id='profile'>
          <img class='avatar-img' src='<?php echo $themeRoot . 'default/images/ips/avatar.jpg'?>' alt=''>
          <div class='avatar-name'><?php echo $app->user->realname?></div>
        </div>
      </div>
    </div>
    <div id='bottomBar' class='dock-bottom'>
      <div id='taskbar'>
        <ul class='bar-menu'>
        </ul>
      </div>
      <div id='bottomRightBar' class='dock-right'>
        <ul class='bar-menu'>
          <li><button id='showDesk' class='fullscreen-btn icon-home' data-toggle-class='icon-check-empty' data-id='home' data-toggle='tooltip' title='<?php echo $lang->index->showDesk; ?>'></button></li>
        </ul>
      </div>
    </div>
    <div id='home' class='fullscreen fullscreen-active'>
      <div class='btn-toolbar actions'><button data-toggle='tooltip' data-placement='bottom' data-id='addblcok' title='<?php echo $lang->index->addBlock; ?>' class='btn btn-pure app-btn'><i class='icon-plus'></i></button><button data-target='#home' data-toggle-class='custom-mode' data-toggle='tooltip' data-placement='bottom' title='<?php echo $lang->index->customBlocks; ?>' class='btn btn-pure'><i class='icon-wrench'></i></button></div>
      <div class='panels-container'>
        <div class='row'>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block1'>
              <div class='panel-heading'>
                <i class='icon-list-ul'></i> Blck Name
                <div class='custom-actions'>
                  <a class='btn btn-mini edit-block' data-toggle='modal' href='<?php echo $this->createLink("block", "edit"); ?>'><i class='icon-pencil'></i></a>
                  <button class='btn btn-mini remove-block btn-danger'><i class='icon-remove'></i></button>
                </div>
              </div>
              <div class='panel-body no-padding'>
                <table class='table table-hover table-condensed'>
                  <tr>
                    <td><strong>Row Title</strong></td>
                    <td><span  class='small'><i class='icon-user'></i> Catouse</span></td>
                    <td class='text-right'><span class='label label-badge'>34</span></td>
                  </tr>
                  <tr>
                    <td><strong>Row Title 2</strong></td>
                    <td><span  class='small'><i class='icon-user'></i> Mouse</span></td>
                    <td class='text-right'><span class='label label-success label label-badge'>34</span></td>
                  </tr>
                  <tr>
                    <td><strong>Row Title 3</strong></td>
                    <td><span  class='small'><i class='icon-user'></i> Cat</span></td>
                    <td class='text-right'></td>
                  </tr>
                  <tr>
                    <td><strong>Row Title 3</strong></td>
                    <td><span  class='small'><i class='icon-user'></i> Cat</span></td>
                    <td class='text-right'><span class='label label-danger label-badge'>10</span></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block2'>
              <div class='panel-heading'>Panel with list group
                <div class='custom-actions'>
                  <button class='btn btn-mini edit-block'><i class='icon-pencil'></i></button>
                  <button class='btn btn-mini remove-block btn-danger'><i class='icon-remove'></i></button>
                </div>
              </div>
              <div class='panel-body no-padding'>
                <div class='list-group'>
                  <a href='###' class='list-group-item'>Haha</a>
                  <a href='###' class='list-group-item'>todo </a>
                  <a href='###' class='list-group-item'>story</a>
                  <a href='###' class='list-group-item'>task active</a>
                  <a href='###' class='list-group-item'>bug</a>
                  <a href='###' class='list-group-item'>case</a>
                </div>
              </div>
            </div>
          </div>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block3'>
              <div class='panel-heading'>Panel Name</div>
              <div class='panel-body'>
                <button class='btn btn-block btn-danger'>HIT ME!</button>
              </div>
            </div>
          </div>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block4'>
              <div class='panel-heading'>Panel Name</div>
              <div class='panel-body'><h1 class="text-center text-muted" style='font-size:60px;line-height:120px'>4</h1></div>
            </div>
          </div>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block5'>
              <div class='panel-heading'>Panel Name</div>
              <div class='panel-body'><h1 class="text-center text-muted" style='font-size:60px;line-height:120px'>5</h1></div>
            </div>
          </div>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block6'>
              <div class='panel-heading'>Panel Name</div>
              <div class='panel-body'><h1 class="text-center text-muted" style='font-size:60px;line-height:120px'>6</h1></div>
            </div>
          </div>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block7'>
              <div class='panel-heading'>Panel Name</div>
              <div class='panel-body'><h1 class="text-center text-muted" style='font-size:60px;line-height:120px'>7</h1></div>
            </div>
          </div>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block8'>
              <div class='panel-heading'>Panel Name</div>
              <div class='panel-body'><h1 class="text-center text-muted" style='font-size:60px;line-height:120px'>8</h1></div>
            </div>
          </div>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block9'>
              <div class='panel-heading'>Panel Name</div>
              <div class='panel-body'><h1 class="text-center text-muted" style='font-size:60px;line-height:120px'>9</h1></div>
            </div>
          </div>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block10'>
              <div class='panel-heading'>Panel Name</div>
              <div class='panel-body'><h1 class="text-center text-muted" style='font-size:60px;line-height:120px'>10</h1></div>
            </div>
          </div>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block11'>
              <div class='panel-heading'>Panel Name</div>
              <div class='panel-body'><h1 class="text-center text-muted" style='font-size:60px;line-height:120px'>11</h1></div>
            </div>
          </div>
          <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='panel' id='block12'>
              <div class='panel-heading'>Panel Name</div>
              <div class='panel-body'><h1 class="text-center text-muted" style='font-size:60px;line-height:120px'>12</h1></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id='allapps' class='fullscreen'>
      <div class='all-apps-panel'>
        <div class='all-apps-head'>
          <div class='row'>
            <div class='col-md-1'>
              <a href='###' id='closeAllApps' class='min-win'><i class='icon-circle-arrow-left'></i></a>
            </div>
            <div class='col-md-3'>
              <h4><i class='icon-th-list'></i> <?php echo $lang->index->allEntries?> &nbsp;<small class='muted'><?php echo $lang->index->countEntries?></small></h4>
            </div>
            <div class='col-md-4'>
              <div class='input-group'>
                <input type='text' class='form-control-clear form-control'>
                <span class='input-group-btn'>
                  <button class='btn btn-clear' type='button'><i class='icon-search'></i></button>
                </span>
              </div>
            </div>
            <div class='col-md-4 text-right'>
              <a class='btn btn-clear' href='admin.php?m=entry&f=create' target='_blank'><i class='icon-plus'></i> <?php echo $lang->index->addEntry?></a>
            </div>
          </div>        
        </div>
        <div class='all-apps-list' id='allAppsList'>
          <ul class='bar-menu'>
          </ul>
        </div>
      </div>      
    </div>
    <div id='deskContainer'>
    </div>
    <div id='modalContainer'>
      
    </div>
  </div>

<script>
var entries = new Array(
{
    id          : 'profile',
    url         : '<?php echo $this->createLink('user', 'profile')?>',
    name        : '<?php echo $lang->user->profile?>',
    type        : 'iframe',
    desc        : '<?php echo $lang->index->profile?>',
    display     : 'fixed',
    size        : 'default',
    menu        : false,
    position    : 'center',
    control     : 'full'
},
{
    id          : 'addblcok',
    url         : '<?php echo $this->createLink("block", "add"); ?>',
    name        : '<?php echo $lang->index->addBlock; ?>',
    type        : 'iframe',
    display     : 'modal',
    size        : 'default',
    menu        : false,
    control     : 'full'
});

<?php echo $allEntries;?>

$(function()
{
    /* start ips */
    $.ipsStart(entries, config);
    $('.entries-count').text(entries.length - 2)
});

</script>
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
?>
</body>
</html>
