function send(){
    var arr = document.getElementsByTagName('input');
    var form_name = arr[0].value;
    var form_phone = arr[1].value;
    var form_lastname = arr[2].value;
    var form_email = arr[3].value;
    var form_message = arr[4].value;
    if(form_name == "" || form_lastname == "" || form_phone == "" || form_email == "" || form_message == ""){
        alert("Vui lòng điền vào tất cả các trường hoặc điền chính xác");
        return;
    }
    if(!isNaN(form_phone)){ //is not a number
        alert("Điện thoại phải là một số");
        return;
    }
}
