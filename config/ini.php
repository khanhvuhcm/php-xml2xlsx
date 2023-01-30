<?php
ini_set("session.use_cookies", "On");
ini_set("session.cookie_lifetime", "0");
ini_set("session.use_only_cookies", "On");
ini_set("session.use_strict_mode", "On");
ini_set("session.cookie_httponly", "On");
ini_set("session.cookie_secure", "On");
ini_set("session.cookie_samesite", "Strict");
ini_set("session.gc_maxlifetime", "600");
ini_set("session.use_trans_sid", "Off");
ini_set("session.cache_limiter", "nocache");
ini_set("session.sid_length","48");
ini_set("session.sid_bits_per_character", "6");
ini_set("session.hash_function", "sha256");


session_start();
session_regenerate_id(true);

// SET THIS LATER
// ini_set("session.save_path", "[non world-readable directory]");