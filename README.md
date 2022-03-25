# Fork for the clickup-php

<p align="center"><img src="https://clickup.com/landing/images/integrations/clickup-api-beta.png"></p>

Fork for the original repo [clickup-php](https://github.com/howyi/clickup-php) | Author: [howyi](https://github.com/howyi)

A simple wrapper for [ClickUp](https://clickup.com/api) API (v1-BETA).

Fork difference:
- Api update to version 2 (in progress)
- Add retries when [rate limit](https://jsapi.apiary.io/apis/clickup20/introduction/rate-limiting.html) is reached (done, thanks [@osiset](https://github.com/osiset/Basic-Shopify-API))
- Add tmp cache for identical requests in a short time (in the plans) 

## Table of Contents
* [Installation](#installation)
* [Usage](#usage)
    * [Generate Client](#generate-client)
    * [Get](#get)
    * [Create](#create)
    * [Update](#update)
    * [Storage](#storage)
* [LICENSE](#license)

## Installation
```
composer require eduard9969/clickup-php
```

The package is in development status. ~~I don't want to add another copy of the fork to https://packagist.org/~~

Also, You can install the package using [VSC](https://getcomposer.org/doc/05-repositories.md#vcs) in your composer.json.
Add the following code:
```composer
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/Eduard9969/clickup-php.git"
    }
]
```

## Usage
 
### Generate client
```php
// create Option (required: API_TOKEN)
$options = new ClickUp\Options('API_TOKEN');

// create Client (required: ClickUp\Options)
$client = new ClickUp\Client($options);
```

### Get

```php
// me
$client->user();
// -> \ClickUp\Objects\User


// all affiliated teams
$client->teams()->objects();
// -> \ClickUp\Objects\Team[]

// team by team id
$team = $client->team($teamId);
// team by name
$team = $client->teams()->getByName('team_name');
// -> \ClickUp\Objects\Team


// spaces in team
$team->spaces()->objects();
// -> \ClickUp\Objects\Space[]

// space by space id
$space = $team->space(888);
// space by name
$space = $team->spaces()->getByName('spaaaaace');
// -> \ClickUp\Objects\Space


// folders in space
$space->folders()->objects();
// -> \ClickUp\Objects\Folder[]

// folder by folder id
$folder = $space->folder(11111);
// folder by name
$folder = $space->folders()->getByName('super cool folder');
// -> \ClickUp\Objects\Folder

// lists in folder
$folder->taskLists()->objects();
// -> \ClickUp\Objects\TaskList[]

// list by list id
$taskList = $folder->taskList(9999);
// list by name
$taskList = $folder->taskLists()->getByName('T A S K L I S T');
// -> \ClickUp\Objects\TaskList

// tasks by list
// @see https://jsapi.apiary.io/apis/clickup20/reference/0/lists/update-list.html
$tasks = $taskList->tasks()->objects();
// -> \ClickUp\Objects\Task[]

// task by task id
$task = $taskList->task(3333);
// -> \ClickUp\Objects\Task

// all tasks with chunks
// tasksChunk get all tasks from the API and execute callback function (arg: $tasks->objects())
$allTasks = [];
$team->tasksChunk(false, false, function($tasks) use (&$allTasks) {
    $allTasks = array_merge($tasks, $allTasks);
    // return false; // break loop 
});
// -> true \ false
```
You can use `tasks` and `task` methods on the any level (`$team->tasks(); $space->tasks(); $folder->tasks(); etc`). But remember, 100 is the maximum number of items in the response (not actual for chunk method), I recommend refining the research area.

### Create 
```php
/**
 * create task list in folder
 * @see https://jsapi.apiary.io/apis/clickup20/reference/0/lists/create-list.html
 * @see https://jsapi.apiary.io/apis/clickup20/reference/0/lists/create-folderless-list.html
 */
$folder->createTaskList(['name' => 'newTaskList']);

/**
 * create task in list
 * @see https://jsapi.apiary.io/apis/clickup20/reference/0/tasks/create-task.html
 */
$taskList->createTask(['name' => 'my second task']);
```

### Update
```php
/**
 * update task list
 * @see https://jsapi.apiary.io/apis/clickup20/reference/0/lists/update-list.html
 */
$taskList->edit(['name' => 'renamed task list']);

/**
 * update task
 * @see https://jsapi.apiary.io/apis/clickup20/reference/0/lists/update-list.html
 */
$task->edit(['name' => 'renamed task']);
```

### Storage
By default retries when rate limit is reached execute via `Memory::Class`. You can use other storage (Implement the `StateStorage` interface) and use custom time deferrer (Implement the `TimeDeferrer` interface).

```php
// create Option (required: API_TOKEN)
$options = new ClickUp\Options('API_TOKEN');

// create StoreOptions (optional: StateStorage, StateStorage, TimeDeferrer)
$storeOptions = new ClickUp\StoreOptions($redisTStorage, $redisLStorage, $timeDeferrer);

// create Client (required: ClickUp\Options, optional: ClickUp\StoreOptions)
$client = new ClickUp\Client($options, $storeOptions);
```

## LICENSE

This project is released under the MIT [license](https://github.com/Eduard9969/clickup-php/blob/master/LICENSE).
