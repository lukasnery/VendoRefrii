<?php

// Encerra a sessão do usuário
session_unset();
session_destroy();

// Redireciona para a página inicial
header("Location: /VendoRefri/public/index.php?route=home");
exit;
