<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    //利用model Task由DB的tasks資料表取出資料並排序
    //暫存 $tasks
    //可簡化為 $tasks= Task->get();
    $tasks = Task::orderBy('created_at', 'asc')->get();

    //將取出的資料$tasks傳遞給tasks視圖
    return view('tasks', [ 'tasks' => $tasks ]);

});

/* */
Route::post('/task',function(Request $request){
    $validator =
        \Dotenv\Validator::make($request ->all(),
            ['name'=> 'required|max:255']);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->save();
    return redirect('/');
});

Route::post('/task/{task}',function(Task $task){
    $task ->delete();
    return redirect('/');
});
