# Laravel API Presenter

### Sample code 

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

    public function all()
    {
        $users = User::paginate();


        $apiPresenterModel = new ApiPresenterModel();
        $apiPresenterModel
            ->setMessage('Success fetch!')
            ->setDescription('Sample description')
            ->withSuccessStatus()
            ->withMeta()
            ->cacheable()
            ->setCacheKey('users')
            ->setMainKey('users')
            ->setData($users->toArray());
        

        $this->apiPresenter->response()->header('X-Header-One', 'Header Value');
        return $this->apiPresenter->present($apiPresenterModel);
    }
}

```

### Sample Response

```json
{
    "success": true,
    "message": "Success fetch!",
    "description": "Sample description",
    "data": {
        "main_key": "users",
        "users": [
            {
                "id": 1,
                "name": "Dr. Gladys McLaughlin",
                "email": "wgoldner@example.com",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 2,
                "name": "Ronaldo Hackett",
                "email": "ubaumbach@example.com",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 3,
                "name": "Sheldon Glover",
                "email": "sigurd.hammes@example.org",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            }
        ]
    },
    "links": {
        "first": "http://127.0.0.1:8000/users?page=1",
        "last": "http://127.0.0.1:8000/users?page=167",
        "next": "http://127.0.0.1:8000/users?page=2",
        "prev": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 167,
        "path": "http://127.0.0.1:8000/users",
        "per_page": 3,
        "to": 3,
        "total": 500
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