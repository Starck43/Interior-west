// Dependencies
var fs = require('fs'),
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

/*	console.log(file_name + ' is extracting...');
	fs.createReadStream(file_name)
	.pipe(unzipper.Extract({ path: path }))
  	.promise()
  	.then( () => {
  				console.log('Done!');
				console.log(file_name + ' is deleting...');
				fs.unlink(file_name, function(e) {
					if (e) return console.log(e);
					console.log('Done. Delete complete!');
				});
  			})
  	.catch( e => console.error('Unpacking error', e) );
*/  	
  	if (fs.realpathSync(path + '/' + WP_DIR + '/wp-content')) {
  		fs.readdir(path, (err, files) => {
	    if (!err) {
	      for (let file of files) {
	        // Delete each file
	        fs.unlinkSync(path.join(_dirloc, file))
	      }
	    }
		})
		// After the 'done' of each file delete,
		// Delete the directory itself.
	  	if (fs.unlinkSync(_dirloc)) {
	    	console.log('Directory has been deleted!')
		}
		console.log('Removing from "' + path + '/' + WP_DIR + '/wp-content" to "' + path + '/wp-content" is beginning...');
		fs.rename(path + '/' + WP_DIR + '/wp-content', path + '/' + 'wp-content' , (err) => {
			if (err) throw err;
			console.log('Remove complete!');
		});
  	}
}

unpack(EXTRACT_DIR);

/*downloadHTTP(FILE_URL)
	.then( function() {
		console.log('Done!');
		unpack(EXTRACT_DIR);
	})
	.catch( e => console.error('Error while downloading', e) );
*/