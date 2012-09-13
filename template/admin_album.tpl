{footer_script require='jquery.ui.sortable'}{literal}
function init_handlers() {
  jQuery(".menuPos").hide();
  jQuery(".drag_button").show();
  jQuery(".menuLi").css("cursor","move");
  jQuery(".menuUl").sortable({
    axis: "y",
    opacity: 0.8
  });
  
  jQuery("#menuOrdering").submit(function(){
    ar = jQuery('.menuUl').sortable('toArray');
    for(i=0;i<ar.length;i++) {
      men = ar[i].split('menu_');
      document.getElementsByName('position[' + men[1] + ']')[0].value = i;
    }
  });
  
  $("a.deletePage").click(function() {
    id = $(this).parents("li.menuLi").attr("id").split("menu_")[1];
    $(this).parents("li.menuLi").remove();
    $("select[name='add_page'] option[value='"+ id +"']").removeAttr("disabled");
  });
}

$("select[name='add_page']").change(function() {
  if ($(this).val() != -1) {
    $option = $(this).children("option:selected");
    $("ul.menuUl").append(
      ' <li class="menuLi" id="menu_'+ $(this).val() +'">'+
        ' <p>'+
        {/literal}
          ' <span style="margin:2px 5px;">'+
            ' <a href="#" class="deletePage"><img src="{$ROOT_URL}{$themeconf.admin_icon_dir}/category_delete.png" alt="{'delete'|@translate}" title="{'delete'|@translate}"></a>'+
          ' </span>'+

          ' <img src="{$themeconf.admin_icon_dir}/cat_move.png" class="button drag_button" style="display:none;" alt="{'Drag to re-order'|@translate}" title="{'Drag to re-order'|@translate}">'+
        {literal}
          ' '+ $option.data("content") +
        ' </p>'+

        ' <p class="menuPos">'+
          ' <label>'+
            ' {/literal}{'Position'|@translate}{literal} :'+
            ' <input type="text" size="4" name="position['+ $(this).val() +']" maxlength="4" value="0">'+
          ' </label>'+
        ' </p>'+
      ' </li>');

    $option.attr("disabled","disabled");
    $(this).val(-1);
    init_handlers();
  }
});

init_handlers();
{/literal}{/footer_script}

{html_head}{literal}
<style type="text/css">#menuOrdering a:hover { border:none; }</style>
{/literal}{/html_head}


<div class="titrePage">
  <h2><span style="letter-spacing:0">{$CATEGORIES_NAV}</span> &#8250; {'Edit album'|@translate} {$TABSHEET_TITLE}</h2>
</div>

<form id="menuOrdering" action="{$F_ACTION}" method="post">
{if count($pages)}
  <p style="margin-bottom:15px;">
    {'ap_add_page'|@translate}
    <select name="add_page">
      <option value="-1" selected="selected">------------</option>
      {foreach from=$pages item=page}
      <option value="{$page.id}" {$page.disabled} data-content="<b><a href='{$page.U_PAGE}'>{$page.title}</a></b>{if $page.standalone == 'true'} - {'ap_standalone_page'|@translate}{/if}{if !empty($page.language)} <i>({$page.language})</i>{/if}">
        {$page.title}
      </option>
      {/foreach}
    </select>
  </p>
{/if}
    
    
  <ul class="menuUl">
    {foreach from=$cat_pages item=page}
    <li class="menuLi" id="menu_{$page.page_id}">
      <p>
        <span style="margin:2px 5px;">
          <a href="#" class="deletePage"><img src="{$ROOT_URL}{$themeconf.admin_icon_dir}/category_delete.png" alt="{'delete'|@translate}" title="{'delete'|@translate}"></a>
        </span>

        <img src="{$themeconf.admin_icon_dir}/cat_move.png" class="button drag_button" style="display:none;" alt="{'Drag to re-order'|@translate}" title="{'Drag to re-order'|@translate}">
        <b><a href="{$page.U_PAGE}">{$page.title}</a></b>
        {if $page.standalone == 'true'} - {'ap_standalone_page'|@translate}{/if}
        {if !empty($page.language)}<i>({$page.language})</i>{/if}
      </p>

      <p class="menuPos">
        <label>
          {'Position'|@translate} :
          <input type="text" size="4" name="position[{$page.page_id}]" maxlength="4" value="{$page.pos}">
        </label>
      </p>
    </li>
    {/foreach}
  </ul>
  <p class="menuSubmit">
    <input type="submit" name="save_pages" value="{'Submit'|@translate}">
    <input type="submit" name="reset" value="{'Reset'|@translate}">
  </p>

</form>