<%@ Page Title="Doctor Profile" Language="C#" MasterPageFile="~/Doctor/DoctorMaster.master" AutoEventWireup="true" CodeBehind="DoctorProfile.aspx.cs" Inherits="Hospital_Management_System_01.Doctor.DoctorProfile" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div style="padding:30px;">

        <h2>Doctor Profile</h2>

        <p>
            Doctor Name:
            <asp:TextBox ID="txtDoctorName" runat="server"></asp:TextBox>
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
            Specialization:
            <asp:TextBox ID="txtSpecialization" runat="server"></asp:TextBox>
        </p>

        <p>
            <asp:Button ID="btnUpdate" runat="server" Text="Update Profile" OnClick="btnUpdate_Click" />
            <asp:Label ID="lblMessage" runat="server" ForeColor="Green"></asp:Label>
        </p>

    </div>

</asp:Content>