<?php
lliure::pre('$_SESSION', $_SESSION);
lliure::pre('$_GET', $_GET);
lliure::pre('url', lliure::url($_GET));
lliure::pre('$desktop', $lista);
lliure::pre('$desktop->getQueryList(true)', $desktop->getQueryList(TRUE));
?>