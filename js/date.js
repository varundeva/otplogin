function date(){
       var bday=document.getElementById('dob').value;
        var today = new Date();
        var birthDate = new Date(bday);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();

        if (today.getMonth() < birthDate.getMonth() || (today.getMonth() == birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
            age--;

        }
        document.getElementById('age').value=age;
    }
