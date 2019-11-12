<?php
namespace monktan\common\services;

class BaseService
{
    public $model;

    protected function rebuildListData($data, callable $callback)
    {

        foreach ($data as $k => $item) {
            if (! empty($item['create_by'])) {
                $user = mt_model('User')->getUserById($item['create_by']);
                $item['create_username'] = $user['username'] ?? '';
                $item['create_real_name'] = $user['real_name'] ?? '';
            }
            if (! empty($item['update_by'])) {
                $user = mt_model('User')->getUserById($item['update_by']);
                $item['create_username'] = $user['username'] ?? '';
                $item['create_real_name'] = $user['real_name'] ?? '';
            }

            $item = call_user_func_array($callback, [$item]);

            $data[$k] = $item;
        }

        return $data;
    }
}
