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

\Yii::$container->set(\monktan\common\models\ClientModelInterface::class, app\framework\common\models\ClientModel::class);
\Yii::$container->set(\monktan\libraries\oauth2\storages\ClientModelInterface::class, app\framework\common\models\ClientModel::class);
\Yii::$container->set(\monktan\common\models\UserModelInterface::class, \app\framework\common\models\UserModel::class);
\Yii::$container->set(\monktan\libraries\oauth2\storages\UserModelInterface::class, \app\framework\common\models\UserModel::class);
\Yii::$container->set(\monktan\common\models\AccessTokenModelInterface::class, \app\framework\common\models\AccessTokenModel::class);
\Yii::$container->set(\monktan\libraries\oauth2\storages\AccessTokenModelInterface::class, \app\framework\common\models\AccessTokenModel::class);
\Yii::$container->set(\monktan\common\models\RefreshTokenModelInterface::class, \app\framework\common\models\RefreshTokenModel::class);
\Yii::$container->set(\monktan\libraries\oauth2\storages\RefreshTokenModelInterface::class, \app\framework\common\models\RefreshTokenModel::class);

\monktan\framework\App::setApp(\Yii::$container->get(monktan\framework\AppInterface::class));
\monktan\framework\App::setContainer(\Yii::$container->get(monktan\framework\ContainerInterface::class));
\monktan\framework\App::setConfig(\Yii::$container->get(monktan\framework\ConfigInterface::class));