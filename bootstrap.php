<?php
/**
 * 设置相关初始化类
 */

Yii::setAlias('@monktan', __DIR__ . '/monktan');
Yii::setAlias('@app', __DIR__);

\Yii::$container->set(monktan\common\models\UserModelInterface::class, app\framework\common\models\UserModel::class);

\Yii::$container->set(monktan\framework\AppInterface::class, app\framework\App::class);
\Yii::$container->set(monktan\framework\ContainerInterface::class, app\framework\Container::class);
\Yii::$container->set(monktan\framework\ConfigInterface::class, app\framework\Config::class);
\Yii::$container->set(monktan\framework\db\ModelInterface::class, app\framework\Model::class);
\Yii::$container->set(monktan\framework\RequestInterface::class, app\framework\Request::class);
\Yii::$container->set(monktan\framework\CacheInterface::class, app\framework\Cache::class);

\Yii::$container->set(\monktan\common\models\ClientModelInterface::class, app\framework\common\models\ClientModel::class);
\Yii::$container->set(\monktan\common\models\UserModelInterface::class, \app\framework\common\models\UserModel::class);
\Yii::$container->set(\monktan\common\models\AuthLogModelInterface::class, \app\framework\common\models\AuthLogModel::class);
\Yii::$container->set(\monktan\common\models\RefreshTokenModelInterface::class, \app\framework\common\models\RefreshTokenModel::class);
\Yii::$container->set(\monktan\common\models\AccessTokenModelInterface::class, \app\framework\common\models\AccessTokenModel::class);
\Yii::$container->set(\monktan\common\models\LogModelInterface::class, \app\framework\common\models\LogModel::class);
\Yii::$container->set(\monktan\common\models\EmailCodeModelInterface::class, \app\framework\common\models\EmailCodeModel::class);

\Yii::$container->set(\monktan\libraries\oauth2\storages\AccessTokenModelInterface::class, \app\framework\common\models\AccessTokenModel::class);
\Yii::$container->set(\monktan\libraries\oauth2\storages\RefreshTokenModelInterface::class, \app\framework\common\models\RefreshTokenModel::class);
\Yii::$container->set(\monktan\libraries\oauth2\storages\UserModelInterface::class, \app\framework\common\models\UserModel::class);
\Yii::$container->set(\monktan\libraries\oauth2\storages\ClientModelInterface::class, app\framework\common\models\ClientModel::class);
