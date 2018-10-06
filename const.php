<?php
    if (!session_start()) {
		die("ERROR DE INICIO DE SESIÓN");
	}
    const ROOT = __DIR__;
	const SRC = __DIR__.'/src';
    const CSS = __DIR__.'/css';
    const JS = __DIR__.'/js';
    const LIB = __DIR__.'/lib';
    const IMG = __DIR__.'/img';
	const HTML = __DIR__.'/html';
    const TEMPLATES = __DIR__.'/templates';
    const MAX_EN_PORTADA = 10;
