<?php

/**
 * Created by PhpStorm.
 * User: xuding
 * Date: 6/8/18
 * Time: 11:06 AM
 */

namespace Omnipay\Xendit\Message;


use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class DisbursementResponse extends AbstractResponse
{
    const STATUS_PENDING = 'PENDING';
    const STATUS_PAID = 'PAID';
    const STATUS_SETTLED = 'SETTLED';

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        if (!is_array($data)) {
            $this->data = json_decode(trim($data), true);
        }
    }

    public function isSuccessful()
    {
        return $this->arrayGet($this->data, 'error_code') != null ? TRUE : FALSE;
    }

    public function isPending()
    {
        return strtolower($this->arrayGet($this->data, 'status')) == strtolower(self::STATUS_PENDING);
    }

    public function getTransactionId()
    {
        return $this->arrayGet($this->data, 'external_id');
    }

    public function getTransactionReference()
    {
        return $this->arrayGet($this->data, 'external_id');
    }

    public function getMessage()
    {
        return $this->arrayGet($this->data, 'message');
    }

    public function arrayGet($data, $key, $default = null)
    {
        if (!isset($data[$key])) {
            return $default;
        }

        return $data[$key];
    }
}