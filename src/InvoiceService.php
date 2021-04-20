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
        $SignatureString = $this->data['RevenueHeadId'].$this->formatAmount($this->data['TaxEntityInvoice']['Amount']).$this->data['CallBackURL'].Cbs::getClientId();
        $this->signature = base64_encode(hash_hmac('sha256', $SignatureString, Cbs::getSecretKey(), true));
        $this->setRequestOptions();
    }

    protected function formatAmount($amount): string
    {
        return number_format((float) $amount, 2, '.', '');
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

            return $this;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getData()
    {
        return $this->result;
    }

    public function redirectNow()
    {
        header('Location: '.$this->result['ResponseObject']['PaymentURL']);
        exit;
    }

    protected function computeMac($invoiceNumber, $paymentRef, $amount, $RequestReference): string
    {
        $MacString = $invoiceNumber.$paymentRef.$this->formatAmount($amount).$RequestReference;

        return base64_encode(hash_hmac('sha256', $MacString, Cbs::getSecretKey(), true));
    }

    public function getPaymentData(): array
    {
        $mac = $this->computeMac($_POST['InvoiceNumber'], $_POST['PaymentRef'], $_POST['AmountPaid'], $_POST['RequestReference']);
        if ($mac !== $_POST['Mac']) {
            throw Exceptions::create('format.invalidCall');
        } else {
            return $_POST;
        }
    }
}
