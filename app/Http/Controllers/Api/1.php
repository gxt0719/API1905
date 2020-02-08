<?php 
server {
		    listen       80;
		    server_name  api.1905.com;

		    access_log  logs/api.access.log;
		    error_log  logs/api.error.log;

		    location / {
		        root   /wwwroot/api1905/public;
		        index  index.php;
		                try_files $uri $uri/ /index.php?$query_string;
		    }

		    location ~ \.php$ {
		        root           /wwwroot/api1905/public;
		        fastcgi_pass   127.0.0.1:9000;
		        fastcgi_index  index.php;
		        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
		        include        fastcgi_params;
		    }


}

?>