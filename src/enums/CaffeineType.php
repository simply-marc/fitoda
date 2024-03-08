<?php

namespace src\Enums;

enum CaffeineType: string
{
    case CAFFEINATED = 'Caffeinated';
    case CAFFEINE_FREE = 'Caffeine Free';
    case DECAFFEINATED = 'Decaffeinated';
    case MIXED = 'Mixed';
    case NONE = '';
}