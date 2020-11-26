<?php

require get_theme_file_path("/Classes/Theme.php");

// Run theme activation
SPC2\Theme::activateTheme();
// Add deactivation hook
$Theme = new SPC2\Theme;