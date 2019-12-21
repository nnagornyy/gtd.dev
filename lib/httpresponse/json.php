<?php

namespace Gtd\Dev\HttpResponse;

class Json implements ResponseInterface {

    protected $response = [
        'error' => false,
        'errorMessage' => "",
        'result' => null,
    ];

    protected $result;
    protected $error;
    protected $http_status_code = 200;

    public function setError($code, $message)
    {
        $this->error = true;
        $this->http_status_code = $code;
        $this->response['errorMessage'] = $message;
    }

    public function setResult($result)
    {
        $this->response['result'] = $result;
    }

    public function show()
    {
        header('Content-Type: application/json');
        $this->response['error'] = $this->error;
        if($this->error){
            $this->response['result'] = null;
        }
        echo json_encode($this->response);
    }
}