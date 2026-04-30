

<?php $__env->startSection('title','All Tasks'); ?>

<?php $__env->startSection('style'); ?>
<style>
.done{
    text-decoration: line-through
}
</style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<?php echo $__env->make('layout.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="container mt-5">

<button type="button" class="btn btn-outline-primary mb-5 end-0" onclick="addTask()">
Add Tasks
</button>

<div class="card">
<div class="card-body">

<table class="table">

<thead>
<tr>
<th scope="col">Si No.</th>
<th scope="col">Task Description</th>
<th scope="col">Task Owner</th>
<th scope="col">Task ETA</th>
<th scope="col">Action</th>
</tr>
</thead>

<tbody id="taskTable"></tbody>

</table>

</div>
</div>
</div>


<!-- CREATE TASK MODAL -->

<div class="modal fade" id="createTaskModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Add Task</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<form>

<div class="form-group">
<label>Task Description</label>
<input type="text" class="form-control" id="createTaskDescription">
</div>

<div class="form-group">
<label>Task Owner</label>
<input type="text" class="form-control" id="createTaskOwner">
</div>

<div class="form-group">
<label>Task Owner Email</label>
<input type="text" class="form-control" id="createTaskEmail">
</div>

<div class="form-group">
<label>Task ETA</label>
<input type="date" class="form-control" id="createTaskETA">
</div>

<div class="form-group">
<label>Task Status</label>
<select class="form-control" id="createTaskStatus">
<option>Set Task Status</option>
<option value="0">In Progress</option>
<option value="1">Done</option>
</select>
</div>

</form>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
Close
</button>

<button type="button" class="btn btn-primary" onclick="createTask()">
Submit
</button>

</div>

</div>
</div>
</div>


<!-- EDIT TASK MODAL -->

<div class="modal fade" id="editTaskModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Edit Task</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<form>

<div class="form-group">
<label>Task Description</label>
<input type="text" class="form-control" id="editTaskDescription">
</div>

<div class="form-group">
<label>Task Owner</label>
<input type="text" class="form-control" id="editTaskOwner">
</div>

<div class="form-group">
<label>Task Owner Email</label>
<input type="text" class="form-control" id="editTaskEmail">
</div>

<div class="form-group">
<label>Task ETA</label>
<input type="date" class="form-control" id="editTaskETA">
</div>

<div class="form-group">
<label>Task Status</label>
<select class="form-control" id="editTaskStatus">
<option value="0">In Progress</option>
<option value="1">Done</option>
</select>
</div>

<input type="hidden" id="editTaskid">

</form>

</div>

<div class="modal-footer">

<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
Close
</button>

<button type="button" class="btn btn-primary" onclick="updateTask()">
Submit
</button>

</div>

</div>
</div>
</div>


<!-- DONE TASK MODAL -->

<div class="modal fade" id="doneTaskModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Mark Task as Done</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<p>Are you Sure you want to Mark this Task as Done?</p>
<input type="hidden" id="doneTaskid">
</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
Close
</button>

<button type="button" class="btn btn-primary" onclick="updateMarkAsDone()">
Submit
</button>
</div>

</div>
</div>
</div>


<!-- DELETE TASK MODAL -->

<div class="modal fade" id="deleteTaskModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Delete Task</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<p>Are you sure you want to delete this task?</p>
<input type="hidden" id="deleteTaskid">
</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
Close
</button>

<button type="button" class="btn btn-primary" onclick="updateTaskDelete()">
Submit
</button>
</div>

</div>
</div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('customjs'); ?>

<script>

$(document).ready(function(){
getAllTasks();
})


function getAllTasks(){

$.ajax({

type : 'get',
url : 'http://localhost:8000/api/task',

success:function(result){

var html = "";

for(var i=0;i<result.length;i++){

var lineThrough = result[i]['status'] == 1 ? 'class="done"' : "";

html += '<tr>' +

'<th scope="row" '+lineThrough+'>'+(i+1)+'</th>' +

'<td '+lineThrough+'>'+result[i]['task_description']+'</td>' +

'<td '+lineThrough+'>'+result[i]['task_owner']+'</td>' +

'<td '+lineThrough+'>'+result[i]['task_eta']+'</td>' +

'<td>' +

'<i class="bi bi-pencil-square text-primary me-2" style="cursor:pointer" onclick="editTask('+result[i]['id']+')"></i>' +

'<i class="bi bi-check2-square text-success me-2" style="cursor:pointer" onclick="markasdone('+result[i]['id']+')"></i>' +

'<i class="bi bi-trash text-danger" style="cursor:pointer" onclick="deleteTask('+result[i]['id']+')"></i>' +

'</td>' +

'</tr>';

}

$("#taskTable").html(html);

},

error:function(e){
console.log(e.responseText);
}

})

}



function addTask(){
$("#createTaskModal").modal('show');
}



function createTask(){

var task_description = $("#createTaskDescription").val();
var task_owner = $("#createTaskOwner").val();
var task_owner_email = $("#createTaskEmail").val();
var task_eta = $("#createTaskETA").val();

$.ajax({

type : 'post',

url : 'http://localhost:8000/api/task',

data : {
task_description : task_description,
task_owner : task_owner,
task_owner_email : task_owner_email,
task_eta : task_eta
},

success:function(result){

$("#createTaskModal").modal('hide');
getAllTasks();

},

error:function(e){
console.log(e.responseText);
}

})

}



function editTask(id){

$.ajax({

type : 'get',

url : 'http://localhost:8000/api/task/'+id,

success:function(result){

$("#editTaskDescription").val(result['task_description']);
$("#editTaskOwner").val(result['task_owner']);
$("#editTaskEmail").val(result['task_owner_email']);
$("#editTaskETA").val(result['task_eta']);
$("#editTaskStatus").val(result['status']);
$("#editTaskid").val(result['id']);

$("#editTaskModal").modal('show');

}

})

}



function updateTask(){

var id = $("#editTaskid").val();

var task_description = $("#editTaskDescription").val();
var task_owner = $("#editTaskOwner").val();
var task_owner_email = $("#editTaskEmail").val();
var task_eta = $("#editTaskETA").val();
var task_status = $("#editTaskStatus").val();

$.ajax({

type : 'put',

url : 'http://localhost:8000/api/task/'+id,

data : {

task_description : task_description,
task_owner : task_owner,
task_owner_email : task_owner_email,
task_eta : task_eta,
task_status : task_status

},

success:function(result){

$("#editTaskModal").modal('hide');
getAllTasks();

}

})

}



function markasdone(id){

$("#doneTaskid").val(id)

$("#doneTaskModal").modal('show')

}



function updateMarkAsDone(){

var id = $("#doneTaskid").val();

$.ajax({

type: 'post',

url: 'http://localhost:8000/api/task/done/' + id,

success:function(result){

$("#doneTaskModal").modal('hide');
getAllTasks();

}

})

}



function deleteTask(id){

$("#deleteTaskid").val(id)

$("#deleteTaskModal").modal('show')

}



function updateTaskDelete(){

var id = $("#deleteTaskid").val();

$.ajax({

type: 'delete',

url: 'http://localhost:8000/api/task/' + id,

success:function(result){

$("#deleteTaskModal").modal('hide');
getAllTasks();

}

})

}

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.baseview', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\KIIT\Desktop\INTERSHIP\WEB DEVELOPEMENT\PROJECTS\PROJECT2\task_manager\resources\views/task/index.blade.php ENDPATH**/ ?>