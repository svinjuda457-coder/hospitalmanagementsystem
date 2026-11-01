<%@ Page Title="Book Appointment" Language="C#" MasterPageFile="~/Patient/PatientMaster.master" AutoEventWireup="true" CodeBehind="BookAppointment.aspx.cs" Inherits="Hospital_Management_System_01.Patient.BookAppointment" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div style="padding:30px;">

        <h2>Book Appointment</h2>

        <br />

        <p>
            Patient Name:
            <asp:TextBox ID="txtPatientName" runat="server"></asp:TextBox>
        </p>

        <p>
            Doctor Name:
            <asp:TextBox ID="txtDoctorName" runat="server"></asp:TextBox>
        </p>

        <p>
            Appointment Date:
            <asp:TextBox ID="txtDate" runat="server" TextMode="Date"></asp:TextBox>
        </p>

        <p>
            Appointment Time:
            <asp:TextBox ID="txtTime" runat="server" TextMode="Time"></asp:TextBox>
        </p>

        <p>
            Reason:
            <asp:TextBox ID="txtReason" runat="server"></asp:TextBox>
        </p>

        <asp:Button ID="btnBook" runat="server"
            Text="Book Appointment"
            OnClick="btnBook_Click" />

        <br /><br />

        <asp:Label ID="lblMessage" runat="server"></asp:Label>

    </div>

</asp:Content>