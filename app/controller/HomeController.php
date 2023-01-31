<?php

namespace App\Controller;
use Core\View\View;
use Core\Controllers\Controller;

use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use \Exception;

class HomeController extends Controller {

  public static function index () {
    return View::render('home.twig');
  }

  public static function uploadAjax () {
    $allowed = array('xml');
    $fileName = $_FILES["file1"]["name"]; // The file name
    $fileTmp = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
    $fileType = $_FILES["file1"]["type"]; // The type of file it is
    $fileSize = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
    $name = pathinfo($fileName, PATHINFO_FILENAME);
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

    if (!in_array($ext, $allowed)) {
      die('ERROR: File type is not allowed');
    }

    if (!$fileTmp) { // if file not chosen
      die("ERROR: Please select a file.");
    }

    if(!move_uploaded_file($fileTmp, "upload/$fileName")) {
      die("ERROR: Move_uploaded_file failed");
    } else {
      try {
        $spreadsheet = IOFactory::load("upload/$fileName");
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save("download/$name.xlsx");
        die("$name.xlsx");
      } catch (\Exception $e) {
        die('ERROR: ' + $e->getMessage());
      }
    }
  }

};
