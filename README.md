# LoadSmile Technical Task
Suggested recipes for lunch API


## Requirement document

https://github.com/loadsmileau/php-tech-task

## How to Deploy
__Clone Repository__
`git clone https://github.com/Firman-CMS/firman-cms-techtask-php.git`
Clone this Repository
- Given that I have made a request to the `/lunch` endpoint I should receive a `JSON` response of the recipes 
that I can prepare based on the availability of ingredients in my fridge.
- Given that an ingredient is past its `use-by` date (inclusive), I should not receive recipes containing this ingredient.
- Given that an ingredient is past its `best-before` date (inclusive), but is still within its `use-by` date (inclusive), any recipe containing the oldest (less fresh) ingredient should placed at the bottom of the response object.

__Additional Criteria__
- The application SHOULD contains unit / integration tests (e.g. `PHPUnit`).
- The application MUST be completed using an `OOP` approach.
- The application MUST be `PSR` compliant.
- Any dependencies MUST be installed using `Composer` (no need to commit dependencies, the
composer.lock file will be sufficient).
- Use `PHP5.6` or `PHP7`.
- Any installation, build steps, testing and usage instructions MUST be provided in a `README.md` file in the root of the application.

## Framework
Use the `Symfony micro framework` (https://symfony.com/doc/current/setup.html) to create the application API. 

