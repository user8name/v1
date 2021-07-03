<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(24, "mi_wp_products", $Language->MenuPhrase("24", "MenuText"), "wp_productslist.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(12, "mi_wp_products_categories", $Language->MenuPhrase("12", "MenuText"), "wp_products_categorieslist.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(13, "mi_wp_products_tasks", $Language->MenuPhrase("13", "MenuText"), "wp_products_taskslist.php", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
