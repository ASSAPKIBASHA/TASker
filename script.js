// script.js
document.addEventListener('DOMContentLoaded', function() {
    const taskList = document.getElementById('task-list');
    const addTaskBtn = document.getElementById('add-task-btn');
    const taskForm = document.getElementById('task-form');
    const taskFormElement = document.getElementById('task-form-element');
    const cancelBtn = document.getElementById('cancel-btn');

    addTaskBtn.addEventListener('click', function() {
        taskForm.style.display = 'block';
    });

    cancelBtn.addEventListener('click', function() {
        taskForm.style.display = 'none';
        taskFormElement.reset();
    });

    taskFormElement.addEventListener('submit', function(e) {
        e.preventDefault();
        const title = document.getElementById('title').value;
        const description = document.getElementById('description').value;
        const dueDate = document.getElementById('due-date').value;
        const status = document.getElementById('status').value;

        const formData = new FormData();
        formData.append('title', title);
        formData.append('description', description);
        formData.append('due_date', dueDate);
        formData.append('status', status);

        fetch('create_task.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            taskList.innerHTML += data;
            taskFormElement.reset();
            taskForm.style.display = 'none';
        })
        .catch(error => console.error('Error:', error));
    });

    taskList.addEventListener('click', function(e) {
        if (e.target.classList.contains('complete-btn')) {
            const taskId = e.target.parentElement.getAttribute('data-id');
            fetch('update_task.php?id=' + taskId + '&status=Completed')
            .then(response => response.text())
            .then(data => {
                e.target.parentElement.querySelector('p:nth-child(4)').textContent = 'Status: Completed';
            })
            .catch(error => console.error('Error:', error));
        } else if (e.target.classList.contains('edit-btn')) {
            const taskId = e.target.parentElement.getAttribute('data-id');
            const taskTitle = e.target.parentElement.querySelector('h3').textContent;
            const taskDescription = e.target.parentElement.querySelector('p:nth-child(2)').textContent.replace('Description: ', '');
            const taskDueDate = e.target.parentElement.querySelector('p:nth-child(3)').textContent.replace('Due Date: ', '');
            const taskStatus = e.target.parentElement.querySelector('p:nth-child(4)').textContent.replace('Status: ', '');

            document.getElementById('title').value = taskTitle;
            document.getElementById('description').value = taskDescription;
            document.getElementById('due-date').value = taskDueDate;
            document.getElementById('status').value = taskStatus;

            taskForm.style.display = 'block';

            const updateBtn = document.createElement('button');
            updateBtn.textContent = 'Update';
            updateBtn.addEventListener('click', function() {
                const updatedTitle = document.getElementById('title').value;
                const updatedDescription = document.getElementById('description').value;
                const updatedDueDate = document.getElementById('due-date').value;
                const updatedStatus = document.getElementById('status').value;

                const formData = new FormData();
                formData.append('id', taskId);
                formData.append('title', updatedTitle);
                formData.append('description', updatedDescription);
                formData.append('due_date', updatedDueDate);
                formData.append('status', updatedStatus);

                fetch('update_task.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    e.target.parentElement.innerHTML = data;
                    taskForm.style.display = 'none';
                    taskFormElement.reset();
                })
                .catch(error => console.error('Error:', error));
            });

            taskFormElement.appendChild(updateBtn);
        } else if (e.target.classList.contains('delete-btn')) {
            const taskId = e.target.parentElement.getAttribute('data-id');
            fetch('delete_task.php?id=' + taskId)
            .then(response => response.text())
            .then(data => {
                e.target.parentElement.remove();
            })
            .catch(error => console.error('Error:', error));
        }
    });
});