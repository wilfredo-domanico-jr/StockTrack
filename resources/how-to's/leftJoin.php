<?php

DB::table('table1')
    ->leftJoin('table2', 'table1.column_name', '=', 'table2.column_name')
    ->select('table1.*', 'table2.column_name as column_alias')
    ->get();


?>