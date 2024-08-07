<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) 2021 CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Simpletine\HMVCShield\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Clones an existing module and renames it to a new module.
 */
class PublishConfig extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'SimpleTine';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'publish:config';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Publishes the StnConfig to APPPATH Config folder.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'publish:assets';

    /**
     * The Command's Arguments
     *
     * @var array<string, string>
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array<string, string>
     */
    protected $options = [];

    /**
     * Execute the command.
     */
    public function run(array $params)
    {
        $sourcePath      = __DIR__ . '/../Config/StnConfig.php';
        $destinationPath = APPPATH . 'Config/StnConfig.php';

        if (! file_exists($sourcePath)) {
            CLI::error('Source file not found: ' . $sourcePath);

            return;
        }

        if (copy($sourcePath, $destinationPath)) {
            CLI::write('Config successfully publish to: ' . $destinationPath, 'green');
        } else {
            CLI::error('Failed to publish the config file.');
        }
    }

    /**
     * Recursively copy a directory.
     */
    private function recursiveCopy(string $source, string $dest)
    {
        $dir = opendir($source);
        @mkdir($dest);

        while (false !== ($file = readdir($dir))) {
            if (($file !== '.') && ($file !== '..')) {
                if (is_dir($source . '/' . $file)) {
                    $this->recursiveCopy($source . '/' . $file, $dest . '/' . $file);
                } else {
                    copy($source . '/' . $file, $dest . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
