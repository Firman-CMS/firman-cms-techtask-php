# LoadSmile Technical Task
Suggested recipes for lunch API


## Requirement document

https://github.com/loadsmileau/php-tech-task

## How to Deploy
__Clone Repository__

`git clone https://github.com/Firman-CMS/firman-cms-techtask-php.git`


__Install Composer Project__

`cd firman-cms-techtask-php`

`composer install`

__Run Symfony Server__

`php bin/console server:run`

__Executed API__

- Use http://127.0.0.1:8000/lunch to get todays's recipes
- Use http://127.0.0.1:8000/lunch?date={date params} to get recipes on spesific date that you want
note :
{date params} format must be 'Y-m-d' (ex: 2019-03-05)
