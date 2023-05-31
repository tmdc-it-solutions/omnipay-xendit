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
                'https://api.xendit.co/batch_disbursements',
                [
                    'Authorization' => 'Basic ' . base64_encode($this->getSecretApiKey() . ':'),
                    'Content-Type' => 'application/json',
                    'XENDIT-IDEMPOTENCY-KEY' => (string)$this->getReferenceId(),
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
            'reference' => (string)$this->getReferenceId(),
            'disbursements' => [
                [
                    'external_id' => (string)$this->getReferenceId(),
                    'amount' => intval($this->getAmount()),
                    'description' => $this->getDescription(),
                    'bank_code' => (string)$this->getChannelCode(),
                    'currency' => (string)$this->getCurrency(),
                    'bank_account_name' => (string)$this->getAccountName(),
                    'bank_account_number' => (string)$this->getAccountNumber(),
                ]
            ]
        ];
    }

    public function getReferenceId()
    {
        return $this->getParameter('reference_id');
    }

    public function setReferenceId($value)
    {
        return $this->setParameter('reference_id', $value);
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

    public function getChannelCode()
    {
        return $this->getParameter('channel_code');
    }

    public function setChannelCode($value)
    {
        return $this->setParameter('channel_code', $value);
    }

    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    public function getAccountName()
    {
        return $this->getParameter('account_name');
    }

    public function setAccountName($value)
    {
        return $this->setParameter('account_name', $value);
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
