<?php
    namespace App\Responses;

    class Response {

        public $status;
        public $message;
        public $data;

        public function make($status, $message = null, $data = null)
        {
            $this->status = $status;
            $this->message = $message;
            $this->data = $data;

            return $this;
        }
    }
