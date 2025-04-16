<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('SERVER_PATH', dirname(__DIR__, 2));
require_once SERVER_PATH . '/adm_program/system/common.php';
require_once SERVER_PATH . '/adm_program/system/login_valid.php';
require_once 'classes/TemplateManager.php';

$pageTitle = $gL10n->get('PLUGIN_SUPERMAILER_NAME');
require_once SERVER_PATH . '/adm_program/system/overall_header.php';

$templateManager = new TemplateManager($gDb);

// Löschen
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $templateManager->deleteTemplate($id);
    $gMessage->show('Vorlage wurde gelöscht.');
}

// Speichern
if (isset($_POST['submit_template'])) {
    if (!empty($_POST['tpl_name']) && !empty($_POST['tpl_subject']) && !empty($_POST['tpl_body'])) {
        $gDb->startTransaction();
        $templateManager->saveTemplate(
            $_POST['tpl_name'],
            $_POST['tpl_subject'],
            $_POST['tpl_body'],
            $_POST['tpl_format']
        );
        $gDb->endTransaction();
        $gMessage->show($gL10n->get('PLUGIN_SUPERMAILER_TEMPLATE_SAVED'));
    }
}

$templates = $templateManager->getAllTemplates();
?>

<div class="formLayout">
    <div class="formHead"><?= $pageTitle ?></div>
    <div class="formBody">

        <form method="post">
            <div class="form-group">
                <label for="tpl_name"><?= $gL10n->get('PLUGIN_SUPERMAILER_TEMPLATE_NAME') ?></label>
                <input type="text" name="tpl_name" id="tpl_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="tpl_subject"><?= $gL10n->get('PLUGIN_SUPERMAILER_TEMPLATE_SUBJECT') ?></label>
                <input type="text" name="tpl_subject" id="tpl_subject" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="tpl_body"><?= $gL10n->get('PLUGIN_SUPERMAILER_TEMPLATE_BODY') ?></label>
                <textarea name="tpl_body" id="tpl_body" rows="6" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="tpl_format"><?= $gL10n->get('PLUGIN_SUPERMAILER_TEMPLATE_FORMAT') ?></label>
                <select name="tpl_format" id="tpl_format" class="form-control">
                    <option value="html">HTML</option>
                    <option value="text">Text</option>
                </select>
            </div>

            <button class="btn btn-primary" type="submit" name="submit_template">
                <?= $gL10n->get('PLUGIN_SUPERMAILER_BUTTON_SAVE') ?>
            </button>
        </form>
    </div>
</div>

<br><br>

<div class="formLayout">
    <div class="formHead"><?= $gL10n->get('PLUGIN_SUPERMAILER_TEMPLATES_LIST') ?></div>
    <div class="formBody">
        <?php if (count($templates) > 0): ?>
            <ul class="list-group">
            <?php foreach ($templates as $tpl): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <strong><?= htmlspecialchars($tpl['tpl_name']) ?></strong> –
                        <?= htmlspecialchars($tpl['tpl_subject']) ?> (<?= $tpl['tpl_format'] ?>)
                    </span>
                    <a href="?delete=<?= $tpl['tpl_id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Wirklich löschen?');">
                       <i class="fas fa-trash-alt"></i> Löschen
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Keine Vorlagen vorhanden.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once SERVER_PATH . '/adm_program/system/overall_footer.php'; ?>
