document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('search-button');
    const input = document.getElementById('search-text');
    const container = document.getElementById('video-container');

    btn.addEventListener('click', async function(){
        container.innerHTML = "";
        var searchString = input.value;
        var uris = await getLibraryResponse(searchString);

        uris.forEach(uri => {
            var videoElement = buildVideoElement(uri);
            container.appendChild(videoElement);
        });
    });
});

async function getLibraryResponse(searchString)
{
    return await fetch('nasa/search/' + encodeURIComponent(searchString))
        .then(response => response.json());
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