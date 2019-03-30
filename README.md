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
        $this->apiPresenterModel
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
        $this->apiPresenterModel
            ->withSuccessStatus()
            ->setMessage('Success fetch!')
            ->setMainKey('user')
            ->setData($user->toArray());
        
        return $this->apiPresenter->present($apiPresenterModel);
    }
}

```

### Response without cache

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









### Sample client use data

```jquery-css

$.ajax(url).done(function(response){
    var mainKey = response.main_key;
    response.data[mainKey];
    //
});

```
