document.addEventListener('DOMContentLoaded', function() {
    const mainHeader = document.querySelector('header'); // Select your main header element
    const heroSection = document.querySelector('.hero');

    if (mainHeader && heroSection) {
        function adjustHeroMargin() {
            // Get the actual computed height of the header
            const headerHeight = mainHeader.offsetHeight;
            // Apply this height as margin-top to the hero section
            heroSection.style.marginTop = `${headerHeight}px`;
        }

        // Call the function once the DOM is loaded
        adjustHeroMargin();

        // Also, adjust the margin whenever the window is resized,
        // in case the header height changes (e.g., due to responsive design)
        window.addEventListener('resize', adjustHeroMargin);

        // If your header content can dynamically change height after page load
        // (e.g., through AJAX, or PHP showing/hiding content after user action)
        // you might need a MutationObserver, but for most cases, resize event is enough.
        // Example for MutationObserver (uncomment if needed):
        // const observer = new MutationObserver(adjustHeroMargin);
        // observer.observe(mainHeader, { attributes: true, childList: true, subtree: true });
    }
});