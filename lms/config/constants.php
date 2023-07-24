<?php

define('TRUE_FALSE_ID', 1);
define('CHOICES_ID', 2);

define('TRUE_FALSE', 'True/False');
define('CHOICES', 'Multiple Choices');

define('EASY', 'Easy');
define('NORMAL', 'Normal');
define('HARD', 'Hard');

define('A', 'a');
define('B', 'b');
define('C', 'c');
define('D', 'd');
define('E', 'e');

define('TRUE_TEXT', 'True');
define('FALSE_TEXT', 'False');



return [
    'response_types' => [
        1 => TRUE_FALSE,
        2 => CHOICES,
    ],
    'difficulty_level' => [
        1 => EASY,
        2 => NORMAL,
        3 => HARD,
    ],
    'answers' => [
        1 => A,
        2 => B,
        3 => C,
        4 => D,
        5 => E,
    ],
    'answers_2' => [
        1 => TRUE_TEXT,
        2 => FALSE_TEXT
    ],
    'TRUE_FALSE_ID' =>  TRUE_FALSE_ID,
    'CHOICES_ID'    =>  CHOICES_ID,
    'TRUE'          =>  TRUE_TEXT,
    'FALSE'         =>  FALSE_TEXT,
];
