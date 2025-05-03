<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ListRemainingModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list-remaining-models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all models with any SoftDeletes reference';

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
            
            if (strpos($contents, 'SoftDeletes') !== false) {
                $models[] = $file->getFilename();
            }
        }
        
        if (count($models) > 0) {
            $this->info("Models still having SoftDeletes references:");
            foreach ($models as $model) {
                $this->line("- {$model}");
            }
        } else {
            $this->info("No models have SoftDeletes references.");
        }
    }
} 