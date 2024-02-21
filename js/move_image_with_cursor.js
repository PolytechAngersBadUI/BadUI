
// Get the image element by its id
const image = document.getElementById('img');

// Add event listener to track mouse movement
image.addEventListener('mousemove', moveImageWithCursor);

// Function to move the image with the cursor
function moveImageWithCursor(event) {
  // Calculate the new position of the image based on the mouse coordinates
  const x = event.clientX - image.width / 2;
  const y = event.clientY - image.height / 2;

  // Set the new position of the image
  image.style.left = x + 'px';
  image.style.top = y + 'px';
}

// Set a timeout to stop the image from following the cursor after 30 seconds
setTimeout(() => {
  image.removeEventListener('mousemove', moveImageWithCursor);
}, 30000);