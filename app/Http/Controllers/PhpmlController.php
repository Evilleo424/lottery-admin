<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Association\Apriori;
use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;

class PhpmlController extends Controller
{
    public function test1(){
        $samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
        $labels = ['a', 'b', 'c', 'd', 'e', 'f'];

        $classifier = new KNearestNeighbors();
        $classifier->train($samples, $labels);

        return $classifier->predict([3, 2]);
    }

    public function test2(){
        $samples = [['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta'], ['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta']];
        $labels  = [];

        $associator = new Apriori($support = 0.5, $confidence = 0.5);
        $associator->train($samples, $labels);
        return $associator->apriori();
    }

    public function test3(){
        $samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
        $labels = ['a', 'a', 'a', 'b', 'b', 'b'];

        $classifier = new SVC(Kernel::LINEAR, $cost = 1000);
        $classifier->train($samples, $labels);
        return $classifier->predict([[3, 2], [1, 5]]);
    }
}
