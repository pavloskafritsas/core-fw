<?php

namespace Pk\Core\Helpers;

class Xml
{
    /**
     * @return \DOMDocument
     */
    public static function newDomDocument($version = '1.0', $encoding = 'utf-8')
    {
        return new \DOMDocument($version, $encoding);
    }

    /**
     * 
     * 
     * @param  \DOMDocument $xml
     * @param  \DOMElement $el
     * @param  array $array
     * 
     * @return void
     */
    public static function arrayToXmlElement(\DOMDocument &$xml, \DOMElement &$el, array $array)
    {
        foreach ($array as $k => $v) {
            if (is_scalar($v)) {
                $el->setAttribute($k, $v);
            } else if (is_array($v)) {
                if (is_string($k)) {
                    $xmlEl = $xml->createElement($k);
                    self::arrayToXmlElement($xml, $xmlEl, $v);
                    $el->appendChild($xmlEl);
                } else {
                    $nodeName = substr($el->nodeName, 0, -1);

                    $xmlEl = $xml->createElement($nodeName);

                    self::arrayToXmlElement($xml, $xmlEl, $v);

                    $el->appendChild($xmlEl);
                }
            }
        }
    }

    /**
     * @param  \DOMDocument $xml
     * @param  string $filename
     * 
     * @return string
     */
    public static function saveXMLFile(\DOMDocument $xml, string $filename)
    {
        $filename = $_SERVER['DOCUMENT_ROOT'] . $filename;

        $xml->formatOutput = true;
        $xml->save($filename);

        return $filename;
    }

    /**
     * @param  string
     * @return void
     */
    public static function downloadXml(string $filename, bool $validate = true)
    {
        self::checkIfFileExists($filename);

        $filename = $_SERVER['DOCUMENT_ROOT'] . $filename;

        $xml = new \DOMDocument();
        $xmlFile = file_get_contents($filename);

        $xml->loadXML($xmlFile);

        if ($validate) {
            self::validate($xml);
        }

        /**
         * αποστολή header στον client για την λήψη αρχείου.
         */
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($filename));
        header('Pragma: public');

        // Clear system output buffer
        flush();

        // Read the size of the file
        readfile($filename);
    }

    /**
     * @param  string
     * @return void
     */
    public static function viewXml(string $filename, bool $validate = true)
    {
        self::checkIfFileExists($filename);

        $xml = new \DOMDocument();
        $xmlFile = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $filename);

        $xml->loadXML($xmlFile);

        if ($validate) {
            self::validate($xml);
        }

        header('Content-type: text/xml');

        echo $xmlFile;
    }

    /**
     * @param  \DOMDocument $xml
     * @return void
     */
    private static function validate(\DOMDocument $xml)
    {
        if (!$xml->validate()) {
            throw new \Exception('XML file is not valid!');
        }
    }

    /**
     * @param  string $filename
     * 
     * @return void
     */
    private static function checkIfFileExists(string $filename)
    {
        $filename = $_SERVER['DOCUMENT_ROOT'] . $filename;

        if (!file_exists($filename)) {
            throw new \Exception("Το αρχείο $filename δεν βρέθηκε.", 500);
        }
    }
}
