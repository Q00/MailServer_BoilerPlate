# MailServer_BoilerPlate
 BoilerPlate Code using PHPMailer 5.2.26 (https://github.com/PHPMailer/PHPMailer/releases/tag/v5.2.26)
 You can send text data and files no limit count.
 This code use Multipart/form-data

# Getting Started
 - this phpmailer version is 5.2.26 so Your server must have PHP version > 5
 - You can use client.php in your client and use CURL to server that has mail_server.php.
   This Server Encoding is EUC-KR. In some case, Korean letters are broken when I request by using "UTF8".
   So I have to change Encoding by using this : iconv("UTF8","EUC-KR",$_FILES['first_file']['name'])
 - In 'server' directory, I use gmail SMTP, so You can put your gmail ID so that it can send mail to other.
 
# license
MIT
 
