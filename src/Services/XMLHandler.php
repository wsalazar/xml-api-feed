<?php

namespace App\Services;

class XMLHandler
{

    /**
     * @param \SimpleXMLElement|null $xml
     * @param array $array
     * @return \SimpleXMLElement
     */
    public function addToXML(\SimpleXMLElement $xml, array $array): \SimpleXMLElement
    {
        foreach ($array as $index => $oneUser) {
            if (is_array($oneUser)) {
                $subNode = !is_numeric($index) ? $xml->addChild("$index") : $xml;
                foreach ($oneUser as $key => $value) {
                    if (is_array($value)) {
                        $subSubNode = $subNode->addChild("$key");
                        $this->addToXML($subSubNode, $value);
                    } else {
                        $subNode->addChild("$key", "$value");
                    }
                }
            } else {
                $xml->addChild("$index", "$oneUser");
            }
        }
        return $xml;
    }

    /**
     * @param \SimpleXMLElement $xmlData
     * @return bool|string
     */
    public function asXML(\SimpleXMLElement $xmlData)
    {
        return $xmlData->asXML();
    }
}