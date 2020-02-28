php artisan migrate
php artisan passport:install
-- Record Password grant client Credentials,
(sample)
----------
# Client ID: 2
# Client secret: JV9xO0iSPHZ19iIjXsd20g5vxLaz0AAdFBaoWPcB
----------
(login)
-----------------------
$http = new GuzzleHttp\Client;

$response = $http->post('http://your-app.com/oauth/token', [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => 'client-id',
        'client_secret' => 'client-secret',
        'username' => 'taylor@laravel.com',
        'password' => 'my-password',
        'scope' => '',
    ],
]);

return json_decode((string) $response->getBody(), true);
-----------------------
(passing access token)
--------------------------
$response = $client->request('GET', '/api/user', [
    'headers' => [
        'Accept' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
    ],
--------------------------
