var btn = document.querySelectorAll(".like");

btn.forEach(function(btn) {
    btn.addEventListener("click", function() {
        likeBtn(btn);
    });
});

function likeBtn(btn) {
    if (btn.classList.contains("fa-regular")) {
        btn.classList.remove("fa-regular");
        btn.classList.add("fa-solid");
        btn.style.color = "red"; // Change color to red
    } else {
        btn.classList.remove("fa-solid");
        btn.classList.add("fa-regular");
        btn.style.color = "white"; // Change color back to white
    }
}