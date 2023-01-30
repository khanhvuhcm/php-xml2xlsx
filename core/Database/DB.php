<?php


namespace Core\Database;

use Exception;
use PDOException;

class DB
{
    public static $conn;
    public static function connect($dbConfigFile)
    {

        /** Load variables from DB config file
         * $dbType
         * $dbHost
         * $dbName
         * $dbUsername
         * $dbPassword
         * $pdoOptions
         */
        require $dbConfigFile;

        try {
            self::$conn = new \PDO("$dbType:host=$dbHost;dbname=$dbName",
                $dbUsername, $dbPassword, $pdoOptions
            );

        } catch (\PDOException $e) {
            print "ERROR: Database connection error.";
            die();
        }
        self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function select(string $query_str, array $query_bindings_array = null, bool $all = false)
    {
        /**
         * Prepares a query and executes it securely.
         *
         * DO NOT USE USER SUPPLIED VARIABLES INSIDE THE $query_str!!!! If you are using user supplied variables, structure your $query_str appropriately
         * @param $query_str
         *
         * The associative array of bindings for the SQL query, and is needed if using user supplied variables to avoid SQL injections
         * @param $query_bindings_array = null
         *
         * Whether or not to return all of the results when running SELECT queries. If not supplied, it will only return one result
         * @param $all
         */

        // Make sure 'SELECT' is the first part of the query.
        if (explode(' ', trim($query_str))[0] != 'SELECT') {
            print(new Exception("'DB::select()' query is not a select query."));
            exit();
        }

        try {
            $prepared_statement = self::$conn->prepare($query_str);
            $prepared_statement->execute($query_bindings_array);

            // Return all results if running a SELECT query.
            if ($all){
                return $prepared_statement->fetchAll();
            }

            // Return the first result when running a SELECT query.
            return $prepared_statement->fetch();
        } catch (PDOException $error) {
            print($error);
            exit();
        }

    }

    public static function query(string $query_str, array $query_bindings_array = null)
    {
        /**
         * Prepares a query and executes it securely.
         *
         * DO NOT USE USER SUPPLIED VARIABLES INSIDE THE $query_str!!!! If you are using user supplied variables, structure your $query_str appropriately
         * @param $query_str
         *
         * The associative array of bindings for the SQL query, and is needed if using user supplied variables to avoid SQL injections
         * @param $query_bindings_array = null
         */

        try {
            $prepared_statement = self::$conn->prepare($query_str);
            $prepared_statement->execute($query_bindings_array);

        } catch (PDOException $error) {
            print($error);
            exit();
        }
    }

    public static function insert(string $table, array $bindings_array) {
        /**
         * Builds an INSERT statement to insert values into $table based on the values in $bindings_array.
         *
         * @param $table
         * The name of the table to insert into.
         *
         * @param $bindings_array
         * An assosiative array of values to insert. i.e:
         * $bindings_array = [
         *  'name' => 'john',
         *  'age' => '23'
         * ]
         */


        $insertQuery = "INSERT INTO $table (";
        $i = 0;
        foreach($bindings_array as $key => $value) {
            if ($i == count($bindings_array) -1 ) {
                $insertQuery .= "$key) ";
                break;
            }
            else {
                $insertQuery .= "$key, ";
            }
            $i++;

        }

        $insertQuery .= 'VALUES (';

        $j = 0;
        foreach($bindings_array as $key => $value) {
            if ($j == count($bindings_array) - 1) {
                $insertQuery .= ":$key);";
                break;

            } else {
                $insertQuery .= ":$key, ";
            }

            $j++;
        }

        self::query($insertQuery, $bindings_array);
    }
}