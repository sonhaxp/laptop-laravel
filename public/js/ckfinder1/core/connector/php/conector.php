
 
$config['backends'][] = array(
    'name'         => 'default',
    'adapter'      => 'local',
 
    'baseUrl'      => 'http://localhost:8000/images/blog',
    'root'         => 'http://localhost:8000/images/blog',
 
    'chmodFiles'   => 0777,
    'chmodFolders' => 0755,
    'filesystemEncoding' => 'UTF-8'
);