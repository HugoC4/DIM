<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use \PDO;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=dim;charset=utf8mb4', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    protected function delete($query, $params) {
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    protected function update($query, $params) {
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    protected function insert($query, $params) {
        $stmt = $this->db->prepare($query);
        $success = $stmt->execute($params);
        return $success === false ? false : $this->db->lastInsertId();
    }

    // Simple handler for the querying
    protected function query($query, $statements = []) {
        $stmt = $this->db->prepare($query);
        $stmt->execute($statements);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function _auth() {
        return isset($_SESSION["admin_id"]);
    }

    protected function _redlog() {
        return redirect()->action("BackendController@Login");
    }

    protected function _redevt() {
        return redirect()->action("EventController@Events");
    }
}
