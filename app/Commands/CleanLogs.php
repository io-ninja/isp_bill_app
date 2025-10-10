<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CleanLogs extends BaseCommand
{
    protected $group       = 'Maintenance';
    protected $name        = 'logs:clean';
    protected $description = 'Membersihkan log yang lebih lama dari 7 hari';
    protected $usage       = 'logs:clean';

    public function run(array $params)
    {
        $log_path = WRITEPATH . 'logs/';

        $files = glob($log_path . 'log-*.log');
        $now   = time();

        foreach ($files as $file) {
            if (is_file($file)) {
                // Hapus file yang lebih dari 7 hari
                if ($now - filemtime($file) >= 7 * 24 * 60 * 60) {
                    unlink($file);
                    CLI::write("Menghapus: " . basename($file), 'yellow');
                } else {
                    CLI::write("Melewati: " . basename($file), 'black');
                }
            } else {
                CLI::write("File tidak ditemukan: " . basename($file), 'red');
            }
        }

        CLI::write('');
        CLI::write('Pembersihan log selesai.', 'green');
        CLI::write('');
    }
}
