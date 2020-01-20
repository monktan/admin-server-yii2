<?php
if (! function_exists('mt_config')) {
    function mt_config($key)
    {
        $config = \monktan\framework\App::config()->get($key);

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
     * @param $frameworkModel
     * @return \monktan\framework\db\ModelInterface
     */
    function mt_model($frameworkModel)
    {
        $modelObj = \monktan\framework\App::model();

        if (is_string($frameworkModel)) {
            $interfaceName = 'monktan\\common\\models\\' . $frameworkModel . 'ModelInterface';
            $m = \monktan\framework\App::container()->get($interfaceName);
            $model = $modelObj->m($m);
        } else {
            $model = $modelObj->m($frameworkModel);
        }

        return $model;
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
        $sessionData = '';
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

if (! function_exists('mt_is_index_array')) {
    function mt_is_index_array($array)
    {
        if (is_array($array)) {
            $keys = array_keys($array);
            return $keys == array_keys($keys);
        }

        return false;
    }
}

if (! function_exists('mt_is_assoc_array')) {
    function mt_is_assoc_array($array)
    {
        if (is_array($array)) {
            $keys = array_keys($array);
            return $keys != array_keys($keys);
        }

        return false;
    }
}

if (! function_exists('mt_is_one_array')) {
    function mt_is_one_array($array)
    {
        return count($array) == count($array, 1);
    }
}

if (! function_exists('mt_is_one_assoc_array')) {
    function mt_is_one_assoc_array($array)
    {
        return mt_is_one_array($array) && mt_is_assoc_array($array);
    }
}
