if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
} else {
    ready()
}
function ready() {
    var emailMsg = document.getElementById('email-msg');
    var emailInput = document.getElementById('email');
    emailInput.addEventListener('blur', validatEemail);
    /* valide phone number */
    var phoneInput = document.getElementById("phone");
    phoneInput.addEventListener('blur', validatePhone);
    /* show tips for user when focus */
    emailInput.addEventListener('focus', emailTip);
    phoneInput.addEventListener('focus', phoneTip);
}


/* validate email */
function validatEemail() {
    var emailInput = document.getElementById('email');
    var emailValue = emailInput.value;
    var emailMsg = document.getElementById('email-msg');
    var atposition = emailValue.indexOf("@");
    var dotposition = emailValue.lastIndexOf(".");

    if (atposition < 1 || dotposition < (atposition + 2) || (dotposition + 2) >= emailValue.length) {
        emailMsg.className= "msg";
        emailMsg.textContent = "Vui lòng nhập email hợp lệ...!!!";
        return false;
    }
    else {
        emailMsg.textContent ='';
    }
}

/* validate phone */
function validatePhone() {
    var phoneInput = document.getElementById("phone");
    var phoneNumber = phoneInput.value;
    var phoneMsg = document.getElementById('phone-msg');
    var re  = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/
    var phoneNumberisValid = re.test(phoneNumber);
    if (phoneNumberisValid == false) {
        phoneMsg.className = "msg"; 
        phoneMsg.textContent ="Xin vui lòng nhập một số điện thoại hợp lệ...!!!";
    }
    else {
        phoneMsg.textContent ="";
    }
}

/* email tip */
function emailTip() {
    var emailMsg = document.getElementById('email-msg');
    emailMsg.className = 'tip';
    emailMsg.textContent = "Email phải có \"@\" and \".com\"... ex: vuhoduc40@gmail.com ";
}

/* phone tips */
function phoneTip() {
    var phoneMsg = document.getElementById('phone-msg');
    phoneMsg.className = "tip";
    phoneMsg.textContent = "Điện thoại phải là số từ 0 đến 9";
}