document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('search-button');
    const input = document.getElementById('search-text');
    const container = document.getElementById('video-container');

    btn.addEventListener('click', async function(){
        container.innerHTML = "";
        const ul = document.createElement('ul');
        ul.classList.add('video-list-ul');
        
        var searchString = input.value;
        var titles = await getLibraryResponse(searchString);
        
        titles.forEach(title => {
            var titleElement = buildTitleElement(title);
            ul.appendChild(titleElement);
        });
        container.appendChild(ul);
    });
});

async function getLibraryResponse(searchString)
{
    return await fetch('nasa/search/' + encodeURIComponent(searchString))
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

function buildVideoElement(uri)
{
    var element = document.createElement('video');
    element.classList.add('video-item');
    element.controls = true;
    element.muted = true; 
    
    var source = document.createElement('source');
    source.src = uri;
    source.type = 'video/mp4';
    element.appendChild(source);

    return element;
}