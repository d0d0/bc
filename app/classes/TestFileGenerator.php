<?php

/**
 * Description of TestFileGenerator
 *
 * @author Jozef
 */
class TestFileGenerator {

    private static function prepareString($string) {
        return trim(str_replace(' ', '', iconv('UTF-8', 'ASCII//TRANSLIT', $string)));
    }

    public static function generate($task_id, $group_id) {
        $task = Task::find($task_id);
        $content = "#include <limits.h>" . PHP_EOL;
        $fileNames = [];
        $taskFiles = $task->files()->header()->select('name')->get();
        foreach ($taskFiles as $taskFile) {
            $fileNames[] = '#include "' . storage_path() . '/' . $task_id . $group_id . '/' . self::prepareString($taskFile->name) . '"';
        }
        $content .= implode(PHP_EOL, $fileNames) . PHP_EOL;
        $content .= '#include "gtest/gtest.h"' . PHP_EOL;
        $blocks = $task->blocks()->get();
        foreach ($blocks as $block) {
            $sections = $block->sections()->get();
            foreach ($sections as $section) {
                $content .= "TEST(" . self::prepareString($block->name) . ", ";
                $content .= self::prepareString($section->name) . ") {" . PHP_EOL;
                $tests = $section->tests()->get();
                foreach ($tests as $test) {
                    $content .= "  " . $test->codebefore . PHP_EOL;
                    switch ($test->compare) {
                        case Test::EQUAL:
                            $content .= "  EXPECT_EQ(";
                            break;
                        case Test::NON_EQUAL:
                            $content .= "  EXPECT_NE(";
                            break;
                    }
                    $content .= self::prepareString($test->expected) . ", " . self::prepareString($test->testfunction) . ");" . PHP_EOL;
                    $content .= "  " . $test->codeafter . PHP_EOL;
                }
                $content .= "}" . PHP_EOL . PHP_EOL;
            }
        }
        $ownTests = OwnTest::where('group_id', '=', $group_id)->where('task_id', '=', $task_id)->get();
        if ($ownTests->count() > 0) {
            $content .= "TEST(VLASTNE, TESTY) {" . PHP_EOL;
            foreach ($ownTests as $test) {
                $content .= "  " . $test->codebefore . PHP_EOL;
                switch ($test->compare) {
                    case Test::EQUAL:
                        $content .= "  EXPECT_EQ(";
                        break;
                    case Test::NON_EQUAL:
                        $content .= "  EXPECT_NE(";
                        break;
                }
                $content .= self::prepareString($test->expected) . ", " . self::prepareString($test->testfunction) . ");" . PHP_EOL;
                $content .= "  " . $test->codeafter . PHP_EOL;
            }
            $content .= "}" . PHP_EOL . PHP_EOL;
        }
        File::put(storage_path() . '/' . $task_id . $group_id . '/test.cpp', $content);
        return storage_path() . '/' . $task_id . $group_id . '/test.cpp';
    }

}
