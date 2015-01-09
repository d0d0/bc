<?php

/**
 * Description of SolutionHelper
 *
 * @author Jozef
 */
class SolutionHelper {

    public static function addNewFile($task_id, $group_id, $name = null, $include_header = null, $text = null) {
        $data = array(
            'name' => $name ? $name : 'main.cpp',
            'group_id' => $group_id,
            'task_id' => $task_id,
            'text' => $text ? $text : '',
            'node_id' => self::getRandomName()
        );
        $solution = Solution::create($data);
        if($include_header){
            
        }
        return $solution;
    }

    public static function deleteFile($node_id) {
        $solution = Solution::where('node_id', '=', $node_id)->first();
        $solution->deleted = Solution::DELETED;
        $solution->save();
    }

    public static function recoverFile($id) {
        $solution = Solution::find($id);
        $solution->deleted = Solution::EXISTS;
        $solution->save();
    }

    private static function getRandomName() {
        $rules = array(
            'node_id' => 'required|unique:solutions,node_id'
        );
        $data = array(
            'node_id' => str_random(64)
        );
        $validator = Validator::make($data, $rules);
        while ($validator->fails()) {
            $data['node_id'] = str_random(64);
            $validator = Validator::make($data, $rules);
        }
        return $data['node_id'];
    }

}
