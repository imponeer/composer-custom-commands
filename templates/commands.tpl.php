<?= '<' . '?php'; ?>

/**
* This file was automatically generated when composer-custom-command found out that
* somebody did composer install/update/dump command. So, don't change it!
*/

<?php foreach ($includes as $file): ?>
	file_exists(<?= var_export($file, true); ?>) && include_once(<?= var_export($file, true); ?>);
<?php endforeach; ?>

return <?= var_export($classes, true); ?>;