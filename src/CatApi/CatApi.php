<?php

namespace CatApi;

class CatApi implements CatApiInterface
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getCatGifUrl($id)
    {
        $responseXml = $this->httpClient->get('http://thecatapi.com/api/images/get?format=xml&image_id=' . $id);
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
        $responseXml = $this->httpClient->get('http://thecatapi.com/api/images/get?format=xml');
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
            $this->httpClient->get($url)
        );
    }
}
