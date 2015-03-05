<?php

namespace sitkoru\updater;

use Yii;

/**
 * Class Module
 *
 * @package sitkoru\updater
 */
class Module extends \yii\base\Module
{
    /**
     * @var string Current path to app
     */
    public $path;

    /**
     * @var string Path to releases root dir
     */
    public $releasesDir;

    /**
     * @var string Git url for checkout
     */
    public $gitUrl;

    /**
     * @var float Current version number
     */
    public $currentVersion = 0.0;
    /**
     * @var string Path to version file
     */
    public $versionFilePath = '';
    /**
     * @var string Version file template
     */
    public $versionFileTemplate = <<<EOF
<?php
        define("%constant%", "%version%");

EOF;
    /**
     * @var string Name of version constant to use in APP
     */
    public $versionConstant = 'APP_VERSION';

    /**
     * @var string Prefix to filter git branches
     */
    public $releasePrefix = 'origin/release-';

    /**
     * @var array Update process steps
     */
    public $steps = [
        'before'   => [],
        'composer' => [
            'php composer.phar update --prefer-dist --no-dev'
        ],
        'cache'    => ['./yii cache/flush-all'],
        'after'    => []
    ];

    public $scenarios = [
        'default' => [
            'before',
            'git',
            'composer',
            'migrations',
            'after'
        ]
    ];

    public $nginx = [];

    public $clearCache = true;

    public $defaultRoute = 'release/index';

    /**
     * @var array Classes with static method check(), that can stop or pause update process
     */
    public $appUpdateStoppers = [];

    public $systemSteps = [
        'files',
        'migrations',
        'composerCopy',
        'nginx'
    ];
}
