<?php

/**
 * Description of TestFileGenerator
 *
 * @author Jozef
 */
class TestFileGenerator {

    private static function prepareString() {
        
    }

    private static function generateSection($section_id) {
        
    }

    private static function generateBlock($block_id) {
        
    }

    public static function generate($task_id) {
        $content = '';
        $fileNames = [];
        $taskFiles = Task::find($task_id)->files()->select('name')->get();
        foreach ($taskFiles as $taskFile) {
            $fileNames[] = $taskFile->name;
        }
        return implode(PHP_EOL, $fileNames);
    }

}
