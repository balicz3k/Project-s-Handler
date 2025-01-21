document.addEventListener('DOMContentLoaded', () => {
    const tasks = document.querySelectorAll('.task');
    const columns = document.querySelectorAll('.column');

    tasks.forEach(task => {
        task.addEventListener('dragstart', handleDragStart);
        task.addEventListener('dragend', handleDragEnd);
    });

    columns.forEach(column => {
        column.addEventListener('dragover', handleDragOver);
        column.addEventListener('drop', handleDrop);
    });

    function handleDragStart(e) {
        e.dataTransfer.setData('text/plain', e.target.id);
        e.target.classList.add('dragging');
    }

    function handleDragEnd(e) {
        e.target.classList.remove('dragging');
    }

    function handleDragOver(e) {
        e.preventDefault();
        const draggingTask = document.querySelector('.dragging');
        const column = e.currentTarget;
        const afterElement = getDragAfterElement(column, e.clientY);
        if (afterElement == null) {
            column.appendChild(draggingTask);
        } else {
            column.insertBefore(draggingTask, afterElement);
        }
    }

    function handleDrop(e) {
        e.preventDefault();
        const id = e.dataTransfer.getData('text/plain');
        const task = document.getElementById(id);
        const column = e.currentTarget;
        column.appendChild(task);

        // Update task status via AJAX
        const status = column.id;
        updateTaskStatus(id.split('-')[1], status);
    }

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.task:not(.dragging)')];

        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    function updateTaskStatus(taskId, status) {
        fetch('/updateTaskStatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ task_id: taskId, status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Failed to update task status');
            }
        })
        .catch(error => console.error('Error:', error));
    }
});