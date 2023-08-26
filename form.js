const searchForm = document.querySelector("form");
const searchInput = document.querySelector("form input");
const postsContainer = document.querySelector(".posts");
const hintError = document.querySelector("form .hint-error");

searchInput.addEventListener("focus", (e) => {
    searchInput.classList.remove("error");
})
searchForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const searchValue = searchInput.value;
    if (searchValue === "" || searchValue.length < 3) {
        searchInput.classList.add("error");
        return;
    }

    fetch(`${window.location.href}search.php`, {
        method: 'POST',
        body: JSON.stringify({
            "string": searchValue
        })
    }).then((response) => {
        if (response.status === 200) {
            return response.json();
        } else if (response.status === 404) {
            postsContainer.innerHTML = "<span class='not-found'>Упс...<br>Мы не нашли комментарии с таким текстом</span>";
            throw new Error("Not found");
        } else {
            throw new Error("Something went wrong");
        }
    }).then((data) => {
        postsContainer.innerHTML = "";
        for (let i = 0; i < data.length; i++) {
            let comments = "";
            for (let j = 0; j < data[i].comments.length; j++) {
                comments += `<p title="comment body"><b>BODY:</b> ${data[i].comments[j]["body"].replace(searchValue, `<b style="background-color:yellow">${searchValue}</b>`)}<span class="comment-author"><b>EMAIL:</b> ${data[i].comments[j]["email"]}:</span></p>`
            }
            postsContainer.innerHTML += `
            <div class="post">
                <span class="post-id"><b>ID:</b> ${data[i].id}</span>
                <h2 title="post title"><b>TITLE:</b> ${data[i].title}</h2>
                <div class="comments">
                    ${comments}
                </div>
            </div>
            `;
        }
    }).catch((error) => {
        throw new Error(error);
    });
});
