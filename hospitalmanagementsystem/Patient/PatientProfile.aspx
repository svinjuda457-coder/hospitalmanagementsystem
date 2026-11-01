<%@ Page Title="Patient Profile" Language="C#" MasterPageFile="~/Patient/PatientMaster.master" AutoEventWireup="true" CodeBehind="PatientProfile.aspx.cs" Inherits="Hospital_Management_System_01.Patient.PatientProfile" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div style="padding:30px;">

        <h2>Patient Profile</h2>

        <br />

        <p>
            Patient Name:
            <asp:TextBox ID="txtPatientName" runat="server"></asp:TextBox>
        </p>

        <p>
            Email:
            <asp:TextBox ID="txtEmail" runat="server"></asp:TextBox>
        </p>

        <p>
            Mobile:
            <asp:TextBox ID="txtMobile" runat="server"></asp:TextBox>
        </p>

        <p>
            Gender:
            <asp:TextBox ID="txtGender" runat="server"></asp:TextBox>
        </p>

        <p>
            City:
            <asp:TextBox ID="txtCity" runat="server"></asp:TextBox>
        </p>

        <asp:Button ID="btnUpdate" runat="server"
            Text="Update Profile"
            OnClick="btnUpdate_Click" />

        <br /><br />

        <asp:Label ID="lblMessage" runat="server"></asp:Label>

    </div>

</asp:Content>