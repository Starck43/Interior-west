// Dependencies
var fs = require('fs-extra'),
	url = require('url'),
	http = require('https'),
	unzipper = require('unzipper');

// App variables
//var FILE_URL = 'http://ru.wordpress.org/latest.tar.gz';
var FILE_URL = 'https://ru.wordpress.org/latest-ru_RU.zip';
var file_name = url.parse(FILE_URL).pathname.split('/').pop();
var EXTRACT_DIR = 'src';
var WP_DIR = 'wordpress';

function downloadHTTP(url){
	var file = fs.createWriteStream(file_name);
	return new Promise((resolve, reject) => {
	    var responseSent = false; // flag to make sure that response is sent only once.
	    http.get(url, response => {
	    	console.log('Downloading the latest WordPress version from ' + url);
	    	response.pipe(file);
	    	file.on('finish', () =>{
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

function unpack(path) {

	try {
			fs.accessSync(file_name);     
			console.log(file_name + ' is extracting...');
			fs.createReadStream(file_name)
			.pipe(unzipper.Extract({ path: path }))
		  	.promise()
		  	.then( () => {
		  				console.log('Done!');
						console.log(file_name + ' is deleting...');
						fs.unlink(file_name, function(e) {
							if (e) return console.log(e);
							console.log('Delete complete!');
						});
		  			})
		  	.catch( e => console.error('Unpacking error', e) );
	} catch (err) {
		console.log('Nothing to extract')
	}
  	
	var wpcontent_folder = path + '/' + WP_DIR + '/wp-content';
  	if (fs.realpathSync(wpcontent_folder)) {
		console.log('Deleting folder "' + wpcontent_folder + '"...');
		fs.removeSync(wpcontent_folder);
		console.log('Done!');
  	} else {console.log('Nothing to delete')}
}

unpack(EXTRACT_DIR);

/*downloadHTTP(FILE_URL)
	.then( function() {
		console.log('Done!');
		unpack(EXTRACT_DIR);
	})
	.catch( e => console.error('Error while downloading', e) );
*/