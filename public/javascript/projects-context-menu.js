document.addEventListener('DOMContentLoaded', () => {
    const projects = document.querySelectorAll('.project');
    const contextMenu = document.getElementById('contextMenu');
    let currentProjectId = null;

    projects.forEach(project => {
        project.addEventListener('contextmenu', handleContextMenu);
    });

    document.getElementById('editProjectTitle').addEventListener('click', () => {
        const newTitle = prompt('Enter new title:');
        if (newTitle) {
            updateProjectTitle(currentProjectId, newTitle);
        }
        contextMenu.style.display = 'none';
    });

    document.getElementById('deleteProject').addEventListener('click', () => {
        console.log(`Deleting project with ID: ${currentProjectId}`);
        deleteProject(currentProjectId);
        contextMenu.style.display = 'none';
    });

    document.addEventListener('click', () => {
        contextMenu.style.display = 'none';
    });

    function handleContextMenu(e) {
        e.preventDefault();
        const projectElement = e.target.closest('.project');
        if (projectElement) {
            currentProjectId = projectElement.id.split('-')[1];
            console.log(currentProjectId);
            contextMenu.style.top = `${e.clientY}px`;
            contextMenu.style.left = `${e.clientX}px`;
            contextMenu.style.display = 'block';
        }
    }

    function updateProjectTitle(projectId, title) {
        console.log(projectId);
        fetch('updateProjectTitle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ project_id: projectId, title: title })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`project-${projectId}`).querySelector('h2').textContent = title;
            } else {
                console.error('Failed to update project title');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function deleteProject(projectId) {
        console.log(`Attempting to delete project with ID: ${projectId}`);
        fetch('deleteProject', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({project_id: projectId})
        })
            .then(response => response.json())
            .then(data => {
                console.log('Server response:', data);
                if (data.success) {
                    const projectElement = document.getElementById(`project-${projectId}`);
                    if (projectElement) {
                        projectElement.remove();
                        console.log(`Project ${projectId} removed successfully.`);
                    } else {
                        console.error(`No element found with ID project-${projectId}`);
                    }
                } else {
                    console.error('Failed to delete project:', data.error);
                }
            })
            .catch(error => console.error('Error:', error));
    }
    });