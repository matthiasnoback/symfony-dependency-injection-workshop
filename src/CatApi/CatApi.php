<?php

namespace CatApi;

class CatApi implements CatApiInterface
{
    private $httpClient;

    /**
     * @var NewUrlObserver[]
     */
    private $observers;

    public function __construct(HttpClientInterface $httpClient, array $observers)
    {
        $this->httpClient = $httpClient;
        $this->observers = $observers;
    }

    public function getCatGifUrl($id)
    {
        $responseXml = $this->httpClient->get('http://thecatapi.com/api/images/get?format=xml&image_id=' . $id);
        if (!$responseXml) {
            return 'http://my-cool-website.com/default.gif';
        }
        $responseElement = new \SimpleXMLElement($responseXml);

        $url = (string)$responseElement->data->images[0]->image->url;

        foreach ($this->observers as $observer) {
            $observer->notify($url);
        }

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

        foreach ($this->observers as $observer) {
            $observer->notify($url);
        }

        return $url;
    }
}
