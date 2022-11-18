<?php

namespace Simtabi\Enekia\Vanilla\Validators;

use DOMDocument;
use Exception;
use function is_string;
use LibXMLError;

/**
 * Class Validator
 *
 * @package Hyperized\Xml
 * Based on: http://stackoverflow.com/a/30058598/1757763
 */
final class Xml
{

    public const UTF_8    = 'utf-8';
    public const VERSION  = '1.0';
    public const NEW_LINE = "\n";

    public const XML_EMPTY_TRIMMED        = 'The provided XML content is, after trimming, in fact an empty string';
    public const EMPTY_FILE               = 'File is empty';
    public const FILE_DOES_NOT_EXIST      = 'File does not exist';
    public const FILE_COULD_NOT_BE_OPENED = 'File could not be opened';

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $version  = self::VERSION;
    /**
     * @var string
     */
    private $encoding = self::UTF_8;

    public function __construct(){}

    public function isValid(string $xmlStringOrFilePath, ?string $xsdFilePath = null, $fromString = false): bool
    {
        if ($fromString) {
            return $this->isValidXmlString($xmlStringOrFilePath, $xsdFilePath);
        }

        return $this->isValidXmlFile($xmlStringOrFilePath, $xsdFilePath);
    }

    private function isValidXmlFile(string $xmlPath, ?string $xsdPath = null): bool
    {
        try {
            $this->setPath($xmlPath);
            $string = $this->getContents();
        } catch (Exception $e) {
            return false;
        }

        if (!empty($xsdPath)) {
            $xsdPath = $this->path;
        }

        return $this->isValidXmlString($string, $xsdPath);
    }

    /**
     * @param  string      $xml
     * @param  string|null $xsdPath
     * @return bool
     */
    private function isValidXmlString(string $xml, string $xsdPath = null): bool
    {
        try {
            if (is_string($xsdPath)) {
                return $this->isXMLValid($xml, $xsdPath);
            }
            return $this->isXMLValid($xml);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param  string      $xmlContent
     * @param  string|null $xsdPath
     * @return bool
     * @throws Exception
     */
    private function isXMLValid(string $xmlContent, string $xsdPath = null): bool
    {
        $this->checkEmptyWhenTrimmed($xmlContent);

        libxml_use_internal_errors(true);

        $document = new DOMDocument($this->version, $this->encoding);
        $document->loadXML($xmlContent);
        if (isset($xsdPath)) {
            $document->schemaValidate($xsdPath);
        }
        $errors = libxml_get_errors();
        libxml_clear_errors();
        $this->parseErrors($errors);
        return true;
    }

    /**
     * @param  string $xmlContent
     * @throws Exception
     */
    private function checkEmptyWhenTrimmed(string $xmlContent): void
    {
        if (trim($xmlContent) === '') {
            throw new Exception(self::XML_EMPTY_TRIMMED);
        }
    }

    /**
     * @param  array<LibXMLError>|null $errors
     * @throws Exception
     */
    private function parseErrors(?array $errors): void
    {
        if (!empty($errors)) {
            $reduced = array_reduce(
                $errors,
                static function (
                    ?array $carry,
                    LibXMLError $item
                ): array {
                    $carry[] = trim($item->message);
                    return $carry;
                }
            );

            if (!empty($reduced)) {
                throw new Exception(implode(self::NEW_LINE, $reduced));
            }
        }
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }

    /**
     * @param string $encoding
     */
    public function setEncoding(string $encoding): void
    {
        $this->encoding = $encoding;
    }

    /**
     * File constructor.
     *
     * @param string $path
     * @return self
     * @throws Exception
     */
    public function setPath(string $path): self
    {
        if ($this->isPath()) {
            $this->path = $path;
        }
        return $this;
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function isPath(): bool
    {
        if (!file_exists($this->path)) {
            throw new Exception(self::FILE_DOES_NOT_EXIST);
        }
        return true;
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getContents(): string
    {
        $contents = file_get_contents($this->path);

        if ($contents === false) {
            throw new Exception(self::FILE_COULD_NOT_BE_OPENED);
        }

        if ($contents === '') {
            throw new Exception(self::EMPTY_FILE);
        }

        return $contents;
    }

    /**
     * @return string
     */
    private function getPath(): string
    {
        return $this->path;
    }
}