<?php

namespace SuperSimpleValidation\Rules;

use SuperSimpleValidation\RuleInterface;
use Psr\Http\Message\UploadedFileInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class FileExtension
 * @package SuperSimpleValidation\Rules
 */
class FileExtension implements RuleInterface
{
    /**
     * @var string
     */
    private $extension;
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * FileExtension constructor.
     * @param string $extension
     * @param string $errorMessage
     */
    public function __construct($extension, $errorMessage)
    {
        if (!is_string($extension)) {
            throw new \InvalidArgumentException($this->errorMessage);
        }

        $this->extension = ltrim($extension, ".");
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function assert($data)
    {
        if (!$this->validate($data)) {
            throw new ValidationException($this->errorMessage);
        }
        return true;
    }

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        if (!($data instanceof UploadedFileInterface || is_string($data))) {
            return false;
        }

        if ($data instanceof UploadedFileInterface) {
            $data = $data->getClientFilename();
        }

        $info = new \SplFileInfo($data);
        return $info->getExtension() === $this->extension;
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return [$this->errorMessage];
    }
}
