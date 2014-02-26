<?php
/**
 *
 * PHP version 5
 *
 * Created by PhpStorm.
 * User: Георгий
 * Date: 24.02.14
 * Time: 12:42
 */

namespace sitkoru\updater;

use sitkoru\updater\components\Console;
use Yii;
use yii\console\Exception;

/**
 * Class Module
 *
 * @package sitkoru\updater
 */
class Module extends \yii\base\Module
{
    /**
     * @var string Path to app
     */
    public $path;

    /**
     * @var float Current version number
     */
    public $currentVersion = 0.0;
    /**
     * @var string Path to version file
     */
    public $versionFilePath = "";
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
    public $versionConstant = "APP_VERSION";

    /**
     * @var string Prefix to filter git branches
     */
    public $releasePrefix = "origin/release-";

    /**
     * @var array Commands to compile assets
     */
    public $assetsCommands = [];

    /**
     * @var array Composer commands to run
     */
    public $composerCommands = [
        'curl -sS https://getcomposer.org/installer | php',
        'php composer.phar update --no-dev'
    ];

    public $clearCache = true;

    public function init()
    {
        parent::init();
        if ($this->path == "") {
            throw new Exception("You should set path to app");
        }
        if ($this->versionFilePath == "") {
            throw new Exception("You should set path to version file");
        }
        if ($this->currentVersion == 0.0) {
            Console::output("Maybe you forget to set current version");
        }
        if ($this->assetsCommands == []) {
            Console::output("Maybe you forget to set assets commands");
        }

    }
} 