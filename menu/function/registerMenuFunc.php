<?php

function regisForm($type)
{
    $arr[0] = '';
    $arr[1] = '';
    if ($type == true) {
        $regisForm = '
        <div class="mb-3">
        <label for="psw"><b>Email: </b></label>' . $arr[0] . '
        <p><label for="psw"><b>Mobile: </b></label>' . $arr[1] . '
        <p><button type="button"  name="btnLogin" id="btnLogin" onclick="closeClick()">
            CLOSE
        </button>
        </div>
        ';
    } else {
        $regisForm = '
        <div class="mb-3">
        <label for="psw" class="form-label form-label-lg"><b>Email</b></label>
        <input type="email" class="form-control form-control-lg"
            id="txtEMail" 
            name="txtEMail"
            placeholder="Enter EMail"
            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
            maxlength="40"
        required>
        </div>
        <div class="mb-3">
        <label for="psw" class="form-label form-label-lg"><b>Mobile</b></label>
        <input type="tel" class="form-control form-control-lg"
            placeholder="Enter Mobile" 
            name="txtTel" id="txtTel" 
            pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" 
            maxlength="10"
        required>
        </div>
        <div class="mb-3">
        <button class="btn btn-success btn-lg rmxRegister pt-3 pb-3" type="button"  
            name="btnLogin" 
            id="btnLogin" 
            onclick="registerCheck()"
        >
        REGISTER
        </button>
        </div>
        ';
    }
    return $regisForm;
}


?>