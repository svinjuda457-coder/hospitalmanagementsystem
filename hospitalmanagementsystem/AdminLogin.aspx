<%@ Page Language="C#" AutoEventWireup="true"
    CodeBehind="AdminLogin.aspx.cs"
    Inherits="Hospital_Management_System_01.AdminLogin" %>

<!DOCTYPE html>
<html>
<head runat="server">
    <title>Admin Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8f7fb, #f5f9fc);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial;
        }

        .login-box {
            width: 420px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 35px rgba(0,0,0,.12);
        }

        .icon {
            width: 70px;
            height: 70px;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: auto;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
        }
    </style>
</head>

<body>

<form id="form1" runat="server">

    <div class="login-box">

        <div class="icon">+</div>

        <h2 class="text-center mt-3">
            Admin Login
        </h2>

        <p class="text-center text-muted">
            Hospital Management System
        </p>

        <asp:Label
            ID="lblMessage"
            runat="server"
            CssClass="text-danger d-block text-center mb-3">
        </asp:Label>

        <!-- Email -->
        <div class="mb-3">

            <label class="form-label">
                Admin Email
            </label>

            <asp:TextBox
                ID="txtEmail"
                runat="server"
                TextMode="Email"
                CssClass="form-control"
                placeholder="Enter admin email">
            </asp:TextBox>

        </div>

        <!-- Password -->
        <div class="mb-3">

            <label class="form-label">
                Password
            </label>

            <asp:TextBox
                ID="txtPassword"
                runat="server"
                TextMode="Password"
                CssClass="form-control"
                placeholder="Enter password">
            </asp:TextBox>

        </div>

        <asp:Button
            ID="btnLogin"
            runat="server"
            Text="Login"
            CssClass="btn btn-primary login-btn"
            OnClick="btnLogin_Click" />

        <div class="text-center mt-3">

            <a href="Home.aspx">
                ← Back to Website
            </a>

        </div>

    </div>

</form>

</body>
</html>