<?php
/**
 * Created by PhpStorm.
 * User: xuding
 * Date: 6/8/18
 * Time: 11:06 AM
 */

namespace Omnipay\Xendit\Message;


use Omnipay\Common\Exception\InvalidRequestException;

class InvoicePurchaseRequest extends AbstractRequest
{
    const MIN_AMOUNT = 11000;

    public function sendData($data)
    {
        $response = $this->httpClient
            ->request(
                'POST',
                $this->getEndPoint(),
                [
                    'Authorization' => 'Basic ' . base64_encode($this->getSecretApiKey() . ':'),
                    'Content-Type' => 'application/json'
                ],
                json_encode($data)
            )
            ->getBody()
            ->getContents();

        return new InvoicePurchaseResponse($this, $response);
    }

    public function getData()
    {
        // $this->guardAmount(intval($this->getAmount()));

        return [
            'external_id' => (string)$this->getExternalId(),
            'amount' => intval($this->getAmount()),
            'description' => $this->getDescription(),
            'success_redirect_url' => (string)$this->getSuccessRedirectUrl(),
            'failure_redirect_url' => (string)$this->getFailureRedirectUrl(),
            'payment_methods' => (array)$this->getPaymentMethods(),
        ];
    }

    public function getExternalId()
    {
        return $this->getParameter('external_id');
    }

    public function setExternalId($value)
    {
        return $this->setParameter('external_id', $value);
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function getDescription()
    {
        return $this->getParameter('description');
    }

    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }

    public function getSuccessRedirectUrl()
    {
        return $this->getParameter('success_redirect_url');
    }

    public function setSuccessRedirectUrl($value)
    {
        return $this->setParameter('success_redirect_url', $value);
    }

    public function getFailureRedirectUrl()
    {
        return $this->getParameter('failure_redirect_url');
    }

    public function setFailureRedirectUrl($value)
    {
        return $this->setParameter('failure_redirect_url', $value);
    }

    public function getPaymentMethods()
    {
        return $this->getParameter('payment_methods');
    }

    public function setPaymentMethods($value)
    {
        return $this->setParameter('payment_methods', $value);
    }

    private function guardAmount($amount)
    {
        if ($amount < self::MIN_AMOUNT) {
            throw new InvalidRequestException('The minimum amount to create an invoice is 11000');
        }
    }
}