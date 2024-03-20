var timeoutID=null;
let on = 0;
// Get the image element by its id
const image = document.getElementById('img');
//const rect = document.getElementById('rect');

image.addEventListener('mousemove', moveImage);

// Function to draw a grid on the canvas
function drawGrid() {
  // Create a canvas element
  // Set the canvas size to match the HTML page
  
  const canvas = document.createElement('canvas');
  // Get the 2D rendering context for the canvas
  const ctx = canvas.getContext('2d');
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
// Append the canvas to the document body

  document.body.appendChild(canvas);
  const gridSize = 50; // Adjust the size of the grid squares as needed
  const canvasWidth = canvas.width;
  const canvasHeight = canvas.height;
  console.log(canvasWidth, canvasHeight);

  ctx.strokeStyle = 'gray';
  ctx.lineWidth = 1;

  // Draw vertical lines
  for (let x = 0; x <= canvasWidth; x += gridSize) {
    ctx.beginPath();
    ctx.moveTo(x, 0);
    ctx.lineTo(x, canvasHeight);
    ctx.stroke();
  }

  // Draw horizontal lines
  for (let y = 0; y <= canvasHeight; y += gridSize) {
    ctx.beginPath();
    ctx.moveTo(0, y);
    ctx.lineTo(canvasWidth, y);
    ctx.stroke();
  }
}

// Call the drawGrid function to draw the grid on the canvas
drawGrid();

function moveImage() {
  if(on==0){
    document.addEventListener('mousemove', moveImageWithCursor, {passive: true});
    on=1;
    
    timeoutID = setTimeout(() => {
      document.removeEventListener('mousemove', moveImageWithCursor, {passive: true});
    }, 30000);
  }
}

// Function to move the image with the cursor
function moveImageWithCursor(event) {
  // Calculate the new position of the image based on the mouse coordinates
  const x = event.clientX - image.width / 2;
  const y = event.clientY - image.height / 2;
  fetch('php/update_image_position.php', {
    method: 'POST',
    body: JSON.stringify({x,y})
  })
  .then(response => response.json())
  .then(data => {
    console.log(data.status + ' ' + data.x + ' ' + data.y);
    if(data.status == 'init'){
      image.style.left = data.x + 'px';
      image.style.top = data.y + 'px';
      console.log(data.message)
    }
    //console.log('x: '+ data.x+ ' y: '+ data.y)
    else if(data.status=='success'){
      console.log(data.message);
      console.log("New starting coords are x: "+ data.x + ' y: ' + data.y + "\nNew ending coords are x: "+ data.endingcoordx + ' y: ' + data.endingcoordy);
      goal.style.left = data.endingcoordx-image.width/2  + 'px';
      goal.style.top = data.endingcoordy-image.height/2  + 'px';
      image.style.left = data.x-image.width/2 + 'px';
      image.style.top = data.y-image.height/2 + 'px';
      on=0;
      //console.log('\'On \'should be reinitialized : ' + on)
      document.removeEventListener('mousemove', moveImageWithCursor, {passive: true})
      clearTimeout(timeoutID);
    }
    else if(data.status == 'in'){
      image.style.left = data.x + 'px';
      image.style.top = data.y + 'px';
    }
    else if(data.status == 'out'){
      console.log('Image position reinitialized, image out x: '+ data.x_out+ ' y: '+ data.y_out);
      image.style.left = data.x-image.width/2 + 'px';
      image.style.top = data.y-image.height/2 + 'px';
      on=0;
      //console.log('\'On \'should be reinitialized : ' + on)
      document.removeEventListener('mousemove', moveImageWithCursor, {passive: true})
      clearTimeout(timeoutID);
    }else if(data.status == 'toofar'){
      console.log(data.message)
      console.log('Image position reinitialized, image out x: '+ data.x_out+ ' y: '+ data.y_out);
      image.style.left = data.x-image.width/2 + 'px';
      image.style.top = data.y-image.height/2 + 'px';
      on=0;
      document.removeEventListener('mousemove', moveImageWithCursor, {passive: true})
      clearTimeout(timeoutID);
    }
  })
}