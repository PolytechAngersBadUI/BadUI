var timeoutID=null;
let on = 0;

const image = document.getElementById('img');
const goal = document.getElementById('goal');

image.addEventListener('mousemove', moveImage);

function moveImage() {
  if(on==0){
    document.addEventListener('mousemove', moveImageWithCursor, {passive: true});
    on=1;
    
    timeoutID = setTimeout(() => {
      document.removeEventListener('mousemove', moveImageWithCursor, {passive: true});
    }, 30000);
  }
}

//Function to move the image with the cursor
function moveImageWithCursor(event) {
  //Calculate the new position of the image based on the mouse coordinates. it will then get sent to the server
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
      image.style.left = data.x-image.width/2 + 'px';
      image.style.top = data.y-image.height/2 + 'px';
      on=0;
      if(data.level==1){
        document.getElementById('laby').style.display = 'none';
        document.getElementById('cube').style.display = 'block';
      }
      else if(data.level==3){
        document.getElementById('laby').style.display = 'block';
        document.getElementById('cube').style.display = 'none';
      }else{
        document.getElementById('laby').style.display = 'none';
        document.getElementById('cube').style.display = 'none';
      }
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
    goal.style.left = data.endingcoordx-(image.width/2)  + 'px';
    goal.style.top = data.endingcoordy-(image.height/2)  + 'px';
  })
}