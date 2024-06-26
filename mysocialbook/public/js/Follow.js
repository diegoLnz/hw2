document.addEventListener("DOMContentLoaded", async function(){
    const followBtn = document.getElementById("follow-btn");

    followBtn.addEventListener("click", async function(){
        var success = await toggleFollow();
        
        if(success.message != "KO")
        {
            toggleFollowUI(followBtn);
        }
    });
});

async function toggleFollow()
{
    const username = document.getElementById("hidden-user").value;
    const usernameToFollow = document.getElementById("hidden-user-to-follow").value;
    return await fetch("../users/follow/" + username + "/" + usernameToFollow)
        .then(response => response.json())
        .then(data => document.getElementById('num-followers').innerHTML = "Followers: " + data.message);
}

function toggleFollowUI(btn)
{
    if (btn.classList.contains("already-follows"))
    {
        btn.classList.remove("already-follows");
        btn.textContent = "Segui";
    }
    else
    {
        btn.classList.add("already-follows");
        btn.textContent = "Segui già";
    }
}