<?php
$menu = new \App\Models\Menu();
$menuAll = $menu->findAllOrderByNumberInOrder();
//        var_dump($menuAll);
$strMenu = "<ul class='nav navbar-nav' id='menuDoIt' >";
$otkrUL_2 = false;
$otkrLI_1 = false;
  $countMenuAll =  count($menuAll);
$style = "style='font-weight:bolder;color:#144288;'";
foreach ($menuAll as $mI):
    $menuNumberinOrderArray = explode('-', $mI->numberInOrder);
    if (htmlspecialchars($_GET['page']) == $mI->title)
        $aHref = "<a $style href='index.php?page=$mI->title'><span class='$mI->image'></span>$mI->title</a>";
    else
        $aHref = "<a href='index.php?page=$mI->title'><span class='$mI->image'></span>$mI->title</a>";
    if (2 == count($menuNumberinOrderArray)):
        if ($otkrUL_2):
            $strMenu .= "</ul>";
            $otkrUL_2 = false;
            $strMenu .= "</li>";
            $otkrLI_1 = false;
            $strMenu .= "<li>$aHref";
            $otkrLI_1 = true;
        else:
            if ($otkrLI_1):
                $strMenu .= "</li><li>$aHref";
            else:
                $strMenu .= "<li>$aHref";
                $otkrLI_1 = true;
            endif;
        endif;
    else:
        if ($otkrLI_1):
            if ($otkrUL_2):
                $strMenu .= "<li>$aHref</li>";
            else:
                $strMenu .= "<ul><li>$aHref</li>";
                $otkrUL_2 = true;
            endif;
        endif;
    endif;

endforeach;
if ($otkrUL_2):
    $strMenu .= "</ul>";
    $otkrUL_2 = false;
endif;
if ($otkrLI_1):
    $strMenu .= "</li></ul>";
    $otkrLI_1 = false;
endif;

echo "$strMenu";
$thisPage=$_GET['page'];
?>
<script type="text/javascript">

    //добавление класса active для активного пункта меню и сокрытие дочерних li если нет класса active
    $(function(event) {
        // путь текущей страницы
        var pathPage = '<?php echo "$thisPage";?>';
//        var parentUl = $('.navbar-nav a[href*="index.php?'+pathPage+'"]').closest('li').addClass('active').parent('ul');
        var parentUl = $('.navbar-nav a[href*=<?php echo "$thisPage";?>]').closest('li').addClass('active').parent('ul');
        if (parentUl.closest('.navbar-nav li').length) {
                        parentUl.closest('li').addClass('active');
        }
        $('#menuDoIt > li').not('.active').find('li').css('display', 'none');
    });
</script>