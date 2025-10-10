<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CleanSession extends BaseCommand
{
    protected $group       = 'Maintenance';
    protected $name        = 'clean:session';
    protected $description = 'Clean up session files older than 7 days from the writable/session folder';

    public function run(array $params)
    {
        // Path to the session folder
        $sessionPath = WRITEPATH . 'session/'; // /writable/session
        $daysAgo     = 1/24; // 1 hour ago
        $timeLimit   = time() - ($daysAgo * 24 * 60 * 60); // 7 days ago in Unix timestamp

        if (!is_dir($sessionPath)) {
            CLI::error("The session path '$sessionPath' is not valid.");
            return;
        }

        $files = glob($sessionPath . 'ci_*'); // Assuming session files start with 'ci_'
        $deletedFilesCount = 0;

        foreach ($files as $file) {
            if (filemtime($file) < $timeLimit) {
                if (unlink($file)) {
                    $deletedFilesCount++;
                }
            }
        }

        CLI::write("$deletedFilesCount session file(s) older than $daysAgo days have been deleted.", 'green');
    }
}
