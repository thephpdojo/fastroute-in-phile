<?php
function response() {
    return new class {
        public function json(array $data) {
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    };
}
