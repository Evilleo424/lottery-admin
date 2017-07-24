<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function import(){
        $filePath = 'storage/exports/history.xls';
        Excel::load($filePath, function($reader) {
            $data = json_decode($reader->get(),true);

            foreach($data as $key => $value){
                $numbers = explode('+',$value['numbers']);
                $red = explode(',',$numbers[0]);
                \App\Ssq::create([
                    'periods'   => $value['periods'],
                    'r1'        => array_shift($red),
                    'r2'        => array_shift($red),
                    'r3'        => array_shift($red),
                    'r4'        => array_shift($red),
                    'r5'        => array_shift($red),
                    'r6'        => array_shift($red),
                    'b1'        => $numbers['1'],
                    'numbers'   => $value['numbers']
                ]);

            }
        });
    }

    public function output(){
        $cellData = [
            ['期数','号码'],
            ['2017033','05 07 15 20 23 30/15'],
            ['2017032','05 08 15 24 27 31/11'],
            ['2017031','06 10 16 26 27 29/03'],
        ];
            Excel::create('history',function($excel) use ($cellData){
                $excel->sheet('result', function($sheet) use ($cellData){
                    $sheet->rows($cellData);
                });
            })->export('xls');
    }
}
