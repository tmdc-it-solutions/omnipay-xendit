<?php

/**
 * Created by PhpStorm.
 * User: xuding
 * Date: 6/8/18
 * Time: 11:06 AM
 */

namespace Omnipay\Xendit\Message;


use Omnipay\Common\Exception\InvalidRequestException;

class DisbursementRequest extends AbstractRequest
{
    const MIN_AMOUNT = 11000;

    public function sendData($data)
    {
        $response = $this->httpClient
            ->request(
                'POST',
                'https://api.xendit.co/disbursements',
                [
                    'Authorization' => 'Basic ' . base64_encode($this->getSecretApiKey() . ':'),
                    'Content-Type' => 'application/json'
                ],
                json_encode($data)
            )
            ->getBody()
            ->getContents();

        return new DisbursementResponse($this, $response);
    }

    public function getData()
    {
        // $this->guardAmount(intval($this->getAmount()));

        return [
            'external_id' => (string)$this->getExternalId(),
            'amount' => intval($this->getAmount()),
            'description' => $this->getDescription(),
            'bank_code' => (string)$this->getBankCode(),
            'account_holder_name' => (string)$this->getAccountHolderName(),
            'account_number' => (string)$this->getAccountNumber(),
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

    public function getBankCode()
    {
        return $this->getParameter('bank_code');
    }

    public function setBankCode($value)
    {
        return $this->setParameter('bank_code', $value);
    }

    public function getAccountHolderName()
    {
        return $this->getParameter('account_holder_name');
    }

    public function setAccountHolderName($value)
    {
        return $this->setParameter('account_holder_name', $value);
    }

    public function getAccountNumber()
    {
        return $this->getParameter('account_number');
    }

    public function setAccountNumber($value)
    {
        return $this->setParameter('account_number', $value);
    }

    private function guardAmount($amount)
    {
        if ($amount < self::MIN_AMOUNT) {
            throw new InvalidRequestException('The minimum amount to create an disbursement is 11000');
        }
    }
}
