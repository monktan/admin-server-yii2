<?php
namespace monktan\common\services;

class BaseService
{
    public $model;

    protected function rebuildListData($data, callable $callback = null)
    {

        foreach ($data as $k => $item) {
            $item = $this->rebuildItem($item);

            if (! empty($callback)) {
                $item = call_user_func_array($callback, [$item]);
            }

            $data[$k] = $item;
        }

        return $data;
    }

    protected function rebuildItem($item)
    {
        if (! empty($item['create_by'])) {
            $user = mt_model('User')->newQuery()->where(['user_id'=>$item['create_by']])->one();
            $item['create_username'] = $user['username'] ?? '';
            $item['create_real_name'] = $user['real_name'] ?? '';
        }
        if (! empty($item['user_id'])) {
            $user = mt_model('User')->newQuery()->where(['user_id'=>$item['create_by']])->one();
            $item['username'] = $user['username'] ?? '';
            $item['real_name'] = $user['real_name'] ?? '';
        }
        if (! empty($item['update_by'])) {
            $user = mt_model('User')->newQuery()->where(['user_id'=>$item['update_by']])->one();
            $item['create_username'] = $user['username'] ?? '';
            $item['create_real_name'] = $user['real_name'] ?? '';
        }
        if (! empty($item['app_id'])) {
            $app = mt_model('Application')->newQuery()->where(['app_id'=>$item['app_id']])->one();
            $item['app_name'] = $app['name'] ?? '';
        }

        return $item;
    }

    public function getList($params)
    {
        $result['data'] = $this->getListData($params);
        $result['count'] = $this->getListCount($params);

        return $result;
    }

    public function getListData($params)
    {
        return [];
    }

    public function getListCount($params)
    {
        return [];
    }
}
