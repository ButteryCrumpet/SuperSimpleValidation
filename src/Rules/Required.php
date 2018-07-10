<?php

namespace SuperSimpleValidation\Rules;

use Psr\Http\Message\UploadedFileInterface;
use SuperSimpleValidation\RuleInterface;
use SuperSimpleValidation\ValidationException;

/**
 * Class Required
 * @package SuperSimpleValidation\Rules
 */
class Required implements RuleInterface
{
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * Required constructor.
     * @param string $errorMessage
     */
    public function __construct($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param $data
     * @throws ValidationException
     * @return bool
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
        if ($data instanceof UploadedFileInterface) {
            return $data->getError() > 0;
        }
        return !(is_null($data) || empty($data));
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return [$this->errorMessage];
    }
}
