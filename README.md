# Cleup - Web application events

#### Installation

Install the `cleup/events` library using composer:

```
composer require cleup/events
```

#### Usage

##### Event initialization
```php 
use Cleup\Components\Events\Event;

# Simple event
Event::apply('customEvent');

# Event with arguments
$name = 'Eduard';
$age = 30;
$fields = array(
    'login' => 'priveted',
    'type' => 'admin'
);
Event::apply('customEvent', $name, $age, $fields, ...);
```


##### Add a new event

```php
use Cleup\Components\Events\Event;

# With the function
Event::add('customEvent', function () {
   print_r("Hi, I've been added to the event thread");
});

# Using the function name
function helloWorld () {
    print_r('Hello World!');
}

Event::add('customEvent', 'helloWorld');

# Using the class method
Event::add('customEvent', [Example::class, 'get']);
```

##### Modifiers for adding an event
Assign the position of the callback execution.
```php
use Cleup\Components\Events\Event;

Event::add('getPosts', function (&$postList) {
    // ...
})->position(100);
```

Create an ID for the event. You can use this ID to delete a specific event
```php
use Cleup\Components\Events\Event;

Event::add('getPosts', function (&$postList) {
    // ...
})->id('isBadPost');
```


Execute once. The modifier can be useful if the event is executed multiple times or in a loop.
```php
use Cleup\Components\Events\Event;

Event::add('postItem', function ($post) {
    // This event will be deleted immediately after execution
})->once();

$posts = array(
    0 => [
        'id' => 1
        'title' => 'First post'
    ],
    1 => [
        'id' => 2
        'title' => 'Hello world!'
    ]
)

foreach($posts as $post) {
    // The event will be executed only once and will be deleted
    Event::apply('postItem', $post);
}

```

##### Delete event

```php
Event::delete('getdPosts');

// Delete event by ID
Event::delete('getdPosts', 'isBadPost');
```

