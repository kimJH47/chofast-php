<?php
namespace App\Http\applications;
class LoginDto
{
    private string $userName;
    private string $password;

    /**
     * @param string $userName
     * @param string $password
     */
    public function __construct(string $userName, string $password)
    {
        $this->userName = $userName;
        $this->password = $password;
    }


    public static function create(string $body): LoginDto
    {
        $body = json_decode($body, true);
        return new LoginDto($body['userName'], $body['password']);
    }
}
