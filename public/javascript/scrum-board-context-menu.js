document.addEventListener('DOMContentLoaded', () => {
    const tasks = document.querySelectorAll('.task');
    const contextMenu = document.getElementById('contextMenu');
    let currentTaskId = null;

    tasks.forEach(task => {
        task.addEventListener('contextmenu', handleContextMenu);
    });

    document.getElementById('editTitle').addEventListener('click', () => {
        const newTitle = prompt('Enter new title:');
        if (newTitle) {
            updateTaskTitle(currentTaskId, newTitle);
        }
        contextMenu.style.display = 'none';
    });

    document.getElementById('editColor').addEventListener('click', () => {
        const newColor = prompt('Enter new color (hex code):');
        if (newColor) {
            updateTaskColor(currentTaskId, newColor);
        }
        contextMenu.style.display = 'none';
    });

    document.getElementById('deleteTask').addEventListener('click', () => {
        deleteTask(currentTaskId);
        contextMenu.style.display = 'none';
    });

    document.addEventListener('click', () => {
        contextMenu.style.display = 'none';
    });

    function handleContextMenu(e) {
        e.preventDefault();
        currentTaskId = e.target.id.split('-')[1];
        contextMenu.style.top = `${e.clientY}px`;
        contextMenu.style.left = `${e.clientX}px`;
        contextMenu.style.display = 'block';
    }

    function updateTaskTitle(taskId, title) {
        fetch('/updateTaskTitle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ task_id: taskId, title: title })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`task-${taskId}`).textContent = title;
                } else {
                    console.error('Failed to update task title');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateTaskColor(taskId, color) {
        fetch('/updateTaskColor', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ task_id: taskId, color: color })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`task-${taskId}`).style.backgroundColor = color;
                } else {
                    console.error('Failed to update task color');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function deleteTask(taskId) {
        fetch('/deleteTask', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ task_id: taskId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`task-${taskId}`).remove();
            } else {
                console.error('Failed to delete task');
            }
        })
        .catch(error => console.error('Error:', error));
    }
});