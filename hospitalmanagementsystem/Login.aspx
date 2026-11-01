<%--<%@ Page Title="Patient Login" Language="C#"
    MasterPageFile="~/Site1.master"
    AutoEventWireup="true"
    CodeBehind="Login.aspx.cs"
    Inherits="Hospital_Management_System_01.Login" %>


<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">

    <style>

        .login-section {
            padding: 120px 0;
            background: #f8f9fa;
            min-height: 700px;
        }

        .login-card {
            background: #ffffff;
            padding: 45px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        .login-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-title h2 {
            color: #2c4964;
            font-size: 32px;
            font-weight: 700;
        }

        .login-title p {
            color: #777;
        }

        .form-label {
            color: #2c4964;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            height: 48px;
            border-radius: 5px;
        }

        .login-btn {
            background: #1977cc;
            border: none;
            color: white;
            padding: 12px 40px;
            border-radius: 5px;
            font-weight: 600;
        }

        .login-btn:hover {
            background: #166ab5;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: #1977cc;
            font-weight: 600;
            text-decoration: none;
        }

        .validation-error {
            color: red;
            font-size: 13px;
            display: block;
            margin-top: 5px;
        }

        .validation-summary {
            background: #fff3f3;
            border: 1px solid #ffcccc;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

    </style>

</asp:Content>


<asp:Content ID="Content3"
    ContentPlaceHolderID="ContentPlaceHolder2"
    runat="server">

    <main class="main">

        <section class="login-section">

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-5 col-md-7">

                        <div class="login-card">

                            <div class="login-title">

                                <h2>Patient Login</h2>

                                <p>
                                    Login to access your hospital services
                                </p>

                            </div>


                            <asp:ValidationSummary
                                ID="ValidationSummary1"
                                runat="server"
                                ForeColor="Red"
                                HeaderText="Please fix the following errors:"
                                DisplayMode="BulletList"
                                CssClass="validation-summary" />


                            <div class="row gy-4">


                                <div class="col-md-12">

                                    <label class="form-label">
                                        Email
                                    </label>

                                    <asp:TextBox
                                        ID="txtLoginEmail"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="Email"
                                        placeholder="Enter your email">
                                    </asp:TextBox>


                                    <asp:RequiredFieldValidator
                                        ID="rfvLoginEmail"
                                        runat="server"
                                        ControlToValidate="txtLoginEmail"
                                        ErrorMessage="Email is required."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic">
                                    </asp:RequiredFieldValidator>


                                    <asp:RegularExpressionValidator
                                        ID="revLoginEmail"
                                        runat="server"
                                        ControlToValidate="txtLoginEmail"
                                        ErrorMessage="Enter a valid email address."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic"
                                        ValidationExpression="^[^@\s]+@[^@\s]+\.[^@\s]+$">
                                    </asp:RegularExpressionValidator>

                                </div>


                                <div class="col-md-12">

                                    <label class="form-label">
                                        Password
                                    </label>

                                    <asp:TextBox
                                        ID="txtLoginPassword"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="Password"
                                        placeholder="Enter your password">
                                    </asp:TextBox>


                                    <asp:RequiredFieldValidator
                                        ID="rfvLoginPassword"
                                        runat="server"
                                        ControlToValidate="txtLoginPassword"
                                        ErrorMessage="Password is required."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic">
                                    </asp:RequiredFieldValidator>

                                </div>


                                <div class="col-md-12 text-center">

                                    <asp:Button
                                        ID="btnLogin"
                                        runat="server"
                                        Text="Login"
                                        CssClass="login-btn"
                                        OnClick="btnLogin_Click"
                                        CausesValidation="True" />

                                </div>


                                <div class="col-md-12">

                                    <div class="register-link">

                                        Don't have an account?

                                        <a href="Registration.aspx">
                                            Register Now
                                        </a>

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

</asp:Content>


<asp:Content
    ID="Content4"
    ContentPlaceHolderID="ContentPlaceHolder3"
    runat="server">

</asp:Content>--%>



<%@ Page Title="Login" Language="C#"
    MasterPageFile="~/Site1.master"
    AutoEventWireup="true"
    CodeBehind="Login.aspx.cs"
    Inherits="Hospital_Management_System_01.Login" %>

<asp:Content ID="Content1"
    ContentPlaceHolderID="head"
    runat="server">

    <style>
        .login-section {
            padding: 120px 0;
            background: #f8f9fa;
            min-height: 700px;
        }

        .login-card {
            background: #ffffff;
            padding: 45px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        .login-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-title h2 {
            color: #2c4964;
            font-size: 32px;
            font-weight: 700;
        }

        .login-title p {
            color: #777;
        }

        .form-label {
            color: #2c4964;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            height: 48px;
            border-radius: 5px;
        }

        .login-btn {
            background: #1977cc;
            border: none;
            color: white;
            padding: 12px 40px;
            border-radius: 5px;
            font-weight: 600;
        }

        .login-btn:hover {
            background: #166ab5;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: #1977cc;
            font-weight: 600;
            text-decoration: none;
        }

        .login-message {
            display: block;
            color: red;
            text-align: center;
            margin-top: 15px;
        }
    </style>

</asp:Content>

<asp:Content ID="Content3"
    ContentPlaceHolderID="ContentPlaceHolder2"
    runat="server">

    <main class="main">
        <section class="login-section">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7">

                        <div class="login-card">

                            <div class="login-title">
                                <h2>Login</h2>
                                <p>Login to access your hospital services</p>
                            </div>

                            <div class="row gy-4">

                                <div class="col-md-12">
                                    <label class="form-label">Email</label>

                                    <asp:TextBox
                                        ID="txtLoginEmail"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="Email"
                                        placeholder="Enter your email">
                                    </asp:TextBox>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Password</label>

                                    <asp:TextBox
                                        ID="txtLoginPassword"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="Password"
                                        placeholder="Enter your password">
                                    </asp:TextBox>
                                </div>

                                <div class="col-md-12 text-center">

                                    <asp:Button
                                        ID="btnLogin"
                                        runat="server"
                                        Text="Login"
                                        CssClass="login-btn"
                                        OnClick="btnLogin_Click" />

                                    <asp:Label
                                        ID="lblMessage"
                                        runat="server"
                                        CssClass="login-message">
                                    </asp:Label>

                                </div>

                                <div class="col-md-12">
                                    <div class="register-link">
                                        Don't have an account?
                                        <a href="Registration.aspx">Register Now</a>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </section>
    </main>

</asp:Content>

<asp:Content ID="Content4"
    ContentPlaceHolderID="ContentPlaceHolder3"
    runat="server">
</asp:Content>