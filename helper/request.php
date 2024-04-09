<?php
function request(array $routeParams) {
    return new class($routeParams) {
        private array $routeParams;

        public function __construct(array $routeParams) {
            $this->routeParams = $routeParams;
        }

        public function route(string $paramsName) {
            return $this->routeParams[$paramsName];
        }

        public function method() {
            return $_SERVER['REQUEST_METHOD'];
        }
    };
}
