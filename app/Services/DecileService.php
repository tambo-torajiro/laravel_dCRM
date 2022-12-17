<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DecileService
{
    public static function decile($subQuery)
    {
        // 購入ID毎にまとめる
        $subQuery = $subQuery->groupBy('id')
        ->selectRaw('id,customer_id, customer_name, SUM(subtotal) as totalPerPurchase');

        // 会員ごとにまとめ、購入額順にソートする
        $subQuery = DB::table($subQuery)
        ->groupBy('customer_id')
        ->selectRaw('customer_id,customer_name, sum(totalPerPurchase) as total')
        ->orderBy('total','desc');

        // 購入順に連番を振る
        DB::statement('set @row_num = 0;');
            $subQuery = DB::table($subQuery)
            ->selectRaw('@row_num:= @row_num+1 as row_num, customer_id, customer_name, total');

        // 全体の件数を数え、1/10の値や合計金額を取得
        $count = DB::table($subQuery)->count();
        $total = DB::table($subQuery)->selectRaw('sum(total) as total')->get();
        $total = $total[0]->total;

        $decile = ceil($count / 10);

        $bindValues = [];
        $tempValue = 0;
        for ($i=1; $i <= 10 ; $i++) {
            array_push($bindValues, 1 + $tempValue);
            $tempValue += $decile;
            array_push($bindValues, 1 + $tempValue);
        }

        // 10分割しグループ毎に数字を振る

        DB::statement('set @row_num = 0;');
        $subQuery = DB::table($subQuery)
        ->selectRaw("row_num,customer_id,customer_name,total,
        case
            WHEN ? <= row_num and row_num < ? THEN 1
            WHEN ? <= row_num and row_num < ? THEN 2
            WHEN ? <= row_num and row_num < ? THEN 3
            WHEN ? <= row_num and row_num < ? THEN 4
            WHEN ? <= row_num and row_num < ? THEN 5
            WHEN ? <= row_num and row_num < ? THEN 6
            WHEN ? <= row_num and row_num < ? THEN 7
            WHEN ? <= row_num and row_num < ? THEN 8
            WHEN ? <= row_num and row_num < ? THEN 9
            WHEN ? <= row_num and row_num < ? THEN 10
        end as decile", $bindValues);

        $subQuery = DB::table($subQuery)
        ->groupBy('decile')
        ->selectRaw('decile,round(avg(total)) as average, sum(total) as totalPerGroup');


        // 構成比を出すために変数を使う

        DB::statement("set @total = ${total};");
        $data = DB::table($subQuery)
        ->selectRaw('decile, average, totalPerGroup,round(100 * totalPerGroup / @total, 1) as totalRatio')
        ->get();

        $labels = $data->pluck('decile');
        $totals = $data->pluck('totalPerGroup');



        return [$data,$labels,$totals];

    }

}