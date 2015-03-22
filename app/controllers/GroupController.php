<?php

/**
 * Description of GroupController
 *
 * @author Jozef Dúc
 */
class GroupController extends BaseController {

    public function show($id = null) {
        return View::make('group.show');
    }

    public function all() {
        return View::make('group.all');
    }

    public function create($id = null) {
        $tasks = [];
        if (Auth::user()->lastSubject) {
            $subject = Auth::user()->lastSubject;
            $tasks = $subject->task()->afterStart()->beforedeadline()->orderBy('deadline')->get();
        }
        return View::make('group.create', array(
                    'tasks' => $tasks,
                    'id' => $id
        ));
    }

    public function createGroup() {
        if (Request::ajax()) {
            $input = Input::all();
            $task = Task::find($input['task_id']);
            if ($task) {
                $groups = $task->groups()->get();
                foreach ($groups as $group) {
                    if ($group->isMember(Auth::id())) {
                        return Response::json(array(
                                    'result' => false
                        ));
                    }
                }
                if ($input['name']) {
                    $input['subject_id'] = $task->subject_id;
                    $input['created_by'] = Auth::id();
                    $input['state'] = Group::CREATED;
                    $group = Group::create($input);
                    if ($group) {
                        GroupMembers::create(array(
                            'group_id' => $group->id,
                            'user_id' => Auth::id()
                        ));
                        return Response::json(array(
                                    'result' => true
                        ));
                    }
                }
            }
        }
        return Response::json(array(
                    'result' => false
        ));
    }

    public function approve() {
        if (Request::ajax()) {
            $input = Input::all();
            $group = Group::find($input['id']);
            $group->state = Group::APPROVED;
            $group->save();
            return Response::json(array(
                        'result' => true
            ));
        }
        return Response::json(array(
                    'result' => false
        ));
    }

    public function leave() {
        if (Request::ajax()) {
            $input = Input::all();
            GroupMembers::where('group_id', '=', $input['id'])->where('user_id', '=', Auth::id())->delete();
            return Response::json(array(
                        'result' => true
            ));
        }
        return Response::json(array(
                    'result' => false
        ));
    }

    public function delete() {
        if (Request::ajax()) {
            $input = Input::all();
            GroupMembers::where('group_id', '=', $input['id'])->delete();
            Group::find($input['id'])->delete();
            return Response::json(array(
                        'result' => true
            ));
        }
        return Response::json(array(
                    'result' => false
        ));
    }

    public function join() {
        if (Request::ajax()) {
            $input = Input::all();
            $size = Group::find($input['id'])->task()->groupsize;
            $actualsize = GroupMembers::where('group_id', '=', $input['id'])->get()->count();
            if ($actualsize < $size) {
                GroupMembers::create(array(
                    'group_id' => $input['id'],
                    'user_id' => Auth::id()
                ));
                return Response::json(array(
                            'result' => true
                ));
            }
        }
        return Response::json(array(
                    'result' => false
        ));
    }

    public function groups() {
        if (Request::ajax()) {
            $input = Input::all();
            $groups = Group::where('task_id', '=', $input['id'])->orderBy('name')->created()->get();
            $allow_join = false;
            $result = [];
            $is_member_g = false;
            foreach ($groups as $group) {
                $members = $group->members()->orderBy('surname')->get();
                $is_member = false;
                foreach ($members as $key => $member) {
                    $members[$key] = $member->getFullName();
                    $is_member |= $member->id == Auth::id();
                }
                $group['is_member'] = $is_member;
                $group['members'] = $members;
                $group['can_edit'] = $group->created_by == Auth::id();
                $allow_join |= $group['can_edit'];
                $is_member_g |= $is_member;
                $result['groups'][] = $group;
            }
            $result['allow_join'] = $allow_join;
            $result['is_member'] = $is_member_g;
            return Response::json($result);
        }
    }

}
