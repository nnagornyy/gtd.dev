<?php
namespace Gtd\Dev\HttpResponse;

interface ResponseInterface {
    public function show();
    public function setResult($result);
    public function setError($code, $message);
}
