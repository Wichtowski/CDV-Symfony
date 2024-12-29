function loadContent(object) {
    const loadable = document.getElementById("load-content");

    fetch(`/api/${object}/get/all`)
        .then(response => response.json())
        .then(data => {
            data.forEach(item => {
                const li = document.createElement("li");
                li.innerHTML = `
                    <div class="card articles-card">
                        <h2 class="content-heading">${item.name || item.title}</h2>
                        <button class="content-button" onclick="window.location.href = '${object}/${item.id}'">See More</button>
                    </div>
                `;

                loadable.appendChild(li);
            });
        })
        .catch(error => {
            console.error(`Error fetching ${object}:`, error);
            loadable.innerHTML = `<li>Error loading ${object}</li>`;
        });
}
