<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConvertAllToCustomSoftDeletes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-all-to-custom-soft-deletes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts all models to use CustomSoftDeletes instead of SoftDeletes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelDirectory = app_path('Models');
        $modelFiles = File::files($modelDirectory);
        
        $count = 0;
        
        foreach ($modelFiles as $file) {
            $contents = File::get($file->getPathname());
            $modified = false;
            
            // Replace imports
            if (strpos($contents, 'use Illuminate\Database\Eloquent\SoftDeletes;') !== false) {
                $contents = str_replace(
                    'use Illuminate\Database\Eloquent\SoftDeletes;', 
                    'use App\Traits\CustomSoftDeletes;', 
                    $contents
                );
                $modified = true;
            }
            
            // Replace trait usage in class declaration
            if (preg_match('/use\s+([^,]*,\s*)*SoftDeletes(\s*,[^;]*)*;/', $contents)) {
                $contents = preg_replace(
                    '/use\s+([^,]*,\s*)*SoftDeletes(\s*,[^;]*)*;/', 
                    '$1CustomSoftDeletes$2;', 
                    $contents
                );
                $modified = true;
            }
            
            if ($modified) {
                File::put($file->getPathname(), $contents);
                $count++;
                $this->info("Updated: " . $file->getFilename());
            }
        }
        
        $this->info("Conversion complete! Updated $count model files.");
    }
} 