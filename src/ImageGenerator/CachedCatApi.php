<?php

namespace ImageGenerator;

class CachedCatApi
{
    public function getRandomImage()
    {
        $cache = new CatApiCache();

        if ($cache->containsNoRandomImage()) {
            $catApi = new CatApi();
            $url = $catApi->getRandomImage();
            $cache->storeRandomImage($url);
            return $url;
        } else {
            return $cache->retrieveRandomImage();
        }
    }
}
