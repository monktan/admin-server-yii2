<?php
/**
 * Description
 *
 *
 * Datetime: 2019-12-29 15:15
 */

if (! function_exists('get_list_user_ids')) {
    function get_list_user_ids($listTestCaseName, $alias)
    {
        $userList = getd($alias[$listTestCaseName], 'response_body.data');
        if (empty($userList)) {
            return [];
        }
        $userIds = array_column($userList, 'user_id');
        return array_slice($userIds, -1, 1);
    }
}

if (! function_exists('get_list_user_id')) {
    function get_list_user_id($listTestCaseName, $alias)
    {
        $userList = getd($alias[$listTestCaseName], 'response_body.data');
        if (empty($userList)) {
            return 0;
        }
        $userIds = array_column($userList, 'user_id');
        return end($userIds);
    }
}