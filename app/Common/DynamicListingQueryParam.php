<?php

namespace App\Common;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @author nazyie
 * 
 * Dynamic query for listing screen using DB facedes
 */
class DynamicListingQueryParam {

    public static function query(string $table, Request $request, string $primarySort = 'id') {
        // wrapping in try catch block for fault tolerance
        try {
            $NOT_EQUAL = "ne_";
            $MORE_THAN = "mt_";
            $LESS_THAN = "lt_";
            $LIKE = "lk_";

            $ORDER_BY = "order_by";
            $ORDER_BY_DESC = "order_by_desc";
            $PER_PAGE = "per_page";

            // main query
            $data = DB::table($table);
            $queryParams = $request->all();

            // transform $queryParams to
            //        $key => $value
            foreach($queryParams as $query => $value) {
                // skip if this paramter
                if ($query == 'page') {
                    continue;
                }

                // not equals
                if (Str::startsWith($query, $NOT_EQUAL)) {
                    $param = Str::after($query, $NOT_EQUAL);
                    $data->whereNot($param, $value);
                    continue;
                }

                // more than
                if (Str::startsWith($query, $MORE_THAN)) {
                    $param = Str::after($query, $MORE_THAN);
                    $data->where($param, '>', $value);
                    continue;
                }

                // less than
                if (Str::startsWith($query, $LESS_THAN)) {
                    $param = Str::after($query, $LESS_THAN);
                    $data->where($param, '<', $value);
                    continue;
                }

                // like
                if (Str::startsWith($query, $LIKE)) {
                    $param = Str::after($query, $LIKE);
                    $data->where($param, 'like', '%'.$value.'%');
                    continue;
                }

                // equal
                if (!Str::contains($query, [$ORDER_BY, $ORDER_BY_DESC, $PER_PAGE])) {
                    $data->where($query, $value);
                    continue;
                }

                // TODO: If required please add more in under this sections
            }

            // optional sorting
            if ($request->order_by) {
                $data->orderBy($request->order_by);
            }

            // optional sorting
            if ($request->order_by_desc) {
                $data->orderBy($request->order_by_desc);
            }

            // primary sorting
            // this will be required if the optional sorting is not unique
            $data->orderBy($primarySort);
            $result = $data->paginate($request->per_page ? $request->per_page : 15);
            return $result->withQueryString();

        } catch (Exception $ex) {
            $data = DB::table($table);
            $result = $data->paginate($request->per_page ? $request->per_page : 15);
            return $result->withQueryString();
        }
    }

}