<?php

/**
 * Description of SolutionHelper
 *
 * @author Jozef
 */
class SolutionHelper {

    public static function addNewFile($task_id, $group_id) {
        $defaultFiles = TaskFile::where('task_id', '=', $task_id)->get();
        foreach ($defaultFiles as $file) {
            $data = array(
                'name' => $file->file_name,
                'group_id' => $group_id,
                'task_id' => $task_id,
                'text' => $file->text,
                'node_id' => self::getRandomName()
            );
            Solution::create($data);
        }
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
