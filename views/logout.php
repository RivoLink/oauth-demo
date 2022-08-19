<?php
session_destroy();

header('Location: '.base_url());
exit;
