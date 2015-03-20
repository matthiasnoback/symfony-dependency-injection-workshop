<?php

namespace CatApi;

class CachedCatApi implements CatApiInterface
{
    const RANDOM_CAT_GIF_URL_EXPIRES = 5;
    /**
     * @var CatApiInterface
     */
    private $catApi;
    /**
     * @var
     */
    private $cacheDir;

    public function __construct(CatApiInterface $catApi, $cacheDir)
    {
        $this->catApi = $catApi;
        $this->cacheDir = $cacheDir;
    }

    public function getCatGifUrl($id)
    {
        $filename = $this->cacheDir . '/' . $id;
        if ($this->isCacheFileFresh($filename)) {
            return file_get_contents($filename);
        }

        $url = $this->catApi->getCatGifUrl($id);

        file_put_contents($filename, $url);

        return $url;
    }

    public function getRandomCatGifUrl()
    {
        $filename = $this->cacheDir . '/random';

        if ($this->isCacheFileFresh($filename, self::RANDOM_CAT_GIF_URL_EXPIRES)) {
            return file_get_contents($filename);
        }

        $url = $this->catApi->getRandomCatGifUrl();

        file_put_contents($filename, $url);

        return $url;
    }

    private function isCacheFileFresh($filename, $expires = 0)
    {
        return file_exists($filename) && ($expires === 0 ? true : time() - filemtime($filename) <= $expires);
    }
}
