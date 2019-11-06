<?php
/**
 * Description
 *
 *
 * Datetime: 2019-08-04 13:44
 */

namespace star\oauth2\storages\mysql;

use star\common\models\BaseModel;
use star\oauth2\storages\ClientModelInterface;

class ClientModel extends BaseModel implements ClientModelInterface
{
    const STATUS_DISABLE = 2;

    const STATUS_ENABLE = 1;

    public static function tableName()
    {
        return 'client';
    }

    public function getClient($clientIdentifier)
    {
        $client = self::findOne(['client_id'=>$clientIdentifier]);
        if (empty($client)) {
            throw_info('不可信任的客户端', RESPONSE_CODE_UNAUTHORIZED);
        }

        if ($client['status'] == self::STATUS_DISABLE) {
            throw_info('客户端已被禁用', RESPONSE_CODE_UNAUTHORIZED);
        }

        return $client;
    }
}
