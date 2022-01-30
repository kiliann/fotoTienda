'use strict'

let login = document.getElementById('login');
let registrar = document.getElementById('registro');
let btn = document.getElementById('btn');

function registro(){
    login.style.left = "-400px";
    registrar.style.left = "50px";
    btn.style.left = "110px";

}

function logined(){
    login.style.left= "50px";
    registrar.style.left = "450px";
    btn.style.left = "0";


}

document.addEventListener('DOMContentLoaded', logined, true)
