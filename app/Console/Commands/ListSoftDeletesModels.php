<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ListSoftDeletesModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list-soft-deletes-models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all models using Laravel\'s SoftDeletes trait';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelDirectory = app_path('Models');
        $modelFiles = File::files($modelDirectory);
        
        $models = [];
        
        foreach ($modelFiles as $file) {
            $contents = File::get($file->getPathname());
            
            if (strpos($contents, 'use Illuminate\Database\Eloquent\SoftDeletes;') !== false &&
                preg_match('/use\s+([^,]*,\s*)*SoftDeletes(\s*,[^;]*)*;/', $contents)) {
                
                $models[] = $file->getFilename();
            }
        }
        
        if (count($models) > 0) {
            $this->info("Models still using SoftDeletes:");
            foreach ($models as $model) {
                $this->line("- {$model}");
            }
        } else {
            $this->info("No models are using SoftDeletes.");
        }
    }
} 