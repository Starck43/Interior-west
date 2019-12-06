/*
 * wp-install.js
 * Usage: <node wp-install> in cmd console
 * Description: downloading and unpacking Wordpress in folder src/wordpress with moving content folder up from wordpress folder
 * Version: 1.0.4
 * Author: Stanislav Shabalin
 */

 // Dependencies
var fs = require('fs-extra'),
	url = require('url'),
	http = require('https'),
	unzipper = require('unzipper');

// App variables
//var FILE_URL = 'http://ru.wordpress.org/latest.tar.gz';
var FILE_URL = 'https://ru.wordpress.org/latest-ru_RU.zip';
var ZIP_FILE = url.parse(FILE_URL).pathname.split('/').pop();
var EXTRACT_DIR = 'src';

function downloadHTTP(url, file_name){
	var file = fs.createWriteStream(file_name);
	return new Promise((resolve, reject) => {
	    var responseSent = false; // flag to make sure that response is sent only once.
	    http.get(url, response => {
	    	console.log('Downloading the latest WordPress [rus] from ' + url +'...');
	    	response.pipe(file);
	    	file.on('finish', () => {
	    		file.close(() => {
	    			if (responseSent) return;
	    			responseSent = true;
	    			resolve();
	    		});
	    	});
	    }).on('error', e => {
	    	if(responseSent) return;
	    	responseSent = true;
	    	reject(e);
	    });
	});
}

function unpack(file_name, path) {

	try {
		var wpcontent_folder = '/wp-content',
			wp_folder = '/wordpress';
		fs.accessSync(file_name);
		console.log(file_name + ' is extracting...');
		fs.createReadStream(file_name)
		.pipe(unzipper.Extract({ path: path }))
		.promise()
		.then( () => {
				console.log('Done!');
				fs.realpath(path + wp_folder + wpcontent_folder, function(e) {
					if (e) return console.log(e);
					//moving content from wordpress/wp-content folder
					move_content(wp_folder, wpcontent_folder, path)
						.then( () => {
							console.log('WORDPRESS has been installed successfully');
						})
						.catch ( err => console.error('WORDPRESS has been installed with some errors!', err) );
				});
		})
		.catch ( err => console.error('Unpacking error', err) );
	} catch {err => console.log('There is no "' + file_name + '" file to extract') };

}

function move_content(wp_folder, wpcontent_folder, path) {
	var wpcontent_folder_from = path + wp_folder + wpcontent_folder,
		wpcontent_folder_to = path + wpcontent_folder,
		lang = '/languages',
		plugins = '/plugins';
	return new Promise((resolve, reject) => {
		try {
			console.log('Moving ' + lang + ' folder from ' + wpcontent_folder_from + ' to ' + wpcontent_folder_to);
			fs.moveSync(wpcontent_folder_from+lang, wpcontent_folder_to+lang, { overwrite: true });
			console.log('Done!');

			console.log('Moving ' + plugins + ' folder from ' + wpcontent_folder_from + ' to ' + wpcontent_folder_to);
			fs.moveSync(wpcontent_folder_from+plugins, wpcontent_folder_to+plugins, { overwrite: true });
			console.log('Done!');

			console.log('Deleting folder ' + wpcontent_folder_from + ' ...');
			fs.removeSync(wpcontent_folder_from);
			console.log('Done!');

			console.log('Deleting archive file ' + ZIP_FILE + ' ...');
			fs.removeSync(ZIP_FILE);
			console.log('Done!');

			resolve();
		} catch (e) {
			console.error(e);
			reject(e);
		}
	});
}

//-----------START-----------
try {
    fs.accessSync(ZIP_FILE);
    // Do something
	console.log('File '+ZIP_FILE+' exists');
	unpack(ZIP_FILE, EXTRACT_DIR);
} catch (e) {
	downloadHTTP(FILE_URL, ZIP_FILE)
		.then( () => {
			console.log('File is downloaded successfully!');
			unpack(ZIP_FILE, EXTRACT_DIR);
		})
		.catch ( err => console.error('Error while downloading', err) );
}
