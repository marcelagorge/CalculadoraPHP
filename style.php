<?php
header("Content-type: text/css; charset: UTF-8");

$cor_fundo_calculadora = "#ffcbdb";

?>

@import url('https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap');

body {
    background-color: <?php echo $cor_fundo_calculadora; ?>;
    font-family: 'Poetsen One', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}


.button {
    background-color: <?php echo $cor_fundo_calculadora; ?>;
    color: #000; 
    font-family: 'Poetsen One', sans-serif; 
    font-size: 18px;
    padding: 15px 30px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-transform: uppercase;
    transition: background-color 0.3s ease;
    margin: 5px;
}


