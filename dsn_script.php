<?php

if (php_sapi_name() !== 'cli') {
    echo 'ERROR: DSN params configuration can be created only via console invocation.' . PHP_EOL;
    return;
}

echo 'Enter database name: ' . PHP_EOL;
$databaseName = sprintf(
    '%s=%s',
    'MYSQL_DATABASE',
    fgets(STDIN)
);

echo 'Enter user: ' . PHP_EOL;
$databaseUser = sprintf(
    '%s=%s',
    'MYSQL_USER',
    fgets(STDIN)
);

echo 'Enter password: ' . PHP_EOL;
$databasePassword = sprintf(
    '%s=%s',
    'MYSQL_PASSWORD',
    fgets(STDIN)
);

echo 'Enter MySQL root password: ' . PHP_EOL;
$databaseRootPassword = sprintf(
    '%s=%s',
    'MYSQL_ROOT_PASSWORD',
    fgets(STDIN)
);

$handle = fopen(__DIR__ . '/.env', 'wb');
fwrite($handle, $databaseName);
fwrite($handle, $databaseUser);
fwrite($handle, $databasePassword);
fwrite($handle, $databaseRootPassword);
fclose($handle);

