<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once dirname(__DIR__, 2) . '/adm_program/system/common.php';
if (!$gCurrentUser->isAdministrator()) {
    $gMessage->show($gL10n->get('SYS_NO_RIGHTS'));
}
$tableName = 'adm_plugin_supermailer_templates';
$result = $gDb->query("SHOW TABLES LIKE '{$tableName}'");
if ($result->rowCount() === 0) {
    $sql = "CREATE TABLE {$tableName} (
        tpl_id INT AUTO_INCREMENT PRIMARY KEY,
        tpl_name VARCHAR(255) NOT NULL,
        tpl_subject VARCHAR(255) NOT NULL,
        tpl_body TEXT NOT NULL,
        tpl_format ENUM('text', 'html') DEFAULT 'html',
        tpl_create_date DATETIME NOT NULL,
        tpl_last_change DATETIME NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $gDb->query($sql);
    echo '<p><strong>Supermailer erfolgreich installiert!</strong></p>';
} else {
    echo '<p>Supermailer ist bereits installiert.</p>';
}
?>