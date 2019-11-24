<?php
namespace monktan\modules\user;

trait AuthLogServiceTrait
{
    public function getLogList($params)
    {
        $result['data'] = $this->getLogListData($params);
        $result['count'] = $this->getLogListCount($params);

        return $result;
    }

    public function getLogListQuery($params)
    {
        $query = mt_model('AuthLog')->newQuery()
            ->where(['user_id'=>$params['user_id']]);

        return $query;
    }

    public function getLogListData($params)
    {
        $pageSize = !empty($params['page_size']) ? intval($params['page_size']) : 20;
        $page = !empty($params['page']) ? intval($params['page']) : 1;
        $offset = ($page - 1) * $pageSize;
        $data = $this->getLogListQuery($params)->offset($offset)->limit($pageSize)->order('id desc')->all();

        $originModel = mt_model('AuthLog')->getOriginModel();
        foreach ($data as $k => $v) {
            $v['type_text'] = $originModel->getTypeText($v['type']);
            $data[$k] = $v;
        }

        return $data;
    }

    public function getLogListCount($params)
    {
        return $this->getLogListQuery($params)->count();
    }
}
