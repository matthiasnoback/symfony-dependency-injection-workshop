<?php

namespace ImageGenerator;

class CachedCatApi
{
    public function getRandomImage()
    {
        $cache = new CatApiCache();

        if ($cache->containsRandomImage()) {
            return $cache->retrieveRandomImage();
        }

        $catApi = new CatApi();
        $url = $catApi->getRandomImage();
        $cache->storeRandomImage($url);

        return $url;
    }
}
