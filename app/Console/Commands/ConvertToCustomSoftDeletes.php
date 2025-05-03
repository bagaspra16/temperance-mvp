<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConvertToCustomSoftDeletes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-to-custom-soft-deletes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts all models using SoftDeletes to use CustomSoftDeletes';

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
            
            if (strpos($contents, 'use Illuminate\Database\Eloquent\SoftDeletes;') !== false &&
                strpos($contents, 'use SoftDeletes') !== false) {
                
                // Replace the import
                $newContents = str_replace(
                    'use Illuminate\Database\Eloquent\SoftDeletes;', 
                    'use App\Traits\CustomSoftDeletes;', 
                    $contents
                );
                
                // Replace the trait usage
                $newContents = preg_replace(
                    '/use\s+([^,]*,\s*)*SoftDeletes(\s*,[^;]*)*;/', 
                    '$1CustomSoftDeletes$2;', 
                    $newContents
                );
                
                File::put($file->getPathname(), $newContents);
                $count++;
                
                $this->info("Updated: " . $file->getFilename());
            }
        }
        
        $this->info("Conversion complete! Updated $count model files.");
    }
} 