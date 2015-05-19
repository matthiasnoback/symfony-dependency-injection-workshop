<?php

namespace ImageGenerator;

class CachedCatApi
{
    public function getRandomImage()
    {
        if (!file_exists(__DIR__ . '/../../cache/random') || time() - filemtime(__DIR__ . '/../../cache/random') > 3) {
            $catApi = new CatApi();
            $url = $catApi->getRandomImage();
            file_put_contents(
                __DIR__ . '/../../cache/random',
                $url
            );
            return $url;
        } else {
            return file_get_contents(__DIR__ . '/../../cache/random');
        }
    }
}
