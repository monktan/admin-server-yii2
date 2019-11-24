<?php
namespace monktan\modules\log;

use monktan\framework\db\QueryInterface;

trait LogListServiceTrait
{
    public function getListCount($params)
    {
        return $this->getListQuery($params)->count();
    }

    public function getListData($params)
    {
        $pageSize = !empty($params['page_size']) ? intval($params['page_size']) : 20;
        $page = !empty($params['page']) ? intval($params['page']) : 1;
        $offset = ($page - 1) * $pageSize;
        $fields = ['user_id', 'log_id', 'item_id', 'app_id',
            'module_name', 'module', 'result_message',
            'result', 'action', 'action_name', 'old_data', 'new_data', 'remark', 'ip', 'agent', 'create_time'];
        $orderBy = 'id desc';

        $data = $this->getListQuery($params)
            ->fields($fields)
            ->order($orderBy)
            ->offset($offset)
            ->limit($pageSize)
            ->all();


        $data = $this->rebuildListData($data);

        return $data;
    }

    /**
     * 获取查询对象
     * @param $params
     * @return QueryInterface
     */
    public function getListQuery($params)
    {
        $query = mt_model($this->model)->newQuery();

        if (! empty($params['log_id'])) {
            $query->where(['log_id'=>$params['log_id']]);
        }
        if (! empty($params['user_id'])) {
            $query->where(['user_id'=>$params['user_id']]);
        }
        if (! empty($params['item_id'])) {
            $query->where(['item_id'=>$params['item_id']]);
        }
        if (! empty($params['app_id'])) {
            $query->where(['app_id'=>$params['app_id']]);
        }
        if (! empty($params['module_name'])) {
            $query->where(['like', 'module_name', $params['module_name']]);
        }
        if (! empty($params['module'])) {
            $query->where(['module'=>$params['module']]);
        }
        if (! empty($params['action_name'])) {
            $query->where(['like', 'action_name', $params['action_name']]);
        }
        if (! empty($params['action'])) {
            $query->where(['action'=>$params['action']]);
        }
        if (! empty($params['result'])) {
            $query->where(['result'=>$params['result']]);
        }

        return $params;
    }
}
