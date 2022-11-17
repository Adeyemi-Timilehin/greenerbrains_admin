<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Password Reset</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="white" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif; border-bottom: 3px solid rgb(80, 191, 141); border-bottom-color: rgb(80, 191, 141);">
                            <img src="https://greenerbrains.com/images/icons/Brain_4.ico" alt="GreenerBrains" width="100" height="65" style="display: block;" />
                            <p style="color: rgb(80, 191, 141); margin: 0px; margin-top: 3px;">GreenerBrains</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        Hello {{ $to_name }},
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b><p style="float:center; margin-top: 0px; text-align: center;">Welcome to GreenerBrains! </p></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0 10px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p style="margin-top: 0px;">
                                            You requested to reset the password
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0 10px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>
                                            Your account is ready to go.
                                        </p>
                                        <p style="margin-left: 10px;">
                                            Your new password is : <b> {{ $password }} </b>
                                        </p>
                                        <p>All the best,</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="rgb(80, 191, 141)" style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; padding: 30px 30px 30px 30px; ">
                             Copyright© 2020 <a href="#" style="color: #ffffff; text-decoration: none; font-weight: 400;"><font color="#ffffff">GreenerBrains</font></a>
                             <br>
                             All logos and trademarks are the properties of their respective owners.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
