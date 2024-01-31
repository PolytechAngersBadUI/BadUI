function sendToServer() {
    var maVariableJS = "Valeur à envoyer";
  
    fetch('script.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'variable=' + encodeURIComponent(maVariableJS),
    });
  }