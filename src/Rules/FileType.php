<?php

namespace SuperSimpleValidation\Rules;

use MongoDB\Driver\Exception\InvalidArgumentException;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use SuperSimpleValidation\ValidationException;

class FileType implements RuleInterface
{
    private $signature;

    public function __construct(array $signature)
    {
        $this->signature = $signature;
    }

    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException(
                sprintf(
                    "Not valid file format for byte signature %s",
                    var_export($this->signature, true)
                )
            );
        }
        return true;
    }

    public function validate($data)
    {
        if (!is_array($this->signature)) {
            throw new \InvalidArgumentException("not arrays is " . gettype($this->signature));
        }
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

        throw new InvalidArgumentException(
            sprintf(
                "Argument must be a valid file uri, resource, UploadFileInterface or StreamInterface. %s was given",
                gettype($data)
            )
        );
    }

    private function handleUploadFile(UploadedFileInterface $data)
    {
        return $this->handleStream($data->getStream());
    }

    private function handleStream(StreamInterface $data)
    {
        if (!($data->isReadable() && $data->isSeekable())) {
            return false;
        }
        $data->rewind();
        $sig = $data->read(count($this->signature));
        return $this->compareBytes($sig);

    }

    private function handleString($fileUri)
    {
        $resource = fopen($fileUri, "rb");
        return $this->handleResource($resource);
    }

    private function handleResource($data)
    {
        fseek($data, 0);
        $sig = fread($data, count($this->signature));
        return $this->compareBytes($sig);
    }

    private function compareBytes($sig)
    {
        $sig = str_split($sig, 1);
        $all_pass = true;
        foreach ($sig as $i => $byte) {
            $all_pass = $all_pass && (bin2hex($byte) === $this->signature[$i]);
        }
        return $all_pass;

    }
}
