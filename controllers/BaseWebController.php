<?php

namespace app\controllers;

use app\framework\common\filters\ValidatorFilter;
use yii\base\Module;
use yii\web\Controller;

class BaseWebController extends Controller
{
    protected $service;

    public $validate;

    public $request;

    public function __construct(string $id, Module $module, array $config = [])
    {
        $this->request = \Yii::$app->request;

        parent::__construct($id, $module, $config);
    }

    /**
     * 声明过滤器
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'validator' => [
                'class' => ValidatorFilter::class
            ],
//            'response' => [
//                'class' => ResponseFilter::class
//            ],
//            'auth' => [
//                'class' => BaseAuthFilter::class
//            ],
        ];
    }

    public function beforeAction($action)
    {
        if (! (parent::beforeAction($action))) {
            return false;
        }

        return true;
    }
}