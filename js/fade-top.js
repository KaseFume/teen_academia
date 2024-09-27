// Get all elements with the class slide-top
const elements = document.querySelectorAll('.slide-top');

// Create an IntersectionObserver instance
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      // Add the animate class to the element when it comes into view
      entry.target.classList.add('animate');
      // Stop observing the element
      observer.unobserve(entry.target);
    }
  });
}, {
  // Options for the observer
  threshold: 0.5, // Trigger the animation when 50% of the element is visible
});

// Observe each element
elements.forEach((element) => {
  observer.observe(element);
});
