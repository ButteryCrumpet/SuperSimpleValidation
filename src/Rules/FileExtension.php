<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\RuleInterface;
use Psr\Http\Message\UploadedFileInterface;
use SuperSimpleValidation\ValidationException;

class FileExtension implements RuleInterface
{
    private $extension;

    public function __construct($extension)
    {
        if (!is_string($extension)) {
            throw new \InvalidArgumentException(sprintf(
                "Extension must be a string. %s was given.",
                gettype($extension)
                )
            );
        }

        $this->extension = ltrim($extension, ".");
    }

    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException(
                sprintf(
                    "File extension for type %s does not match %s",
                    gettype($data),
                    $this->extension
                )
            );
        }
        return true;
    }

    public function validate($data)
    {
        if (!$this->argCheck($data)) {
            return false;
        }

        if ($data instanceof UploadedFileInterface) {
            $data = $data->getClientFilename();
        }

        $info = new \SplFileInfo($data);
        return $info->getExtension() === $this->extension;
    }

    private function argCheck($data)
    {
        if (!($data instanceof UploadedFileInterface || is_string($data))) {
            return false;
        }
        return true;
    }

}
