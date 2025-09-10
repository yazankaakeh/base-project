<?php

namespace Modules\Blog\Enum;

enum Languages: string
{

  case EN = 'en';
  case AR = 'ar';
  case TR = 'tr';

  public static function values(): array
  {
    return [
      self::EN->value,
      self::AR->value,
      self::TR->value,
    ];
  }
}
