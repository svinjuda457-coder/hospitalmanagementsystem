<%--<%@ Page Title="Registration" Language="C#" MasterPageFile="~/Site1.master"
    AutoEventWireup="true"
    CodeBehind="Registration.aspx.cs"
    Inherits="Hospital_Management_System_01.Registration" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">

    <style>

        .registration-section {
            padding: 100px 0;
            background: #f8f9fa;
        }

        .registration-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        .registration-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .registration-title h2 {
            font-size: 32px;
            font-weight: 700;
            color: #2c4964;
        }

        .registration-title p {
            color: #777;
        }

        .form-label {
            font-weight: 600;
            color: #2c4964;
            margin-bottom: 8px;
        }

        .form-control {
            height: 45px;
            border-radius: 5px;
        }

        textarea.form-control {
            height: 100px;
        }

        .gender-box {
            padding-top: 8px;
        }

        .gender-box label {
            margin-right: 20px;
            margin-left: 5px;
        }

        .register-btn {
            background: #1977cc;
            border: none;
            padding: 12px 35px;
            color: white;
            border-radius: 5px;
            font-weight: 600;
        }

        .register-btn:hover {
            background: #166ab5;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #1977cc;
            text-decoration: none;
            font-weight: 600;
        }


        /* ==========================
           PATIENT GRID
           ========================== */

        .patient-list-card {
            background: #ffffff;
            padding: 30px;
            margin-top: 35px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        .patient-list-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .patient-list-title h3 {
            color: #2c4964;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .patient-list-title p {
            color: #777;
        }

        .patient-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-grid th {
            background: #1977cc;
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: 600;
        }

        .patient-grid td {
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }

        .patient-grid tr:nth-child(even) {
            background: #f8f9fa;
        }

        .patient-grid tr:hover {
            background: #eef6ff;
        }

        .edit-btn {
            background: #198754;
            color: white !important;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        .delete-btn {
            background: #dc3545;
            color: white !important;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        .update-btn {
            background: #0d6efd;
            color: white !important;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        .cancel-btn {
            background: #6c757d;
            color: white !important;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

    </style>

</asp:Content>


<asp:Content ID="Content3"
    ContentPlaceHolderID="ContentPlaceHolder2"
    runat="server">

    <main class="main">

        <section class="registration-section">

            <div class="container">


                <!-- =====================================
                     PATIENT REGISTRATION FORM
                     ===================================== -->

                <div class="row justify-content-center">

                    <div class="col-lg-9">

                        <div class="registration-card">

                            <div class="registration-title">

                                <h2>Patient Registration</h2>

                                <p>
                                    Create your account to access hospital services
                                </p>

                            </div>


                            <div class="row gy-4">


                                <!-- Full Name -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Full Name
                                    </label>

                                    <asp:TextBox
                                        ID="txtFullName"
                                        runat="server"
                                        CssClass="form-control"
                                        placeholder="Enter your full name">
                                    </asp:TextBox>

                                </div>


                                <!-- Email -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Email
                                    </label>

                                    <asp:TextBox
                                        ID="txtEmail"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="Email"
                                        placeholder="Enter your email">
                                    </asp:TextBox>

                                </div>


                                <!-- Mobile -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Mobile Number
                                    </label>

                                    <asp:TextBox
                                        ID="txtMobile"
                                        runat="server"
                                        CssClass="form-control"
                                        placeholder="Enter mobile number">
                                    </asp:TextBox>

                                </div>


                                <!-- Gender -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Gender
                                    </label>

                                    <div class="gender-box">

                                        <asp:RadioButton
                                            ID="rbMale"
                                            runat="server"
                                            GroupName="Gender"
                                            Text="Male" />

                                        <asp:RadioButton
                                            ID="rbFemale"
                                            runat="server"
                                            GroupName="Gender"
                                            Text="Female" />

                                        <asp:RadioButton
                                            ID="rbOther"
                                            runat="server"
                                            GroupName="Gender"
                                            Text="Other" />

                                    </div>

                                </div>


                                <!-- Address -->

                                <div class="col-md-12">

                                    <label class="form-label">
                                        Address
                                    </label>

                                    <asp:TextBox
                                        ID="txtAddress"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="MultiLine"
                                        Rows="4"
                                        placeholder="Enter your address">
                                    </asp:TextBox>

                                </div>


                                <!-- Password -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Password
                                    </label>

                                    <asp:TextBox
                                        ID="txtPassword"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="Password"
                                        placeholder="Enter password">
                                    </asp:TextBox>

                                </div>


                                <!-- Confirm Password -->

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Confirm Password
                                    </label>

                                    <asp:TextBox
                                        ID="txtConfirmPassword"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="Password"
                                        placeholder="Confirm password">
                                    </asp:TextBox>

                                </div>


                                <!-- Register Button -->

                                <div class="col-md-12 text-center">

                                    <asp:Button
                                        ID="btnRegister"
                                        runat="server"
                                        Text="Register"
                                        CssClass="register-btn"
                                        OnClick="btnRegister_Click" />

                                </div>


                                <!-- Login -->

                                <div class="col-md-12">

                                    <div class="login-link">

                                        Already have an account?

                                        <a href="Login.aspx">
                                            Login
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================
                     REGISTERED PATIENTS GRIDVIEW
                     ===================================== -->

                <div class="row justify-content-center">

                    <div class="col-lg-11">

                        <div class="patient-list-card">

                            <div class="patient-list-title">

                                <h3>Registered Patients</h3>

                                <p>
                                    List of all registered patients
                                </p>

                            </div>


                            <div class="table-responsive">

                                <asp:GridView
    ID="gvPatients"
    runat="server"
    AutoGenerateColumns="False"
    DataKeyNames="PatientId"
    CssClass="patient-grid"
    Width="100%"
    EmptyDataText="No patients registered yet."
    OnRowEditing="gvPatients_RowEditing"
    OnRowCancelingEdit="gvPatients_RowCancelingEdit"
    OnRowUpdating="gvPatients_RowUpdating"
    OnRowDeleting="gvPatients_RowDeleting">

    <Columns>

        <asp:BoundField
            DataField="PatientId"
            HeaderText="ID"
            ReadOnly="True" />

        <asp:TemplateField HeaderText="Full Name">
            <ItemTemplate>
                <%# Eval("FullName") %>
            </ItemTemplate>

            <EditItemTemplate>
                <asp:TextBox
                    ID="txtGridFullName"
                    runat="server"
                    CssClass="form-control"
                    Text='<%# Bind("FullName") %>'>
                </asp:TextBox>
            </EditItemTemplate>
        </asp:TemplateField>

        <asp:TemplateField HeaderText="Email">
            <ItemTemplate>
                <%# Eval("Email") %>
            </ItemTemplate>

            <EditItemTemplate>
                <asp:TextBox
                    ID="txtGridEmail"
                    runat="server"
                    CssClass="form-control"
                    Text='<%# Bind("Email") %>'>
                </asp:TextBox>
            </EditItemTemplate>
        </asp:TemplateField>

        <asp:TemplateField HeaderText="Mobile">
            <ItemTemplate>
                <%# Eval("Mobile") %>
            </ItemTemplate>

            <EditItemTemplate>
                <asp:TextBox
                    ID="txtGridMobile"
                    runat="server"
                    CssClass="form-control"
                    Text='<%# Bind("Mobile") %>'>
                </asp:TextBox>
            </EditItemTemplate>
        </asp:TemplateField>

        <asp:TemplateField HeaderText="Gender">
            <ItemTemplate>
                <%# Eval("Gender") %>
            </ItemTemplate>

            <EditItemTemplate>
                <asp:TextBox
                    ID="txtGridGender"
                    runat="server"
                    CssClass="form-control"
                    Text='<%# Bind("Gender") %>'>
                </asp:TextBox>
            </EditItemTemplate>
        </asp:TemplateField>

        <asp:TemplateField HeaderText="Address">
            <ItemTemplate>
                <%# Eval("Address") %>
            </ItemTemplate>

            <EditItemTemplate>
                <asp:TextBox
                    ID="txtGridAddress"
                    runat="server"
                    CssClass="form-control"
                    Text='<%# Bind("Address") %>'>
                </asp:TextBox>
            </EditItemTemplate>
        </asp:TemplateField>

        <asp:CommandField
            HeaderText="Action"
            ShowEditButton="True"
            EditText="Edit"
            UpdateText="Update"
            CancelText="Cancel" />

        <asp:CommandField
            HeaderText="Delete"
            ShowDeleteButton="True"
            DeleteText="Delete" />

    </Columns>

</asp:GridView>

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


<%@ Page Title="Registration" Language="C#" MasterPageFile="~/Site1.master"
    AutoEventWireup="true"
    CodeBehind="Registration.aspx.cs"
    Inherits="Hospital_Management_System_01.Registration" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">

    <style>

        .registration-section {
            padding: 100px 0;
            background: #f8f9fa;
        }

        .registration-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        .registration-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .registration-title h2 {
            font-size: 32px;
            font-weight: 700;
            color: #2c4964;
        }

        .registration-title p {
            color: #777;
        }

        .form-label {
            font-weight: 600;
            color: #2c4964;
            margin-bottom: 8px;
        }

        .form-control {
            height: 45px;
            border-radius: 5px;
        }

        textarea.form-control {
            height: 100px;
        }

        .gender-box {
            padding-top: 8px;
        }

        .gender-box label {
            margin-right: 20px;
            margin-left: 5px;
        }

        .register-btn {
            background: #1977cc;
            border: none;
            padding: 12px 35px;
            color: white;
            border-radius: 5px;
            font-weight: 600;
        }

        .register-btn:hover {
            background: #166ab5;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #1977cc;
            text-decoration: none;
            font-weight: 600;
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

        .patient-list-card {
            background: #ffffff;
            padding: 30px;
            margin-top: 35px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        .patient-list-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .patient-list-title h3 {
            color: #2c4964;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .patient-list-title p {
            color: #777;
        }

        .patient-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-grid th {
            background: #1977cc;
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: 600;
        }

        .patient-grid td {
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }

        .patient-grid tr:nth-child(even) {
            background: #f8f9fa;
        }

        .patient-grid tr:hover {
            background: #eef6ff;
        }

        .edit-btn {
            background: #198754;
            color: white !important;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        .delete-btn {
            background: #dc3545;
            color: white !important;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        .update-btn {
            background: #0d6efd;
            color: white !important;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        .cancel-btn {
            background: #6c757d;
            color: white !important;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

    </style>

</asp:Content>


<asp:Content ID="Content3"
    ContentPlaceHolderID="ContentPlaceHolder2"
    runat="server">

    <main class="main">

        <section class="registration-section">

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-9">

                        <div class="registration-card">

                            <div class="registration-title">

                                <h2>Patient Registration</h2>

                                <p>
                                    Create your account to access hospital services
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

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Full Name
                                    </label>

                                    <asp:TextBox
                                        ID="txtFullName"
                                        runat="server"
                                        CssClass="form-control"
                                        placeholder="Enter your full name">
                                    </asp:TextBox>

                                    <asp:RequiredFieldValidator
                                        ID="rfvFullName"
                                        runat="server"
                                        ControlToValidate="txtFullName"
                                        ErrorMessage="Full Name is required."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic">
                                    </asp:RequiredFieldValidator>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Email
                                    </label>

                                    <asp:TextBox
                                        ID="txtEmail"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="Email"
                                        placeholder="Enter your email">
                                    </asp:TextBox>

                                    <asp:RequiredFieldValidator
                                        ID="rfvEmail"
                                        runat="server"
                                        ControlToValidate="txtEmail"
                                        ErrorMessage="Email is required."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic">
                                    </asp:RequiredFieldValidator>

                                    <asp:RegularExpressionValidator
                                        ID="revEmail"
                                        runat="server"
                                        ControlToValidate="txtEmail"
                                        ErrorMessage="Enter a valid email address."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic"
                                        ValidationExpression="^[^@\s]+@[^@\s]+\.[^@\s]+$">
                                    </asp:RegularExpressionValidator>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Mobile Number
                                    </label>

                                    <asp:TextBox
                                        ID="txtMobile"
                                        runat="server"
                                        CssClass="form-control"
                                        placeholder="Enter mobile number">
                                    </asp:TextBox>

                                    <asp:RequiredFieldValidator
                                        ID="rfvMobile"
                                        runat="server"
                                        ControlToValidate="txtMobile"
                                        ErrorMessage="Mobile Number is required."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic">
                                    </asp:RequiredFieldValidator>

                                    <asp:RegularExpressionValidator
                                        ID="revMobile"
                                        runat="server"
                                        ControlToValidate="txtMobile"
                                        ErrorMessage="Enter a valid 10-digit mobile number."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic"
                                        ValidationExpression="^[0-9]{10}$">
                                    </asp:RegularExpressionValidator>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Gender
                                    </label>

                                    <div class="gender-box">

                                        <asp:RadioButton
                                            ID="rbMale"
                                            runat="server"
                                            GroupName="Gender"
                                            Text="Male" />

                                        <asp:RadioButton
                                            ID="rbFemale"
                                            runat="server"
                                            GroupName="Gender"
                                            Text="Female" />

                                        <asp:RadioButton
                                            ID="rbOther"
                                            runat="server"
                                            GroupName="Gender"
                                            Text="Other" />

                                    </div>

                                </div>


                                <div class="col-md-12">

                                    <label class="form-label">
                                        Address
                                    </label>

                                    <asp:TextBox
                                        ID="txtAddress"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="MultiLine"
                                        Rows="4"
                                        placeholder="Enter your address">
                                    </asp:TextBox>

                                    <asp:RequiredFieldValidator
                                        ID="rfvAddress"
                                        runat="server"
                                        ControlToValidate="txtAddress"
                                        ErrorMessage="Address is required."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic">
                                    </asp:RequiredFieldValidator>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Password
                                    </label>

                                    <asp:TextBox
                                        ID="txtPassword"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="Password"
                                        placeholder="Enter password">
                                    </asp:TextBox>

                                    <asp:RequiredFieldValidator
                                        ID="rfvPassword"
                                        runat="server"
                                        ControlToValidate="txtPassword"
                                        ErrorMessage="Password is required."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic">
                                    </asp:RequiredFieldValidator>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Confirm Password
                                    </label>

                                    <asp:TextBox
                                        ID="txtConfirmPassword"
                                        runat="server"
                                        CssClass="form-control"
                                        TextMode="Password"
                                        placeholder="Confirm password">
                                    </asp:TextBox>

                                    <asp:RequiredFieldValidator
                                        ID="rfvConfirmPassword"
                                        runat="server"
                                        ControlToValidate="txtConfirmPassword"
                                        ErrorMessage="Confirm Password is required."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic">
                                    </asp:RequiredFieldValidator>

                                    <asp:CompareValidator
                                        ID="cvPassword"
                                        runat="server"
                                        ControlToValidate="txtConfirmPassword"
                                        ControlToCompare="txtPassword"
                                        ErrorMessage="Passwords do not match."
                                        ForeColor="Red"
                                        CssClass="validation-error"
                                        Display="Dynamic">
                                    </asp:CompareValidator>

                                </div>


                                <div class="col-md-12 text-center">

                                    <asp:Button
                                        ID="btnRegister"
                                        runat="server"
                                        Text="Register"
                                        CssClass="register-btn"
                                        OnClick="btnRegister_Click"
                                        CausesValidation="True" />

                                </div>


                                <div class="col-md-12">

                                    <div class="login-link">

                                        Already have an account?

                                        <a href="Login.aspx">
                                            Login
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="row justify-content-center">

                    <div class="col-lg-11">

                        <div class="patient-list-card">

                            <div class="patient-list-title">

                                <h3>Registered Patients</h3>

                                <p>
                                    List of all registered patients
                                </p>

                            </div>


                            <div class="table-responsive">

                                <asp:GridView
                                    ID="gvPatients"
                                    runat="server"
                                    AutoGenerateColumns="False"
                                    DataKeyNames="PatientId"
                                    CssClass="patient-grid"
                                    Width="100%"
                                    EmptyDataText="No patients registered yet."
                                    OnRowEditing="gvPatients_RowEditing"
                                    OnRowCancelingEdit="gvPatients_RowCancelingEdit"
                                    OnRowUpdating="gvPatients_RowUpdating"
                                    OnRowDeleting="gvPatients_RowDeleting">

                                    <Columns>

                                        <asp:BoundField
                                            DataField="PatientId"
                                            HeaderText="ID"
                                            ReadOnly="True" />

                                        <asp:TemplateField HeaderText="Full Name">

                                            <ItemTemplate>

                                                <%# Eval("FullName") %>

                                            </ItemTemplate>

                                            <EditItemTemplate>

                                                <asp:TextBox
                                                    ID="txtGridFullName"
                                                    runat="server"
                                                    CssClass="form-control"
                                                    Text='<%# Bind("FullName") %>'>
                                                </asp:TextBox>

                                            </EditItemTemplate>

                                        </asp:TemplateField>


                                        <asp:TemplateField HeaderText="Email">

                                            <ItemTemplate>

                                                <%# Eval("Email") %>

                                            </ItemTemplate>

                                            <EditItemTemplate>

                                                <asp:TextBox
                                                    ID="txtGridEmail"
                                                    runat="server"
                                                    CssClass="form-control"
                                                    Text='<%# Bind("Email") %>'>
                                                </asp:TextBox>

                                            </EditItemTemplate>

                                        </asp:TemplateField>


                                        <asp:TemplateField HeaderText="Mobile">

                                            <ItemTemplate>

                                                <%# Eval("Mobile") %>

                                            </ItemTemplate>

                                            <EditItemTemplate>

                                                <asp:TextBox
                                                    ID="txtGridMobile"
                                                    runat="server"
                                                    CssClass="form-control"
                                                    Text='<%# Bind("Mobile") %>'>
                                                </asp:TextBox>

                                            </EditItemTemplate>

                                        </asp:TemplateField>


                                        <asp:TemplateField HeaderText="Gender">

                                            <ItemTemplate>

                                                <%# Eval("Gender") %>

                                            </ItemTemplate>

                                            <EditItemTemplate>

                                                <asp:TextBox
                                                    ID="txtGridGender"
                                                    runat="server"
                                                    CssClass="form-control"
                                                    Text='<%# Bind("Gender") %>'>
                                                </asp:TextBox>

                                            </EditItemTemplate>

                                        </asp:TemplateField>


                                        <asp:TemplateField HeaderText="Address">

                                            <ItemTemplate>

                                                <%# Eval("Address") %>

                                            </ItemTemplate>

                                            <EditItemTemplate>

                                                <asp:TextBox
                                                    ID="txtGridAddress"
                                                    runat="server"
                                                    CssClass="form-control"
                                                    Text='<%# Bind("Address") %>'>
                                                </asp:TextBox>

                                            </EditItemTemplate>

                                        </asp:TemplateField>


                                        <asp:CommandField
                                            HeaderText="Action"
                                            ShowEditButton="True"
                                            EditText="Edit"
                                            UpdateText="Update"
                                            CancelText="Cancel" />


                                        <asp:CommandField
                                            HeaderText="Delete"
                                            ShowDeleteButton="True"
                                            DeleteText="Delete" />

                                    </Columns>

                                </asp:GridView>

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

</asp:Content>





