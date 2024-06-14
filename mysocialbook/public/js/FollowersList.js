var baseUrl = "followers/get";

document.addEventListener("DOMContentLoaded", async function() {
    const username = document.getElementById("hidden-username").value;
    const users = await getFollowers();
    displayUsers(users);
});

async function getFollowers() {
    return await fetch(`${baseUrl}`)
        .then(response => response.json());
}

function displayUsers(users) 
{
    const usersListDiv = document.getElementById("users-list-div");
    usersListDiv.innerHTML = "";

    users.forEach(user => {
        const userDiv = document.createElement("a");
        userDiv.classList.add("user-item");

        userDiv.href = `user/${user.username}`;
        
        userInfo = document.createElement("div");
        userInfo.classList.add("user-item-info");
        var usernamesurname = document.createElement("span");
        usernamesurname.classList.add("usernamesurname");
        usernamesurname.innerHTML = user.name_surname;
        var username = document.createElement("span");
        username.classList.add("username");
        username.innerHTML = user.username;
        userInfo.appendChild(usernamesurname);
        userInfo.appendChild(username);
        userDiv.appendChild(userInfo);
        
        var image = document.createElement("img");
        image.classList.add("profile-image");
        image.src = "images/Generic_User.png";
        userDiv.appendChild(image);

        usersListDiv.appendChild(userDiv);
    });
}

function clearUsers() 
{
    const usersListDiv = document.getElementById("users-list-div");
    usersListDiv.innerHTML = "";
}