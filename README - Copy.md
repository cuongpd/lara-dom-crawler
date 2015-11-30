## Laravel Data Crawler


## Installation

Require this package with composer:

```
composer require cuongpd/lara-dom-crawler
```

## Usage


### Get HTML Data


```php

use VnCode\VnCrawler\VnCrawler

$html = VnCrawler::get('https://google.com' , ['q' => 'laravel'] , ['mobile' => true , 'referer' => 'https://facebook.com' , 'header' => 'json']);
echo $html;

```

### Get HTML data to Dom

```php

use VnCode\VnCrawler\VnCrawler

$dom = VnCrawler::dom('https://google.com' , ['q' => 'laravel'] , ['mobile' => true , 'referer' => 'https://facebook.com' , 'header' => 'json']);

echo $dom->find('title',0)->innertext;

```