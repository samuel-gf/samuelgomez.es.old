<?php
    // $$x = {-b \pm \sqrt{b^2-4ac} \over 2a}$$
    if (!session_start()) { die("ERROR DE INICIO DE SESIÓN");}
    const ROOT = __DIR__;    
    const CSS = __DIR__.'/css';
    const JS = __DIR__.'/js';
    const LIB = __DIR__.'/lib';
    const IMG = __DIR__.'/img';
    const ARTICLES = __DIR__.'/articles';
    const TEMPLATES = __DIR__.'/templates';
    const MAX_EN_PORTADA = 10;

    if ($_SERVER['REMOTE_ADDR'] == '192.168.1.10'){
        define('DATABASE_PASSWORD','uT7A69uJyXPdvBl');
        define('DATABASE_USER','root');
        define('DATABASE_HOST','localhost');
        define('DATABASE_NAME','GenioDelMal');
    } else {
        define('DATABASE_PASSWORD','RhL-5aq-vgK-YRn');
        define('DATABASE_USER','dbo685183673');
        define('DATABASE_HOST','db685183673.db.1and1.com');
        define('DATABASE_NAME','db685183673');
    }
