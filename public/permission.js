function createButtonWithPermission(buttonLabel, redirectUrl) {
    fetch("/api/users/post/permission", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${localStorage.getItem("user_token") || (document.cookie.split('; ').find(row => row.startsWith('user_token='))?.split('=')[1] || 'symfony-role-guest')}`
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.permissionGranted) {
                const container = document.getElementsByClassName("container")[0];
                const button = document.createElement("button");
                button.textContent = buttonLabel;
                button.onclick = () => {
                    window.location.href = redirectUrl;
                };
                container.appendChild(button);
            } else {
                console.warn("User does not have permission to create a new item");
            }
        })
        .catch(error => {
            console.warn("Error fetching user permission:", error);
        });
}
