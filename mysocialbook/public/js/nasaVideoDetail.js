document.addEventListener('DOMContentLoaded', () => {
    const saveBtn = document.getElementById('save-btn');
    saveBtn.addEventListener('click', async function(){
        var result = await saveVideoForUser();
        if (result.isSuccess)
        {
            toggleSaveBtnIcon();
        }
    });
});

async function saveVideoForUser()
{
    var title = window.location.href.split('/').pop();
    return await fetch('../nasa/saveVideo/' + title)
        .then(response => response.json());
}

function toggleSaveBtnIcon()
{
    const saveBtn = document.getElementById('save-btn');
    const svgElement = saveBtn.querySelector('svg');
    const path = svgElement.querySelector('path');
    
    if (path.getAttribute('d') == 'M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z')
        path.setAttribute('d', 'M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2');
    else
        path.setAttribute('d', 'M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z');
}