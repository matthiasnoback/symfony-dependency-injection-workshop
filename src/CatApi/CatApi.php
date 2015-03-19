<?php

namespace CatApi;

class CatApi
{
    public function getCatGifUrl($id)
    {
        if (!file_exists(__DIR__ . '/../../cache/' . $id)) {
            $responseXml = file_get_contents('http://thecatapi.com/api/images/get?format=xml&image_id=' . $id);
            $responseElement = new \SimpleXMLElement($responseXml);

            $url = (string)$responseElement->data->images[0]->image->url;
            file_put_contents(__DIR__ . '/../../cache/' . $id, $url);
            return $url;
        } else {
            return file_get_contents(__DIR__ . '/../../cache/' . $id);
        }
    }

    public function getRandomCatGifUrl()
    {
        if (!file_exists(__DIR__ . '/../../cache/random')
            || time() - filemtime(__DIR__ . '/../../cache/random') > 5) {
            $responseXml = file_get_contents('http://thecatapi.com/api/images/get?format=xml');
            $responseElement = new \SimpleXMLElement($responseXml);

            $url = (string)$responseElement->data->images[0]->image->url;
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
