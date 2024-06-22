document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('video-container');
    const ul = document.createElement('ul');
    ul.classList.add('video-list-ul');
    
    var titles = await getSavedVideosResponse();
        
    titles.forEach(title => {
        var titleElement = buildTitleElement(title);
        ul.appendChild(titleElement);
    });
    container.appendChild(ul);
});

async function getSavedVideosResponse(searchString)
{
    return await fetch('nasa/get-saved-videos')
        .then(response => response.json());
}

function buildTitleElement(title)
{
    var element = document.createElement('li');
    var a = document.createElement('a');
    a.href = 'nasa-video-library/' + title;
    a.innerHTML = title;
    element.appendChild(a);
    return element;
}