<?php

/* Global settings */
define("TITLE", "WebPlug | Tableau de bord");
define("SEARCHBOX", "Rechercher...");


/* Navbar */
define("NAV_01", "Tableau de bord");
define("NAV_02", "Général");
define("NAV_03", "Configuration");
define("NAV_04", "Securité");
define("NAV_05", "Se déconecter");

/* PAGES */
define("PAGE_01", array(
"name" => "Tableau de bord"
));
define("PAGE_02", array(
"name" => "Général",
"form-name" => "Paramètres généraux",
"form-sitename" => "Nom",
"form-sitelang" => "Langue",
"form-siteadvanced" => "Avancés",
"form-sitedebug" => "Déboguer",
"form-send" => "Vérification & envoi",
"form-lang" => "fr",
"success_msg" => "<strong>Succès!</strong> Les informations ont bien été modifiés."
));
define("PAGE_03", array(
"name" => "Configuration",
"add-btn" => "Ajouter",
"send-btn" => "Sauvegarder",
"remove-btn" => "Supprimer",
"form-lang" => "fr",
"success_msg" => "<strong>Succès!</strong> Les informations ont bien été modifiés."
));
define("PAGE_04", array(
"name" => "Sécurité & Confidentialité",
"clear" => "Vider le cache",
"success_msg" => "<strong>Succès !</strong> Le cache à bien été vidé"
));