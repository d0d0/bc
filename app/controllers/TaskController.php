<?php

/**
 * Description of TaskController
 *
 * @author Jozef Dúc
 */
class TaskController extends BaseController {

    public function show($id = null) {
        return View::make('task.show');
    }

    public function all() {
        $tasks = [];
        if (Auth::user()->lastSubject) {
            $subject = Auth::user()->lastSubject;
            if (Auth::id() == $subject->teacher()->first()->id) {
                $tasks = $subject->task();
            } else {
                $tasks = $subject->task()->afterStart();
            }
            $tasks = $tasks->orderBy('deadline')->get();
        }
        return View::make('task.all', array(
                    'tasks' => $tasks
        ));
    }

    public function create() {
        if ($subject = Auth::user()->lastSubject) {
            return View::make('task.create');
        }
        return Redirect::action('SubjectController@create');
    }

    public function edit($id = null) {
        if (Task::find($id)) {
            return View::make('task.create', array(
                        'id' => $id
            ));
        }
        return Redirect::action('HomeController@showWelcome')
                        ->with('warning', Lang::get('common.acces_denied'));
    }

    public function add() {
        if (Request::ajax()) {
            $input = Input::all();
            if (Carbon::createFromFormat('d.m.Y H:i', $input['start']) &&
                    Carbon::createFromFormat('d.m.Y H:i', $input['deadline'])) {
                $input['subject_id'] = Auth::user()->last_subject;
                $input['text'] = str_replace('\'', '', $input['text']);
                $input['start'] = date('Y-m-d H:i', strtotime($input['start']));
                $input['deadline'] = date('Y-m-d H:i', strtotime($input['deadline']));
                $task = new Task($input);
                if ($task->save()) {
                    $input['result'] = true;
                    $filesforRevert = [];
                    foreach ($input['files'] as $file) {
                        $taskFileData = array(
                            'name' => $file['name'],
                            'task_id' => $task->id,
                            'text' => $file['text'],
                            'header' => $file['header']
                        );
                        $taskFile = new TaskFile($taskFileData);
                        if ($taskFile->save()) {
                            $filesforRevert[] = $taskFile->id;
                        } else {
                            try {
                                TaskFile::whereIn('id', $filesforRevert)->delete();
                            } catch (Exception $e) {
                                
                            }
                            $task->delete();
                            return Response::json(array(
                                        'result' => false
                            ));
                        }
                    }
                    if (isset($input['tests'])) {
                        foreach ($input['tests'] as $block) {
                            $blockdata = array(
                                'task_id' => $task->id,
                                'name' => $block['name']
                            );
                            $blockO = new Block($blockdata);
                            $blockO->save();
                            if (isset($block['section'])) {
                                foreach ($block['section'] as $section) {
                                    $sectiondata = array(
                                        'name' => $section['name'],
                                        'points' => $section['points'],
                                        'block_id' => $blockO->id
                                    );
                                    $sectionO = new Section($sectiondata);
                                    $sectionO->save();
                                    if (isset($section['tests'])) {
                                        foreach ($section['tests'] as $test) {
                                            $testdata = array(
                                                'section_id' => $sectionO->id,
                                                'codebefore' => $test['codebefore'],
                                                'testfunction' => $test['testfunction'],
                                                'compare' => $test['compare'],
                                                'expected' => $test['expected'],
                                                'codeafter' => $test['codeafter'],
                                            );
                                            (new Test($testdata))->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    return Response::json($input);
                }
                return Response::json($task->getErrors());
            }
        }
        return Response::json(array(
                    'result' => false
        ));
    }

    public function loadData() {
        if (Request::ajax()) {
            $input = Input::all();
            $task = Task::find($input['id']);
            $result = [
                'name' => $task->name,
                'start' => $task->formattedStart(),
                'deadline' => $task->formattedDeadline(),
                'groupsize' => $task->groupsize,
                'text' => $task->text,
            ];
            $result['files'] = $task->taskFiles()->get();
            $blocks = $task->blocks()->get();
            $blocks_array = [];
            foreach ($blocks as $block) {
                $sections = $block->sections()->get();
                $sections_array = [];
                foreach ($sections as $section) {
                    $test_array = [];
                    $tests = $section->tests()->get();
                    foreach ($tests as $test) {
                        $test_array[] = [
                            'codebefore' => $test->codebefore,
                            'testfunction' => $test->testfunction,
                            'compare' => $test->compare,
                            'expected' => $test->expected,
                            'codeafter' => $test->codeafter
                        ];
                    }
                    $sections_array[] = [
                        'name' => $section->name,
                        'points' => $section->points,
                        'tests' => $test_array
                    ];
                }
                $blocks_array[] = [
                    'name' => $block->name,
                    'sections' => $sections_array
                ];
            }
            $result['blocks'] = $blocks_array;
            return Response::json($result);
        }
    }

}
