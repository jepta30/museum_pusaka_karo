<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SyncSqliteToMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:sync-to-mysql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all data from SQLite database to MySQL database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting data synchronization from SQLite to MySQL...');

        $mysqlConnection = DB::connection('mysql');
        $sqliteConnection = DB::connection('sqlite');

        // Nonaktifkan foreign key checks di MySQL sementara
        $mysqlConnection->statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            // Dapatkan semua tabel dari SQLite
            $schemaTables = Schema::connection('sqlite')->getTables();
            $tables = array_map(function($table) {
                return $table['name'];
            }, $schemaTables);
            
            // Tabel yang perlu kita sinkronisasi (mungkin ingin mengecualikan migrations atau sqlite_sequence)
            $tablesToSync = array_filter($tables, function ($table) {
                return !in_array($table, ['migrations', 'sqlite_sequence']);
            });

            foreach ($tablesToSync as $table) {
                $this->info("Syncing table: {$table}");
                
                // Hapus data lama di MySQL jika ada (opsional, tapi migrate:fresh sudah melakukan ini)
                $mysqlConnection->table($table)->truncate();

                // Ambil semua data dari tabel SQLite
                $rows = $sqliteConnection->table($table)->get()->map(function($row) {
                    return (array) $row;
                })->toArray();

                if (count($rows) > 0) {
                    // Masukkan ke MySQL dalam chunk untuk mencegah memory limit
                    $chunks = array_chunk($rows, 500);
                    foreach ($chunks as $chunk) {
                        $mysqlConnection->table($table)->insert($chunk);
                    }
                    $this->info("  -> Inserted " . count($rows) . " rows.");
                } else {
                    $this->info("  -> Table is empty.");
                }
            }

            $this->info('Synchronization completed successfully!');
        } catch (\Exception $e) {
            $this->error('Error during synchronization: ' . $e->getMessage());
        } finally {
            // Aktifkan kembali foreign key checks di MySQL
            $mysqlConnection->statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
