<?php
// core/Controller.php
class Controller {
protected $pdo;
public function __construct($pdo) {
$this->pdo = $pdo;
}


protected function view($path, $data = []) {
extract($data);
require __DIR__ . '/../app/views/layout/header.php';
require __DIR__ . '/../app/views/' . $path;
require __DIR__ . '/../app/views/layout/footer.php';
}
}