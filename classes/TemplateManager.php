<?php
class TemplateManager {
    private $db;
    public function __construct($gDb) {
        $this->db = $gDb;
    }

    public function getAllTemplates() {
        $stmt = $this->db->query("SELECT * FROM adm_plugin_supermailer_templates ORDER BY tpl_create_date DESC");
        return $stmt->fetchAll();
    }

    public function saveTemplate($name, $subject, $body, $format) {
        $now = date('Y-m-d H:i:s');
        $name = addslashes($name);
        $subject = addslashes($subject);
        $body = addslashes($body);
        $format = addslashes($format);
        $sql = "INSERT INTO adm_plugin_supermailer_templates
            (tpl_name, tpl_subject, tpl_body, tpl_format, tpl_create_date, tpl_last_change)
            VALUES ('{$name}', '{$subject}', '{$body}', '{$format}', '{$now}', '{$now}')";
        $this->db->query($sql);
    }

    public function deleteTemplate($id) {
        $id = (int)$id;
        $sql = "DELETE FROM adm_plugin_supermailer_templates WHERE tpl_id = {$id}";
        $this->db->query($sql);
    }
}
?>