<?php
function cleanArrayCart() {
    if (!isset($_SESSION['cart'])||empty($_SESSION['cart'])):
        $_SESSION['cart'] = array();
    endif;
}