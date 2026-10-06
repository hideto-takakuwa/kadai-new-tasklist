<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = [];
        if (Auth::check()) {
            // ログインユーザー取得
            $user = Auth::user();
            // ログインユーザーのタスク一覧取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->get();
        }       

        // タスク一覧ビューで表示
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // タスクを取得
        $task = Task::findOrFail($id);
        
        // 認証済みユーザー（閲覧者）がそのタスクの所有者である場合は表示
        if (Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        }

        // トップページへリダイレクトさせる
        return redirect('/')->with('error', 'このタスクを表示する権限がありません。');
 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
            'color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'status' => 'required|max:10',
        ], [
            'content.required' => 'タスク内容を入力してください。',
            'content.max' => 'タスク内容は255文字以内で入力してください。',
            'color.regex' => '正しい色を選択してください。',
            'status.required' => 'ステータスを入力してください。',
            'status.max' => 'ステータスは10文字以内で入力してください。',
        ]);

        // 認証済みユーザー（閲覧者）のタスクとして作成（リクエストされた値をもとに作成）
        $request->user()->tasks()->create([
            'status' => $request->status,
            'color' => $request->color,
            'content' => $request->content,
        ]);

        return redirect('/')->with('success', 'タスクを追加しました。');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // タスクを取得
        $task = Task::findOrFail($id);

        // 認証済みユーザー（閲覧者）がそのタスクの所有者である場合は表示
        if (Auth::id() === $task->user_id) {
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }

        // トップページへリダイレクトさせる
        return redirect('/')->with('error', 'このタスクを操作する権限がありません。');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // タスク取得
        $task = Task::findOrFail($id);

        // 他人のタスクに対してバリデーションを実行しないよう、先に所有者チェック
        if (Auth::id() !== $task->user_id) {
            // トップページへリダイレクトさせる
            return redirect('/')->with('error', 'このタスクを操作する権限がありません。'); 
        }

        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
            'color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'status' => 'required|max:10',
        ], [
            'content.required' => 'タスク内容を入力してください。',
            'content.max' => 'タスク内容は255文字以内で入力してください。',
            'color.regex' => '正しい色を選択してください。',
            'status.required' => 'ステータスを入力してください。',
            'status.max' => 'ステータスは10文字以内で入力してください。',
        ]);
        
        $task->status = $request->status;
        $task->color = $request->color;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/')->with('success', 'タスクを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        // 認証済みユーザー（閲覧者）がそのタスクの所有者である場合はタスクを削除
        if (Auth::id() === $task->user_id) {
            $task->delete();
            return redirect('/')->with('success', 'タスクを完了しました。');
        }

        // トップページへリダイレクトさせる
        return redirect('/')->with('error', 'このタスクを操作する権限がありません。');
    }
}
