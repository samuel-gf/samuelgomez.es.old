<?php
    if (!session_start()) {
		die("ERROR DE INICIO DE SESIÓN");
	}
    const ROOT = __DIR__;
	const SRC = ROOT.'/src';
    const CSS = ROOT.'/css';
    const JS = ROOT.'/js';
    const LIB = ROOT.'/lib';
    const IMG = ROOT.'/img';
	const HTML = ROOT.'/html';
    const TEMPLATES = ROOT.'/templates';
    const MAX_EN_PORTADA = 10;
