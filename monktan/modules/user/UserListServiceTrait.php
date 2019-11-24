<?php
namespace monktan\modules\user;

trait UserListServiceTrait
{
    public function getListData($params)
    {
        $pageSize = !empty($params['page_size']) ? intval($params['page_size']) : 20;
        $page = !empty($params['page']) ? intval($params['page']) : 1;
        $offset = ($page - 1) * $pageSize;
        $fields = ['user_id', 'real_name', 'username', 'mobile',
            'email', 'status', 'remark', 'create_time', 'update_time', 'create_by', 'update_by'];
        $orderBy = 'id desc';

        $data = $this->getListQuery($params)->fields($fields)->offset($offset)
            ->limit($pageSize)
            ->order($orderBy)
            ->all();

        $model = $this->model;
        $data = $this->rebuildListData($data, function($user) use ($model) {
            $user['status_text'] = $this->model->getStatusText($user['status']);
            return $user;
        });

        return $data;
    }

    public function getListCount($params)
    {
        $count = $this->getListQuery($params)->count();

        return $count;
    }

    public function getListQuery($params)
    {
        $query = mt_model($this->model)->newQuery()->where(['is_deleted'=>$this->model::NORMAL]);

        if (! empty($params['real_name'])) {
            $query->where(['like', 'real_name', $params['real_name']]);
        }

        if (! empty($params['mobile'])) {
            $query->where(['like', 'mobile', $params['mobile']]);
        }

        if (! empty($params['email'])) {
            $query->where(['like', 'email', $params['email']]);
        }

        if (! empty($params['status'])) {
            $query->where(['status'=>$params['status']]);
        }

        if (! empty($params['username'])) {
            $query->where(['username'=>$params['username']]);
        }

        if (! empty($params['create_time_begin'])) {
            $query->where(['>=', 'create_time', $params['create_time_begin']]);
        }

        if (! empty($params['create_time_end'])) {
            $query->where(['<=', 'create_time', $params['create_time_end']]);
        }

        return $query;
    }

    public function getListForOptions($params)
    {
        $pageSize = !empty($params['page_size']) ? intval($params['page_size']) : 20;
        $page = !empty($params['page']) ? intval($params['page']) : 1;
        $offset = ($page - 1) * $pageSize;
        $fields = ['user_id', 'real_name', 'username'];
        $orderBy = 'id desc';

        $data = $this->getListQuery($params)->fields($fields)->offset($offset)
            ->limit($pageSize)
            ->order($orderBy)
            ->all();

        return $data;
    }
}
