<?php

// Disable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS = 0');

// Your bulk data operations or other queries here

// Enable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS = 1');


?>