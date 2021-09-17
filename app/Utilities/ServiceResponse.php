<?php


namespace App\Utilities;

use Illuminate\Http\Response;

/**
 * Class ServiceResponse
 * @package App\Utilities
 */
class ServiceResponse
{

    /**
     * @param $message
     * @param string $type
     * @return array
     */
    public static function notification($message, $type = 'success')
    {
        return [
            [
                'type'    => $type,
                'message' => $message
            ]
        ];
    }

    /**
     * @param $message
     * @param array $data
     *
     * @return array
     */
    public static function error($message,$data = [])
    {
        $data = [
            'message'   => $message,
            'status'    => false,
            'type'      => 'danger',
            'data'      => $data
        ];

        \Session::flash('notifications', [$data]);

        return $data;
    }

    /**
     * @param $message
     * @param null $data
     * @return array
     */
    public static function success($data = null, $message = '')
    {
        return [
            'message'   => $message,
            'status'    => true,
            'data'      => $data
        ];
    }

    /**
     * @param $message
     * @param int $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function jsonNotification($message, $code = 200, $data = [])
    {
        return response()->json(
            [
                'message'   => $message,
                'code'      => $code,
                'data'      => $data,
                'status'    => $code
            ]
        )->setStatusCode($code && is_numeric($code) ? (int)$code : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}
