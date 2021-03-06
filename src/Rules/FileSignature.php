<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\RuleInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class FileType
 * @package SuperSimpleValidation\Rules
 */
class FileSignature implements RuleInterface
{
    /**
     * @var array
     */
    private $signature;
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * FileType constructor.
     * @param string[] $signature Array of hex values
     * @param string $errorMessage
     */
    public function __construct(array $signature, $errorMessage)
    {
        $this->signature = $signature;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param $data
     * @return bool
     * @throws ValidationException When validation fails
     */
    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException($this->errorMessage);
        }
        return true;
    }

    /**
     * @param UploadedFileInterface|StreamInterface|resource|string $data
     * @return bool
     */
    public function validate($data)
    {
        if ($data instanceof UploadedFileInterface) {
            return $this->handleUploadFile($data);
        }

        if ($data instanceof StreamInterface) {
            return $this->handleStream($data);
        }

        if (is_resource($data)) {
            return $this->handleResource($data);
        }

        if (is_file($data)) {
            return $this->handleString($data);
        }

        return false;
    }

    /**
     * @param UploadedFileInterface $data
     * @return bool
     */
    private function handleUploadFile(UploadedFileInterface $data)
    {
        try {
            return $this->handleStream($data->getStream());
        } catch (\RuntimeException $e) {
            return false;
        }
    }

    /**
     * @param StreamInterface $data
     * @return bool
     */
    private function handleStream(StreamInterface $data)
    {
        if (!($data->isReadable() && $data->isSeekable())) {
            return false;
        }
        $data->rewind();
        $sig = $data->read(count($this->signature));
        return $this->compareBytes($sig);

    }

    /**
     * @param $fileUri
     * @return bool
     */
    private function handleString($fileUri)
    {
        $resource = fopen($fileUri, "rb");
        return $this->handleResource($resource);
    }

    /**
     * @param $data
     * @return bool
     */
    private function handleResource($data)
    {
        fseek($data, 0);
        $sig = fread($data, count($this->signature));
        return $this->compareBytes($sig);
    }

    /**
     * @param $sig
     * @return bool
     */
    private function compareBytes($sig)
    {
        $sig = str_split($sig, 1);
        $allPass = true;
        foreach ($sig as $i => $byte) {
            $allPass = $allPass && (bin2hex($byte) === $this->signature[$i]);
        }
        return $allPass;
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return [$this->errorMessage];
    }

}
