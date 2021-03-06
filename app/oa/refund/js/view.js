$(document).ready(function()
{
    $('#menu .nav li').removeClass('active').find('[href*=' + v.mode + ']').parent().addClass('active');
    if(v.mode == 'reviewed') $('#menu .nav li').find('[href*=unreviewed]').parent().removeClass();

    $('.panel-history a, .table-info a').click(function()
    {
        var href = $(this).prop('href');
        var app  = '';
        if(href.indexOf('/crm/') != -1)  app = 'crm';
        if(href.indexOf('/cash/') != -1) app = 'cash';
        if(href.indexOf('/proj/') != -1) app = 'proj';

        if(app != '' && $(this).data('toggle') == undefined)
        {
            $.openEntry(app, href);
            return false;
        }
    });
})
