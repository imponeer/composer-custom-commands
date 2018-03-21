<?= '<' . '?php'; ?>

/**
* This file was automatically generated when composer-custom-command found out that
* somebody did composer install/update/dump command. So, don't change it!
*/

use Imponeer\\ComposerCustomCommands\\ProxyCommand;

<?php foreach ($includes as $file): ?>
	if (file_exists($file)) {
	include_once <?= var_export($file, true); ?>;
	}
<?php endforeach; ?>

return array_map(
'ProxyCommand::create',
array_filter(
'class_exists',
<?= var_export($classes, true); ?>
)
);