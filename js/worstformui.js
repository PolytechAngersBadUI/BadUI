function toggleButton(button,digit) {
    var phoneNumberField = document.getElementById('phoneInput');
    if (button.classList.contains("on")) {
        button.classList.remove("on");
        button.classList.add("off");
        button.innerHTML = 'Off';
    } else {
        button.classList.remove("off");
        button.classList.add("on");
        button.innerHTML = 'On';
    }
    var newdigit = 0
    var position_digit=0;
    var casetogo=0;
    console.log(digit);
    if (digit>0 && digit<5) {
        casetogo=1;
    }else if (digit>4 && digit<9) {
        casetogo=2;
    }else if (digit>8 && digit<13) {
        casetogo=3;
    }else if (digit>12 && digit<17) {
        casetogo=4;
    }else if (digit>16 && digit<21) {
        casetogo=5;
    } else if (digit>20 && digit<25) {
        casetogo=6;
    } else if (digit>24 && digit<29) {
        casetogo=7;
    } else if (digit>28 && digit<33) {
        casetogo=8;
    } else if (digit>32 && digit<37) {
        casetogo=9;
    }
    console.log(casetogo);
    switch(casetogo) {
        case casetogo=1:
            console.log("Updating first digit");
            if(document.getElementById('button1').classList.contains("on")) {
                newdigit = newdigit+1;
            }
            if(document.getElementById('button2').classList.contains("on")) {
                newdigit = newdigit+2;
            }
            if(document.getElementById('button3').classList.contains("on")) {
                newdigit = newdigit+4;
            }
            if(document.getElementById('button4').classList.contains("on")) {
                newdigit = newdigit+8;
            }
            position_digit=0;
        break; 
        case casetogo=2: 
            console.log("Updating second digit");
            if(document.getElementById('button5').classList.contains("on")) {
                newdigit = newdigit+1;
            }
            if(document.getElementById('button6').classList.contains("on")) {
                newdigit = newdigit+2;
            }
            if(document.getElementById('button7').classList.contains("on")) {
                newdigit = newdigit+4;
            }
            if(document.getElementById('button8').classList.contains("on")) {
                newdigit = newdigit+8;
            }
            position_digit=1;
        break;
        case 3:
            console.log("Updating third digit");
            if(document.getElementById('button9').classList.contains("on")) {
                newdigit = newdigit+1;
            }
            if(document.getElementById('button10').classList.contains("on")) {
                newdigit = newdigit+2;
            }
            if(document.getElementById('button11').classList.contains("on")) {
                newdigit = newdigit+4;
            }
            if(document.getElementById('button12').classList.contains("on")) {
                newdigit = newdigit+8;
            }
            position_digit=2;
        break;
        case 4:
            console.log("Updating fourth digit");
            if(document.getElementById('button13').classList.contains("on")) {
                newdigit = newdigit+1;
            }
            if(document.getElementById('button14').classList.contains("on")) {
                newdigit = newdigit+2;
            }
            if(document.getElementById('button15').classList.contains("on")) {
                newdigit = newdigit+4;
            }
            if(document.getElementById('button16').classList.contains("on")) {
                newdigit = newdigit+8;
            }
            position_digit=4;
        break;
        case 5:
            console.log("Updating fifth digit");
            if(document.getElementById('button17').classList.contains("on")) {
                newdigit = newdigit+1;
            }
            if(document.getElementById('button18').classList.contains("on")) {
                newdigit = newdigit+2;
            }
            if(document.getElementById('button19').classList.contains("on")) {
                newdigit = newdigit+4;
            }
            if(document.getElementById('button20').classList.contains("on")) {
                newdigit = newdigit+8;
            }
            position_digit=5;
        break;
        case 6:
            console.log("Updating sixth digit");
            if(document.getElementById('button21').classList.contains("on")) {
                newdigit = newdigit+1;
            }
            if(document.getElementById('button22').classList.contains("on")) {
                newdigit = newdigit+2;
            }
            if(document.getElementById('button23').classList.contains("on")) {
                newdigit = newdigit+4;
            }
            if(document.getElementById('button24').classList.contains("on")) {
                newdigit = newdigit+8;
            }
            position_digit=6;
        break;
        case 7:
            console.log("Updating seventh digit");
            if(document.getElementById('button25').classList.contains("on")) {
                newdigit = newdigit+1;
            }
            if(document.getElementById('button26').classList.contains("on")) {
                newdigit = newdigit+2;
            }
            if(document.getElementById('button27').classList.contains("on")) {
                newdigit = newdigit+4;
            }
            if(document.getElementById('button28').classList.contains("on")) {
                newdigit = newdigit+8;
            }
            position_digit=8;
        break;
        case 8:
            console.log("Updating eighth digit");
            if(document.getElementById('button29').classList.contains("on")) {
                newdigit = newdigit+1;
            }
            if(document.getElementById('button30').classList.contains("on")) {
                newdigit = newdigit+2;
            }
            if(document.getElementById('button31').classList.contains("on")) {
                newdigit = newdigit+4;
            }
            if(document.getElementById('button32').classList.contains("on")) {
                newdigit = newdigit+8;
            }
            position_digit=9;
        break;
        case 9:
            console.log("Updating ninth digit");
            if(document.getElementById('button33').classList.contains("on")) {
                newdigit = newdigit+1;
            }
            if(document.getElementById('button34').classList.contains("on")) {
                newdigit = newdigit+2;
            }
            if(document.getElementById('button35').classList.contains("on")) {
                newdigit = newdigit+4;
            }
            if(document.getElementById('button36').classList.contains("on")) {
                newdigit = newdigit+8;
            }
            position_digit=10;
        break;
    }
    console.log(phoneNumberField);
    var phoneNumber = phoneNumberField.innerHTML;
    var numbers = phoneNumber.split('');
    console.log(numbers)
    console.log(position_digit);
    console.log(newdigit);
    numbers[position_digit] = newdigit;
    var newPhoneNumber = numbers.join('');
    phoneNumberField.innerHTML = newPhoneNumber;
    if(newdigit>9) {
        clearAll();
    }
}

// Function to clear the phone number field
function clearField() {
    var phoneNumberField = document.getElementById('phoneInput');
    phoneNumberField.innerHTML = '000 000 000';
}

function clearAll() {
    console.log("Hello1");
    var test = document.getElementById('phoneForm');
    console.log(test);
    var buttons = test.querySelectorAll('.digit-input');
    console.log("Hello");
    console.log(buttons);
    buttons.forEach(function(button) {
        console.log("One down");
        button.classList.remove('on');
        button.classList.add('off');
        button.innerHTML = 'Off';
    }
    )
    clearField();
}

function savenumber(){
}