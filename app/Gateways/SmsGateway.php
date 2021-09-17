<?php


namespace App\Gateways;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Log;

class SmsGateway
{

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $baseUrl;

    /**
     * @var
     */
    private $endPoint;

    /**
     * @var
     */
    private $method;

    /**
     * @var
     */
    protected $response;

    /**
     * @var
     */
    protected $token;

    /**
     * @var array
     */
    protected $headers = [
        'Content-Type'  => 'application/json',
        'Accept'        => 'application/json',
    ];

    /**
     * @var array
     */
    protected $requestData = [];

    /**
     * @var string
     */
    protected $apiVersion = 'v1';

    /**
     * @var string
     */
    protected $dbName = 'tbilisi';

    /**
     * @var string
     */
    protected $requestOption = 'json';

    /**
     * MyPostGateway constructor.
     */
    public function __construct()
    {
        $this->baseUrl = config('services.sms_service.base_url');
        $this->requestData = [
            'username'      => config('services.sms_service.username'),
            'password'      => config('services.sms_service.password'),
            'client_id'     => config('services.sms_service.client_id'),
            'service_id'    => config('services.sms_service.service_id'),
            'utf'           => 1,
            'result'        => 'json'
        ];
        $this->response = [
            'status'    => true,
            'message'   => '',
            'data'      => ''
        ];
    }

    /**
     * Get response.
     *
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Do request in Merchant.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function doRequest()
    {
        try {
            $client = new Client([
                'verify' => false
            ]);

            $response = $client->request($this->method, $this->baseUrl . $this->endPoint, [
                'headers' => $this->headers,
                $this->requestOption    => $this->requestData
            ]);

            $this->response['data'] = $response->getBody()->getContents();

            Log::info('[Sms response]',[
                'request'   => $this->requestData,
                'response'  => $this->response
            ]);

        } catch (ClientException $ex) {
            Log::error('Error sms client ', ['data' => $this->requestData, 'error' => $ex->getResponse()->getBody(),'url' => $this->baseUrl . $this->endPoint , 'message' => $ex->getMessage()]);
            $this->response['status'] = false;
            $this->response['message'] = $ex->getMessage();
        } catch (\Exception $ex) {
            Log::error('Error sms ', ['data' => $this->requestData, 'url' => $this->baseUrl . $this->endPoint , 'message' => $ex->getMessage()]);
            $this->response['status'] = false;
            $this->response['message'] = $ex->getMessage();
        }

        return $this;
    }

    /**
     * @param string $number
     * @param string $text
     *
     * @return $this
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendSms(string $number,string $text)
    {
        $this->endPoint = '/sendsms.php';
        $this->method = 'GET';
        $this->requestOption = 'query';
        $this->requestData['to'] = $number;
        $this->requestData['text'] = $text;

        // Do request
        $this->doRequest();

        return $this;
    }

}
