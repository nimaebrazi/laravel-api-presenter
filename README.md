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
            },
            {
                "id": 4,
                "name": "Clark Wunsch",
                "email": "zieme.sonny@example.com",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 5,
                "name": "Elmore Bode",
                "email": "breilly@example.org",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 6,
                "name": "Ms. Adela Purdy III",
                "email": "fflatley@example.com",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 7,
                "name": "Cristina Heathcote",
                "email": "ryley.smith@example.net",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 8,
                "name": "Janis Brekke",
                "email": "bartoletti.gabe@example.com",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 9,
                "name": "Brando Brown",
                "email": "cbrekke@example.net",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 10,
                "name": "D'angelo Schinner",
                "email": "maya74@example.com",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 11,
                "name": "Katrina Wisozk",
                "email": "ellsworth.witting@example.com",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 12,
                "name": "Devonte Parisian",
                "email": "will.jack@example.net",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 13,
                "name": "Zoie O'Reilly",
                "email": "alvera26@example.com",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 14,
                "name": "Lila Gutkowski",
                "email": "aufderhar.eloisa@example.com",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
            },
            {
                "id": 15,
                "name": "Tyree O'Connell",
                "email": "langworth.lilly@example.net",
                "email_verified_at": null,
                "created_at": "2019-03-28 05:51:23",
                "updated_at": "2019-03-28 05:51:23"
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
        "per_page": 15,
        "to": 15,
        "total": 500
    }
}

```