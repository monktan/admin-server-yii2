<?php
if (! function_exists('mt_config')) {
    function mt_config($key)
    {
        $config = \monktan\framework\App::$config->get($key);

        return $config;
    }
}

if (! function_exists('mt_throw_info')) {
    function mt_throw_info($message, $httpCode = RESPONSE_CODE_WARNING)
    {
        $exception = new \monktan\common\exceptions\InfoException($message, $httpCode);

        throw $exception;
    }
}

if (! function_exists('mt_success')) {
    function mt_success($data)
    {
        return mt_response($data, RESPONSE_CODE_NORMAL);
    }
}

if (! function_exists('mt_warn')) {
    function mt_warn(Throwable $exception)
    {
        $data['message'] = $exception->getMessage();
        $code = $exception->getCode();
        if (empty($code)) {
            $code = RESPONSE_CODE_WARNING;
        }

        return mt_response($data, $code);
    }
}

if (! function_exists('mt_error')) {
    function mt_error(Throwable $exception)
    {
        if (YII_ENV != ENV_PROD) {
            $data['message'] = $exception->getMessage();
        } else {
            $data['message'] = '系统繁忙，请稍后再试';
        }

        return mt_response($data, RESPONSE_CODE_ERROR);
    }
}

if (! function_exists('mt_response')) {
    function mt_response($data = [], $code = RESPONSE_CODE_NORMAL)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        \Yii::$app->response->statusCode = $code;
        \Yii::$app->response->data = $data;

        return \Yii::$app->response->send();
    }
}

if (! function_exists('mt_model')) {
    /**
     * @param $modelObj
     * @return \monktan\framework\db\ModelInterface
     */
    function mt_model($modelObj)
    {
        $model = \monktan\framework\App::$model;

        return $model->m($modelObj);
    }
}

if (! function_exists('mt_route')) {
    function mt_route()
    {
        $controller = get_class(Yii::$app->controller);
        $action = Yii::$app->controller->action->id;

        return "{$controller}::{$action}";
    }
}

if (! function_exists('mt_session_data')) {
    function mt_session_data($key = '')
    {
        $sessionData = [];
        if (! isset($_SERVER['session_data'])) {
            return $sessionData;
        }
        $sessionData = $_SERVER['session_data'];
        if (empty($key)) {
            return $sessionData;
        }

        return $sessionData[$key] ?? null;
    }
}
