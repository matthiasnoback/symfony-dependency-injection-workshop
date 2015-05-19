<?php

namespace ImageGenerator;

class CatApiCache
{
    public function containsRandomImage()
    {
        return file_exists(__DIR__ . '/../../cache/random') && time() - filemtime(__DIR__ . '/../../cache/random') <= 3;
    }

    public function storeRandomImage($url)
    {
        file_put_contents(
            __DIR__ . '/../../cache/random',
            $url
        );
    }

    public function retrieveRandomImage()
    {
        return file_get_contents(__DIR__ . '/../../cache/random');
    }
}
