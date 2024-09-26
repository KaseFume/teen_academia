function animateCountUp(element, end, duration) {
    let start = 0;
    let startTime = null;

    function update(currentTime) {
        if (!startTime) startTime = currentTime;

        const progress = currentTime - startTime;
        const value = Math.min(start + Math.floor((progress / duration) * end), end);

        element.innerHTML = value;

        if (value < end) {
            requestAnimationFrame(update);
        }
    }

    requestAnimationFrame(update);
}

document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll(".counter");

    counters.forEach(counter => {
        const target = +counter.getAttribute("data-target");
        animateCountUp(counter, target, 2000); // Duration of 2 seconds for each counter
    });
});
