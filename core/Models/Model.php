<?php

namespace Core\Models;

use Exception;
use Core\Database\DB;

class Model
{
    /**
     * This will be where you can interact with data from your app
     * in a neat and organized manner.
     */

    public string $table;
    public array $fillable;
    private array $data;

    public function __get($varName) {
        if (!array_key_exists($varName, $this->data)) {
            throw new Exception("[-] No variable with name '$varName' in " . __CLASS__);
        }
        else return $this->data[$varName];
    }

    public function __set($varName, $value) {
        $this->data[$varName] = $value;
    }

    public function __construct(array $propArray)
    {
        $this->data = [];
        if (count($propArray) > count($this->fillable)) {
            throw new Exception(
                "[-] Too many items in \$propArray!\n
                Expected ${count($this->fillable)} but got ${count($propArray)} instead."
            );
        } else {

            // Set this class's variables to the ones passed in.
            foreach ($propArray as $key => $value) {
                $this->data[$key] = $value;
            }
        }
    }


    public function save() {
        DB::insert($this->table, $this->data);
        foreach($this->data as $key => $value) {
            error_log($key . ' => ' . $value);
        }
    }

    public function test() {
        error_log("Model table: $this->table");
        foreach($this->data as $key => $value) {
            error_log($key . ' => ' . $value);
        }
    }

};