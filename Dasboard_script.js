// Get the elements
const header = document.querySelector('header');
const main = document.querySelector('main');
const footer = document.querySelector('footer');

// Set the initial height of the header
const headerHeight = header.offsetHeight;

// Set the initial height of the main content
const mainHeight = main.offsetHeight;

// Set the initial height of the footer
const footerHeight = footer.offsetHeight;

// Set the initial height of the window
const windowHeight = window.innerHeight;

// Set the initial width of the window
const windowWidth = window.innerWidth;

// Resize the window event listener
window.addEventListener('resize', () => {
  // Get the new height of the window
  const newWindowHeight = window.innerHeight;

  // Get the new width of the window
  const newWindowWidth = window.innerWidth;

  // Calculate the new height of the main content
  const newMainHeight = newWindowHeight - headerHeight - footerHeight;

  // Calculate the new width of the main content
  const newMainWidth = newWindowWidth;

  // Set the new height of the main content
  main.style.height = newMainHeight + 'px';

  // Set the new width of the main content
  main.style.width = newMainWidth + 'px';
});