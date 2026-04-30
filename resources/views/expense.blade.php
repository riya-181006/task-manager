@extends('layout.baseview')
@section('title', 'Task Manager')
@section('style')
    <style>
        body{
            background-color: #e0d4ff;
        }
        .card{
            border-radius:15px;
            background: #ffffff;
            box-shadow:0 12px 30px rgba(0,0,0,0.12);
        }
        .btn-primary{
            background-color:#7c3aed;
            border:none;
        }
        .btn-primary:hover{
            background-color:#6d28d9;
        }
        .btn-outline-primary{
            border:2px solid #7c3aed;
            color:#6d28d9;
            font-weight:600;
            border-radius:25px;
        }
        .table th{
            background:#ede9fe;
        }
        .badge-complete{
            background:#22c55e;
            padding:6px 10px;
            border-radius:8px;
            color:white;
        }
        .badge-pending{
            background:#f59e0b;
            padding:6px 10px;
            border-radius:8px;
            color:white;
            cursor:pointer;
        }
    </style>
@endsection
@section('content')
    <div class="container mt-5">
        <div class="mb-3">
            <div class="float-end">
                <button class="btn btn-outline-primary" onclick="showTaskModal()">
                    Add Task
                </button>
            </div>
            <h4 class="fw-bold text-dark">My Tasks</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table text-center">
                    <thead>
                        <th>#</th>
                        <th>Task</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="taskTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="taskModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="taskForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Task</label>
                            <input type="text" class="form-control" name="task" required>
                        </div>
                        <div class="mb-2">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="mb-2">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveTask()">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    <script>
        var editIndex = null;
        loadTasks();
        function showTaskModal(){
            $("#taskModal").modal('show');
        }
        function saveTask(){
            var dataArr = $("#taskForm").serializeArray();
            var taskObj = {};
            var taskList = JSON.parse(localStorage.getItem("taskStorage")) || [];
            dataArr.forEach(item => {
                taskObj[item.name] = item.value;
            });
            if(editIndex !== null){
                taskList[editIndex] = taskObj;
                editIndex = null;
            } else {
                taskList.push(taskObj);
            }
            localStorage.setItem("taskStorage", JSON.stringify(taskList));
            $("#taskModal").modal('hide');
            $("#taskForm")[0].reset();
            loadTasks();
        }
        function loadTasks(){
            var taskList = JSON.parse(localStorage.getItem("taskStorage")) || [];
            var html = "";
            taskList.forEach((task, i) => {
                var badge = task.status === "Completed"
                    ? '<span class="badge-complete">Completed</span>'
                    : `<span class="badge-pending" onclick="markAsDone(${i})">Pending</span>`;
                html += `
                    <tr>
                        <td>${i+1}</td>
                        <td>${task.task}</td>
                        <td>${task.date}</td>
                        <td>${badge}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editTask(${i})">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteTask(${i})">Delete</button>
                        </td>
                    </tr>
                `;
            });
            if(taskList.length === 0){
                html = '<tr><td colspan="5">No Tasks Yet</td></tr>';
            }
            $("#taskTableBody").html(html);
        }
        function markAsDone(index){
            var taskList = JSON.parse(localStorage.getItem("taskStorage"));
            taskList[index].status = "Completed";
            localStorage.setItem("taskStorage", JSON.stringify(taskList));
            loadTasks();
        }
        function editTask(index){
            if(!confirm("Edit this task?")) return;
            var taskList = JSON.parse(localStorage.getItem("taskStorage"));
            var data = taskList[index];
            $("input[name='task']").val(data.task);
            $("input[name='date']").val(data.date);
            $("select[name='status']").val(data.status);
            editIndex = index;
            $("#taskModal").modal('show');
        }
        function deleteTask(index){
            if(!confirm("Delete this task?")) return;
            var taskList = JSON.parse(localStorage.getItem("taskStorage"));
            taskList.splice(index,1);
            localStorage.setItem("taskStorage", JSON.stringify(taskList));
            loadTasks();
        }
    </script>
@endsection