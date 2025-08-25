<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MigrateMediaToPublic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:migrate-to-public {--force : Force migration without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing media files from storage to public uploads directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Media Library Migration Tool');
        $this->info('========================');
        
        // Check if uploads directory exists
        $uploadsDir = public_path('uploads');
        if (!File::exists($uploadsDir)) {
            File::makeDirectory($uploadsDir, 0755, true);
            $this->info('Created uploads directory: ' . $uploadsDir);
        }
        
        // Check if there are existing media files
        $mediaCount = Media::count();
        if ($mediaCount === 0) {
            $this->info('No media files found in database. Nothing to migrate.');
            return 0;
        }
        
        $this->info("Found {$mediaCount} media files in database.");
        
        // Check if old storage has files
        $oldStoragePath = storage_path('app/public');
        if (!File::exists($oldStoragePath)) {
            $this->info('Old storage directory not found. Nothing to migrate.');
            return 0;
        }
        
        if (!$this->option('force')) {
            if (!$this->confirm('Do you want to proceed with migration?')) {
                $this->info('Migration cancelled.');
                return 0;
            }
        }
        
        $this->info('Starting migration...');
        
        $bar = $this->output->createProgressBar($mediaCount);
        $bar->start();
        
        $migrated = 0;
        $errors = 0;
        
        Media::chunk(100, function ($mediaItems) use (&$migrated, &$errors, $bar) {
            foreach ($mediaItems as $media) {
                try {
                    $this->migrateMediaFile($media);
                    $migrated++;
                } catch (\Exception $e) {
                    $errors++;
                    $this->error("\nError migrating media ID {$media->id}: " . $e->getMessage());
                }
                $bar->advance();
            }
        });
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("Migration completed!");
        $this->info("Successfully migrated: {$migrated} files");
        if ($errors > 0) {
            $this->warn("Errors encountered: {$errors} files");
        }
        
        $this->info('Remember to clear cache: php artisan optimize:clear');
        
        return 0;
    }
    
    /**
     * Migrate a single media file
     */
    private function migrateMediaFile(Media $media)
    {
        $oldPath = storage_path('app/public/' . $media->getPathRelativeToRoot());
        $newPath = public_path('uploads/' . $media->getPathRelativeToRoot());
        
        // Create directory if it doesn't exist
        $newDir = dirname($newPath);
        if (!File::exists($newDir)) {
            File::makeDirectory($newDir, 0755, true);
        }
        
        // Copy file if it exists
        if (File::exists($oldPath)) {
            File::copy($oldPath, $newPath);
        }
        
        // Handle conversions
        $conversionsPath = storage_path('app/public/' . $media->getPathRelativeToRoot() . 'conversions');
        if (File::exists($conversionsPath)) {
            $newConversionsPath = public_path('uploads/' . $media->getPathRelativeToRoot() . 'conversions');
            if (!File::exists($newConversionsPath)) {
                File::makeDirectory($newConversionsPath, 0755, true);
            }
            File::copyDirectory($conversionsPath, $newConversionsPath);
        }
        
        // Handle responsive images
        $responsivePath = storage_path('app/public/' . $media->getPathRelativeToRoot() . 'responsive-images');
        if (File::exists($responsivePath)) {
            $newResponsivePath = public_path('uploads/' . $media->getPathRelativeToRoot() . 'responsive-images');
            if (!File::exists($newResponsivePath)) {
                File::makeDirectory($newResponsivePath, 0755, true);
            }
            File::copyDirectory($responsivePath, $newResponsivePath);
        }
    }
}
