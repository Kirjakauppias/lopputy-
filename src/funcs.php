<?php

function printSessionData() {
    if (!empty($_SESSION)) {
        echo "<h3>Sessiotiedot:</h3>";
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
    } else {
        echo "<p>Ei sessiotietoja saatavilla.</p>";
    }
}