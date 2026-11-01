<%@ Page Title="My Appointments" Language="C#" MasterPageFile="~/Patient/PatientMaster.master" AutoEventWireup="true" CodeBehind="MyAppointments.aspx.cs" Inherits="Hospital_Management_System_01.Patient.MyAppointments" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">

    <div style="padding:30px;">

        <h2>My Appointments</h2>

        <br />

        <asp:GridView ID="GridViewAppointments" runat="server"
            AutoGenerateColumns="true"
            Width="100%">
        </asp:GridView>

    </div>

</asp:Content>