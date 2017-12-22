<?php
if (isset($_REQUEST["generate"])) {
    msv_genegate_sitemap();
    msv_message_ok("Sitemap successfully generated.");
}

$sitemapPath = ABS."/sitemap.xml";
if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
    file_put_contents($sitemapPath, $_POST["form_sitemap_content"]);
}
if (file_exists($sitemapPath)) {
    $robotsCont = file_get_contents($sitemapPath);
    msv_assign_data("admin_sitemap", $robotsCont);
} else {
    msv_message_error("$sitemapPath ."._t("not_found"));
}

if (isset($_REQUEST["edit_mode"])) {
    msv_assign_data("admin_sitemap_edit_mode", true);
}


