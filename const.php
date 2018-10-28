<?php
    if (!session_start()) {
		die("ERROR DE INICIO DE SESIÓN");
	}
	setlocale(LC_ALL,"es_ES");
	date_default_timezone_set('Europe/Madrid');

    const ROOT = __DIR__;
	const BASE_URL = 'http://samuelgomez.es';
	const SRC = ROOT.'/src';
    const CSS = ROOT.'/css';
    const JS = ROOT.'/js';
    const IMG = ROOT.'/img';
	const HTML = ROOT.'/html';
    const TEMPLATES = ROOT.'/templates';
	const PAGES = ROOT.'/pages';
	const LOG = ROOT.'/log';
    const MAX_EN_PORTADA = 10;

	const SRC_EXT = '.md';
	const AUTOR = 'Samuel Gómez';
