<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Execution Status</title>
</head>
<body>
    <h2>Task Execution Status: Task #{{ $task->id }}</h2>

    <p><strong>Status:</strong> {{ $statusMessage }}</p>

    <h3>Task Details:</h3>
    <ul>
        <li><strong>Execution Date:</strong> {{ $task->execution_date }}</li>
        <li><strong>Status Description:</strong> {{ $task->status_description }}</li>
        <li><strong>Task URL:</strong> {{ $task->url }}</li>
        <li><strong>Parameters:</strong> {{ json_encode($task->parameters) }}</li>
    </ul>

    @if ($task->status === 'error')
        <h3>Error Details:</h3>
        <p><strong>Exception:</strong> {{ $exception }}</p>
    @endif

    <p>Thank you for using our service.</p>
    <p>Best regards, <br> Muhammad Sajid</p>
</body>
</html>
