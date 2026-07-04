#!/usr/bin/env node
/**
 * build-css.mjs — SPN Cabinets CSS build.
 * -----------------------------------------------------------------------------
 * Concatenates the modular ITCSS partials in assets/css/src/** into a single
 * enqueued stylesheet, assets/css/main.css. This gives us modular authoring
 * (many small, focused files) AND a performant single render-blocking request.
 *
 * Files are included in ascending path order — the numeric folder prefixes
 * (01-settings, 02-generic, …) guarantee the correct ITCSS cascade order.
 *
 * Zero dependencies — uses only Node's standard library.
 *
 * Usage:
 *   node tools/build-css.mjs           # build once
 *   node tools/build-css.mjs --watch   # rebuild on change
 *
 * NOTE: assets/css/main.css is a GENERATED file. Do not edit it by hand —
 * edit the partials in assets/css/src/ and rebuild.
 */

import { readdir, readFile, writeFile } from 'node:fs/promises';
import { watch } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, join, relative } from 'node:path';

const __dirname = dirname( fileURLToPath( import.meta.url ) );
const THEME_ROOT = join( __dirname, '..' );
const SRC_DIR = join( THEME_ROOT, 'assets', 'css', 'src' );
const OUT_FILE = join( THEME_ROOT, 'assets', 'css', 'main.css' );

/**
 * Recursively collect .css files under a directory, sorted by full path.
 * @param {string} dir
 * @returns {Promise<string[]>}
 */
async function collectCssFiles( dir ) {
	const entries = await readdir( dir, { withFileTypes: true } );
	const files = [];

	for ( const entry of entries ) {
		const full = join( dir, entry.name );
		if ( entry.isDirectory() ) {
			files.push( ...( await collectCssFiles( full ) ) );
		} else if ( entry.isFile() && entry.name.endsWith( '.css' ) ) {
			files.push( full );
		}
	}

	return files.sort( ( a, b ) => a.localeCompare( b ) );
}

/**
 * Build main.css from the partials.
 */
async function build() {
	const start = Date.now();
	const files = await collectCssFiles( SRC_DIR );

	const header =
		'/*!\n' +
		' * SPN Cabinets — main.css\n' +
		' * =====================================================================\n' +
		' * ⚠ GENERATED FILE — DO NOT EDIT DIRECTLY.\n' +
		' * Built by tools/build-css.mjs from assets/css/src/**.\n' +
		' * Edit the partials in assets/css/src/ and run `npm run build:css`.\n' +
		' * =====================================================================\n' +
		` * Built: ${ new Date().toISOString() }\n` +
		` * Sources (${ files.length }):\n` +
		files.map( ( f ) => ` *   - ${ relative( THEME_ROOT, f ).replace( /\\/g, '/' ) }` ).join( '\n' ) +
		'\n */\n\n';

	const parts = [];
	for ( const file of files ) {
		const rel = relative( SRC_DIR, file ).replace( /\\/g, '/' );
		const css = await readFile( file, 'utf8' );
		parts.push( `/* ==== src/${ rel } ==== */\n${ css.trim() }\n` );
	}

	await writeFile( OUT_FILE, header + parts.join( '\n' ) + '\n', 'utf8' );

	const ms = Date.now() - start;
	console.log( `✓ Built main.css from ${ files.length } partials in ${ ms }ms` );
}

// --watch mode: rebuild on any change under src/.
if ( process.argv.includes( '--watch' ) ) {
	await build();
	console.log( `👀 Watching ${ relative( THEME_ROOT, SRC_DIR ) } for changes…` );
	let timer = null;
	watch( SRC_DIR, { recursive: true }, () => {
		clearTimeout( timer );
		timer = setTimeout( () => {
			build().catch( ( err ) => console.error( err ) );
		}, 80 );
	} );
} else {
	build().catch( ( err ) => {
		console.error( err );
		process.exit( 1 );
	} );
}
