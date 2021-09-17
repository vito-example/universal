<?php


namespace App\Exceptions;

use App\Utilities\ServiceResponse;
use Exception;
use Illuminate\Http\Response;
use Log;
use Throwable;

/**
 * @property null parentException
 * @property array responseData
 */
class ClientExceptionJsonResponse extends Exception
{

    /**
     * @var null
     */
    protected $parentException;

    /**
     * @var array
     */
    protected $responseData;

    /**
     * ClientJsonResponse constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param null $parentException
     * @param array $responseData
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null, $parentException = null, $responseData = [])
    {
        parent::__construct($message, $code && is_numeric($code) ? (int)$code : Response::HTTP_INTERNAL_SERVER_ERROR, $previous);
        $this->parentException = $parentException;
        $this->responseData = $responseData;
    }

    /**
     * log error.
     */
    public function report()
    {
        Log::error('Client json render exception.', [
            'message'   => $this->getMessage(),
            'code'      => $this->getCode(),
            'line'      => $this->getLine(),
            'file'      => $this->getFile(),
            'data'      => request()->all(),
            'response_data'      => $this->responseData,
            'error'     => $this->parentException,
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json(
            [
                'message'   => $this->getMessage(),
                'code'      => $this->getCode(),
                'data'      => $this->responseData
            ]
        )->setStatusCode($this->getCode() && is_numeric($this->getCode()) ? (int)$this->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}
