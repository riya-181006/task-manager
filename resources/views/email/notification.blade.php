Dear {{ $data->task_owner }},<br><br>

The task {{ $data->status_description }},<br><br> 
{{ $data->task_eta == 0 ? "has been added for you" : "has been marked as completed" }}<br><br>

@if($data->status_eta != 0)
Kindly complete it within {{ $data->task_eta }} days.<br><br>
@endif

Thank you