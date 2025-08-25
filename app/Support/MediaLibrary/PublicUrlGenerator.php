<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\Support\UrlGenerator\BaseUrlGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PublicUrlGenerator extends BaseUrlGenerator
{
    public function getUrl(): string
    {
        $path = $this->getPathRelativeToRoot();
        
        return url('uploads/' . $path);
    }

    public function getPath(): string
    {
        $path = $this->getPathRelativeToRoot();
        
        return public_path('uploads/' . $path);
    }

    public function getTemporaryUrl(\DateTimeInterface $expiration, array $options = []): string
    {
        return $this->getUrl();
    }

    public function getResponsiveImagesDirectoryUrl(): string
    {
        $path = $this->getPathRelativeToRoot();
        
        return url('uploads/' . $path);
    }

    public function getConversionUrl(string $conversionName = ''): string
    {
        $path = $this->getPathRelativeToRoot();
        
        if ($conversionName) {
            $path .= 'conversions/' . $conversionName . '/';
        }
        
        return url('uploads/' . $path);
    }
}
