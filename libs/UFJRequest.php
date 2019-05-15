<?php
class UFJRequest {
    public $client_secret = '';
    public $account_id = '';
    public $api_base_url = 'https://developer.api.bk.mufg.jp/btmu/retail/trial/v1/';
    public $max_redires = 10;
    public $timeout = 30;
    public $encoding = '';

    /**
     * valid client secret
     *
     * @return boolan
     */
    function validClientSecret() {
        return (boolean) ($this->client_secret);
    }

    /**
     * load client secret
     *
     * @param string $path
     * @return UFJRequest
     */
    function loadClientSecret($path) {
        if (file_exists($path)) {
            $file = fopen($path, 'r');
            $client_secret = fgets($file);
            $this->setClientSecret($client_secret);
        }
        if (!$this->client_secret) exit('Not found client_secret file');
        return $this;
    }

    /**
     * set client secret
     *
     * @param string $client_secret
     * @return UFJRequest
     */
    function setClientSecret($client_secret) {
        $this->client_secret = $client_secret;
        return $this;
    }

    /**
     * set client secret
     *
     * @param string $client_secret
     * @return UFJRequest
     */
    function setAccountId($account_id) {
        $this->account_id = $account_id;
        return $this;
    }

    /**
     * request account
     *
     * @param string $account_id
     * @param string $seq_no
     * @param string $client_secret
     * @param string $accept
     * @return void
     */
    function getAccount($accept = 'application/json') {
        if (!$this->validClientSecret()) return;
        $seq_no = self::sequenceNumber();
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "{$this->api_base_url}accounts/{$this->account_id}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => $this->encoding,
        CURLOPT_MAXREDIRS => $this->max_redires,
        CURLOPT_TIMEOUT => $this->timeout,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: {$accept}",
            "x-btmu-seq-no: {$seq_no}",
            "x-ibm-client-id: {$this->client_secret}"
        ),
        ));
        
        if ($error = curl_error($curl)) echo "cURL Error #:" . $error;
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * sequence number
     *
     * @return string
     */
    static function sequenceNumber() {
        $random = self::random();
        $no = date('Ymd')."-{$random}";
        return $no;
    }

    /**
     * random
     *
     * @param integer $length
     * @return string
     */
    static function random($length = 16) {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, $length);
    }
}