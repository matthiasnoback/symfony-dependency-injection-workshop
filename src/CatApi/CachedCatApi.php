<?php

namespace CatApi;

class CachedCatApi implements CatApiInterface
{
    /**
     * @var CatApiInterface
     */
    private $catApi;

    public function __construct(CatApiInterface $catApi)
    {
        $this->catApi = $catApi;
    }

    public function getCatGifUrl($id)
    {
        if (!file_exists(__DIR__ . '/../../cache/' . $id)) {
            $url = $this->catApi->getCatGifUrl($id);

            file_put_contents(__DIR__ . '/../../cache/' . $id, $url);

            return $url;
        } else {
            return file_get_contents(__DIR__ . '/../../cache/' . $id);
        }
    }

    public function getRandomCatGifUrl()
    {
        if (!file_exists(__DIR__ . '/../../cache/random')
            || time() - filemtime(__DIR__ . '/../../cache/random') > 5
        ) {
            $url = $this->catApi->getRandomCatGifUrl();

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
