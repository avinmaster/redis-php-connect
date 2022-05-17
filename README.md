# PHP script for manipulating existance of redis/memcached keys.
Author: <b>me</b>. For TA. <b>Used [phpredis](https://github.com/phpredis/phpredis).</b>

## Usage:
```bash
php redis-php-connect.php <db-name> <command> <key> <value>
```
Arguments' acceptable values:
1. db-name - `redis`, `memcached`;
2. command - `add`, `delete`;
3. key - any text;
4. value - any text.

Даже не час работы, не судите строго)