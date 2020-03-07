<?php

return [
    'sourcePath' => __DIR__ . '/../../',
    'messagePath' => __DIR__,
    'languages' => [
        'en',
        'ru',
    ],
    'translator' => 'Yii::t',
    'sort' => true,
    'overwrite' => true,
    'removeUnused' => false,
    'markUnused' => true,
    'only' => ['*.php'],
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        '/BaseYii.php',
    ],
    'format' => 'php',
];
