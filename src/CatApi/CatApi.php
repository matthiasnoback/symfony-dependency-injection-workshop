<?php

namespace CatApi;

class CatApi implements CatApiInterface
{
    public function getCatGifUrl($id)
    {
        $responseXml = @file_get_contents('http://thecatapi.com/api/images/get?format=xml&image_id=' . $id);
        if (!$responseXml) {
            return 'http://my-cool-website.com/default.gif';
        }
        $responseElement = new \SimpleXMLElement($responseXml);

        $url = (string)$responseElement->data->images[0]->image->url;

        $this->prefetchGifFile($url, __DIR__ . '/../../cache/' . $id . '.gif');
        return $url;
    }

    public function getRandomCatGifUrl()
    {
        $responseXml = @file_get_contents('http://thecatapi.com/api/images/get?format=xml');
        if (!$responseXml) {
            return 'http://my-cool-website.com/default.gif';
        }
        $responseElement = new \SimpleXMLElement($responseXml);

        $url = (string)$responseElement->data->images[0]->image->url;

        $this->prefetchGifFile($url, __DIR__ . '/../../cache/random.gif');
        return $url;
    }

    private function prefetchGifFile($url, $target)
    {
        file_put_contents(
            $target,
            file_get_contents($url)
        );
    }
}
