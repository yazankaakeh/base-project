<?php

/*
|--------------------------------------------------------------------------
| Unit Smoke Test
|--------------------------------------------------------------------------
|
| Minimal Pest unit test so `vendor/bin/phpunit --testsuite=Unit` has at
| least one green assertion before the suite is populated. Module-specific
| unit tests live under Modules/<Name>/tests/Unit.
|
*/

it('has sane basic assertions', function () {
    expect(true)->toBeTrue();
    expect(1 + 1)->toBe(2);
});
