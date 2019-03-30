# Laravel API Presenter

## Description

### Installation

```
composer require nimaebrazi/laravel-api-presenter
```
#### Register ServiceProvider
If using laravel 5.4.* and older version you need add service provider in config/app.php
```php
'providers' => [
    ...
    \LaravelApiPresenter\ApiPresenterServiceProvider::class,
    ...
]
```

### Usage
#### 1. Response without cache

##### Example 1.1

```php
<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use LaravelApiPresenter\Contract\ApiPresenterInterface;
use LaravelApiPresenter\Presenter\Model\ApiPresenterModel;

class UserController extends Controller
{
    /**
     * @var ApiPresenterInterface
     */
    protected $apiPresenter;


    public function __construct(ApiPresenterInterface $apiPresenter)
    {
        $this->apiPresenter = $apiPresenter;
    }

    public function find($id)
    {
        $user = User::find($id);

        $apiPresenterModel = new ApiPresenterModel();
        $apiPresenterModel
            ->withSuccessStatus()
            ->setMessage('Success fetch!')
            ->setMainKey('user')
            ->setData($user->toArray());
        
        return $this->apiPresenter->present($apiPresenterModel);
    }
}

```

```json
{
    "success": true,
    "message": "Success fetch!",
    "description": "",
    "data": {
    "main_key": "user",
        "user": {
        "id": 1,
        "name": "Mr. Claude Greenfelder I",
        "email": "carlie84@example.com",
        "email_verified_at": "2019-03-19 00:07:52",
        "created_at": "2019-03-19 00:07:52",
        "updated_at": "2019-03-19 00:07:52"
        }
    }
}

```


##### Example 1.2

```php
<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use LaravelApiPresenter\Contract\ApiPresenterInterface;
use LaravelApiPresenter\Presenter\Model\ApiPresenterModel;

class UserController extends Controller
{
    /**
     * @var ApiPresenterInterface
     */
    protected $apiPresenter;


    public function __construct(ApiPresenterInterface $apiPresenter)
    {
        $this->apiPresenter = $apiPresenter;
    }

    public function find()
    {
        $ids = [1,2,3];
        $user = User::find($ids);

        $apiPresenterModel = new ApiPresenterModel();
        $apiPresenterModel
            ->withSuccessStatus()
            ->setMessage('Success fetch!')
            ->setMainKey('user')
            ->setData($user->toArray());
        
        return $this->apiPresenter->present($apiPresenterModel);
    }
}

```

```json
{
    "success": true,
    "message": "Success fetch!",
    "description": "",
    "data": {
    "main_key": "user",
    "user": 
        [
            {
            "id": 1,
            "name": "Mr. Claude Greenfelder I",
            "email": "carlie84@example.com",
            "email_verified_at": "2019-03-19 00:07:52",
            "created_at": "2019-03-19 00:07:52",
            "updated_at": "2019-03-19 00:07:52"
            },
            {
            "id": 2,
            "name": "Josiane Rath IV",
            "email": "isobel66@example.org",
            "email_verified_at": "2019-03-19 00:07:52",
            "created_at": "2019-03-19 00:07:52",
            "updated_at": "2019-03-19 00:07:52"
            },
            {
            "id": 3,
            "name": "Mr. Godfrey Witting I",
            "email": "karine35@example.org",
            "email_verified_at": "2019-03-19 00:07:52",
            "created_at": "2019-03-19 00:07:52",
            "updated_at": "2019-03-19 00:07:52"
            }
        ]
    }
}
```


#### 2. Response single object with cache

##### Example 2.1

```php
<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use LaravelApiPresenter\Contract\ApiPresenterInterface;
use LaravelApiPresenter\Presenter\Model\ApiPresenterModel;

class UserController extends Controller
{
    /**
     * @var ApiPresenterInterface
     */
    protected $apiPresenter;


    public function __construct(ApiPresenterInterface $apiPresenter)
    {
        $this->apiPresenter = $apiPresenter;
    }

    public function find($id)
    {
        $user = User::find($id);

        $apiPresenterModel = new ApiPresenterModel();
        $apiPresenterModel->withSuccessStatus()
            ->setMessage('Success fetch!')
            ->setMainKey('user')
            ->cacheable()
            ->setCacheKey("user_{$id}")
            ->setData($user->toArray());
        
        return $this->apiPresenter->present($apiPresenterModel);
    }
}

```

```json
{
    "success": true,
    "message": "Success fetch!",
    "description": "",
    "data": {
    "main_key": "user",
        "user": {
        "id": 1,
        "name": "Mr. Claude Greenfelder I",
        "email": "carlie84@example.com",
        "email_verified_at": "2019-03-19 00:07:52",
        "created_at": "2019-03-19 00:07:52",
        "updated_at": "2019-03-19 00:07:52"
        }
    }
}

```

##### Note
It's depend on your application cache driver setting.

For example you can find output key if using redis like:
```text
laravel_cache:user_1
```
 
 
#### 3. Response with cache and _auto pagination_

##### Example 3.1

```php
<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use LaravelApiPresenter\Contract\ApiPresenterInterface;
use LaravelApiPresenter\Presenter\Model\ApiPresenterModel;

class UserController extends Controller
{
    /**
     * @var ApiPresenterInterface
     */
    protected $apiPresenter;


    public function __construct(ApiPresenterInterface $apiPresenter)
    {
        $this->apiPresenter = $apiPresenter;
    }

    public function all(Request $request)
    {
        $limit = $request->has('limit') ? $request->input('limit') : 5;

        $users = User::paginate($limit);

        $apiPresenterModel = new ApiPresenterModel();
        $apiPresenterModel
            ->withSuccessStatus()
            ->setMessage('Success fetch!')
            ->setMainKey('users')
            ->withMeta()
            ->cacheable()
            ->setCacheKey("users")
            ->setData($users->toArray());
        
        return $this->apiPresenter->present($apiPresenterModel);
    }
}

```

```json
{
    "success": true,
    "message": "Success fetch!",
    "description": "",
    "data": {
    "main_key": "users",
    "users": 
        [
            {
            "id": 1,
            "name": "Mr. Claude Greenfelder I",
            "email": "carlie84@example.com",
            "email_verified_at": "2019-03-19 00:07:52",
            "created_at": "2019-03-19 00:07:52",
            "updated_at": "2019-03-19 00:07:52"
            },
            {
            "id": 2,
            "name": "Josiane Rath IV",
            "email": "isobel66@example.org",
            "email_verified_at": "2019-03-19 00:07:52",
            "created_at": "2019-03-19 00:07:52",
            "updated_at": "2019-03-19 00:07:52"
            },
            {
            "id": 3,
            "name": "Mr. Godfrey Witting I",
            "email": "karine35@example.org",
            "email_verified_at": "2019-03-19 00:07:52",
            "created_at": "2019-03-19 00:07:52",
            "updated_at": "2019-03-19 00:07:52"
            }
        ]
    },
    "links": {
        "first": "http://127.0.0.1:8000/users?page=1",
        "last": "http://127.0.0.1:8000/users?page=34",
        "next": "http://127.0.0.1:8000/users?page=2",
        "prev": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 34,
        "path": "http://127.0.0.1:8000/users",
        "per_page": "3",
        "to": 3,
        "total": 100
    }
}

```
##### Note:
Package generate key from meta and transform cache key in redis like:
```text
laravel_cache:users__limit_3__page_1
```

#### 4. Response with cache and _custom pagination_
- Pay attention, when use custom meta, you should make custom cache key too.
Suppose you set cache key `users` and paginate your data and respond to client `page one`. So package set your cache `users` and not append meta data to cache key.
And your response not correct when client limit the result of data and page.
- Don't use `withMeta()` method when set custom meta data.

##### Example 4.1

```php
<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use LaravelApiPresenter\Contract\ApiPresenterInterface;
use LaravelApiPresenter\Presenter\Model\ApiPresenterModel;
use LaravelApiPresenter\Presenter\Model\MetaModel;

class UserController extends Controller
{
    /**
     * @var ApiPresenterInterface
     */
    protected $apiPresenter;


    public function __construct(ApiPresenterInterface $apiPresenter)
    {
        $this->apiPresenter = $apiPresenter;
    }

    public function all(Request $request)
    {
        $limit = $request->has('limit') ? $request->input('limit') : 5;

        $users = User::paginate($limit);

        $metaModel = new MetaModel();
        $metaModel->setCurrentPage(1)
            ->setLastPage(3)
            ->setTo(3)
            ->setTotal(50);


        $apiPresenterModel = new ApiPresenterModel();
        $apiPresenterModel
            ->withSuccessStatus()
            ->setMessage('Success fetch!')
            ->setMainKey('users')
            ->withMeta()
            ->cacheable()
            ->setCacheKey("users__limit_1__page_1")
            ->setData($users->toArray());

        return $this->apiPresenter->present($apiPresenterModel);
    }
}

```

For more info about MetaModel read class:
```php
LaravelApiPresenter\Presenter\Model\MetaModel
```

#### How to set custom response?

You access to response object in ApiPresenter.

Suppose you want change response header:
```php
...
        $this->apiPresenter->response()
            ->header('X-Header-One', 'Header Value One ')
            ->header('X-Header-Two', 'Header Value Two');
...
```