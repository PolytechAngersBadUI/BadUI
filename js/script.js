let numbershown = 0;



function increaseNumber() {
  const formData = new FormData();
  formData.append('operation', 1);
  fetch('php/incdec.php', {
    method: 'POST',
    body:formData
  })
    .then(response => response.text())
    .then(data => document.getElementById("numberField").innerHTML = data)
    .catch(error => console.error('Error:', error));
}

function decreaseNumber() {
  const formData = new FormData();
  formData.append('operation', 2);
  fetch('php/incdec.php', {
    method: 'POST',
    body:formData
  })
    .then(response => response.text())
    .then(data => document.getElementById("numberField").innerHTML = data)
    .catch(error => console.error('Error:', error))
}

function sendToServer() {
  let number = numbershown;
  console.log(number);
  const formData = new FormData();
  formData.append('number', number);
  fetch('php/process_number.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));
}
