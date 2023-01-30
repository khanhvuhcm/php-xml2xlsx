<?php

namespace App\Controller;
use Core\View\View;
use Core\Controllers\Controller;

use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HomeController extends Controller {

  public static function index () {
    return View::render('home.twig');
  }

  public static function upload () {
    $spreadsheet = IOFactory::load("download/sample.xml");
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save("download/sample.xlsx");
    $res['msg'] = 'Converted';
    return View::render('home.twig', $res);
  }
};