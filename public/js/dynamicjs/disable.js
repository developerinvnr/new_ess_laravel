// Function to create and show a tooltip at a specific position
function showTooltip(message, x, y) {
    const tooltip = document.createElement('div');
    tooltip.textContent = message;
    tooltip.style.position = 'absolute';
    tooltip.style.top = `${y}px`;
    tooltip.style.left = `${x}px`;
    tooltip.style.padding = '8px';
    tooltip.style.backgroundColor = '#f44336';  // Red background
    tooltip.style.color = 'white';
    tooltip.style.fontSize = '12px';
    tooltip.style.borderRadius = '5px';
    tooltip.style.zIndex = '9999';
    tooltip.style.pointerEvents = 'none';  // Make tooltip not interactable
    tooltip.style.fontWeight = 'bold';

    // Append the tooltip to the body
    document.body.appendChild(tooltip);

    // Remove the tooltip after 2 seconds
    setTimeout(() => {
        tooltip.remove();
    }, 2000);
}

// Disable right-click (context menu)
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();  // Prevent the context menu from appearing
    showTooltip("Right-click is disabled on this page.", e.clientX, e.clientY);  // Show tooltip
});

// Disable specific keyboard shortcuts: F12, Ctrl+Shift+I, Ctrl+U
document.addEventListener('keydown', function(e) {
    // Disable F12 key (Developer tools)
    if (e.key === 'F12') {
        e.preventDefault();
        showTooltip("Developer Tools are disabled on this page.", window.innerWidth / 2, window.innerHeight / 2);  // Show tooltip in the center of the screen
    }

    // Disable Ctrl+Shift+I (Inspector Tools)
    if (e.ctrlKey && e.shiftKey && e.key === 'I') {
        e.preventDefault();
        showTooltip("Developer Tools are disabled on this page.", window.innerWidth / 2, window.innerHeight / 2);  // Show tooltip in the center of the screen
    }

    // Disable Ctrl+U (View Source)
    if (e.ctrlKey && e.key === 'u') {
        e.preventDefault();
        showTooltip("Viewing page source is disabled.", window.innerWidth / 2, window.innerHeight / 2);  // Show tooltip in the center of the screen
    }
});

// Disable text selection using mouse (optional)
document.addEventListener('mousedown', function(e) {
    e.preventDefault();  // Prevent text selection
    showTooltip("Text selection is disabled on this page.", e.clientX, e.clientY);  // Show tooltip at mouse position
});


// Disable text selection using mouse
document.addEventListener('mousedown', function(e) {
    e.preventDefault();  // Disable text selection on mouse down
    const tooltip = document.createElement('div');  // Create a tooltip element
    tooltip.textContent = "Text selection is disabled on this page.";  // Tooltip message
    tooltip.style.position = 'absolute';
    tooltip.style.top = e.clientY + 'px';
    tooltip.style.left = e.clientX + 'px';
    tooltip.style.padding = '5px';
    tooltip.style.backgroundColor = '#f44336';
    tooltip.style.color = 'white';
    tooltip.style.fontSize = '12px';
    tooltip.style.borderRadius = '5px';
    tooltip.style.zIndex = '9999';
    tooltip.style.pointerEvents = 'none';
    
    // Append the tooltip to the body and remove it after 3 seconds
    document.body.appendChild(tooltip);
    setTimeout(() => {
        document.body.removeChild(tooltip);
    }, 3000);
});

