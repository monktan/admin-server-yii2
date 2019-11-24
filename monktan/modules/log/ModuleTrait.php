<?php
namespace monktan\modules\log;

trait ModuleTrait
{
    public function getModules()
    {
        return self::modules();
    }

    public static function modules()
    {
        $modules = [
            [
                'title' => '用户模块',
                'name' => 'UserModule',
                'children' => [
                    [
                        'title' => '用户管理',
                        'name' => 'User',
                        'actions' => [
                            'create' => '创建用户',
                            'delete' => '删除用户',
                            'update' => '更新用户',
                        ]
                    ]
                ],
            ]
        ];

        return $modules;
    }

    public function getModuleTitle($controllerName)
    {
        $module = $this->getModule($controllerName);

        return $module['title'] ?? '';
    }

    public function getActionTitle($controllerName, $actionName)
    {
        $module = $this->getModule($controllerName);

        return isset($module['actions'][$actionName]) ? $module['actions'][$actionName] : '';
    }

    public function getModule($controllerName)
    {
        $modules = self::getModules();
        foreach ($modules as $module) {
            foreach ($module['children'] as $mod) {
                if ($mod['name'] == $controllerName) {
                    return $mod;
                }
            }
        }

        return [];
    }
}
