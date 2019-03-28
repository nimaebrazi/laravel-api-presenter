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