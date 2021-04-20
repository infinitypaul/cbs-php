<?php


namespace Infinitypaul\Cbs;


use Exception;
use GuzzleHttp\Client;


class InvoiceService
{
    public $signature;

    public $client;

    protected $data;

    protected $response;

    protected $result;

    public function __construct()
    {

    }

    public function addBody($name, $value): InvoiceService
    {
        $this->data[$name] = $value;

        return $this;
    }


    protected function setSignature()
    {
        $SignatureString = $this->data['RevenueHeadId'].$this->formatAmount().$this->data['CallBackURL'].Cbs::getClientId();
        $this->signature = base64_encode(hash_hmac('sha256', $SignatureString, Cbs::getSecretKey(), true));
        $this->setRequestOptions();
    }

    protected function formatAmount(): string
    {
        return number_format((float) $this->data['TaxEntityInvoice']['Amount'], 2, '.', '');
    }

    protected function computeMac($invoiceNumber, $paymentRef): string
    {
        $MacString = $invoiceNumber.ReferenceNumber::getHashedToken().$this->formatAmount().$this->result['ResponseObject']['RequestReference'];

        return base64_encode(hash_hmac('sha256', $MacString, Cbs::getSecretKey(), true));
    }

    /**
     * Set options for making the Client request.
     */
    private function setRequestOptions()
    {
        $this->client = new Client([
            'base_uri' => Cbs::getBaseUrl(),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'CLIENTID' => Cbs::getClientId(),
                'Signature' => $this->signature,
            ],
        ]);
    }

    protected function performGetRequest($relativeUrl)
    {
        $this->response = $this->client->request('GET', $relativeUrl);

        return $this->getResponse();
    }

    protected function performPostRequest($relativeUrl)
    {
        $this->response = $this->client->request('POST', $relativeUrl, ['json'=> $this->data]);

        return $this->getResponse();
    }


    private function getResponse()
    {
        return json_decode($this->response->getBody(), true);
    }

    public function getAuthorizationUrl(): InvoiceService
    {
        $this->setSignature();

        try {
            $this->result = $this->performPostRequest('/api/v1/invoice/create');
            dd($this->result);

            return $this;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

    }

    public function getData(){
        return $this->result;
    }

    public function redirectNow()
    {
        header('Location: '.$this->result['ResponseObject']['PaymentURL']);
        exit;
    }

    public function getPaymentData()
    {

    }
}
