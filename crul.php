<?php
class curl_web {
    private $set_attribute; // set attribute for get crf
    private $html;          // get html
    public $crf;            // code unic for data send parametr
    public $url_json;       // URL for get ajax
    private $response_json; // result ajax request
    private $url;           // URL web for get html
    private $ch;            // connection curl
    // if outpute method get_html() was equal json
    public $json;
    private $xpath;
    private $dom;
    public function __construct($url ="") {
        if ($url != "") {
            $this->url = $url;
            $this->ch = curl_init($this->url);
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
                'User-Agent: Mozilla/5.0',
            ]);
        }
    }
    // ================================================set attribute for get value in crf
    public function setAttribute(string $attrName) {
        $this->set_attribute = $attrName;
    }
    //===========================================================get value html or creat crf
    //===================================================set html page========================================================
    public function get_html() {
        $this->html = curl_exec($this->ch);
        if (!$this->html) {
            throw new Exception("Error processing request or empty HTML.");
        }

        libxml_use_internal_errors(true);
        $this->dom = new DOMDocument();
        $this->dom->loadHTML($this->html);
        libxml_clear_errors();

        $this->xpath = new DOMXPath($this->dom);
    }


    //=========================================================set query===========================================================
    public function render_xpath($query_path = "//*", bool $return_only_Node_Value = true, bool $loop_tag = false, bool $as_html = false) {
        if (!$this->xpath) {
            throw new Exception("XPath not initialized. Run get_html() first.");
        }

        $nodes = $this->xpath->query($query_path);
        if ($nodes->length == 0) {
            throw new Exception("XPath query returned no results.");
        }

        $results = [];
        foreach ($nodes as $node) {
            if ($return_only_Node_Value) {
                $results[] = $as_html ? $this->dom->saveHTML($node) : trim($node->textContent);
            } else {
                if (!$this->set_attribute) {
                    throw new Exception("Attribute name not set. Use setAttribute() first.");
                }
                $this->crf = $node->getAttribute($this->set_attribute);
                if ($this->crf !== '') {
                    $results[] = $this->crf;
                }
            }
            if (!$loop_tag) break;
        }

        return $loop_tag ? $results : $results[0];
    }

// =========================================url_json for send request api
    public function setUrljson(string $url_json) {
        $this->url_json = $url_json;
    }
// =========================================set data array for parametr
    public function send_data(array $data=[]) {

        if (!$this->url_json) {
            throw new Exception("url_json not set. Set it before calling set_data().");
        }

        $postFields = http_build_query($data);
        curl_setopt($this->ch, CURLOPT_URL, $this->url_json);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postFields);
        $this->response_json = curl_exec($this->ch);
        if ($this->response_json === false) {
            throw new Exception('cURL error: ' . curl_error($this->ch));
        }
        return $this->response_json;
    }

    // ==================================================show  create JSON
    public function render_json(bool $creat = false) {
        $jsonData = json_decode($this->json ?? $this->response_json, true);

        if ($jsonData !== null) {
            $response = mb_convert_encoding($jsonData, 'UTF-8', 'auto');
            if ($creat) {
//                    set name for save data jason
                file_put_contents("unic_" . uniqid() . ".json", json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
            return  json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo "Response (not valid JSON):\n" . $this->response_json . "\n";
        }
    }
//        ===================================================================cread json for reseve data web
    public function cread_jason(string $company, array $currency = [], array $planes = [])
    {
        $data_json = [];

        // read file exist
        if (file_exists("unic.json")) {
            $data_json = json_decode(file_get_contents("unic.json"), true);
        }

        // creat company
        if (!isset($data_json[$company])) {
            $data_json[$company] = [
                "currency" => [],
                "planes" => []
            ];
        }

        foreach ($currency as $key => $value) {
            if (!isset($data_json[$company]["currency"][$key]) || $data_json[$company]["currency"][$key] !== $value) {
                $data_json[$company]["currency"][$key] = $value;
            }
        }

        foreach ($planes as $planKey => $planValue) {
            if (!isset($data_json[$company]["planes"][$planKey]) || $data_json[$company]["planes"][$planKey] !== $planValue) {
                $data_json[$company]["planes"][$planKey] = $planValue;
            }
        }

        file_put_contents("unic.json", json_encode($data_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }



    // =======================================================end cURL
    public function __destruct() {
        curl_close($this->ch);
    }
}




//$curl = new curl_web("https://example.com");
//$curl->get_html();
//$token = $curl->render_xpath('//input[@name="csrf"]', false);
//$curl->setUrljson("https://example.com/api");
//$response = $curl->send_data(['csrf'=>$token]);
//echo $curl->render_json();