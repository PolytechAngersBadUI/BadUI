let on = 0;
// Get the image element by its id
const image = document.getElementById('img');
//const rect = document.getElementById('rect');

image.addEventListener('mousemove', moveImage);


function moveImage() {
  if(on==0){
    document.addEventListener('mousemove', moveImageWithCursor, {passive: true});
    on=1;
    
    setTimeout(() => {
      document.removeEventListener('mousemove', moveImageWithCursor, {passive: true});
    }, 30000);
  }
}

// Function to move the image with the cursor
function moveImageWithCursor(event) {
  // Calculate the new position of the image based on the mouse coordinates
  const x = event.clientX - image.width / 2;
  const y = event.clientY - image.height / 2;
  image.style.left = x + 'px';
  image.style.top = y + 'px';
  fetch('php/update_image_position.php', {
    method: 'POST',
    body: JSON.stringify({x,y})
  })
  .then(response => response.json())
  .then(data => {
    /*if('xr' in data && 'yr' in data){
      rect.style.left = data.xr + 'px';
      rect.style.top = data.yr + 'px';
    }*/
    if(data.status == 'success2'){
    console.log(data.status);}
  })
  .catch(error => console.error('Error:', error));
}