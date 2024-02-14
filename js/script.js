let numbershown = 0;



function increaseNumber() {
  fetch('php/increment_index.php', {
    method: 'POST',
    body:''
  })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));
}

function decreaseNumber() {
  numbershown--;
  console.log(numbershown);
  document.getElementById("numberField").value = numbershown;
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
