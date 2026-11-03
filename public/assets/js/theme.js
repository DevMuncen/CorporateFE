//add Shadow to header on scroll
document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("scroll", function () {
        const topHeader = document.querySelector(".top-header") || document.querySelector("header");
        if (!topHeader) return;
        if (document.body.scrollTop > 60 || document.documentElement.scrollTop > 60) {
            topHeader.classList.add("shadow-sm");  
        } else {
            topHeader.classList.remove("shadow-sm");
        }
    });
});