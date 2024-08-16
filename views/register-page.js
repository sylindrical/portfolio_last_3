let email = document.getElementById("email");
let password = document.getElementById("password");
let username = document.getElementById("username");

let submit_btn = document.getElementById("submit");
let Eform = document.querySelector("form");
console.log(Eform);

let err = document.getElementById("error");

console.log("it works");
/**
 * 
 * @param {event} ev 
 */
function submit_validate(ev)
{
console.log("second");
ev.preventDefault();


if (!(username.value.length>= 5))
{
    msg = "Username too short; have a username 5 or more characters in length"
    alert("Username too short; have a username 5 or more characters in length")
    err.style.display = "flex";
    err.children[1].textContent = msg;
return;
}
if (!(password.value.length >= 5))
{
    msg = "Password too short; have a password 5 or more characters in length"

alert("Password too short; have a password 5 or more characters in length")
err.style.display = "flex";
err.children[1].textContent = msg;

return;
}
if (!(emailIsValid(email.value)))
{
    msg = "email is not valid";

    alert("email is not valid")
    err.style.display = "flex";
    err.children[1].textContent = msg;


    return;
}
Eform.submit();


}

function username_changed()
{
    if (username.value.length < 5)
    {
        username.style.backgroundColor = "rgb(218, 165, 32)";
        username.style.opacity = "0.9";
    }
    else{
        username.style.backgroundColor = "white";
        username.style.opacity = "1";
    }
}


function emailIsValid(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}


Eform.addEventListener("submit", submit_validate);

username.addEventListener("change", username_changed);