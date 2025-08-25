<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PublicPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $collection = $media->collection_name;
        $id = $media->id;
        
        return $collection . '/' . $id . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive-images/';
    }
}
