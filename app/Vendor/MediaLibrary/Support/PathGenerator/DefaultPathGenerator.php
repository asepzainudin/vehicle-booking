<?php

namespace App\Vendor\MediaLibrary\Support\PathGenerator;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DefaultPathGenerator extends \Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator
{
    // /** @inheritdoc */
    // public function getPath(Media $media): string
    // {
    //     if (!empty($media->hasCustomProperty('path'))) {
    //         return $media->getCustomProperty('path');
    //     }
    // }

    /*
     * Get a unique base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        $prefix = config('media-library.prefix', '');
        $path = ($media->tenant_id ? $media->tenant_id . '/' : '') . $media->getKey();

        if ($prefix !== '') {
            $path = $prefix.'/'.$path;
        }

        return $path;
    }
}
