function ChangeNumber(change) {
  console.log('Changing the Number');
  const formData = new FormData();
  formData.append('operation', change);
  fetch('php/numbertragedyservercode.php', {
    method: 'POST',
    body:formData
  })
    .then(response => response.json())
    .then(data => {console.log(data);console.log(data.number);document.getElementById("numberField").innerHTML = data.number})
    .catch(error => console.error('Error:', error));
}

function sendToServer() {
  const formData = new FormData();
  formData.append('operation', 3);
  fetch('php/numbertragedyservercode.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.json())
    .then(data => {console.log(data);document.getElementById("valnum").innerHTML=data.validatenumber;})
    .catch(error => console.error('Error:', error));
}

function difficulty(difficulty) {
  const formData = new FormData();
  formData.append('operation', difficulty+3);
  fetch('php/numbertragedyservercode.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.json())
    .then(data => {console.log(data);console.log(data.difficultymessage);document.getElementById("difficulty_message").innerHTML=data.difficultymessage;})
    .catch(error => console.error('Error:', error));
}