<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public  function uploadimage()
    {
        return view("imageupload");
    }



    public  function sum()
    {
        return view("array_sum");
    }



    public  function findsortnumber()
    {
        return view("ksort");
    }


    public function process(Request $request)
    {
        $request->validate([
            'numbers' => 'required|string',
            'target' => 'required|numeric',
        ]);

        $nums = array_map('intval', explode(',', $request->numbers));
        $target = (int) $request->target;

        $results = [];

        for ($i = 0; $i < count($nums); $i++) {
            for ($j = $i + 1; $j < count($nums); $j++) {
                if ($nums[$i] + $nums[$j] == $target) {
                    $results[] = [$i, $j];
                }
            }
        }

        if (count($results)) {
            return view('array_sum', [
                'allResults' => $results,
                'original_nums' => $nums,
                'original_target' => $target
            ]);
        }

        return view('array_sum', [
            'message' => 'No matches found.',
            'original_nums' => $nums,
            'original_target' => $target
        ]);
    }


    public function kclosest(Request $request)
    {
        $request->validate([
            'numbers' => 'required|string',
            'k'       => 'required|integer|min:1',
            'x'       => 'required|numeric',
        ]);

        $nums = explode(',', $request->numbers);
        foreach ($nums as $i => $val) {
            $nums[$i] = (int) trim($val);
        }

        sort($nums);

        $k = (int) $request->k;
        $x = (int) $request->x;

        $diffs = [];
        foreach ($nums as $num) {
            $diffs[] = [
                'value' => $num,
                'dist'  => abs($num - $x)
            ];
        }

        usort($diffs, function ($a, $b) {
            if ($a['dist'] === $b['dist']) {
                return $a['value'] <=> $b['value'];
            }
            return $a['dist'] <=> $b['dist'];
        });

        $closest = [];
        for ($i = 0; $i < $k && isset($diffs[$i]); $i++) {
            $closest[] = $diffs[$i]['value'];
        }

        sort($closest);

        return view('ksort', [
            'result'        => $closest,
            'original_nums' => $nums,
            'original_k'    => $k,
            'original_x'    => $x,
        ]);
    }
}
